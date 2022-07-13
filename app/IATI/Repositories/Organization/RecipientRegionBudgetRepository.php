<?php

declare(strict_types=1);

namespace App\IATI\Repositories\Organization;

use App\IATI\Models\Organization\Organization;
use Illuminate\Database\Eloquent\Model;

/**
 * Class RecipientRegionBudgetRepository.
 */
class RecipientRegionBudgetRepository
{
    /**
     * @var Organization
     */
    protected Organization $organization;

    /**
     * RecipientRegionBudgetRepository Constructor.
     *
     * @param Organization $organization
     */
    public function __construct(Organization $organization)
    {
        $this->organization = $organization;
    }

    /**
     * Returns reporting org budget data of an organization.
     *
     * @param $organizationId
     *
     * @return array|null
     */
    public function getRecipientRegionBudgetData($organizationId): ?array
    {
        return $this->organization->findorFail($organizationId)->recipient_region_budget;
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
     * Updates organization reporting region budget.
     *
     * @param $recipientRegionBudget
     * @param $organization
     *
     * @return bool
     */
    public function update($recipientRegionBudget, $organization): bool
    {
        $recipientRegionBudget['recipient_region_budget'] = array_values($recipientRegionBudget['recipient_region_budget']);

        foreach ($recipientRegionBudget['recipient_region_budget'] as $key => $budget) {
            foreach ($budget['recipient_region'] as $sub_index => $sub_element) {
                $recipientRegionBudget['recipient_region_budget'][$key]['recipient_region'][$sub_index]['narrative'] = array_values($sub_element['narrative']);
            }

            foreach ($budget['budget_line'] as $sub_index => $sub_element) {
                $recipientRegionBudget['recipient_region_budget'][$key]['budget_line'][$sub_index]['narrative'] = array_values($sub_element['narrative']);
            }

            $recipientRegionBudget['recipient_region_budget'][$key]['budget_line'] = array_values($recipientRegionBudget['recipient_region_budget'][$key]['budget_line']);
            $recipientRegionBudget['recipient_region_budget'][$key]['recipient_region'] = array_values($recipientRegionBudget['recipient_region_budget'][$key]['recipient_region']);
        }

        $organization->recipient_region_budget = array_values($recipientRegionBudget['recipient_region_budget']);

        return $organization->save();
    }
}
