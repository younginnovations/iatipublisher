<?php

namespace App\Jobs;

use App\IATI\Elements\Xml\XmlGenerator;
use App\IATI\Models\Activity\Activity;
use App\IATI\Models\Organization\Organization;
use App\IATI\Models\Setting\Setting;
use App\IATI\Models\User\User;
use App\IATI\Repositories\Activity\ValidationStatusRepository;
use App\IATI\Services\ApiLog\ApiLogService;
use App\IATI\Services\Validator\ActivityValidatorResponseService;
use App\IATI\Services\Workflow\ActivityWorkflowService;
use App\IATI\Traits\IatiValidatorResponseTrait;
use Exception;
use GuzzleHttp\Promise\PromiseInterface;
use GuzzleHttp\Promise\Utils;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Arr;
use JsonException;

class RegistryValidatorJobForMultipleActivities implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels, IatiValidatorResponseTrait;

    private XmlGenerator $xmlGenerator;
    private ApiLogService $apiLogService;
    private ActivityWorkflowService $activityWorkflowService;

    private ValidationStatusRepository $validationStatusRepository;

    private ActivityValidatorResponseService $activityValidatorResponseService;

    private const BATCH_SIZE = 20;

    private const BATCH_DELAY_MICROSECONDS = 50000;

    /**
     * Class constructor.
     *
     * @param User                 $user
     * @param Collection<Activity> $activities
     * @param Organization         $organization
     * @param Setting              $settings
     */
    public function __construct(
        public User $user,
        public Collection $activities,
        public Organization $organization,
        public Setting $settings,
    ) {
    }

    /**
     * Execute the job.
     *
     * @return void
     *
     * @throws BindingResolutionException
     * @throws JsonException
     */
    public function handle(): void
    {
        $this->xmlGenerator = app(XmlGenerator::class);
        $this->apiLogService = app(ApiLogService::class);
        $this->activityWorkflowService = app(ActivityWorkflowService::class);
        $this->validationStatusRepository = app(ValidationStatusRepository::class);
        $this->activityValidatorResponseService = app(ActivityValidatorResponseService::class);

        $validatorResponses = [];
        $validatorPromises = [];
        $orgId = $this->organization->id;

        foreach ($this->activities as $index => $activity) {
            $currentActivityId = $activity->id;
            $transactions = $activity->transactions ?? [];
            $results = $activity->results ?? [];
            $xmlDocument = $this->xmlGenerator->getXml($activity, $transactions, $results, $this->settings, $this->organization);

            $xmlContent = $xmlDocument->saveXML();
            $path = "xmlValidation/$orgId/activity_$activity->id.xml";

            awsUploadFile($path, $xmlContent);

            $validatorPromises[$currentActivityId] = $this->createValidatorPromise($this->activityWorkflowService, $xmlContent);

            if ($this->isBatchProcessingCompleted($index)) {
                $this->processPromises($validatorPromises, $validatorResponses);
            }
        }

        if (!empty($validatorPromises)) {
            $this->processPromises($validatorPromises, $validatorResponses);
        }

        foreach ($validatorResponses as $currentActivityId => $response) {
            $activity = $this->activities->firstWhere('id', $currentActivityId);
            $this->storeValidation($activity, $response);
        }
    }

    /**
     * Create a promise for validator request.
     *
     * @param ActivityWorkflowService $activityWorkflowService
     * @param string $xmlData
     *
     * @return PromiseInterface
     */
    private function createValidatorPromise(ActivityWorkflowService $activityWorkflowService, string $xmlData): PromiseInterface
    {
        return $activityWorkflowService->getResponseAsync($xmlData)
            ->then(
                function ($response) {
                    return $response->getBody()->getContents();
                },
                function (Exception $ex) {
                    $response = '';

                    if ($ex->getCode() === 422) {
                        $response = $ex->getResponse()->getBody()->getContents();
                    }

                    return $response;
                }
            );
    }

    /**
     * Check if batch processing complete.
     *
     * @param int $index
     *
     * @return bool
     */
    private function isBatchProcessingCompleted(int $index): bool
    {
        return ($index + 1) % self::BATCH_SIZE === 0;
    }

    /**
     * Handle  responses for resolved promises. Basically get the validator response.
     *
     * @param array $promises
     * @param array $validatorResponses
     *
     * @return void
     */
    private function processPromises(array $promises, array &$validatorResponses): void
    {
        $parallelResponses = Utils::settle($promises)->wait();

        foreach ($parallelResponses as $actId => $response) {
            if ($response['state'] === 'fulfilled') {
                $validatorResponses[$actId] = $response['value'];
            } else {
                logger()->error(
                    'Error processing activity for bulk publish.',
                    [
                        'activity_id' => $actId,
                        'error'       => $response['reason'],
                    ]
                );
            }
        }

        usleep(self::BATCH_DELAY_MICROSECONDS);
    }

    /**
     * Store validator responses to DB.
     *
     * @throws BindingResolutionException
     * @throws JsonException
     */
    public function storeValidation(Activity $activity, string $response): void
    {
        $response = $this->addElementOnIatiValidatorResponse($response, $activity);

        $this->apiLogService->store(generateApiInfo('POST', env('IATI_VALIDATOR_ENDPOINT'), ['form_params' => json_encode($activity)], json_encode($response)));

        $recordResponse = [
            'activity_id'   =>  $activity->id,
            'title'         =>  Arr::get($activity->title, '0.narrative', 'Not Available') ?: 'Not Available',
            'response'      =>  $response,
        ];

        if ($this->activityValidatorResponseService->updateOrCreateResponse($activity->id, $response)) {
            $this->validationStatusRepository->updateValidationStatus((int) $activity->id, (int) $this->user->id, status: 'completed', response: $recordResponse);
        }
    }
}
