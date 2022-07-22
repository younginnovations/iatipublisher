<?php

declare(strict_types=1);

namespace App\IATI\Services\Activity;

use App\IATI\Models\Activity\Activity;
use App\IATI\Repositories\Activity\BudgetRepository;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Arr;

/**
 * Class BudgetService.
 */
class BudgetService
{
    /**
     * @var BudgetRepository
     */
    protected BudgetRepository $budgetRepository;

    /**
     * BudgetService constructor.
     *
     * @param BudgetRepository $budgetRepository
     */
    public function __construct(BudgetRepository $budgetRepository)
    {
        $this->budgetRepository = $budgetRepository;
    }

    /**
     * Returns budget data of an activity.
     *
     * @param int $activity_id
     *
     * @return array|null
     */
    public function getBudgetData(int $activity_id): ?array
    {
        return $this->budgetRepository->getBudgetData($activity_id);
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
        return $this->budgetRepository->getActivityData($id);
    }

    /**
     * Updates activity budget.
     *
     * @param $activityBudget
     * @param $activity
     *
     * @return bool
     */
    public function update($activityBudget, $activity): bool
    {
        return $this->budgetRepository->update($activityBudget, $activity);
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
        $budgets = (array) $activity->budget;

        if (count($budgets)) {
            foreach ($budgets as $budget) {
                $activityData[] = [
                    '@attributes'  => [
                        'type'   => Arr::get($budget, 'budget_type', null),
                        'status' => Arr::get($budget, 'budget_status', null),
                    ],
                    'period-start' => [
                        '@attributes' => [
                            'iso-date' => Arr::get($budget, 'period_start.0.date', null),
                        ],
                    ],
                    'period-end'   => [
                        '@attributes' => [
                            'iso-date' => Arr::get($budget, 'period_end.0.date', null),
                        ],
                    ],
                    'value'        => [
                        '@attributes' => [
                            'currency'   => Arr::get($budget, 'budget_value.0.currency', null),
                            'value-date' => Arr::get($budget, 'budget_value.0.value_date', null),
                        ],
                        '@value'      => Arr::get($budget, 'budget_value.0.amount', null),
                    ],
                ];
            }
        }

        return $activityData;
    }
}
