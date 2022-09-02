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
     * @param       $organizationId
     * @param array $queryParams
     * @param int   $page
     *
     * @return Collection|LengthAwarePaginator
     */
    public function getActivityForOrganization($organizationId, array $queryParams = [], int $page = 1): Collection|LengthAwarePaginator
    {
        $whereSql = '1=1';
        $bindParams = [];

        if (!empty($organizationId)) {
            $whereSql .= " AND org_id=$organizationId";
        }

        if (array_key_exists('query', $queryParams) && (!empty($queryParams['query']) || $queryParams['query'] === '0')) {
            $query = $queryParams['query'];
            $innerSql = 'select id, json_array_elements(title) title_array from activities';

            if (!empty($organizationId)) {
                $innerSql . " org_id=$organizationId";
            }

            $whereSql .= " AND ((iati_identifier->>'activity_identifier')::text ilike ? or id in (select x1.id from ($innerSql)x1 where (x1.title_array->>'narrative')::text ilike ?))";
            $bindParams[] = "%$query%";
            $bindParams[] = "%$query%";
        }

        $orderBy = 'created_at';
        $direction = 'desc';

        if (array_key_exists('orderBy', $queryParams) && !empty($queryParams['orderBy'])) {
            $orderBy = $queryParams['orderBy'];

            if (array_key_exists('direction', $queryParams) && !empty($queryParams['direction'])) {
                $direction = $queryParams['direction'];
            }
        }

        return $this->model->whereRaw($whereSql, $bindParams)
                           ->orderBy($orderBy, $direction)
                           ->paginate(10, ['*'], 'activity', $page);
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
        return (bool) $this->model->where('id', $activity->id)->update([
            'status'            => $status,
            'already_published' => $alreadyPublished,
            'linked_to_iati'    => $linkedToIati,
        ]);
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

    /**
     * Sets activity status to draft.
     *
     * @param $activity_id
     *
     * @return void
     */
    public function resetActivityWorkflow($activity_id): void
    {
        $this->model->whereId($activity_id)->update(['status' => 'draft']);
    }
}
