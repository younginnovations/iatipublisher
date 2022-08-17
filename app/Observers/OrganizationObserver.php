<?php

declare(strict_types=1);

namespace App\Observers;

use App\IATI\Models\Organization\Organization;

/**
 * Class OrganizationObserver.
 */
class OrganizationObserver
{
    /**
     * Handle the Organization "updated" event.
     *
     * @param Organization $organization
     *
     * @return void
     * @throws \JsonException
     */
    public function updated(Organization $organization): void
    {
        $organization->reporting_org_complete_status = $organization->getReportingOrgElementCompletedAttribute();

        $organization->saveQuietly();
    }
}
