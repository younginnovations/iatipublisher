<?php

declare(strict_types=1);

namespace App\IATI\Services\Organization;

use App\IATI\Repositories\Organization\TotalBudgetRepository;
use App\IATI\Traits\OrganizationXmlBaseElements;
use Illuminate\Database\Eloquent\Model;

/**
 * Class TotalBudgetService.
 */
class TotalBudgetService
{
    use OrganizationXmlBaseElements;

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

    /**
     * @param $orgData
     * @return array
     */
    public function getXmlData($orgData)
    {
        $orgTotalBudgetData = [];
        $totalBudget = (array) $orgData->total_budget;
        foreach ($totalBudget as $orgTotalBudget) {
            $orgTotalBudgetData[] = [
                '@attributes'  => [
                    'status' => $orgTotalBudget['total_budget_status'],
                ],
                'period-start' => [
                    '@attributes' => [
                        'iso-date' => $orgTotalBudget['period_start'][0]['date'],
                    ],
                ],
                'period-end'   => [
                    '@attributes' => [
                        'iso-date' => $orgTotalBudget['period_end'][0]['date'],
                    ],
                ],
                'value'        => [
                    '@value'      => $orgTotalBudget['value'][0]['amount'],
                    '@attributes' => [
                        'currency'   => $orgTotalBudget['value'][0]['currency'],
                        'value-date' => $orgTotalBudget['value'][0]['value_date'],
                    ],
                ],
                'budget-line' => $this->buildBudgetLine($orgTotalBudget['budget_line']),
            ];
        }

        return $orgTotalBudgetData;
    }
}
