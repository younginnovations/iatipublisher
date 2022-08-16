<?php

declare(strict_types=1);

namespace App\IATI\Services\Activity;

use App\IATI\Elements\Builder\BaseFormCreator;
use App\IATI\Models\Activity\Activity;
use App\IATI\Repositories\Activity\ActivityRepository;
use Kris\LaravelFormBuilder\Form;

/**
 * Class CollaborationTypeService.
 */
class CollaborationTypeService
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
     * CollaborationTypeService constructor.
     *
     * @param ActivityRepository $activityRepository
     */
    public function __construct(ActivityRepository $activityRepository, BaseFormCreator $baseFormCreator)
    {
        $this->activityRepository = $activityRepository;
        $this->baseFormCreator = $baseFormCreator;
    }

    /**
     * Returns collaboration type data of an activity.
     *
     * @param int $activity_id
     *
     * @return int|null
     */
    public function getCollaborationTypeData(int $activity_id): ?int
    {
        return $this->activityRepository->find($activity_id)->collaboration_type;
    }

    /**
     * Returns activity object.
     *
     * @param $id
     *
     * @return Object
     */
    public function getActivityData($id): Object
    {
        return $this->activityRepository->find($id);
    }

    /**
     * Updates activity collaboration type data.
     *
     * @param $id
     * @param $activityCollaborationType
     *
     * @return bool
     */
    public function update($id, $activityCollaborationType): bool
    {
        return $this->activityRepository->update($id, ['collaboration_type' => $activityCollaborationType]);
    }

    /**
     * Returns collaboration type form.
     *
     * @param $id
     *
     * @return Form
     * @throws \JsonException
     */
    public function formGenerator($id): Form
    {
        $element = getElementSchema('collaboration_type');
        $model['collaboration_type'] = $this->getCollaborationTypeData($id);
        $this->baseFormCreator->url = route('admin.activity.collaboration-type.update', [$id]);

        return $this->baseFormCreator->editForm($model, $element, 'PUT', '/activity/' . $id);
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

        if ($activity->collaboration_type) {
            $activityData = [
                '@attributes' => [
                    'code' => $activity->collaboration_type,
                ],
            ];
        }

        return $activityData;
    }
}
