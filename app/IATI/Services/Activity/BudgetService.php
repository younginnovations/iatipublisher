<?php

declare(strict_types=1);

namespace App\IATI\Services\Activity;

use App\IATI\Repositories\Activity\BudgetRepository;
use Illuminate\Database\Eloquent\Model;

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
}
