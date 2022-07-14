<?php

declare(strict_types=1);

namespace App\IATI\Services\Activity;

use App\IATI\Elements\Builder\BaseFormCreator;
use App\IATI\Models\Activity\Activity;
use App\IATI\Repositories\Activity\CollaborationTypeRepository;
use Illuminate\Database\Eloquent\Model;
use Kris\LaravelFormBuilder\Form;

/**
 * Class CollaborationTypeService.
 */
class CollaborationTypeService
{
    /**
     * @var CollaborationTypeRepository
     */
    protected CollaborationTypeRepository $collaborationTypeRepository;

    /**
     * @var BaseFormCreator
     */
    protected BaseFormCreator $baseFormCreator;

    /**
     * CollaborationTypeService constructor.
     *
     * @param CollaborationTypeRepository $collaborationTypeRepository
     */
    public function __construct(CollaborationTypeRepository $collaborationTypeRepository, BaseFormCreator $baseFormCreator)
    {
        $this->collaborationTypeRepository = $collaborationTypeRepository;
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
        return $this->collaborationTypeRepository->getCollaborationTypeData($activity_id);
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
        return $this->collaborationTypeRepository->getActivityData($id);
    }

    /**
     * Updates activity collaboration type data.
     *
     * @param $activityCollaborationType
     * @param $activity
     *
     * @return bool
     */
    public function update($activityCollaborationType, $activity): bool
    {
        return $this->collaborationTypeRepository->update($activityCollaborationType, $activity);
    }

    /**
     * Returns collaboration type form.
     *
     * @param $id
     *
     * @return Form
     */
    public function formGenerator($id): Form
    {
        $element = json_decode(file_get_contents(app_path('IATI/Data/elementJsonSchema.json')), true);
        $model['collaboration_type'] = $this->getCollaborationTypeData($id);
        $this->baseFormCreator->url = route('admin.activities.collaboration-type.update', [$id]);

        return $this->baseFormCreator->editForm($model, $element['collaboration_type'], 'PUT', '/activities/' . $id);
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
