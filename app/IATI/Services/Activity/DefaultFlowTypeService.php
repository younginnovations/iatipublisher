<?php

declare(strict_types=1);

namespace App\IATI\Services\Activity;

use App\IATI\Repositories\Activity\DefaultFlowTypeRepository;
use Illuminate\Database\Eloquent\Model;

/**
 * Class DefaultFlowTypeService.
 */
class DefaultFlowTypeService
{
    /**
     * @var DefaultFlowTypeRepository
     */
    protected DefaultFlowTypeRepository $defaultFlowTypeRepository;

    /**
     * DefaultFlowTypeService constructor.
     *
     * @param DefaultFlowTypeRepository $defaultFlowTypeRepository
     */
    public function __construct(DefaultFlowTypeRepository $defaultFlowTypeRepository)
    {
        $this->defaultFlowTypeRepository = $defaultFlowTypeRepository;
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
        return $this->defaultFlowTypeRepository->getDefaultFlowTypeData($activity_id);
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
        return $this->defaultFlowTypeRepository->getActivityData($id);
    }

    /**
     * Updates activity default flow type data.
     *
     * @param $activityDefaultFlowType
     * @param $activity
     *
     * @return bool
     */
    public function update($activityDefaultFlowType, $activity): bool
    {
        return $this->defaultFlowTypeRepository->update($activityDefaultFlowType, $activity);
    }
}
