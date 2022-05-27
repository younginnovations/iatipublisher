<?php

declare(strict_types=1);

namespace App\IATI\Services\Activity;

use App\IATI\Repositories\Activity\StatusRepository;
use Illuminate\Database\Eloquent\Model;

/**
 * Class StatusService.
 */
class StatusService
{
    /**
     * @var StatusRepository
     */
    protected StatusRepository $statusRepository;

    /**
     * StatusService constructor.
     *
     * @param StatusRepository $statusRepository
     */
    public function __construct(StatusRepository $statusRepository)
    {
        $this->statusRepository = $statusRepository;
    }

    /**
     * Returns status data of an activity.
     *
     * @param int $activity_id
     *
     * @return int|null
     */
    public function getStatusData(int $activity_id): ?int
    {
        return $this->statusRepository->getStatusData($activity_id);
    }

    /**
     * Returns activity object.
     *
     * @param $id
     *
     * @return Model
     */
    public function getActivityData($id): Model
    {
        return $this->statusRepository->getActivityData($id);
    }

    /**
     * Updates activity status.
     *
     * @param $activityStatus
     * @param $activity
     *
     * @return bool
     */
    public function update($activityStatus, $activity): bool
    {
        return $this->statusRepository->update($activityStatus, $activity);
    }
}
