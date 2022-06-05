<?php

declare(strict_types=1);

namespace App\IATI\Repositories\Activity;

use App\IATI\Models\Activity\Activity;
use Illuminate\Database\Eloquent\Model;

/**
 * Class HumanitarianScopeRepository.
 */
class HumanitarianScopeRepository
{
    /**
     * @var Activity
     */
    protected Activity $activity;

    /**
     * HumanitarianScopeRepository Constructor.
     * @param Activity $activity
     */
    public function __construct(Activity $activity)
    {
        $this->activity = $activity;
    }

    /**
     * Returns humanitarian scope data of an activity.
     * @param $activityId
     * @return array|null
     */
    public function getHumanitarianScopeData($activityId): ?array
    {
        return $this->activity->findorFail($activityId)->humanitarian_scope;
    }

    /**
     * Returns activity object.
     * @param $id
     * @return Model
     */
    public function getActivityData($id): Model
    {
        return $this->activity->findOrFail($id);
    }

    /**
     * Updates activity humanitarian scope.
     * @param $activityHumanitarianScope
     * @param $activity
     * @return bool
     */
    public function update($activityHumanitarianScope, $activity): bool
    {
        foreach ($activityHumanitarianScope['humanitarian_scope'] as $key => $humanitarian_scope) {
            $activityHumanitarianScope['humanitarian_scope'][$key]['narrative'] = array_values($humanitarian_scope['narrative']);
        }

        $activity->humanitarian_scope = array_values($activityHumanitarianScope['humanitarian_scope']);

        return $activity->save();
    }
}
