<?php

declare(strict_types=1);

namespace App\IATI\Services\Activity;

use App\IATI\Repositories\Activity\DefaultFinanceTypeRepository;
use Illuminate\Database\Eloquent\Model;

/**
 * Class DefaultFinanceTypeService.
 */
class DefaultFinanceTypeService
{
    /**
     * @var DefaultFinanceTypeRepository
     */
    protected DefaultFinanceTypeRepository $defaultFinanceTypeRepository;

    /**
     * DefaultFinanceTypeService constructor.
     *
     * @param DefaultFinanceTypeRepository $defaultFinanceTypeRepository
     */
    public function __construct(DefaultFinanceTypeRepository $defaultFinanceTypeRepository)
    {
        $this->defaultFinanceTypeRepository = $defaultFinanceTypeRepository;
    }

    /**
     * Returns default finance type data of an activity.
     *
     * @param int $activity_id
     *
     * @return int|null
     */
    public function getDefaultFinanceTypeData(int $activity_id): ?int
    {
        return $this->defaultFinanceTypeRepository->getDefaultFinanceTypeData($activity_id);
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
        return $this->defaultFinanceTypeRepository->getActivityData($id);
    }

    /**
     * Updates activity default finance type data.
     *
     * @param $activityDefaultFinanceType
     * @param $activity
     *
     * @return bool
     */
    public function update($activityDefaultFinanceType, $activity): bool
    {
        return $this->defaultFinanceTypeRepository->update($activityDefaultFinanceType, $activity);
    }
}
