<?php

declare(strict_types=1);

namespace App\IATI\Services\Activity;

use App\IATI\Elements\Builder\MultilevelSubElementFormCreator;
use App\IATI\Models\Activity\Activity;
use App\IATI\Repositories\Activity\CountryBudgetItemRepository;
use App\IATI\Traits\XmlBaseElement;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Arr;
use Kris\LaravelFormBuilder\Form;

/**
 * Class CountryBudgetItemService.
 */
class CountryBudgetItemService
{
    use XmlBaseElement;

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
        $element = getElementSchema('country_budget_items');
        $model = $this->getCountryBudgetItemData($id) ?: [];
        $this->multilevelSubElementFormCreator->url = route('admin.activities.country-budget-items.update', [$id]);

        return $this->multilevelSubElementFormCreator->editForm($model, $element, 'PUT', '/activities/' . $id);
    }

    /**
     * Returns data in required xml array format.
     *
     * @param Activity $activity
     *
     * @return array
     */
    public function getXmlData(Activity $activity): array
    {
        $activityData = [];
        $countryBudgetItem = (array) $activity->country_budget_items;

        if (count($countryBudgetItem)) {
            $activityData[] = [
                '@attributes' => [
                    'vocabulary' => Arr::get($countryBudgetItem, 'country_budget_vocabulary', null),
                ],
                'budget-item' => $this->buildBudgetItem(
                    Arr::get($countryBudgetItem, 'budget_item', []),
                    Arr::get($countryBudgetItem, 'country_budget_vocabulary', null)
                ),
            ];
        }

        return $activityData;
    }

    /**
     * Returns array of xml budget items.
     *
     * @param $budgetItems
     * @param $vocabulary
     *
     * @return array
     */
    private function buildBudgetItem($budgetItems, $vocabulary): array
    {
        $budgetItemData = [];

        if (count($budgetItems)) {
            foreach ($budgetItems as $budgetItem) {
                $budgetItemData[] = [
                    '@attributes' => [
                        'code' => $vocabulary == 1 ? Arr::get($budgetItem, 'code', null) : Arr::get(
                            $budgetItem,
                            'code_text',
                            null
                        ),
                        'percentage' => Arr::get($budgetItem, 'percentage', null),
                    ],
                    'description' => [
                        'narrative' => $this->buildNarrative(
                            Arr::get($budgetItem, 'description.0.narrative', null)
                        ),
                    ],
                ];
            }
        }

        return $budgetItemData;
    }
}
