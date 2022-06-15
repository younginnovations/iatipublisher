<?php

declare(strict_types=1);

namespace App\IATI\Services\Activity;

use App\IATI\Repositories\Activity\HumanitarianScopeRepository;
use Illuminate\Database\Eloquent\Model;

/**
 * Class HumanitarianScopeService.
 */
class HumanitarianScopeService
{
    /**
     * @var HumanitarianScopeRepository
     */
    protected HumanitarianScopeRepository $humanitarianScopeRepository;

    /**
     * HumanitarianScopeService constructor.
     *
     * @param HumanitarianScopeRepository $humanitarianScopeRepository
     */
    public function __construct(HumanitarianScopeRepository $humanitarianScopeRepository)
    {
        $this->humanitarianScopeRepository = $humanitarianScopeRepository;
    }

    /**
     * Returns humanitarian scope data of an activity.
     *
     * @param int $activity_id
     *
     * @return array|null
     */
    public function getHumanitarianScopeData(int $activity_id): ?array
    {
        return $this->humanitarianScopeRepository->getHumanitarianScopeData($activity_id);
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
        return $this->humanitarianScopeRepository->getActivityData($id);
    }

    /**
     * Updates activity humanitarian scope.
     *
     * @param $activityHumanitarianScope
     * @param $activity
     *
     * @return bool
     */
    public function update($activityHumanitarianScope, $activity): bool
    {
        return $this->humanitarianScopeRepository->update($activityHumanitarianScope, $activity);
    }
}
