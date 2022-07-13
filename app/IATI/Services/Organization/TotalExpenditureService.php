<?php

declare(strict_types=1);

namespace App\IATI\Services\Organization;

use App\IATI\Repositories\Organization\TotalExpenditureRepository;
use Illuminate\Database\Eloquent\Model;

/**
 * Class TotalExpenditureService.
 */
class TotalExpenditureService
{
    /**
     * @var TotalExpenditureRepository
     */
    protected TotalExpenditureRepository $totalExpenditureRepository;

    /**
     * TotalExpenditureService constructor.
     *
     * @param TotalExpenditureRepository $totalExpenditureRepository
     */
    public function __construct(TotalExpenditureRepository $totalExpenditureRepository)
    {
        $this->totalExpenditureRepository = $totalExpenditureRepository;
    }

    /**
     * Returns total expenditure of an organization.
     *
     * @param int $organization_id
     *
     * @return array|null
     */
    public function getTotalExpenditureData(int $organization_id): ?array
    {
        return $this->totalExpenditureRepository->getTotalExpenditureData($organization_id);
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
        return $this->totalExpenditureRepository->getOrganizationData($id);
    }

    /**
     * Updates Organization total expenditure.
     *
     * @param $totalExpenditure
     * @param $organization
     *
     * @return bool
     */
    public function update($totalExpenditure, $organization): bool
    {
        return $this->totalExpenditureRepository->update($totalExpenditure, $organization);
    }
}
