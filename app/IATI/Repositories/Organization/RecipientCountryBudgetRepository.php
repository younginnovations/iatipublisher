<?php

declare(strict_types=1);

namespace App\IATI\Repositories\Organization;

use App\IATI\Models\Organization\Organization;
use Illuminate\Database\Eloquent\Model;

/**
 * Class RecipientCountryBudgetRepository.
 */
class RecipientCountryBudgetRepository
{
    /**
     * @var Organization
     */
    protected Organization $organization;

    /**
     * RecipientCountryBudgetRepository Constructor.
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
    public function getRecipientCountryBudgetData($organizationId): ?array
    {
        return $this->organization->findorFail($organizationId)->recipient_country_budget;
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
     * Updates organization reporting country budget.
     *
     * @param $recipientCountryBudget
     * @param $organization
     *
     * @return bool
     */
    public function update($recipientCountryBudget, $organization): bool
    {
        $recipientCountryBudget['recipient_country_budget'] = array_values($recipientCountryBudget['recipient_country_budget']);

        foreach ($recipientCountryBudget['recipient_country_budget'] as $key => $budget) {
            foreach ($budget['recipient_country'] as $sub_index => $sub_element) {
                $recipientCountryBudget['recipient_country_budget'][$key]['recipient_country'][$sub_index]['narrative'] = array_values($sub_element['narrative']);
            }

            foreach ($budget['budget_line'] as $sub_index => $sub_element) {
                $recipientCountryBudget['recipient_country_budget'][$key]['budget_line'][$sub_index]['narrative'] = array_values($sub_element['narrative']);
            }

            $recipientCountryBudget['recipient_country_budget'][$key]['budget_line'] = array_values($recipientCountryBudget['recipient_country_budget'][$key]['budget_line']);
            $recipientCountryBudget['recipient_country_budget'][$key]['recipient_country'] = array_values($recipientCountryBudget['recipient_country_budget'][$key]['recipient_country']);
        }

        $organization->recipient_country_budget = $recipientCountryBudget['recipient_country_budget'];

        return $organization->save();
    }
}
