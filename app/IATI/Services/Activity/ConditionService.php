<?php

declare(strict_types=1);

namespace App\IATI\Services\Activity;

use App\IATI\Elements\Builder\MultilevelSubElementFormCreator;
use App\IATI\Repositories\Activity\ConditionRepository;
use Illuminate\Database\Eloquent\Model;
use Kris\LaravelFormBuilder\Form;

/**
 * Class ConditionService.
 */
class ConditionService
{
    /**
     * @var ConditionRepository
     */
    protected ConditionRepository $conditionRepository;

    /**
     * @var MultilevelSubElementFormCreator
     */
    protected MultilevelSubElementFormCreator $multilevelSubElementFormCreator;

    /**
     * ConditionService constructor.
     *
     * @param ConditionRepository $conditionRepository
     * @param MultilevelSubElementFormCreator $multilevelSubElementFormCreator
     */
    public function __construct(ConditionRepository $conditionRepository, MultilevelSubElementFormCreator $multilevelSubElementFormCreator)
    {
        $this->conditionRepository = $conditionRepository;
        $this->multilevelSubElementFormCreator = $multilevelSubElementFormCreator;
    }

    /**
     * Returns conditions data of an activity.
     *
     * @param int $activity_id
     *
     * @return array|null
     */
    public function getConditionData(int $activity_id): ?array
    {
        return $this->conditionRepository->getConditionData($activity_id);
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
        return $this->conditionRepository->getActivityData($id);
    }

    /**
     * Updates activity condition.
     *
     * @param $activityCondition
     * @param $activity
     *
     * @return bool
     */
    public function update($activityCondition, $activity): bool
    {
        return $this->conditionRepository->update($activityCondition, $activity);
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
        $model = $this->getConditionData($id) ?: [];
        $this->multilevelSubElementFormCreator->url = route('admin.activities.conditions.update', [$id]);

        return $this->multilevelSubElementFormCreator->editForm($model, $element['conditions'], 'PUT', '/activities/' . $id);
    }
}
