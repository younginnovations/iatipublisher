<?php

declare(strict_types=1);

namespace App\IATI\Services\Activity;

use App\IATI\Elements\Builder\MultilevelSubElementFormCreator;
use App\IATI\Repositories\Activity\ActivityRepository;
use Illuminate\Database\Eloquent\Model;
use Kris\LaravelFormBuilder\Form;

/**
 * Class CountryBudgetItemService.
 */
class CountryBudgetItemService
{
    /**
     * @var ActivityRepository
     */
    protected ActivityRepository $activityRepository;

    /**
     * @var MultilevelSubElementFormCreator
     */
    protected MultilevelSubElementFormCreator $multilevelSubElementFormCreator;

    /**
     * CountryBudgetItemService constructor.
     *
     * @param ActivityRepository $activityRepository
     * @param MultilevelSubElementFormCreator $multilevelSubElementFormCreator
     */
    public function __construct(ActivityRepository $activityRepository, MultilevelSubElementFormCreator $multilevelSubElementFormCreator)
    {
        $this->activityRepository = $activityRepository;
        $this->multilevelSubElementFormCreator = $multilevelSubElementFormCreator;
    }

    /**
     * Returns country budget item data of an activity.
     *
     * @param int $activity_id
     *
     * @return array|null
     */
    public function getCountryBudgetItemData(int $activity_id): ?array
    {
        return $this->activityRepository->find($activity_id)->country_budget_items;
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
        return $this->activityRepository->find($id);
    }

    /**
     * Updates activity country budget item.
     *
     * @param $id
     * @param $activityCountryBudgetItem
     *
     * @return bool
     */
    public function update($id, $activityCountryBudgetItem): bool
    {
        foreach ($activityCountryBudgetItem['budget_item'] as $key => $budget_item) {
            $activityCountryBudgetItem['budget_item'][$key]['description'][0]['narrative'] = array_values($budget_item['description'][0]['narrative']);
        }

        $activityCountryBudgetItem['budget_item'] = array_values($activityCountryBudgetItem['budget_item']);

        return $this->activityRepository->update($id, ['country_budget_items' => $activityCountryBudgetItem]);
    }

    /**
     * Generates country budget form.
     *
     * @param id
     *
     * @return Form
     */
    public function formGenerator($id): Form
    {
        $element = json_decode(file_get_contents(app_path('IATI/Data/elementJsonSchema.json')), true);
        $model = $this->getCountryBudgetItemData($id) ?: [];
        $this->multilevelSubElementFormCreator->url = route('admin.activity.country-budget-items.update', [$id]);

        return $this->multilevelSubElementFormCreator->editForm($model, $element['country_budget_items'], 'PUT', '/activity/' . $id);
    }
}
