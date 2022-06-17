<?php

declare(strict_types=1);

namespace App\IATI\Services\Activity;

use App\IATI\Repositories\Activity\PolicyMarkerRepository;
use Illuminate\Database\Eloquent\Model;

/**
 * Class PolicyMarkerService.
 */
class PolicyMarkerService
{
    /**
     * @var PolicyMarkerRepository
     */
    protected PolicyMarkerRepository $policyMarkerRepository;

    /**
     * PolicyMarkerService constructor.
     *
     * @param PolicyMarkerRepository $policyMarkerRepository
     */
    public function __construct(PolicyMarkerRepository $policyMarkerRepository)
    {
        $this->policyMarkerRepository = $policyMarkerRepository;
    }

    /**
     * Returns policy marker data of an activity.
     *
     * @param int $activity_id
     *
     * @return array|null
     */
    public function getPolicyMarkerData(int $activity_id): ?array
    {
        return $this->policyMarkerRepository->getPolicyMarkerData($activity_id);
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
        return $this->policyMarkerRepository->getActivityData($id);
    }

    /**
     * Updates activity policy marker.
     *
     * @param $activityPolicyMarker
     * @param $activity
     *
     * @return bool
     */
    public function update($activityPolicyMarker, $activity): bool
    {
        return $this->policyMarkerRepository->update($activityPolicyMarker, $activity);
    }
}
