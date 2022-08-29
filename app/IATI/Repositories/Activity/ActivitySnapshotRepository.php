<?php

declare(strict_types=1);

namespace App\IATI\Repositories\Activity;

use App\IATI\Models\Activity\ActivitySnapshot;
use App\IATI\Repositories\Repository;

/**
 * Class ActivitySnapshotRepository.
 */
class ActivitySnapshotRepository extends Repository
{
    /**
     * Returns activity snapshot model.
     *
     * @return string
     */
    public function getModel(): string
    {
        return ActivitySnapshot::class;
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
        return $this->model->updateOrCreate(
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
