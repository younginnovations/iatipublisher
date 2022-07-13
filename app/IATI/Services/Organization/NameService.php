<?php

declare(strict_types=1);

namespace App\IATI\Services\Organization;

use App\IATI\Repositories\Organization\NameRepository;
use Illuminate\Database\Eloquent\Model;

/**
 * Class NameService.
 */
class NameService
{
    /**
     * @var NameRepository
     */
    protected NameRepository $nameRepository;

    /**
     * NameService constructor.
     *
     * @param NameRepository $nameRepository
     */
    public function __construct(NameRepository $nameRepository)
    {
        $this->nameRepository = $nameRepository;
    }

    /**
     * Returns name data of an organization.
     *
     * @param int $organization_id
     *
     * @return array|null
     */
    public function getNameData(int $organization_id): ?array
    {
        return $this->nameRepository->getNameData($organization_id);
    }

    /**
     * Returns Organization object.
     *
     * @param $id
     *
     * @return Model
     */
    public function getOrganizationData($id): Model
    {
        return $this->nameRepository->getOrganizationData($id);
    }

    /**
     * Updates Organization name.
     *
     * @param $organizationName
     * @param $organization
     *
     * @return bool
     */
    public function update($organizationName, $organization): bool
    {
        $organization->name = array_values($organizationName['narrative']);

        return $organization->save();
    }
}
