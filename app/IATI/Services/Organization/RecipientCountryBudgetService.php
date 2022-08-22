<?php

declare(strict_types=1);

namespace App\IATI\Services\Organization;

use App\IATI\Models\Organization\Organization;
use App\IATI\Repositories\Organization\RecipientCountryBudgetRepository;
use App\IATI\Traits\OrganizationXmlBaseElements;
use Illuminate\Database\Eloquent\Model;

/**
 * Class RecipientCountryBudgetService.
 */
class RecipientCountryBudgetService
{
    use OrganizationXmlBaseElements;

    /**
     * @var RecipientCountryBudgetRepository
     */
    protected RecipientCountryBudgetRepository $recipientCountryBudgetRepository;

    /**
     * RecipientCountryBudgetService constructor.
     *
     * @param RecipientCountryBudgetRepository $recipientCountryBudgetRepository
     */
    public function __construct(RecipientCountryBudgetRepository $recipientCountryBudgetRepository)
    {
        $this->recipientCountryBudgetRepository = $recipientCountryBudgetRepository;
    }

    /**
     * Returns recipient country budget of an organization.
     *
     * @param int $organization_id
     *
     * @return array|null
     */
    public function getRecipientCountryBudgetData(int $organization_id): ?array
    {
        return $this->recipientCountryBudgetRepository->getRecipientCountryBudgetData($organization_id);
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
        return $this->recipientCountryBudgetRepository->getOrganizationData($id);
    }

    /**
     * Updates recipient org budget.
     *
     * @param $recipientCountryBudget
     * @param $organization
     *
     * @return bool
     */
    public function update($recipientCountryBudget, $organization): bool
    {
        return $this->recipientCountryBudgetRepository->update($recipientCountryBudget, $organization);
    }

    /**
     * @param OrganizationData $organizationData
     * @return array
     */
    public function getXmlData($organizationData)
    {
        $orgRecipientCountryData = [];
        $recipientCountryBudget = (array) $organizationData->recipient_country_budget;
        foreach ($recipientCountryBudget as $orgRecipientCountry) {
            $orgRecipientCountryData[] = [
                'recipient-country' => [
                    '@attributes' => [
                        'code' => $orgRecipientCountry['recipient_country'][0]['code'],
                    ],
                    'narrative' => $this->buildNarrative($orgRecipientCountry['recipient_country'][0]['narrative']),
                ],
                'period-start' => [
                    '@attributes' => [
                        'iso-date' => $orgRecipientCountry['period_start'][0]['date'],
                    ],
                ],
                'period-end' => [
                    '@attributes' => [
                        'iso-date' => $orgRecipientCountry['period_end'][0]['date'],
                    ],
                ],
                'value' => [
                    '@value'      => $orgRecipientCountry['value'][0]['amount'],
                    '@attributes' => [
                        'currency' => $orgRecipientCountry['value'][0]['currency'],
                        'value-date' => $orgRecipientCountry['value'][0]['value_date'],
                    ],
                ],
                'budget-line' => $this->buildBudgetLine($orgRecipientCountry['budget_line']),
            ];
        }

        return $orgRecipientCountryData;
    }
}
