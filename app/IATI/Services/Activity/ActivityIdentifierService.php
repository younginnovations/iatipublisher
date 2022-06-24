<?php

declare(strict_types=1);

namespace App\IATI\Services\Activity;

use App\IATI\Repositories\Activity\ActivityIdentifierRepository;
use Illuminate\Database\Eloquent\Model;

/**
 * Class ActivityIdentifierService.
 */
class ActivityIdentifierService
{
    /**
     * @var ActivityIdentifierRepository
     */
    protected ActivityIdentifierRepository $activityIdentifierRepository;

    /**
     * ActivityIdentifierService constructor.
     *
     * @param ActivityIdentifierRepository $activityIdentifierRepository
     */
    public function __construct(ActivityIdentifierRepository $activityIdentifierRepository)
    {
        $this->activityIdentifierRepository = $activityIdentifierRepository;
    }

    /**
     * Returns activity identifier data of an activity.
     *
     * @param int $activity_id
     *
     * @return array|null
     */
    public function getActivityIdentifierData(int $activity_id): ?array
    {
        return $this->activityIdentifierRepository->getActivityIdentifierData($activity_id);
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
        return $this->activityIdentifierRepository->getActivityData($id);
    }

    /**
     * Updates activity identifier.
     *
     * @param $activityIdentifier
     * @param $activity
     *
     * @return bool
     */
    public function update($activityIdentifier, $activity): bool
    {
        return $this->activityIdentifierRepository->update($activityIdentifier, $activity);
    }
}
