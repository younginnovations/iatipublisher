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
     * @return bool
     */
    public function updateActivityStatus($activityId, $uuid, $status): bool
    {
        $activityStatus = $this->model->where('activity_id', $activityId)->where('job_batch_uuid', $uuid)->first();

        if ($activityStatus) {
            $activityStatus->status = $status;

            return $activityStatus->save();
        }

        return false;
    }

    /**
     * Returns activities that are currently undergoing bulk publishing for an organization.
     *
     * @param $organizationId
     * @param string|null $uuid
     *
     * @return object|null
     */
    public function getActivityPublishingStatus($organizationId, ?string $uuid = ''): ?object
    {
        return $this->model->where('organization_id', '=', $organizationId)
                           ->when(!empty($uuid), function ($query) use ($uuid) {
                               return $query->where('job_batch_uuid', '=', $uuid);
                           })->get();
    }

    /**
     * Returns ongoing bulk publishing processes for an organization.
     *
     * @param $organizationId
     *
     * @return object|null
     */
    public function ongoingActivityPublishingStatus($organizationId): ?object
    {
        return $this->model->where('organization_id', $organizationId)
                           ->where('status', 'created')
                           ->orWhere('status', 'processing')
                           ->get();
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
        return $this->model->where('organization_id', $organizationId)
                            ->where('status', '!=', 'completed')
                            ->where('status', '!=', 'processing')
                            ->delete();
    }
}
