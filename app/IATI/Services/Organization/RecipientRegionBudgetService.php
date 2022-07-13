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

    // /**
    //  * Returns recipient region for xml generation.
    //  *
    //  * @param Organization $organization
    //  *
    //  * @return array
    //  */
    // public function getXMLData(Organization $organization): array
    // {
    //     $recipient_regions = (array)$organization->recipient_region_budget;
    //     $organizationData = [];

    //     if (count($recipient_regions)) {
    //         foreach ($recipient_regions as $key => $recipient_region) {
    //             $regions = [];
    //             $budget = [];

    //             foreach ($recipient_region['recipient_region'] as $index => $region) {
    //                 $regions[] = [
    //                     '@attributes' => [
    //                         'code' => $region[$index]['code'],
    //                     ],
    //                     'sub-elements' => [
    //                         'narrative' => $this->buildNarrative($region[$index]['narrative']),
    //                     ],
    //                 ];
    //             }

    //             $period_start['@attributes']['iso_date'] = $recipient_region[$key]['period_start'][0]['iso_date'];
    //             $period_end['@attributes']['iso_date'] = $recipient_region[$key]['period_end'][0]['iso_date'];

    //             foreach ($recipient_region['budget_line'] as $index => $budget_line) {
    //                 $budget[] = [
    //                     '@attributes' => [
    //                         'ref' => $budget_line[$index]['ref'],
    //                     ],
    //                     'value' => [
    //                         '@attributes' => $this->buildValue($budget_line[$index]['value']),
    //                     ],
    //                     'sub-elements' => [
    //                         'narrative' => $this->buildValue($budget_line[$index]['narrative']),
    //                     ],
    //                 ];
    //             }

    //             $organizationData[] = [
    //                 '@attributes' => [
    //                     'status' => $recipient_region[$key]['status'],
    //                 ],
    //                 'recipient-country' => $regions,
    //                 'period-start' => $period_start,
    //                 'period-end' => $period_end,
    //                 'value' => $this->buildValue($recipient_region['value']),
    //                 'budget-line' => $budget,
    //             ];
    //         }
    //     }

    //     return $organizationData;
    // }

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
