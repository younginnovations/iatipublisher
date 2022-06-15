<?php

declare(strict_types=1);

namespace App\IATI\Repositories\Activity;

use App\IATI\Models\Activity\Activity;
use Illuminate\Database\Eloquent\Model;

/**
 * Class CountryBudgetItemRepository.
 */
class CountryBudgetItemRepository
{
    /**
     * @var Activity
     */
    protected Activity $activity;

    /**
     * CountryBudgetItemRepository Constructor.
     * @param Activity $activity
     */
    public function __construct(Activity $activity)
    {
        $this->activity = $activity;
    }

    /**
     * Returns country budget items data of an activity.
     * @param $activityId
     * @return array|null
     */
    public function getCountryBudgetItemData($activityId): ?array
    {
        return $this->activity->findorFail($activityId)->country_budget_items;
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
     * Updates activity country budget items.
     * @param $activityCountryBudgetItem
     * @param $activity
     * @return bool
     */
    public function update($activityCountryBudgetItem, $activity): bool
    {
        foreach ($activityCountryBudgetItem['budget_item'] as $key => $budget_item) {
            $activityCountryBudgetItem['budget_item'][$key]['description'][0]['narrative'] = array_values($budget_item['description'][0]['narrative']);
        }

        $activityCountryBudgetItem['budget_item'] = array_values($activityCountryBudgetItem['budget_item']);
        $activity->country_budget_items = $activityCountryBudgetItem;

        return $activity->save();
    }
}
