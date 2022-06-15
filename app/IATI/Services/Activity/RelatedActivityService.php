<?php

declare(strict_types=1);

namespace App\IATI\Services\Activity;

use App\IATI\Repositories\Activity\RelatedActivityRepository;
use Illuminate\Database\Eloquent\Model;

/**
 * Class RelatedActivityService.
 */
class RelatedActivityService
{
    /**
     * @var RelatedActivityRepository
     */
    protected RelatedActivityRepository $relatedActivityRepository;

    /**
     * RelatedActivityService constructor.
     *
     * @param RelatedActivityRepository $relatedActivityRepository
     */
    public function __construct(RelatedActivityRepository $relatedActivityRepository)
    {
        $this->relatedActivityRepository = $relatedActivityRepository;
    }

    /**
     * Returns related activity data of an activity.
     *
     * @param int $activity_id
     *
     * @return array|null
     */
    public function getRelatedActivityData(int $activity_id): ?array
    {
        return $this->relatedActivityRepository->getRelatedActivityData($activity_id);
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
        return $this->relatedActivityRepository->getActivityData($id);
    }

    /**
     * Updates activity related activity.
     *
     * @param $activityRelatedActivity
     * @param $activity
     *
     * @return bool
     */
    public function update($activityRelatedActivity, $activity): bool
    {
        return $this->relatedActivityRepository->update($activityRelatedActivity, $activity);
    }
}
