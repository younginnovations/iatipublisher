<?php

declare(strict_types=1);

namespace App\IATI\Services\Activity;

use App\IATI\Elements\Builder\BaseFormCreator;
use App\IATI\Models\Activity\Activity;
use App\IATI\Repositories\Activity\ActivityRepository;
use Kris\LaravelFormBuilder\Form;

/**
 * Class DefaultFlowTypeService.
 */
class DefaultFlowTypeService
{
    /**
     * @var ActivityRepository
     */
    protected ActivityRepository $activityRepository;

    /**
     * @var BaseFormCreator
     */
    protected BaseFormCreator $baseFormCreator;

    /**
     * DefaultFlowTypeService constructor.
     *
     * @param ActivityRepository $activityRepository
     * @param BaseFormCreator    $baseFormCreator
     */
    public function __construct(ActivityRepository $activityRepository, BaseFormCreator $baseFormCreator)
    {
        $this->activityRepository = $activityRepository;
        $this->baseFormCreator = $baseFormCreator;
    }

    /**
     * Returns default flow type data of an activity.
     *
     * @param int $activity_id
     *
     * @return int|null
     */
    public function getDefaultFlowTypeData(int $activity_id): ?int
    {
        return $this->activityRepository->find($activity_id)->default_flow_type;
    }

    /**
     * Returns activity object.
     *
     * @param $id
     *
     * @return object
     */
    public function getActivityData($id): object
    {
        return $this->activityRepository->find($id);
    }

    /**
     * Updates activity default flow type data.
     *
     * @param $id
     * @param $activityDefaultFlowType
     *
     * @return bool
     */
    public function update($id, $activityDefaultFlowType): bool
    {
        return $this->activityRepository->update($id, ['default_flow_type' => $activityDefaultFlowType]);
    }

    /**
     * Generates default flow type form.
     *
     * @param id
     *
     * @return Form
     * @throws \JsonException
     */
    public function formGenerator($id, $activityDefaultFieldValues): Form
    {
        $element = getElementSchema('default_flow_type');
        $model['default_flow_type'] = $this->getDefaultFlowTypeData($id);
        $this->baseFormCreator->url = route('admin.activity.default-flow-type.update', [$id]);

        return $this->baseFormCreator->editForm($model, $element, 'PUT', '/activity/' . $id, overRideDefaultFieldValue: $activityDefaultFieldValues);
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

        if ($activity->default_flow_type) {
            $activityData = [
                '@attributes' => [
                    'code' => $activity->default_flow_type,
                ],
            ];
        }

        return $activityData;
    }
}
