<?php

declare(strict_types=1);

namespace App\IATI\Services\Activity;

use App\IATI\Repositories\Activity\DateRepository;
use Illuminate\Database\Eloquent\Model;

/**
 * Class DateService.
 */
class DateService
{
    /**
     * @var DateRepository
     */
    protected DateRepository $dateRepository;

    /**
     * DateService constructor.
     *
     * @param DateRepository $dateRepository
     */
    public function __construct(DateRepository $dateRepository)
    {
        $this->dateRepository = $dateRepository;
    }

    /**
     * Returns date data of an activity.
     *
     * @param int $activity_id
     *
     * @return array|null
     */
    public function getDateData(int $activity_id): ?array
    {
        return $this->dateRepository->getDateData($activity_id);
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
        return $this->dateRepository->getActivityData($id);
    }

    /**
     * Updates activity date.
     *
     * @param $activityDate
     * @param $activity
     *
     * @return bool
     */
    public function update($activityDate, $activity): bool
    {
        return $this->dateRepository->update($activityDate, $activity);
    }
}
