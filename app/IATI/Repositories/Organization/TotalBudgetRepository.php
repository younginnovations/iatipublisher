<?php

declare(strict_types=1);

namespace App\IATI\Repositories\Organization;

use App\IATI\Models\Organization\Organization;
use Illuminate\Database\Eloquent\Model;

/**
 * Class TotalBudgetRepository.
 */
class TotalBudgetRepository
{
    /**
     * @var Organization
     */
    protected Organization $organization;

    /**
     * TotalBudgetRepository Constructor.
     *
     * @param Organization $organization
     */
    public function __construct(Organization $organization)
    {
        $this->organization = $organization;
    }

    /**
     * Returns total budget data of an organization.
     *
     * @param $organizationId
     *
     * @return array|null
     */
    public function getTotalBudgetData($organizationId): ?array
    {
        return $this->organization->findorFail($organizationId)->total_budget;
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
        return $this->organization->findOrFail($id);
    }

    /**
     * Updates organization total budget.
     *
     * @param $totalBudget
     * @param $organization
     *
     * @return bool
     */
    public function update($totalBudget, $organization): bool
    {
        $totalBudget['total_budget'] = array_values($totalBudget['total_budget']);

        foreach ($totalBudget['total_budget'] as $key => $budget) {
            foreach ($budget['budget_line'] as $sub_index => $sub_element) {
                $totalBudget['total_budget'][$key]['budget_line'][$sub_index]['narrative'] = array_values($sub_element['narrative']);
            }

            $totalBudget['total_budget'][$key]['budget_line'] = array_values($totalBudget['total_budget'][$key]['budget_line']);
        }

        $organization->total_budget = array_values($totalBudget['total_budget']);

        return $organization->save();
    }
}
