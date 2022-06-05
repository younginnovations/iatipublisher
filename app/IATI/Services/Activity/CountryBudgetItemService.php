<?php

declare(strict_types=1);

namespace App\IATI\Services\Activity;

use App\IATI\Repositories\Activity\CountryBudgetItemRepository;
use Illuminate\Database\Eloquent\Model;

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
}
