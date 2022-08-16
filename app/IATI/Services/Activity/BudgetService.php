<?php

declare(strict_types=1);

namespace App\IATI\Services\Activity;

use App\IATI\Elements\Builder\ParentCollectionFormCreator;
use App\IATI\Repositories\Activity\BudgetRepository;
use Illuminate\Database\Eloquent\Model;
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
        $element = json_decode(file_get_contents(app_path('IATI/Data/elementJsonSchema.json')), true);
        $model['budget'] = $this->getBudgetData($id);
        $this->parentCollectionFormCreator->url = route('admin.activity.budget.update', [$id]);

        return $this->parentCollectionFormCreator->editForm($model, $element['budget'], 'PUT', '/activity/' . $id);
    }
}
