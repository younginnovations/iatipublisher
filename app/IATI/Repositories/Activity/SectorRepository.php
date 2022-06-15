<?php

declare(strict_types=1);

namespace App\IATI\Repositories\Activity;

use App\IATI\Models\Activity\Activity;
use Illuminate\Database\Eloquent\Model;

/**
 * Class SectorRepository.
 */
class SectorRepository
{
    /**
     * @var Activity
     */
    protected Activity $activity;

    /**
     * SectorRepository Constructor.
     *
     * @param Activity $activity
     */
    public function __construct(Activity $activity)
    {
        $this->activity = $activity;
    }

    /**
     * Returns sector data of an activity.
     *
     * @param $activityId
     *
     * @return array|null
     */
    public function getSectorData($activityId): ?array
    {
        return $this->activity->findorFail($activityId)->sector;
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
        return $this->activity->findOrFail($id);
    }

    /**
     * Updates activity sector.
     *
     * @param $activitySector
     * @param $activity
     *
     * @return bool
     */
    public function update($activitySector, $activity): bool
    {
        foreach ($activitySector['sector'] as $key => $sector) {
            $activitySector['sector'][$key]['narrative'] = array_values($sector['narrative']);
        }

        $activity->sector = array_values($activitySector['sector']);

        return $activity->save();
    }
}
