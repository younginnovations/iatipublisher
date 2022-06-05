<?php

declare(strict_types=1);

namespace App\IATI\Services\Activity;

use App\IATI\Repositories\Activity\ConditionRepository;
use Illuminate\Database\Eloquent\Model;

/**
 * Class ConditionService.
 */
class ConditionService
{
    /**
     * @var ConditionRepository
     */
    protected ConditionRepository $conditionRepository;

    /**
     * ConditionService constructor.
     *
     * @param ConditionRepository $conditionRepository
     */
    public function __construct(ConditionRepository $conditionRepository)
    {
        $this->conditionRepository = $conditionRepository;
    }

    /**
     * Returns conditions data of an activity.
     *
     * @param int $activity_id
     *
     * @return array|null
     */
    public function getConditionData(int $activity_id): ?array
    {
        return $this->conditionRepository->getConditionData($activity_id);
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
        return $this->conditionRepository->getActivityData($id);
    }

    /**
     * Updates activity condition.
     *
     * @param $activityCondition
     * @param $activity
     *
     * @return bool
     */
    public function update($activityCondition, $activity): bool
    {
        return $this->conditionRepository->update($activityCondition, $activity);
    }
}
