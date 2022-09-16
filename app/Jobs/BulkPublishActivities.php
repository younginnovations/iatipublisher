<?php

declare(strict_types=1);

namespace App\Jobs;

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
     * @param $organizationId
     * @param $uuid
     *
     * @return void
     */
    public function __construct($activities, $organizationId, $uuid)
    {
        $this->activities = $activities;
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
        $publishFile = true;
        $this->setServices($publishingStatusService, $activityWorkflowService, $activityService);

        if (count($this->activities)) {
            foreach ($this->activities as $activity) {
                $this->publishingStatusService->updateActivityStatus($activity->id, $this->uuid, 'processing');
                $this->publishActivity($activity, $publishFile);
                $publishFile = false;
            }
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
     * @param $activity
     * @param $publishFile
     *
     * @return void
     */
    public function publishActivity($activity, $publishFile): void
    {
        try {
            $this->activityWorkflowService->publishActivity($activity, $publishFile);
            $this->publishingStatusService->updateActivityStatus($activity->id, $this->uuid, 'completed');
        } catch (\Exception $e) {
            logger()->error($e->getMessage());
            $this->activityService->updatePublishedStatus($activity, 'draft', $activity->already_published, false);
            $this->publishingStatusService->updateActivityStatus($activity->id, $this->uuid, 'failed');
        }
    }
}
