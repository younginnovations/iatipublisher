<?php

declare(strict_types=1);

namespace App\IATI\Repositories\Activity;

use App\IATI\Models\Activity\ActivityPublished;

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
        $this->$activityPublished = $activityPublished;
    }
}
