<?php

declare(strict_types=1);

namespace App\IATI\Services\Activity;

use App\IATI\Models\Activity\Activity;
use App\IATI\Repositories\Activity\ScopeRepository;
use Illuminate\Database\Eloquent\Model;

/**
 * Class ScopeService.
 */
class ScopeService
{
    /**
     * @var ScopeRepository
     */
    protected ScopeRepository $scopeRepository;

    /**
     * ScopeService constructor.
     *
     * @param ScopeRepository $scopeRepository
     */
    public function __construct(ScopeRepository $scopeRepository)
    {
        $this->scopeRepository = $scopeRepository;
    }

    /**
     * Returns scope data of an activity.
     *
     * @param int $activity_id
     *
     * @return int|null
     */
    public function getScopeData(int $activity_id): ?int
    {
        return $this->scopeRepository->getScopeData($activity_id);
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
        return $this->scopeRepository->getActivityData($id);
    }

    /**
     * Updates activity scope.
     *
     * @param $activityScope
     * @param $activity
     *
     * @return bool
     */
    public function update($activityScope, $activity): bool
    {
        return $this->scopeRepository->update($activityScope, $activity);
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

        if ($activity->activity_scope) {
            $activityData = [
                '@attributes' => [
                    'code' => $activity->activity_scope,
                ],
            ];
        }

        return $activityData;
    }
}
