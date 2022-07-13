<?php

declare(strict_types=1);

namespace App\IATI\Services\Organization;

use App\IATI\Repositories\Organization\TotalBudgetRepository;
use Illuminate\Database\Eloquent\Model;

/**
 * Class TotalBudgetService.
 */
class TotalBudgetService
{
    /**
     * @var TotalBudgetRepository
     */
    protected TotalBudgetRepository $totalBudgetRepository;

    /**
     * TotalBudgetService constructor.
     *
     * @param TotalBudgetRepository $totalBudgetRepository
     */
    public function __construct(TotalBudgetRepository $totalBudgetRepository)
    {
        $this->totalBudgetRepository = $totalBudgetRepository;
    }

    /**
     * Returns total budget of an organization.
     *
     * @param int $organization_id
     *
     * @return array|null
     */
    public function getTotalBudgetData(int $organization_id): ?array
    {
        return $this->totalBudgetRepository->getTotalBudgetData($organization_id);
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
        return $this->totalBudgetRepository->getOrganizationData($id);
    }

    /**
     * Updates Organization budget.
     *
     * @param $totalBudget
     * @param $organization
     *
     * @return bool
     */
    public function update($totalBudget, $organization): bool
    {
        return $this->totalBudgetRepository->update($totalBudget, $organization);
    }
}
