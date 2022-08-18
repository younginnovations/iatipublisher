<?php

declare(strict_types=1);

namespace App\IATI\Services\Activity;

use App\IATI\Elements\Builder\MultilevelSubElementFormCreator;
use App\IATI\Repositories\Activity\ActivityRepository;
use Illuminate\Database\Eloquent\Model;
use Kris\LaravelFormBuilder\Form;

/**
 * Class ConditionService.
 */
class ConditionService
{
    /**
     * @var ActivityRepository
     */
    protected ActivityRepository $activityRepository;

    /**
     * @var MultilevelSubElementFormCreator
     */
    protected MultilevelSubElementFormCreator $multilevelSubElementFormCreator;

    /**
     * ConditionService constructor.
     *
     * @param ActivityRepository $activityRepository
     * @param MultilevelSubElementFormCreator $multilevelSubElementFormCreator
     */
    public function __construct(ActivityRepository $activityRepository, MultilevelSubElementFormCreator $multilevelSubElementFormCreator)
    {
        $this->activityRepository = $activityRepository;
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
        return $this->activityRepository->find($activity_id)->conditions;
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
        return $this->activityRepository->find($id);
    }

    /**
     * Updates activity condition.
     *
     * @param $id
     * @param $activityCondition
     *
     * @return bool
     */
    public function update($id, $activityCondition): bool
    {
        foreach ($activityCondition['condition'] as $key => $conditions) {
            $activityCondition['condition'][$key]['narrative'] = array_values($conditions['narrative']);
        }

        $activityCondition['condition'] = array_values($activityCondition['condition']);

        return $this->activityRepository->update($id, ['conditions' => $activityCondition]);
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
        $this->multilevelSubElementFormCreator->url = route('admin.activity.conditions.update', [$id]);

        return $this->multilevelSubElementFormCreator->editForm($model, $element['conditions'], 'PUT', '/activity/' . $id);
    }
}
