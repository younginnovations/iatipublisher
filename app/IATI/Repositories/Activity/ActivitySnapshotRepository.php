<?php

declare(strict_types=1);

namespace App\IATI\Repositories\Activity;

use App\IATI\Models\Activity\ActivitySnapshot;

/**
 * Class ActivitySnapshotRepository.
 */
class ActivitySnapshotRepository
{
    /**
     * @var ActivitySnapshot
     */
    protected ActivitySnapshot $activitySnapshot;

    /**
     * ActivitySnapshotRepository Constructor.
     *
     * @param ActivitySnapshot $activitySnapshot
     */
    public function __construct(ActivitySnapshot $activitySnapshot)
    {
        $this->activitySnapshot = $activitySnapshot;
    }

    /**
     * Creates or updates activity snapshot.
     *
     * @param $organization_id
     * @param $activity
     * @param $published_data
     * @param $filename
     *
     * @return mixed
     */
    public function createOrUpdateActivitySnapshot($organization_id, $activity, $published_data, $filename): mixed
    {
        return $this->activitySnapshot->updateOrCreate(
            ['org_id' => $organization_id, 'activity_id' => $activity->id],
            [
                'org_id'         => $organization_id,
                'activity_id'    => $activity->id,
                'published_data' => $published_data,
                'filename'       => $filename,
            ]
        );
    }
}
