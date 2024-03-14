<?php

declare(strict_types=1);

namespace App\IATI\Services\Activity;

use App\IATI\Elements\Builder\ParentCollectionFormCreator;
use App\IATI\Models\Activity\Activity;
use App\IATI\Repositories\Activity\ActivityRepository;
use Illuminate\Support\Arr;
use Kris\LaravelFormBuilder\Form;

/**
 * Class BudgetService.
 */
class BudgetService
{
    /**
     * @var ActivityRepository
     */
    protected ActivityRepository $activityRepository;

    /**
     * @var ParentCollectionFormCreator
     */
    protected ParentCollectionFormCreator $parentCollectionFormCreator;

    /**
     * BudgetService constructor.
     *
     * @param ActivityRepository          $activityRepository
     * @param ParentCollectionFormCreator $parentCollectionFormCreator
     */
    public function __construct(ActivityRepository $activityRepository, ParentCollectionFormCreator $parentCollectionFormCreator)
    {
        $this->activityRepository = $activityRepository;
        $this->parentCollectionFormCreator = $parentCollectionFormCreator;
    }

    /**
     * Updates activity budget.
     *
     * @param $id
     * @param $activityBudget
     *
     * @return bool
     */
    public function update($id, $activityBudget): bool
    {
        return $this->activityRepository->update($id, ['budget' => array_values($this->setBudgets($activityBudget['budget']))]);
    }

    /**
     * Sets default values for budget status and type if not provided.
     *
     * @param $budgets
     *
     * @return array
     */
    public function setBudgets($budgets): array
    {
        if (count($budgets)) {
            foreach ($budgets as $key => $budget) {
                $budgets[$key]['budget_status'] = !empty(Arr::get($budget, 'budget_status', '1')) ? Arr::get(
                    $budget,
                    'budget_status',
                    '1'
                ) : '1';
                $budgets[$key]['budget_type'] = !empty(Arr::get($budget, 'budget_type', '1')) ? Arr::get(
                    $budget,
                    'budget_type',
                    '1'
                ) : '1';
            }
        }

        return $budgets;
    }

    /**
     * Generates budget form.
     *
     * @param $id
     *
     * @return Form
     * @throws \JsonException
     */
    public function formGenerator($id, $activityDefaultFieldValues): Form
    {
        $element = getElementSchema('budget');
        $model['budget'] = $this->activityRepository->find($id)->budget;
        $this->parentCollectionFormCreator->url = route('admin.activity.budget.update', [$id]);

        return $this->parentCollectionFormCreator->editForm($model, $element, 'PUT', '/activity/' . $id, $activityDefaultFieldValues);
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
