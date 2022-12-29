<?php

declare(strict_types=1);

namespace App\IATI\Repositories\User;

use App\IATI\Models\User\User;
use App\IATI\Repositories\Repository;

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
        $users = $this->model->paginate(10, ['*'], 'users', $page);

        return $users;
    }

    public function getUserDownloadData()
    {
        $users = $this->model->select('username', 'full_name', 'organization_id', 'email', 'role_id')->join()->get()->toArray();

        dd($users);
        // return $this->model->select('username', 'full_name', 'organization_id', 'email', 'role_id')->get()->toArray();
    }

    public function filterUsers()
    {
        $whereSql = '1=1';

        // foreach($filter as $key=>$value){

        // }
    }
}
