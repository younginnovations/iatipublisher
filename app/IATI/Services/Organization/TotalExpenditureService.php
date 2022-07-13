<?php

declare(strict_types=1);

namespace App\IATI\Services\Organization;

use App\IATI\Repositories\Organization\TotalExpenditureRepository;
use App\IATI\Traits\OrganizationXmlBaseElements;
use Illuminate\Database\Eloquent\Model;

/**
 * Class TotalExpenditureService.
 */
class TotalExpenditureService
{
    use OrganizationXmlBaseElements;

    /**
     * @var TotalExpenditureRepository
     */
    protected TotalExpenditureRepository $totalExpenditureRepository;

    /**
     * TotalExpenditureService constructor.
     *
     * @param TotalExpenditureRepository $totalExpenditureRepository
     */
    public function __construct(TotalExpenditureRepository $totalExpenditureRepository)
    {
        $this->totalExpenditureRepository = $totalExpenditureRepository;
    }

    /**
     * Returns total expenditure of an organization.
     *
     * @param int $organization_id
     *
     * @return array|null
     */
    public function getTotalExpenditureData(int $organization_id): ?array
    {
        return $this->totalExpenditureRepository->getTotalExpenditureData($organization_id);
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
        return $this->totalExpenditureRepository->getOrganizationData($id);
    }

    /**
     * Updates Organization total expenditure.
     *
     * @param $totalExpenditure
     * @param $organization
     *
     * @return bool
     */
    public function update($totalExpenditure, $organization): bool
    {
        return $this->totalExpenditureRepository->update($totalExpenditure, $organization);
    }

    /**
     * @param $orgData
     * @return array
     */
    public function getXmlData($orgData)
    {
        $orgTotalExpenseData = [];
        $totalBudget = (array) $orgData->total_expenditure;
        foreach ($totalBudget as $orgTotalExpense) {
            $orgTotalExpenseData[] = [
                '@attributes'  => [
                    // 'status' => $orgTotalExpense['total_expenditure_status'],
                ],
                'period-start' => [
                    '@attributes' => [
                        'iso-date' => $orgTotalExpense['period_start'][0]['iso_date'],
                    ],
                ],
                'period-end'   => [
                    '@attributes' => [
                        'iso-date' => $orgTotalExpense['period_end'][0]['iso_date'],
                    ],
                ],
                'value'        => [
                    '@value'      => $orgTotalExpense['value'][0]['amount'],
                    '@attributes' => [
                        'currency'   => $orgTotalExpense['value'][0]['currency'],
                        'value-date' => $orgTotalExpense['value'][0]['value_date'],
                    ],
                ],
                'expense-line' => $this->buildBudgetLine($orgTotalExpense['expense_line']),
            ];
        }

        return $orgTotalExpenseData;
    }
}
