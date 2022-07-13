<?php

declare(strict_types=1);

namespace App\IATI\Repositories\Organization;

use App\IATI\Models\Organization\Organization;
use Illuminate\Database\Eloquent\Model;

/**
 * Class RecipientOrgBudgetRepository.
 */
class RecipientOrgBudgetRepository
{
    /**
     * @var Organization
     */
    protected Organization $organization;

    /**
     * RecipientOrgBudgetRepository Constructor.
     *
     * @param Organization $organization
     */
    public function __construct(Organization $organization)
    {
        $this->organization = $organization;
    }

    /**
     * Returns recipient org budget data of an organization.
     *
     * @param $organizationId
     *
     * @return array|null
     */
    public function getRecipientOrgBudgetData($organizationId): ?array
    {
        return $this->organization->findorFail($organizationId)->recipient_org_budget;
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
     * Updates organization recipient org budget.
     *
     * @param $recipientOrgBudget
     * @param $organization
     *
     * @return bool
     */
    public function update($recipientOrgBudget, $organization): bool
    {
        $recipientOrgBudget['recipient_org_budget'] = array_values($recipientOrgBudget['recipient_org_budget']);

        foreach ($recipientOrgBudget['recipient_org_budget'] as $key => $budget) {
            foreach ($budget['recipient_org'] as $sub_index => $sub_element) {
                $recipientOrgBudget['recipient_org_budget'][$key]['recipient_org'][$sub_index]['narrative'] = array_values($sub_element['narrative']);
            }

            foreach ($budget['budget_line'] as $sub_index => $sub_element) {
                $recipientOrgBudget['recipient_org_budget'][$key]['budget_line'][$sub_index]['narrative'] = array_values($sub_element['narrative']);
            }

            $recipientOrgBudget['recipient_org_budget'][$key]['budget_line'] = array_values($recipientOrgBudget['recipient_org_budget'][$key]['budget_line']);
        }

        $organization->recipient_org_budget = array_values($recipientOrgBudget['recipient_org_budget']);

        return $organization->save();
    }
}
