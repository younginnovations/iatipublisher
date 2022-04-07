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
    public function getModel():string
    {
        return Organization::class;
    }

    public function createOrganization(array $data)
    {
        return $this->model->firstOrCreate($data);
    }
}
