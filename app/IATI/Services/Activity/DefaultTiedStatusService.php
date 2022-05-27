<?php

declare(strict_types=1);

namespace App\IATI\Services\Activity;

use App\IATI\Repositories\Activity\DefaultTiedStatusRepository;
use Illuminate\Database\Eloquent\Model;

/**
 * Class DefaultTiedStatusService.
 */
class DefaultTiedStatusService
{
    /**
     * @var DefaultTiedStatusRepository
     */
    protected DefaultTiedStatusRepository $defaultTiedStatusRepository;

    /**
     * DefaultTiedStatusService constructor.
     *
     * @param DefaultTiedStatusRepository $defaultTiedStatusRepository
     */
    public function __construct(DefaultTiedStatusRepository $defaultTiedStatusRepository)
    {
        $this->defaultTiedStatusRepository = $defaultTiedStatusRepository;
    }

    /**
     * Returns default tied status data of an activity.
     *
     * @param int $activity_id
     *
     * @return int|null
     */
    public function getDefaultTiedStatusData(int $activity_id): ?int
    {
        return $this->defaultTiedStatusRepository->getDefaultTiedStatusData($activity_id);
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
        return $this->defaultTiedStatusRepository->getActivityData($id);
    }

    /**
     * Updates activity default tied status data.
     *
     * @param $activityDefaultTiedStatus
     * @param $activity
     *
     * @return bool
     */
    public function update($activityDefaultTiedStatus, $activity): bool
    {
        return $this->defaultTiedStatusRepository->update($activityDefaultTiedStatus, $activity);
    }
}
