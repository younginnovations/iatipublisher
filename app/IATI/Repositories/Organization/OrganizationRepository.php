<?php

declare(strict_types=1);

namespace App\IATI\Repositories\Organization;

use App\IATI\Models\Organization\Organization;
use App\IATI\Repositories\Repository;

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
        return $this->model->firstOrCreate($data);
    }
}
