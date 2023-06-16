<?php

declare(strict_types=1);

namespace App\IATI\Repositories\Organization;

use App\IATI\Models\Organization\Organization;
use App\IATI\Models\Setting\Setting;
use App\IATI\Models\User\Role;
use App\IATI\Repositories\Repository;
use App\IATI\Traits\FillDefaultValuesTrait;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

/**
 * Class OrganizationRepository.
 */
class OrganizationRepository extends Repository
{
    use FillDefaultValuesTrait;

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

        if (
            array_key_exists(
                'q',
                $queryParams
            ) && !empty($queryParams['q'])
        ) {
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

        $organizations = $this->model
            ->withCount('allActivities')
            ->with([
                'user' => function ($user) use ($adminRoleId) {
                    return $user->where('role_id', $adminRoleId)
                        ->where('status', 1)
                        ->whereNull('deleted_at');
                },
            ])
            ->with('latestUpdatedActivity')
            ->with('latestLoggedInUser')
            ->with('settings');

        if (array_key_exists('q', $queryParams) && !empty($queryParams['q'])) {
            $organizations->whereRaw($whereSql, $bindParams)
                ->orWhereHas('user', function ($q) use ($bindParams) {
                    $q->where('email', 'ilike', $bindParams);
                });
        }

        if (Arr::get($queryParams, 'start_date', false) && Arr::get($queryParams, 'end_date', false)) {
            $dateColumn = Arr::get($queryParams, 'date_column', 'created_at');
            if ($dateColumn === 'last_logged_in') {
                $organizations->whereHas('latestLoggedInUser', function ($user) use ($queryParams) {
                    $user->whereDate('last_logged_in', '>=', $queryParams['start_date'])
                        ->whereDate('last_logged_in', '<=', $queryParams['end_date']);
                });
            } else {
                $organizations
                      ->whereDate("organizations.$dateColumn", '>=', $queryParams['start_date'])
                      ->whereDate("organizations.$dateColumn", '<=', $queryParams['end_date']);
            }
        }

        if (Arr::get($queryParams, 'filters', false)) {
            $organizations = $this->applyFilters($organizations, Arr::get($queryParams, 'filters'));
        }

        if ($orderBy === 'name') {
            return $organizations->orderByRaw("organizations.name->0->>'narrative'" . $direction)
                ->paginate(10, ['*'], 'organization', $page);
        }

        $orderBy = ($orderBy === 'registered_on') ? 'created_at' : $orderBy;

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
     * Override base repository update method.
     *
     * @param $data
     *
     * @inheritDoc
     *
     * @return Model|void
     */
    public function update($id, array $data): bool
    {
        $orgId = auth()->user()->organization->id;
        $defaultValues = Setting::where('organization_id', $orgId)->first()?->default_values ?? [];

        if (!empty($defaultValues)) {
            $data = $this->populateDefaultFields($data, $defaultValues);
        }

        if (isset($data['name'])) {
            $data['name'] = $data['name']['narrative'];
        }

        return $this->model->find($id)->update($data);
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
        return $this->model->where('publisher_id', $publisherId)->with(['settings', 'users', 'activities'])->first();
    }

    /**
     * Returns Organizations by publisher ids.
     *
     * @param array $publisherIds
     *
     * @return array|Collection
     */
    public function getOrganizationByPublisherIds(array $publisherIds): Collection|array
    {
        return $this->model->whereIn('publisher_id', $publisherIds)->get();
    }

    /**
     * Applies filter to the publisher query.
     *
     * @param $queryParams
     */
    protected function filterPublisher($query, $queryParams, $type = null)
    {
        $filteredQuery = $query;

        if (isset($queryParams['start_date']) && isset($queryParams['end_date'])) {
            $filteredQuery = $query->where('created_at', '>=', $queryParams['start_date'])
                ->where('created_at', '<=', $queryParams['end_date']);
        }

        $direction = 'asc';
        $orderBy = 'count';

        if ($type) {
            if (isset($queryParams['order_by'])) {
                $orderBy = $queryParams['order_by'];
            }

            if (isset($queryParams['sort'])) {
                $direction = $queryParams['sort'];
            }

            $filteredQuery = $filteredQuery->orderBy($orderBy, $direction);

            $filteredQuery = $filteredQuery->groupBy($type);
        }

        if (isset($queryParams['page'])) {
            $filteredQuery = $filteredQuery->paginate(10, ['*'], 'publisher', $queryParams['page']);
        }

        return $filteredQuery;
    }

    public function getPublisherStats($queryParams): array
    {
        return [
            'totalCount' => $this->model->count(),
            'lastRegisteredPublisher' => $this->model->select('id', 'created_at', 'name')->latest('created_at')->first(),
            'inActivePublisher' => $this->model->with('latestLoggedInUser')
                ->whereHas('latestLoggedInUser', function (Builder $q) {
                    $q->where('last_logged_in', '<', '2023-05-03 04:14:12');
                })
                ->orDoesntHave('latestLoggedInUser')
                ->count(),
        ];
    }

    public function getPublisherBy($queryParams, $type, $page = 1): array
    {
        $query = $this->model->select(DB::raw('count(*) as count, ' . $type));

        if ($queryParams) {
            $query = $this->filterPublisher($query, $queryParams, $type);
        }

        return [
            $type => $query->pluck('count', $type),
        ];
    }

    public function getPublisherBySetup($queryParams): array
    {
        // need code refactor and optimization
        $completedSetting = $this->model->select('publisher_name', 'id')->whereHas('settings', function (Builder $q) {
            $q->whereJsonContains('publishing_info->publisher_verification', true)
                ->whereJsonContains('publishing_info->token_verification', true)
                ->whereNotNull('default_values->default_currency')
                ->whereJsonDoesntContain('default_values->default_currency', '')
                ->whereJsonDoesntContain('default_values->default_language', '')
                ->whereNotNull('default_values->default_language')
                ->whereJsonDoesntContain('default_values->default_language', '')
                ->whereNotNull('default_values->default_language')
                ->whereJsonDoesntContain('default_values->default_language', '')
                ->whereNotNull('default_values->default_language')
                ->whereJsonDoesntContain('default_values->default_language', '')
                ->whereNotNull('default_values->default_language');
        })->pluck('id');

        $incompletePublisherSetting = $this->model->select('id')->with('settings')->whereNotIn('id', $completedSetting)->whereHas('settings', function (Builder $q) {
            $q->whereJsonContains('publishing_info->publisher_verification', false)
                ->orWhereJsonContains('publishing_info->token_verification', false)
                ->orWhereNull('publishing_info');
        })->count();
        $incompleteDefaultValues = $this->model->select('id')->with('settings')->whereNotIn('id', $completedSetting)->whereHas('settings', function (Builder $q) {
            $q->whereNull('default_values->default_currency')
                ->orwhereNull('default_values->default_language')
                ->orwhereNull('default_values')
                ->orwhereNull('activity_default_values')
                ->orwhereNull('activity_default_values->token_verification')
                ->orwhereNull('activity_default_values->token_verification');
        })->count();
        $incompleteBothSettings = $this->model->select('id')->with('settings')->whereNotIn('id', $completedSetting)->whereHas('settings', function (Builder $q) {
            $q->whereNull('default_values->default_currency')
                ->orwhereNull('default_values->default_language')
                ->orwhereNull('default_values')
                ->orwhereNull('activity_default_values')
                ->orwhereNull('activity_default_values->token_verification')
                ->orwhereNull('activity_default_values->token_verification')
                ->WhereJsonContains('publishing_info->publisher_verification', false)
                ->orWhereJsonContains('publishing_info->token_verification', false)
                ->WhereNull('publishing_info');
        })->count();
        $incompleteCount = $this->model->select('id')->whereNotIn('id', $completedSetting)->count();

        if ($queryParams) {
        }

        return [
            'completeSetup' => [
                'count' => $completedSetting->count(),
                'types' => [],
            ],
            'incompleteSetup' => [
                'count' => $incompleteCount,
                'types' => [
                    'publisher' => $incompletePublisherSetting,
                    'defaultValue' => $incompleteDefaultValues,
                    'both' => $incompleteBothSettings,
                ],
            ],
        ];
    }

    public function getPublisherGroupedByDate($queryParams, $type)
    {
        $query = $this->model;
        $queryType = 'day';

        $formats = [
            'day' => 'Y-m-d',
            'month' => 'Y-m',
        ];

        if ($queryParams) {
            $query = $this->filterPublisher($query, $queryParams);
        }

        return $query->get()->groupBy(
            function ($q) use ($formats, $queryType) {
                return $q->created_at->format($formats[$queryType]);
            }
        )->map(fn ($d) => count($d));
    }

    public function publisherWithoutActivity()
    {
        return $this->model->doesntHave('allActivities')->count();
    }

    public function getOrganizationDashboardDownload(): array
    {
        // case when linked_to_iati and activities.status='draft' then 'published recently' else activities.status end as case,
        // upload_medium,
        dd($this->model->select(DB::raw("name->0->>'narrative' as organization,
        identifier,
        publisher_type,
         country,
         organizations.created_at,
         organizations.updated_at
         "))->join('settings', 'organizations.id', 'settings.organization_id')->get()->toArray());
    }

    /**
     * Applies filters to organization listing page.
     *
     * @param mixed $organizations
     * @param mixed $filters
     *
     * @return mixed
     */
    private function applyFilters(mixed $organizations, mixed $filters): mixed
    {
        $tableConfig = getTableConfig('organisation');
        $filterMode = $tableConfig['filters'];
        $queryMap = $this->getCompletenessMap();

        foreach ($filters as $filterName => $filterValue) {
            if ($filterName !== 'completeness') {
                if (Arr::get($filterMode, $filterName) === 'single') {
                    $organizations->where($filterName, $filterValue);
                } else {
                    $organizations->whereIn($filterName, $filterValue);
                }
            } else {
                $organizations->leftJoin('settings', 'settings.organization_id', 'organizations.id')->whereRaw($queryMap[$filterValue]);
            }
        }

        return $organizations;
    }

    /**
     * Returns where conditions for querying completeness based data.
     *
     * @return string[]
     */
    private function getCompletenessMap(): array
    {
        return [
            'Publisher_with_complete_setup' => "
                    CAST(settings.publishing_info->>'publisher_verification' as bool) = true and
                    settings.publishing_info->>'publisher_id' notnull and
                    CAST(settings.publishing_info->>'token_verification' as bool) = true and
                    settings.publishing_info->>'api_token' notnull
                ",
            'Publisher_setting_not_completed' => "
                    CAST(settings.publishing_info->>'publisher_verification' as bool) = false or
                    settings.publishing_info->>'publisher_id' isnull  or
                    CAST(settings.publishing_info->>'token_verification' as bool) = false or
                    settings.publishing_info->>'api_token' isnull
                ",
            'Default_values_not_completed' => "
                    settings.default_values->>'default_currency' isnull or
                    settings.default_values->>'default_language' isnull or
                    settings.activity_default_values->>'hierarchy' isnull or
                    settings.activity_default_values->>'humanitarian' isnull or
                    settings.activity_default_values->>'budget_not_provided' isnull
                ",
            'Both_publishing_settings_and_default_values_not_completed' => "
                    (
                        CAST(settings.publishing_info->>'publisher_verification' as bool) = false or
                        settings.publishing_info->>'publisher_id' isnull  or
                        CAST(settings.publishing_info->>'token_verification' as bool) = false or
                        settings.publishing_info->>'api_token' isnull
                    ) and
                    (
                        settings.default_values->>'default_currency' isnull or
                        settings.default_values->>'default_language' isnull or
                        settings.activity_default_values->>'hierarchy' isnull or
                        settings.activity_default_values->>'humanitarian' isnull or
                        settings.activity_default_values->>'budget_not_provided' isnull
                    )
                ",
        ];
    }
}
