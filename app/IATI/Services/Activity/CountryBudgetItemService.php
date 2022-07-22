<?php

declare(strict_types=1);

namespace App\IATI\Services\Activity;

use App\IATI\Models\Activity\Activity;
use App\IATI\Repositories\Activity\CountryBudgetItemRepository;
use App\IATI\Traits\XmlBaseElement;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Arr;

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
     * CountryBudgetItemService constructor.
     *
     * @param CountryBudgetItemRepository $countryBudgetItemRepository
     */
    public function __construct(CountryBudgetItemRepository $countryBudgetItemRepository)
    {
        $this->countryBudgetItemRepository = $countryBudgetItemRepository;
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
