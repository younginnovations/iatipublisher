<?php

declare(strict_types=1);

namespace App\IATI\Services\Activity;

use App\IATI\Elements\Builder\MultilevelSubElementFormCreator;
use App\IATI\Models\Activity\Activity;
use App\IATI\Repositories\Activity\ActivityRepository;
use App\IATI\Traits\XmlBaseElement;
use Kris\LaravelFormBuilder\Form;

/**
 * Class ConditionService.
 */
class ConditionService
{
    use XmlBaseElement;

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
     * @param ActivityRepository              $activityRepository
     * @param MultilevelSubElementFormCreator $multilevelSubElementFormCreator
     */
    public function __construct(ActivityRepository $activityRepository, MultilevelSubElementFormCreator $multilevelSubElementFormCreator)
    {
        $this->activityRepository              = $activityRepository;
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
     * @return Object
     */
    public function getActivityData($id): object
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
     * @param $id
     *
     * @return Form
     * @throws \JsonException
     */
    public function formGenerator($id): Form
    {
        $element                                    = getElementSchema('conditions');
        $model                                      = $this->getConditionData($id) ?: [];
        $this->multilevelSubElementFormCreator->url = route('admin.activity.conditions.update', [$id]);

        return $this->multilevelSubElementFormCreator->editForm($model, $element, 'PUT', '/activity/'.$id);
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
        $conditions   = (array)$activity->conditions;

        if (count($conditions)) {
            $activityData[] = [
                '@attributes' => [
                    'attached' => Arr::get($conditions, 'condition_attached', null),
                ],
                'condition'   => Arr::get($conditions, 'condition_attached', null) === '1' ? $this->buildCondition(Arr::get($conditions, 'condition', [])) : [],
            ];
        }

        return $activityData;
    }

    /**
     * Returns array of xml conditions.
     *
     * @param $conditions
     *
     * @return array
     */
    private function buildCondition($conditions): array
    {
        $conditionData = [];

        if (!$conditions) {
            $conditions = [['condition_type' => null, 'narrative' => [['narrative' => '', 'language' => '']]]];
        }

        foreach ($conditions as $condition) {
            $conditionData[] = [
                '@attributes' => [
                    'type' => Arr::get($condition, 'condition_type', null),
                ],
                'narrative'   => $this->buildNarrative(Arr::get($condition, 'narrative', null)),
            ];
        }

        return $conditionData;
    }
}
