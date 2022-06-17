<?php

declare(strict_types=1);

namespace App\IATI\Repositories\Activity;

use App\IATI\Models\Activity\Activity;
use Illuminate\Database\Eloquent\Model;

/**
 * Class TagRepository.
 */
class TagRepository
{
    /**
     * @var Activity
     */
    protected Activity $activity;

    /**
     * TagRepository Constructor.
     * @param Activity $activity
     */
    public function __construct(Activity $activity)
    {
        $this->activity = $activity;
    }

    /**
     * Returns tag data of an activity.
     * @param $activityId
     * @return array|null
     */
    public function getTagData($activityId): ?array
    {
        return $this->activity->findorFail($activityId)->tag;
    }

    /**
     * Returns activity object.
     * @param $id
     * @return Model
     */
    public function getActivityData($id): Model
    {
        return $this->activity->findOrFail($id);
    }

    /**
     * Updates activity tag.
     * @param $activityTag
     * @param $activity
     * @return bool
     */
    public function update($activityTag, $activity): bool
    {
        foreach ($activityTag['tag'] as $key => $tag) {
            $activityTag['tag'][$key]['narrative'] = array_values($tag['narrative']);
        }

        $activity->tag = array_values($activityTag['tag']);

        return $activity->save();
    }
}
