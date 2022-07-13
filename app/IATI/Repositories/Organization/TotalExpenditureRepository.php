<?php

declare(strict_types=1);

namespace App\IATI\Repositories\Organization;

use App\IATI\Models\Organization\Organization;
use Illuminate\Database\Eloquent\Model;

/**
 * Class  TotalExpenditureRepository.
 */
class TotalExpenditureRepository
{
    /**
     * @var Organization
     */
    protected Organization $organization;

    /**
     *  TotalExpenditureRepository Constructor.
     *
     * @param Organization $organization
     */
    public function __construct(Organization $organization)
    {
        $this->organization = $organization;
    }

    /**
     * Returns total expenditure data of an organization.
     *
     * @param $organizationId
     *
     * @return array|null
     */
    public function getTotalExpenditureData($organizationId): ?array
    {
        return $this->organization->findorFail($organizationId)->total_expenditure;
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
     * Updates organization total expenditure.
     *
     * @param $totalExpenditure
     * @param $organization
     *
     * @return bool
     */
    public function update($totalExpenditure, $organization): bool
    {
        $totalExpenditure['total_expenditure'] = array_values($totalExpenditure['total_expenditure']);

        foreach ($totalExpenditure['total_expenditure'] as $key => $budget) {
            foreach ($budget['expense_line'] as $sub_index => $sub_element) {
                $totalExpenditure['total_expenditure'][$key]['expense_line'][$sub_index]['narrative'] = array_values($sub_element['narrative']);
            }

            $totalExpenditure['total_expenditure'][$key]['expense_line'] = array_values($totalExpenditure['total_expenditure'][$key]['expense_line']);
        }

        $organization->total_expenditure = $totalExpenditure['total_expenditure'];

        return $organization->save();
    }
}
