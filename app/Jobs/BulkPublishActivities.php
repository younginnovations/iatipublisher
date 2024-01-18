<?php

declare(strict_types=1);

namespace App\Jobs;

use App\IATI\Repositories\Activity\BulkPublishingStatusRepository;
use App\IATI\Services\Activity\ActivityService;
use App\IATI\Services\Activity\BulkPublishingStatusService;
use App\IATI\Services\Workflow\ActivityWorkflowService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

/**
 * Class BulkPublishActivities.
 */
class BulkPublishActivities implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * @var object
     */
    protected object $activities;

    /**
     * @var object
     */
    protected object $organization;

    /**
     * @var object
     */
    protected object $settings;

    /**
     * @var int
     */
    protected int $organizationId;

    /**
     * @var string
     */
    protected string $uuid;

    /**
     * @var BulkPublishingStatusService
     */
    protected BulkPublishingStatusService $publishingStatusService;

    /**
     * @var ActivityWorkflowService
     */
    protected ActivityWorkflowService $activityWorkflowService;

    /**
     * @var ActivityService
     */
    protected ActivityService $activityService;

    /**
     * Create a new job instance.
     *
     * @param $activities
     * @param $organization
     * @param $settings
     * @param $organizationId
     * @param $uuid
     *
     * @return void
     */
    public function __construct($activities, $organization, $settings, $organizationId, $uuid)
    {
        $this->activities = $activities;
        $this->organization = $organization;
        $this->settings = $settings;
        $this->organizationId = $organizationId;
        $this->uuid = $uuid;
    }

    /**
     * Execute the job.
     *
     * @param BulkPublishingStatusService $publishingStatusService
     * @param ActivityWorkflowService $activityWorkflowService
     * @param ActivityService $activityService
     *
     * @return void
     */
    public function handle(BulkPublishingStatusService $publishingStatusService, ActivityWorkflowService $activityWorkflowService, ActivityService $activityService): void
    {
        $counter = 0;
        $this->setServices($publishingStatusService, $activityWorkflowService, $activityService);

        if (count($this->activities)) {
            foreach ($this->activities as $activity) {
                $publishFile = false;

                if ($counter === 0 || $counter === count($this->activities) - 1) {
                    $publishFile = true;
                }

                $this->publishingStatusService->updateActivityStatus($activity->id, $this->uuid, 'processing');
                $counter++;
            }

            $this->publishActivities($this->activities, $this->organization, $this->settings, $publishFile);
        }
    }

    /**
     * Initializes required services.
     *
     * @param $publishingStatusService
     * @param $activityWorkflowService
     * @param $activityService
     *
     * @return void
     */
    public function setServices($publishingStatusService, $activityWorkflowService, $activityService): void
    {
        $this->publishingStatusService = $publishingStatusService;
        $this->activityWorkflowService = $activityWorkflowService;
        $this->activityService = $activityService;
    }

    /**
     * Publishes activity and updates publish status table.
     *
     * @param $activities
     * @param $organization
     * @param $settings
     * @param $publishFile
     *
     * @return void
     */
    public function publishActivities($activities, $organization, $settings, $publishFile): void
    {
        try {
            $this->activityWorkflowService->publishActivities($activities, $organization, $settings, $publishFile);

            foreach ($activities as $activity) {
                $this->publishingStatusService->updateActivityStatus($activity->id, $this->uuid, 'completed');
            }
        } catch (\Exception $e) {
            logger()->error($e);
            awsUploadFile('error-bulk-publish.log', $e->getMessage());
            foreach ($activities as $activity) {
                $this->activityService->updatePublishedStatus($activity, 'draft', false);
                $this->publishingStatusService->updateActivityStatus($activity->id, $this->uuid, 'failed');
            }
        }
    }

    /**
     * In case of job failure , set created and processing to failed.
     *
     * @return void
     */
    public function failed(): void
    {
        try {
            app(BulkPublishingStatusRepository::class)->failStuckActivities($this->organizationId);
        } catch (\Exception $e) {
            awsUploadFile('error-bulk-publish.log', $e->getMessage());
        }
    }
}
