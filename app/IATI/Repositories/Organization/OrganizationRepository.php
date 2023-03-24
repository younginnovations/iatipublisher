<?php

declare(strict_types=1);

namespace App\IATI\Repositories\Organization;

use App\IATI\Models\Organization\Organization;
use App\IATI\Models\User\Role;
use App\IATI\Repositories\Repository;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

/**
 * Class OrganizationRepository.
 */
class OrganizationRepository extends Repository
{
    /**
     * Return Organization model.
     *
     * @return string
     */
    public function getModel(): string
    {
        return Organization::class;
    }

    /**
     * Creates new organization.
     *
     * @param array $data
     *
     * @return \Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Eloquent\Model|mixed
     */
    public function createOrganization(array $data): mixed
    {
        return $this->model->updateOrCreate(['publisher_id' => $data['publisher_id']], $data);
    }

    /**
     * Returns organization object.
     *
     * @param $id
     *
     * @return Model
     */
    public function getOrganizationData($id): Model
    {
        return $this->model->findOrFail($id);
    }

    /**
     * Updates status column of activity row.
     *
     * @param $organization
     * @param $status
     * @param $alreadyPublished
     *
     * @return bool
     */
    public function updatePublishedStatus($organization, $status, $alreadyPublished): bool
    {
        $organization->status = $status;
        $organization->is_published = $alreadyPublished;

        return $organization->save();
    }

    /**
     * Returns organizations in paginated format.
     *
     * @param $page
     * @param $queryParams
     *
     * @return null|LengthAwarePaginator
     */
    public function getPaginatedOrganizations($page, $queryParams): ?LengthAwarePaginator
    {
        $whereSql = '1=1';
        $bindParams = [];
        $adminRoleId = app(Role::class)->getOrganizationAdminId();

        if (array_key_exists(
            'q',
            $queryParams
        ) && !empty($queryParams['q'])) {
            $query = $queryParams['q'];
            $innerSql = 'select id, json_array_elements(name) name_array from organizations';

            $whereSql .= " AND id in (select x1.id from ($innerSql)x1 where (x1.name_array->>'narrative')::text ilike ?)";
            $bindParams[] = "%$query%";
        }

        $orderBy = 'updated_at';
        $direction = 'desc';

        if (array_key_exists('orderBy', $queryParams) && !empty($queryParams['orderBy'])) {
            $orderBy = $queryParams['orderBy'];

            if (array_key_exists('direction', $queryParams) && !empty($queryParams['direction'])) {
                $direction = $queryParams['direction'];
            }
        }

        $organizations = $this->model->withCount('allActivities')
            ->with(['user' => function ($user) use ($adminRoleId) {
                return $user->where('role_id', $adminRoleId)
                    ->where('status', 1)
                    ->whereNull('deleted_at');
            }]);

        if (array_key_exists('q', $queryParams) && !empty($queryParams['q'])) {
            $organizations->whereRaw($whereSql, $bindParams)
                ->orWhereHas('user', function ($q) use ($bindParams) {
                    $q->where('email', 'ilike', $bindParams);
                });
        }

        if ($orderBy === 'name') {
            return $organizations->orderByRaw("name->0->>'narrative'" . $direction)
                ->paginate(10, ['*'], 'organization', $page);
        }

        return $organizations->orderBy($orderBy, $direction)
            ->paginate(10, ['*'], 'organization', $page);
    }

    /**
     * Returns list of organization name with their id.
     *
     * @return Collection
     */
    public function pluckAllOrganizations(): Collection
    {
        return $this->model->get()->where('name', '!=', null)->pluck('name.0.narrative', 'id');
    }

    /**
     * Returns organization by publisher id.
     *
     * @param $publisherId
     *
     * @return object|null
     */
    public function getOrganizationByPublisherId($publisherId): ?object
    {
        return $this->model->where('publisher_id', $publisherId)->first();
    }
}
