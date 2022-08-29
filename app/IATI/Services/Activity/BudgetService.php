<?php

declare(strict_types=1);

namespace App\IATI\Services\Activity;

use App\IATI\Elements\Builder\ParentCollectionFormCreator;
use App\IATI\Models\Activity\Activity;
use App\IATI\Repositories\Activity\BudgetRepository;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Arr;
use Kris\LaravelFormBuilder\Form;

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
     * @var ParentCollectionFormCreator
     */
    protected ParentCollectionFormCreator $parentCollectionFormCreator;

    /**
     * BudgetService constructor.
     *
     * @param BudgetRepository $budgetRepository
     * @param ParentCollectionFormCreator $parentCollectionFormCreator
     */
    public function __construct(BudgetRepository $budgetRepository, ParentCollectionFormCreator $parentCollectionFormCreator)
    {
        $this->budgetRepository = $budgetRepository;
        $this->parentCollectionFormCreator = $parentCollectionFormCreator;
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
     * Generates budget form.
     *
     * @param id
     *
     * @return Form
     */
    public function formGenerator($id): Form
    {
        $element = getElementSchema('budget');
        $model['budget'] = $this->getBudgetData($id);
        $this->parentCollectionFormCreator->url = route('admin.activities.budget.update', [$id]);

        return $this->parentCollectionFormCreator->editForm($model, $element['budget'], 'PUT', '/activities/' . $id);
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
