<?php

declare(strict_types=1);

namespace App\IATI\Services\Organization;

use App\IATI\Models\Organization\Organization;
use App\IATI\Repositories\Organization\RecipientRegionBudgetRepository;
use App\IATI\Traits\OrganizationXmlBaseElements;
use Illuminate\Database\Eloquent\Model;

/**
 * Class RecipientRegionBudgetService.
 */
class RecipientRegionBudgetService
{
    use OrganizationXmlBaseElements;

    /**
     * @var RecipientRegionBudgetRepository
     */
    protected RecipientRegionBudgetRepository $recipientRegionBudgetRepository;

    /**
     * RecipientRegionBudgetService constructor.
     *
     * @param RecipientRegionBudgetRepository $recipientRegionBudgetRepository
     */
    public function __construct(RecipientRegionBudgetRepository $recipientRegionBudgetRepository)
    {
        $this->recipientRegionBudgetRepository = $recipientRegionBudgetRepository;
    }

    /**
     * Returns recipient region budget of an organization.
     *
     * @param int $organization_id
     *
     * @return array|null
     */
    public function getRecipientRegionBudgetData(int $organization_id): ?array
    {
        return $this->recipientRegionBudgetRepository->getRecipientRegionBudgetData($organization_id);
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
        return $this->recipientRegionBudgetRepository->getOrganizationData($id);
    }

    /**
     * Updates recipient org budget.
     *
     * @param $recipientRegionBudget
     * @param $organization
     *
     * @return bool
     */
    public function update($recipientRegionBudget, $organization): bool
    {
        return $this->recipientRegionBudgetRepository->update($recipientRegionBudget, $organization);
    }

    /**
     * return recipient region budget xml data.
     * @param OrganizationData $organizationData
     * @return array
     */
    public function getXmlData($organizationData)
    {
        $orgRecipientRegionData = [];
        $recipientRegionBudget = (array) $organizationData->recipient_region_budget;
        foreach ($recipientRegionBudget as $orgRecipientRegion) {
            $orgRecipientRegionData[] = [
                '@attributes'      => [
                    'status' => $orgRecipientRegion['status'],
                ],
                'recipient-region' => [
                    '@attributes' => [
                        'vocabulary'     => $orgRecipientRegion['recipient_region'][0]['region_vocabulary'],
                        'vocabulary-uri' => $orgRecipientRegion['recipient_region'][0]['vocabulary_uri'] ?? '',
                        'code'           => $orgRecipientRegion['recipient_region'][0]['region_code'] ?? '',
                    ],
                    'narrative'   => $this->buildNarrative($orgRecipientRegion['recipient_region'][0]['narrative']),
                ],
                'period-start'     => [
                    '@attributes' => [
                        'iso-date' => $orgRecipientRegion['period_start'][0]['date'],
                    ],
                ],
                'period-end'       => [
                    '@attributes' => [
                        'iso-date' => $orgRecipientRegion['period_end'][0]['date'],
                    ],
                ],
                'value'            => $this->buildValue($orgRecipientRegion['value']),
                'budget-line'      => $this->buildBudgetLine($orgRecipientRegion['budget_line']),
            ];
        }

        return $orgRecipientRegionData;
    }
}
