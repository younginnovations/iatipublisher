<?php

declare(strict_types=1);

namespace App\IATI\Repositories\User;

use App\IATI\Models\User\User;
use App\IATI\Repositories\Repository;
use Illuminate\Support\Arr;

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

    public function getPaginatedusers($page, $queryParams)
    {
        $query = $this->model
            ->join('organizations', 'organizations.id', 'users.organization_id')
            ->join('roles', 'roles.id', 'users.role_id')
            ->select('username', 'full_name', 'organizations.publisher_name', 'email', 'roles.role');

        if (!empty($queryParams)) {
            $query = $this->filterUsers($query, $queryParams);
        }

        return $query->paginate(10, ['*'], 'users', $page);
    }

    public function getUserDownloadData($queryParams)
    {
        $query = $this->model
            ->join('organizations', 'organizations.id', 'users.organization_id')
            ->join('roles', 'roles.id', 'users.role_id')
            ->select('username', 'full_name', 'organizations.publisher_name', 'email', 'roles.role');

        if (!empty($queryParams)) {
            $query = $this->filterUsers($query, $queryParams);
        }

        return $query->get()->toArray();
    }

    public function filterUsers($query, $queryParams)
    {
        // $orderBy = 'users.created_at';
        // $direction = 'desc';
        logger()->error($queryParams);

        if (array_key_exists('organization_id', $queryParams)) {
            $query = $query->whereIn('organization_id', explode(',', Arr::get($queryParams, 'organization_id', '')));
        }

        if (array_key_exists('status', $queryParams)) {
            $query = $query->where('status', Arr::get($queryParams, 'status'));
        }

        if (array_key_exists('role', $queryParams)) {
            $query = $query->whereIn('role_id', explode(',', Arr::get($queryParams, 'role', '')));
        }

        if (array_key_exists('q', $queryParams)) {
            $query = $query->where('username', 'like', Arr::get($queryParams, 'q'));
        }

        // if (array_key_exists('orderBy', $queryParams) && !empty($queryParams['orderBy'])) {
        //     $orderBy = $queryParams['orderBy'];

        //     if (array_key_exists('direction', $queryParams) && !empty($queryParams['direction'])) {
        //         $direction = $queryParams['direction'];
        //     }
        // }

        // return $query->orderBy($orderBy, $direction)->orderBy('users.id', $direction);
        return $query;
    }
}
