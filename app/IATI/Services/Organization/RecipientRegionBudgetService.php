<?php

declare(strict_types=1);

namespace App\IATI\Services\Organization;

use App\IATI\Repositories\Organization\RecipientRegionBudgetRepository;
use Illuminate\Database\Eloquent\Model;

/**
 * Class RecipientRegionBudgetService.
 */
class RecipientRegionBudgetService
{
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
}
