<?php

declare(strict_types=1);

namespace App\IATI\Services\Activity;

use App\IATI\Repositories\Activity\BulkPublishingStatusRepository;
use Illuminate\Support\Arr;

/**
 * Class BulkPublishingStatusService.
 */
class BulkPublishingStatusService
{
    /**
     * @var BulkPublishingStatusRepository
     */
    protected BulkPublishingStatusRepository $bulkPublishingStatusRepository;

    /**
     * BulkPublishingStatusService constructor.
     *
     * @param BulkPublishingStatusRepository $bulkPublishingStatusRepository
     */
    public function __construct(BulkPublishingStatusRepository $bulkPublishingStatusRepository)
    {
        $this->bulkPublishingStatusRepository = $bulkPublishingStatusRepository;
    }

    /**
     * Stores bulk publishing activities to publishing status table.
     *
     * @param $activities
     * @param $organizationId
     * @param $uuid
     *
     * @return void
     */
    public function storeProcessingActivities($activities, $organizationId, $uuid): void
    {
        if (count($activities)) {
            foreach ($activities as $activity) {
                $this->bulkPublishingStatusRepository->store([
                   'organization_id' => $organizationId,
                    'activity_id' => $activity->id,
                    'activity_title' => Arr::get($activity->title, '0.narrative', 'Not Available') ?: 'Not Available',
                    'status' => 'created',
                    'job_batch_uuid' => $uuid,
                ]);
            }
        }
    }

    /**
     * Updates status of activity in publishing status table.
     *
     * @param $activityId
     * @param $uuid
     * @param $status
     *
     * @return void
     */
    public function updateActivityStatus($activityId, $uuid, $status): void
    {
        $this->bulkPublishingStatusRepository->updateActivityStatus($activityId, $uuid, $status);
    }

    /**
     * Returns activities that are currently undergoing bulk publishing for an organization.
     *
     * @param $organizationId
     * @param string|null $uuid
     *
     * @return object|null
     */
    public function getActivityPublishingStatus($organizationId, ?string $uuid): ?object
    {
        return $this->bulkPublishingStatusRepository->getActivityPublishingStatus($organizationId, $uuid);
    }

    /**
     * Deletes bulk publishing statuses once all are completed.
     *
     * @param $publishStatuses
     *
     * @return void
     */
    public function deleteStatuses($publishStatuses): void
    {
        if (count($publishStatuses)) {
            foreach ($publishStatuses as $publishStatus) {
                $this->bulkPublishingStatusRepository->delete($publishStatus->id);
            }
        }
    }

    /**
     * Checks if organization has any bulk publishing processes.
     *
     * @param $organizationId
     *
     * @return bool
     */
    public function ongoingBulkPublishing($organizationId): bool
    {
        $statuses = $this->bulkPublishingStatusRepository->ongoingActivityPublishingStatus($organizationId);

        if (count($statuses)) {
            return true;
        }

        return false;
    }

    /**
     * Stop bulk publishing.
     *
     * @param $organizationId
     *
     * @return int
     */
    public function stopBulkPublishing($organizationId): int
    {
        return $this->bulkPublishingStatusRepository->stopBulkPublishing($organizationId);
    }
}
