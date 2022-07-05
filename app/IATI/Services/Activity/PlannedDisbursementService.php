<?php

declare(strict_types=1);

namespace App\IATI\Services\Activity;

use App\IATI\Repositories\Activity\PlannedDisbursementRepository;
use Illuminate\Database\Eloquent\Model;

/**
 * Class planned$plannedDisbursement
 *Service.
 */
class PlannedDisbursementService
{
    /**
     * @var PlannedDisbursementRepository
     */
    protected PlannedDisbursementRepository $plannedDisbursementRepo;

    /**
     * PlannedDisbursementService constructor.
     *
     * @param PlannedDisbursementRepository $plannedDisbursementRepo
     */
    public function __construct(PlannedDisbursementRepository $plannedDisbursementRepo)
    {
        $this->plannedDisbursementRepository = $plannedDisbursementRepo;
    }

    /**
     * Returns planned disbursement data of an activity.
     *
     * @param int $activity_id
     *
     * @return array|null
     */
    public function getPlannedDisbursementData(int $activity_id): ?array
    {
        return $this->plannedDisbursementRepository->getPlannedDisbursementData($activity_id);
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
        return $this->plannedDisbursementRepository->getActivityData($id);
    }

    /**
     * Updates activity planned disbursement.
     *
     * @param $plannedDisbursement
     * @param $activity
     *
     * @return bool
     */
    public function update($plannedDisbursement, $activity): bool
    {
        return $this->plannedDisbursementRepository->update($plannedDisbursement, $activity);
    }
}
