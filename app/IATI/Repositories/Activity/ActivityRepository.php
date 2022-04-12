<?php

declare(strict_types=1);

namespace App\IATI\Repositories\Activity;

use App\IATI\Models\Activity\Activity;

/**
 * Class ActivityRepository.
 */
class ActivityRepository
{
    /**
     * @var Activity
     */
    protected $activity;

    /**
     * ActivityRepository Constructor.
     * @param Activity $activity
     */
    public function __construct(Activity $activity)
    {
        $this->activity = $activity;
    }

    /**
     * Returns all activities present in database.
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getAllActivities(): \Illuminate\Database\Eloquent\Collection
    {
        return $this->activity->all();
    }
}
