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
use Illuminate\Support\Facades\Log;
use JsonException;

class RegistryValidatorJobForMultipleActivities implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels, IatiValidatorResponseTrait;

    private XmlGenerator $xmlGenerator;
    private ApiLogService $apiLogService;
    private ActivityWorkflowService $activityWorkflowService;

    private ValidationStatusRepository $validationStatusRepository;

    private ActivityValidatorResponseService $activityValidatorResponseService;

    private const REQUEST_BATCH_SIZE = 5;

    private const REQUEST_DELAY_MICROSECONDS = 100000;

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
//        $this->activities = Activity::whereIn([1420,1417,1342,1340,1341,1339,1343,1344,1345,1346,1347,1348,1349,1350,1351,1352,1353,1354,1355,1356,1357,1358,1359,1360,1361])->with(['transactions', 'results.indicators.periods'])->get();
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
        $promises = [];

        $orgId = $this->organization->id;
        foreach ($this->activities as $index => $activity) {
            $activityId = $activity->id;
            $transactions = $activity->transactions ?? [];
            $results = $activity->results ?? [];
            $xmlDocument = $this->xmlGenerator->getXml($activity, $transactions, $results, $this->settings, $this->organization);

            $xmlString = $xmlDocument->saveXML();
            $path = "xmlValidation/$orgId/activity_$activity->id.xml";
            awsUploadFile($path, $xmlString);
            $promises[$activityId] = $this->validatorResponsePromise($this->activityWorkflowService, $xmlString);

            if ($this->isBatchComplete($index)) {
                $parallelResponses = Utils::settle($promises)->wait();

                foreach ($parallelResponses as $actId => $response) {
                    if ($response['state'] === 'fulfilled') {
                        $validatorResponses[$actId] = $response['value'];
                    } else {
                        Log::error('Error processing activity', ['activity_id' => $activityId, 'error' => $response['reason']]);
                    }
                }

                $promises = [];
                usleep(self::REQUEST_DELAY_MICROSECONDS);
            }
        }

        if (!empty($promises)) {
            $parallelResponses = Utils::settle($promises)->wait();

            foreach ($parallelResponses as $actId =>$response) {
                if ($response['state'] === 'fulfilled') {
                    $validatorResponses[$actId] = $response['value'];
                } else {
                    Log::error('Error processing remaining activities', ['error' => $response['reason']]);
                }
            }
        }

        foreach ($validatorResponses as $activityId => $response) {
            $activity = $this->activities->firstWhere('id', $activityId);
            $this->storeValidation($activity, $response);
        }
    }

    private function validatorResponsePromise(ActivityWorkflowService $activityWorkflowService, string $xmlData): PromiseInterface
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
     * @param int $index
     *
     * @return bool
     */
    private function isBatchComplete(int $index): bool
    {
        return ($index + 1) % self::REQUEST_BATCH_SIZE === 0;
    }

    /**
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
