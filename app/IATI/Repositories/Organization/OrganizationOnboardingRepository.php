<?php

declare(strict_types=1);

namespace App\IATI\Repositories\Organization;

use App\IATI\Models\Organization\OrganizationOnboarding;
use App\IATI\Repositories\Repository;

/**
 * Class OrganizationOnboardingRepository.
 */
class OrganizationOnboardingRepository extends Repository
{
    /**
     * Return OrganizationOnboarding model.
     *
     * @return string
     */
    public function getModel(): string
    {
        return OrganizationOnboarding::class;
    }

    /**
     * Returns organization onboarding information.
     *
     * @param $organization_id
     *
     * @return object|null
     */
    public function getOrganizationOnboarding($organization_id): ?object
    {
        return $this->model->where('org_id', $organization_id)->first();
    }
}
