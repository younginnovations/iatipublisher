<?php

declare(strict_types=1);

namespace App\IATI\Repositories\User;

use App\IATI\Models\User\User;
use App\IATI\Repositories\Repository;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;

/**
 * Class UserRepository.
 */
class UserRepository extends Repository
{
    /**
     * Returns user model.
     *
     * @return string
     */
    public function getModel(): string
    {
        return User::class;
    }

    /**
     * @return void
     */
    public function sendEmail(): void
    {
        User::sendEmail();
    }

    /**
     * @param $user_id
     *
     * @return bool
     */
    public function getStatus($user_id): bool
    {
        return (bool) ($this->model->find($user_id))['email_verified_at'];
    }

    /**
     * Returns user if found.
     *
     * @param $id
     *
     * @return object
     */
    public function getUser($id): object
    {
        return $this->model->findOrFail($id);
    }

    /**
     * Get paginated users.
     *
     * @param $page
     * @param $queryParams
     *
     * @return LengthAwarePaginator
     */
    public function getPaginatedUsers($page, $queryParams): LengthAwarePaginator
    {
        $query = $this->model
            ->leftJoin('organizations', 'organizations.id', 'users.organization_id')
            ->join('roles', 'roles.id', 'users.role_id')
            ->select('users.id', 'username', 'full_name', 'name->0->narrative as publisher_name', 'email', 'users.status', 'roles.role', 'role_id', 'users.created_at')
            ->where('users.id', '!=', Auth::user()->id);

        if (!empty($queryParams)) {
            $query = $this->filterUsers($query, $queryParams);
        }

        return $query->paginate(10, ['*'], 'users', $page);
    }

    /**
     * Returns paginated User count of organizations.
     *
     * @param $page
     * @param $queryParam
     *
     * @return LengthAwarePaginator
     */
    public function getUserCountByOrganization($page, $queryParam):LengthAwarePaginator
    {
        $query = $this->model::query()
            ->join('organizations', 'organizations.id', '=', 'users.organization_id')
            ->selectRaw('organizations.id as organization_id,
                organizations.publisher_name,
                count(Case when users.role_id = 3 and users.organization_id = organizations.id then 1 end) as admin_user_count,
                count(Case when users.role_id = 4 and users.organization_id = organizations.id then 1 end) as general_user_count,
                count(Case when users.status = true and users.organization_id = organizations.id then 1 end) as active_user_count,
                count(Case when users.status = false and users.organization_id = organizations.id then 1 end) as deactivated_user_count,
                count(organizations.id) as total_user_count')
            ->groupBy('organizations.id', 'organizations.publisher_name');

        $direction = Arr::get($queryParam, 'direction', 'asc');
        $orderBy = Arr::get($queryParam, 'order_by', 'name');

        if ($orderBy === 'name') {
            $query->orderBy('organizations.publisher_name', $direction);
        } else {
            $query->orderBy($orderBy, $direction);
        }

        return $query->paginate(10, ['*'], 'user', $page);
    }

    /**
     * Download csv with user data.
     *
     * @param $queryParams
     *
     * @return Collection|array
     */
    public function getUserDownloadData($queryParams): Collection | array
    {
        $query = $this->model
            ->leftJoin('organizations', 'organizations.id', 'users.organization_id')
            ->join('roles', 'roles.id', 'users.role_id');

        if (!empty($queryParams)) {
            $query = $this->filterUsers($query, $queryParams);
        }

        return $query->get(['username', 'full_name', 'name->0->narrative as publisher_name', 'email', 'roles.role', 'users.created_at', 'users.id as id']);
    }

    /**
     * Create user filter query.
     *
     * @param $query
     * @param $queryParams
     *
     * @return Builder
     */
    public function filterUsers($query, $queryParams): Builder
    {
        $orderBy = 'users.created_at';
        $direction = 'desc';

        if (!empty($queryParams['organization_id'])) {
            $query = $query->whereIn('organization_id', Arr::get($queryParams, 'organization_id', []));
        }

        if (array_key_exists('users', $queryParams)) {
            $query = $query->whereIn('users.id', Arr::get($queryParams, 'users'));
        }

        if (array_key_exists('status', $queryParams)) {
            $query = $query->whereIn('users.status', Arr::get($queryParams, 'status'));
        }

        if (!empty($queryParams['role'])) {
            $query = $query->whereIn('role_id', Arr::get($queryParams, 'role', []));
        }

        if (array_key_exists('q', $queryParams)) {
            $query = $query->where(function ($query) use ($queryParams) {
                $query->where('username', 'ilike', '%' . Arr::get($queryParams, 'q') . '%')
                ->orWhere('full_name', 'ilike', '%' . Arr::get($queryParams, 'q') . '%');
            });
        }

        if (array_key_exists('orderBy', $queryParams) && !empty($queryParams['orderBy'])) {
            $orderBy = $queryParams['orderBy'];

            if (array_key_exists('direction', $queryParams) && !empty($queryParams['direction'])) {
                $direction = $queryParams['direction'];
            }
        }

        return $query->whereNull('deleted_at')->orderBy($orderBy, $direction)->orderBy('users.id', $direction);
    }

    /**
     * Returns user count for user dashboard.
     *
     * @return Collection
     */
    public function getUserCounts(): Collection
    {
        $query = User::query()
            ->selectRaw('role_id, status, COUNT(*) as count')
            ->groupBy(['role_id', 'status']);

        return $query->get();
    }

    /**
     * Returns count of users registered today.
     *
     * @param $countOnly
     *
     * @return mixed
     */
    public function getUsersCreatedToday($countOnly): mixed
    {
        return $this->model->registeredToday($countOnly)->count();
    }
}
