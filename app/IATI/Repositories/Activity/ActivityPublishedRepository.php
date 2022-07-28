<?php

declare(strict_types=1);

namespace App\IATI\Repositories\Activity;

use App\IATI\Models\Activity\ActivityPublished;
use Illuminate\Database\Eloquent\Model;

/**
 * Class ActivityPublishedRepository.
 */
class ActivityPublishedRepository
{
    /**
     * @var ActivityPublished
     */
    protected ActivityPublished $activityPublished;

    /**
     * ActivityPublishedRepository Constructor.
     * @param ActivityPublished $activityPublished
     */
    public function __construct(ActivityPublished $activityPublished)
    {
        $this->activityPublished = $activityPublished;
    }

    /**
     * Creates new record or updates existing record in activity published table.
     *
     * @param $filename
     * @param $organizationId
     *
     * @return Model
     */
    public function findOrCreate($filename, $organizationId): Model
    {
        $published = $this->activityPublished->firstOrNew([
            'filename' => $filename,
            'organization_id' => $organizationId,
        ]);

        $published->touch();

        return $published;
    }

    /**
     * Updates existing record in activity published table.
     *
     * @param $activityPublished
     * @param $publishedActivities
     *
     * @return bool
     */
    public function update($activityPublished, $publishedActivities): bool
    {
        $activityPublished->published_activities = $publishedActivities;

        return $activityPublished->save();
    }
}
