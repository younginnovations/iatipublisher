<?php

declare(strict_types=1);

namespace App\IATI\Repositories\Activity;

use App\IATI\Models\Activity\Activity;
use App\IATI\Repositories\Repository;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

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
    public function getModel(): string
    {
        return Activity::class;
    }

    /**
     * Returns all activities present in database.
     *
     * @return Collection
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
        return $this->model->where('org_id', $organizationId)->get(['iati_identifier']);
    }

    /**
     * Returns activity identifiers used by an organization.
     *
     * @param $organizationId
     * @param int $page
     *
     * @return Collection|LengthAwarePaginator
     */
    public function getActivityForOrganization($organizationId, int $page = 1): Collection|LengthAwarePaginator
    {
        return $this->model->where('org_id', $organizationId)->paginate(10, ['*'], 'activity', $page);
    }

    /**
     * Updates status column of activity row.
     *
     * @param $activity
     * @param $status
     * @param $alreadyPublished
     * @param $linkedToIati
     *
     * @return bool
     */
    public function updatePublishedStatus($activity, $status, $alreadyPublished, $linkedToIati): bool
    {
        $activity->status = $status;
        $activity->already_published = $alreadyPublished;
        $activity->linked_to_iati = $linkedToIati;

        return $activity->save();
    }

    /**
     * Deletes desired activity.
     *
     * @param Activity $activity
     *
     * @return bool
     */
    public function deleteActivity(Activity $activity): bool
    {
        return $activity->delete();
    }
}
