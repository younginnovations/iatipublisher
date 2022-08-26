<?php

declare(strict_types=1);

namespace App\IATI\Services\Activity;

use App\IATI\Elements\Builder\MultilevelSubElementFormCreator;
use App\IATI\Models\Activity\Activity;
use App\IATI\Repositories\Activity\ConditionRepository;
use App\IATI\Traits\XmlBaseElement;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Arr;
use Kris\LaravelFormBuilder\Form;

/**
 * Class ConditionService.
 */
class ConditionService
{
    use XmlBaseElement;

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
        $element = getElementSchema('conditions');
        $model = $this->getConditionData($id) ?: [];
        $this->multilevelSubElementFormCreator->url = route('admin.activities.conditions.update', [$id]);

        return $this->multilevelSubElementFormCreator->editForm($model, $element, 'PUT', '/activities/' . $id);
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
        $conditions = (array) $activity->conditions;

        if (count($conditions)) {
            $activityData[] = [
                '@attributes' => [
                    'attached' => Arr::get($conditions, 'condition_attached', null),
                ],
                'condition'   => Arr::get($conditions, 'condition_attached', null) == '1' ? $this->buildCondition(
                    Arr::get($conditions, 'condition', [])
                ) : [],
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
        if (!boolval($conditions)) {
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
