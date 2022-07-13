<?php

declare(strict_types=1);

namespace App\IATI\Services\Organization;

use App\IATI\Repositories\Organization\RecipientCountryBudgetRepository;
use Illuminate\Database\Eloquent\Model;

/**
 * Class RecipientCountryBudgetService.
 */
class RecipientCountryBudgetService
{
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
}
