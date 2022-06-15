<?php

declare(strict_types=1);

namespace App\IATI\Services\Activity;

use App\IATI\Repositories\Activity\CapitalSpendRepository;
use Illuminate\Database\Eloquent\Model;

/**
 * Class CapitalSpendService.
 */
class CapitalSpendService
{
    /**
     * @var CapitalSpendRepository
     */
    protected CapitalSpendRepository $capitalSpendRepository;

    /**
     * CapitalSpendService constructor.
     *
     * @param CapitalSpendRepository $capitalSpendRepository
     */
    public function __construct(CapitalSpendRepository $capitalSpendRepository)
    {
        $this->capitalSpendRepository = $capitalSpendRepository;
    }

    /**
     * Returns capital spend data of an activity.
     *
     * @param int $activity_id
     *
     * @return float|null
     */
    public function getCapitalSpendData(float $activity_id): ?float
    {
        return $this->capitalSpendRepository->getCapitalSpendData($activity_id);
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
        return $this->capitalSpendRepository->getActivityData($id);
    }

    /**
     * Updates activity capital spend data.
     *
     * @param $activityCapitalSpend
     * @param $activity
     *
     * @return bool
     */
    public function update($activityCapitalSpend, $activity): bool
    {
        return $this->capitalSpendRepository->update($activityCapitalSpend, $activity);
    }
}
