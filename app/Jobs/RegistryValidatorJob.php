<?php

declare(strict_types=1);

namespace App\Jobs;

use App\IATI\Models\Activity\Activity;
use App\IATI\Models\User\User;
use App\IATI\Repositories\Activity\ValidationStatusRepository;
use App\IATI\Services\ApiLog\ApiLogService;
use App\IATI\Services\Validator\ActivityValidatorResponseService;
use App\IATI\Services\Workflow\ActivityWorkflowService;
use App\IATI\Traits\IatiValidatorResponseTrait;
use GuzzleHttp\Exception\BadResponseException;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Cache;
use JsonException;

/**
 * Class RegistryValidatorJob.
 *
 * Validates Activity on IATI Registry
 */
class RegistryValidatorJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels, IatiValidatorResponseTrait;

    /**
     * The number of seconds the job can run before timing out.
     *
     * @var int
     */
    public int $timeout = 36000;

    /**
     * Activity Instance for validation.
     *
     * @var Activity
     */
    protected Activity $activity;

    /**
     * User Instance for querying the database.
     *
     * @var User
     */
    protected User $user;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(Activity $activity, User $user)
    {
        $this->activity = $activity;
        $this->user = $user;
    }

    /**
     * Validates activity on IATI Registry.
     *
     * @param ActivityWorkflowService $activityWorkflowService
     * @return void
     *
     * @throws BindingResolutionException
     * @throws GuzzleException
     * @throws JsonException
     */
    public function handle(ActivityWorkflowService $activityWorkflowService): void
    {
        $startTime = now();
        writeLog('validation', "Registry validator job for activity: {$this->activity->id} started at $startTime");

        try {
            if (!Cache::get('activity-validation-delete')) {
                $validationStatusRepository = app()->make(ValidationStatusRepository::class);
                $validationStatusRepository->storeValidationStatus((int) $this->activity->id, (int) $this->user->id, status: 'processing');

                $response = $activityWorkflowService->validateActivityOnIATIValidator($this->activity);

                $storeStart = now();
//                writeLog("validation", "Store validation process for activity: {$this->activity->id} started at $storeStart");
                $this->storeValidation($response);
                $storeEnd = now();
//                writeLog("validation", "Store validation process for activity: {$this->activity->id} ended at $storeEnd");
                writeLog('validation', "Store validation process for activity {$this->activity->id} took " . $storeEnd->diffInSeconds($storeStart) . ' seconds or ' . $storeEnd->diffInMinutes($storeStart) . ' minutes.', 'info', false, 'store_validation_process', $storeEnd->diffInSeconds($storeStart));
            }
        } catch (BadResponseException $ex) {
            if ($ex->getCode() === 422) {
                $response = $ex->getResponse()->getBody()->getContents();
                $storeStart = now();
//                writeLog("validation", "Store validation process for activity with validation errors: {$this->activity->id} started at $storeStart");
                $this->storeValidation($response);
                $storeEnd = now();
//                writeLog("validation", "Store validation process for activity with validation errors: {$this->activity->id} ended at $storeEnd");
                writeLog('validation', "Store validation process for activity with validation errors {$this->activity->id} took " . $storeEnd->diffInSeconds($storeStart) . ' seconds or ' . $storeEnd->diffInMinutes($storeStart) . ' minutes.', 'info', false, 'store_validation_process', $storeEnd->diffInSeconds($storeStart));
            }
        } catch (BindingResolutionException|JsonException $e) {
            logger($e);
            $this->fail();
        }

        $endTime = now();
//        writeLog("validation", "Registry validator job for activity: {$this->activity->id} ended at $endTime");
        writeLog('validation', "Registry validator job for activity {$this->activity->id} took " . $endTime->diffInSeconds($startTime) . ' seconds or ' . $endTime->diffInMinutes($startTime) . ' minutes.', 'info', true, 'registry_validator_job', $endTime->diffInSeconds($startTime));
    }

    /**
     * Stores Validation after response.
     *
     * @param $response
     *
     * @return void
     *
     * @throws BindingResolutionException
     * @throws JsonException
     */
    public function storeValidation($response): void
    {
        $apiLogService = app()->make(ApiLogService::class);
        $validatorService = app()->make(ActivityValidatorResponseService::class);
        $validationStatusRepository = app()->make(ValidationStatusRepository::class);
        $response = $this->addElementOnIatiValidatorResponse($response, $this->activity);
        $apiLogService->store(generateApiInfo('POST', env('IATI_VALIDATOR_ENDPOINT'), ['form_params' => json_encode($this->activity)], json_encode($response)));

        $recordResponse = [
            'activity_id'   =>  $this->activity->id,
            'title'         =>  Arr::get($this->activity->title, '0.narrative', 'Not Available') ?: 'Not Available',
            'response'      =>  $response,
        ];

        if ($validatorService->updateOrCreateResponse($this->activity->id, $response)) {
            $validationStatusRepository->updateValidationStatus((int) $this->activity->id, (int) $this->user->id, status: 'completed', response: $recordResponse);
        }
    }

    /**
     * Clears up the failed validation.
     *
     * @return void
     *
     * @throws BindingResolutionException
     */
    public function failed(): void
    {
        $validationStatusRepository = app()->make(ValidationStatusRepository::class);
        $validationStatusRepository->updateValidationStatus((int) $this->activity->id, (int) $this->user->id, status: 'failed');
    }
}
