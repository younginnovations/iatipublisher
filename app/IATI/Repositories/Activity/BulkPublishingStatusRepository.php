<?php

declare(strict_types=1);

namespace App\IATI\Repositories\Activity;

use App\IATI\Models\Activity\BulkPublishingStatus;
use App\IATI\Repositories\Repository;

/**
 * Class BulkPublishingStatusRepository.
 */
class BulkPublishingStatusRepository extends Repository
{
    /**
     * Returns activity model.
     *
     * @return string
     */
    public function getModel(): string
    {
        return BulkPublishingStatus::class;
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
        $this->model->where('activity_id', $activityId)->where('job_batch_uuid', $uuid)->first()->update(['status' => $status]);
    }

    /**
     * Returns activities that are currently undergoing bulk publishing for an organization.
     *
     * @param $organizationId
     * @param $uuid
     *
     * @return object|null
     */
    public function getBulkPublishingStatuses($organizationId, $uuid): ?object
    {
        return $this->model->where('organization_id', $organizationId)
                           ->where('job_batch_uuid', $uuid)
                           ->get();
    }

    /**
     * Returns ongoing bulk publishing processes for an organization.
     *
     * @param $organizationId
     *
     * @return object|null
     */
    public function ongoingBulkPublishingStatuses($organizationId): ?object
    {
        return $this->model->where('organization_id', $organizationId)
                           ->where('status', 'created')
                           ->orWhere('status', 'processing')
                           ->get();
    }
}
