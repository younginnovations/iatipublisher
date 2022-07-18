<?php

declare(strict_types=1);

namespace App\IATI\Services\Organization;

use App\IATI\Repositories\Organization\RecipientOrgBudgetRepository;
use Illuminate\Database\Eloquent\Model;

/**
 * Class RecipientOrgBudgetService.
 */
class RecipientOrgBudgetService
{
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
}
