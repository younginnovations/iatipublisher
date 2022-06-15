<?php

declare(strict_types=1);

namespace App\IATI\Services\Activity;

use App\IATI\Repositories\Activity\DefaultAidTypeRepository;
use Illuminate\Database\Eloquent\Model;

/**
 * Class DefaultAidTypeService.
 */
class DefaultAidTypeService
{
    /**
     * @var DefaultAidTypeRepository
     */
    protected DefaultAidTypeRepository $defaultAidTypeRepository;

    /**
     * DefaultAidTypeService constructor.
     *
     * @param DefaultAidTypeRepository $defaultAidTypeRepository
     */
    public function __construct(DefaultAidTypeRepository $defaultAidTypeRepository)
    {
        $this->defaultAidTypeRepository = $defaultAidTypeRepository;
    }

    /**
     * Returns default aid type data of an activity.
     *
     * @param int $activity_id
     *
     * @return array|null
     */
    public function getDefaultAidTypeData(int $activity_id): ?array
    {
        return $this->defaultAidTypeRepository->getDefaultAidTypeData($activity_id);
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
        return $this->defaultAidTypeRepository->getActivityData($id);
    }

    /**
     * Updates activity default aid type.
     *
     * @param $activityDefaultAidType
     * @param $activity
     *
     * @return bool
     */
    public function update($activityDefaultAidType, $activity): bool
    {
        return $this->defaultAidTypeRepository->update($activityDefaultAidType, $activity);
    }
}
