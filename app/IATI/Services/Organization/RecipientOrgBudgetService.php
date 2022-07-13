<?php

declare(strict_types=1);

namespace App\IATI\Services\Organization;

use App\IATI\Repositories\Organization\RecipientOrgBudgetRepository;
use App\IATI\Traits\OrganizationXmlBaseElements;
use Illuminate\Database\Eloquent\Model;

/**
 * Class RecipientOrgBudgetService.
 */
class RecipientOrgBudgetService
{
    use OrganizationXmlBaseElements;

    /**
     * @var RecipientOrgBudgetRepository
     */
    protected RecipientOrgBudgetRepository $recipientOrgBudgetRepository;

    /**
     * RecipientOrgBudgetService constructor.
     *
     * @param RecipientOrgBudgetRepository $recipientOrgBudgetRepository
     */
    public function __construct(RecipientOrgBudgetRepository $recipientOrgBudgetRepository)
    {
        $this->recipientOrgBudgetRepository = $recipientOrgBudgetRepository;
    }

    /**
     * Returns recipient org budget of an organization.
     *
     * @param int $organization_id
     *
     * @return array|null
     */
    public function getRecipientOrgBudgetData(int $organization_id): ?array
    {
        return $this->recipientOrgBudgetRepository->getRecipientOrgBudgetData($organization_id);
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
        return $this->recipientOrgBudgetRepository->getOrganizationData($id);
    }

    /**
     * Updates recipient org budget.
     *
     * @param $recipientOrgBudget
     * @param $organization
     *
     * @return bool
     */
    public function update($recipientOrgBudget, $organization): bool
    {
        return $this->recipientOrgBudgetRepository->update($recipientOrgBudget, $organization);
    }

    /**
     * @param $organization
     * @return mixed
     */
    public function getXmlData($organization)
    {
        $organizationData = [];
        $recipientOrgBudget = (array) $organization->recipient_organization_budget;
        foreach ($recipientOrgBudget as $RecipientOrgBudget) {
            $organizationData[] = [
                '@attributes'   => [
                    'status' => $RecipientOrgBudget['status'],
                ],
                'recipient-org' => [
                    '@attributes' => [
                        'ref' => $RecipientOrgBudget['recipient_organization'][0]['ref'],
                    ],
                    'narrative'   => $this->buildNarrative($RecipientOrgBudget['recipient_organization'][0]['narrative']),
                ],
                'period-start'  => [
                    '@attributes' => [
                        'iso-date' => $RecipientOrgBudget['period_start'][0]['date'],
                    ],
                ],
                'period-end'    => [
                    '@attributes' => [
                        'iso-date' => $RecipientOrgBudget['period_end'][0]['date'],
                    ],
                ],
                'value'         => [
                    '@value'      => $RecipientOrgBudget['value'][0]['amount'],
                    '@attributes' => [
                        'currency'   => $RecipientOrgBudget['value'][0]['currency'],
                        'value-date' => $RecipientOrgBudget['value'][0]['value_date'],
                    ],
                ],
                'budget-line' => $this->buildBudgetLine($RecipientOrgBudget['budget_line']),
            ];
        }

        return $organizationData;
    }
}
