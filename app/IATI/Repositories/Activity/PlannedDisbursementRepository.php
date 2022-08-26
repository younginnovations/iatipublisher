<?php

declare(strict_types=1);

namespace App\IATI\Repositories\Activity;

use App\IATI\Models\Activity\Activity;
use Illuminate\Database\Eloquent\Model;

/**
 * Class PlannedDisbursementRepository.
 */
class PlannedDisbursementRepository
{
    /**
     * @var Activity
     */
    protected Activity $activity;

    /**
     * PlannedDisbursementRepository Constructor.
     *
     * @param Activity $activity
     */
    public function __construct(Activity $activity)
    {
        $this->activity = $activity;
    }

    /**
     * Returns planned disbursement data of an activity.
     *
     * @param $activityId
     *
     * @return array|null
     */
    public function getPlannedDisbursementData($activityId): ?array
    {
        return $this->activity->findorFail($activityId)->planned_disbursement;
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
        return $this->activity->findOrFail($id);
    }

    /**
     * Updates planned disbursement.
     *
     * @param $plannedDisbursement
     * @param $activity
     *
     * @return bool
     */
    public function update($plannedDisbursement, $activity): bool
    {
        $element = getElementSchema('planned_disbursement');

        foreach ($plannedDisbursement['planned_disbursement'] as $key => $disbursement) {
            foreach (array_keys($element['sub_elements']) as $subelement) {
                $plannedDisbursement['planned_disbursement'][$key][$subelement] = array_values($disbursement[$subelement]);
            }
        }

        $activity->planned_disbursement = $plannedDisbursement['planned_disbursement'];

        return $activity->save();
    }
}
