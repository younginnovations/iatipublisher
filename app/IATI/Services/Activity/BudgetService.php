<?php

declare(strict_types=1);

namespace App\IATI\Services\Activity;

use App\IATI\Elements\Builder\ParentCollectionFormCreator;
use App\IATI\Repositories\Activity\ActivityRepository;
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
     * @param ActivityRepository $activityRepository
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
        return $this->activityRepository->update($id, ['budget' => array_values($activityBudget['budget'])]);
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
        $model['budget'] = $this->activityRepository->find($id)->budget;
        $this->parentCollectionFormCreator->url = route('admin.activity.budget.update', [$id]);

        return $this->parentCollectionFormCreator->editForm($model, $element['budget'], 'PUT', '/activity/' . $id);
    }
}
