<?php

declare(strict_types=1);

namespace App\IATI\Repositories\Activity;

use App\IATI\Models\Activity\Activity;
use App\IATI\Repositories\Repository;
use Illuminate\Database\Eloquent\Collection;

/**
 * Class ActivityRepository.
 */
class ActivityRepository extends Repository
{
    /**
     * Returns activity model.
     *
     * @return string
     */
    public function getModel():string
    {
        return Activity::class;
    }

    /**
     * Returns all activities present in database.
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getAllActivities(): Collection
    {
        return $this->model->all();
    }

    /**
     * Returns activity identifiers used by an organization.
     *
     * @param $organizationId
     *
     * @return Collection
     */
    public function getActivityIdentifiersForOrganization($organizationId): Collection
    {
        return $this->model->where('org_id', $organizationId)->get(['identifier']);
    }

    /**
     * Returns activity identifiers used by an organization.
     *
     * @param $organizationId
     * @param $page
     *
     * @return Collection
     */
    public function getActivityForOrganization($organizationId, $page = 1)
    {
        return $this->model->where('org_id', $organizationId)->paginate(10, ['*'], 'activity', $page);
    }
}
