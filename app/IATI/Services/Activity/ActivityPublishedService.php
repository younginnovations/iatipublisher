<?php

declare(strict_types=1);

namespace App\IATI\Services\Activity;

use App\IATI\Repositories\Activity\ActivityPublishedRepository;

/**
 * Class ActivityPublishedService.
 */
class ActivityPublishedService
{
    /**
     * @var ActivityPublishedRepository
     */
    protected ActivityPublishedRepository $activityPublishedRepository;

    /**
     * ActivityPublishedService constructor.
     *
     * @param ActivityPublishedRepository $activityPublishedRepository
     */
    public function __construct(ActivityPublishedRepository $activityPublishedRepository)
    {
        $this->activityPublishedRepository = $activityPublishedRepository;
    }
}
