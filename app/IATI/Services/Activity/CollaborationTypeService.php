<?php

declare(strict_types=1);

namespace App\IATI\Services\Activity;

use App\IATI\Repositories\Activity\CollaborationTypeRepository;
use Illuminate\Database\Eloquent\Model;

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
     * CollaborationTypeService constructor.
     *
     * @param CollaborationTypeRepository $collaborationTypeRepository
     */
    public function __construct(CollaborationTypeRepository $collaborationTypeRepository)
    {
        $this->collaborationTypeRepository = $collaborationTypeRepository;
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
}
