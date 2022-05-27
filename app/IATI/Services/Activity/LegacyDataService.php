<?php

declare(strict_types=1);

namespace App\IATI\Services\Activity;

use App\IATI\Repositories\Activity\LegacyDataRepository;
use Illuminate\Database\Eloquent\Model;

/**
 * Class LegacyDataService.
 */
class LegacyDataService
{
    /**
     * @var LegacyDataRepository
     */
    protected LegacyDataRepository $legacyDataRepository;

    /**
     * LegacyDataService constructor.
     *
     * @param LegacyDataRepository $legacyDataRepository
     */
    public function __construct(LegacyDataRepository $legacyDataRepository)
    {
        $this->legacyDataRepository = $legacyDataRepository;
    }

    /**
     * Returns legacy data of an activity.
     *
     * @param int $activity_id
     *
     * @return array|null
     */
    public function getActivityLegacyData(int $activity_id): ?array
    {
        return $this->legacyDataRepository->getActivityLegacyData($activity_id);
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
        return $this->legacyDataRepository->getActivityData($id);
    }

    /**
     * Updates activity legacy.
     *
     * @param $activityLegacy
     * @param $activity
     *
     * @return bool
     */
    public function update($activityLegacy, $activity): bool
    {
        return $this->legacyDataRepository->update($activityLegacy, $activity);
    }
}
