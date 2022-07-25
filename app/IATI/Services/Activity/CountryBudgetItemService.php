<?php

declare(strict_types=1);

namespace App\IATI\Services\Activity;

use App\IATI\Elements\Builder\MultilevelSubElementFormCreator;
use App\IATI\Repositories\Activity\CountryBudgetItemRepository;
use Illuminate\Database\Eloquent\Model;
use Kris\LaravelFormBuilder\Form;

/**
 * Class CountryBudgetItemService.
 */
class CountryBudgetItemService
{
    /**
     * @var CountryBudgetItemRepository
     */
    protected CountryBudgetItemRepository $countryBudgetItemRepository;

    /**
     * @var MultilevelSubElementFormCreator
     */
    protected MultilevelSubElementFormCreator $multilevelSubElementFormCreator;

    /**
     * CountryBudgetItemService constructor.
     *
     * @param CountryBudgetItemRepository $countryBudgetItemRepository
     * @param MultilevelSubElementFormCreator $multilevelSubElementFormCreator
     */
    public function __construct(CountryBudgetItemRepository $countryBudgetItemRepository, MultilevelSubElementFormCreator $multilevelSubElementFormCreator)
    {
        $this->countryBudgetItemRepository = $countryBudgetItemRepository;
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
        return $this->countryBudgetItemRepository->getCountryBudgetItemData($activity_id);
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
        return $this->countryBudgetItemRepository->getActivityData($id);
    }

    /**
     * Updates activity country budget item.
     *
     * @param $activityCountryBudgetItem
     * @param $activity
     *
     * @return bool
     */
    public function update($activityCountryBudgetItem, $activity): bool
    {
        return $this->countryBudgetItemRepository->update($activityCountryBudgetItem, $activity);
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
        $this->multilevelSubElementFormCreator->url = route('admin.activities.country-budget-items.update', [$id]);

        return $this->multilevelSubElementFormCreator->editForm($model, $element['country_budget_items'], 'PUT', '/activities/' . $id);
    }
}
