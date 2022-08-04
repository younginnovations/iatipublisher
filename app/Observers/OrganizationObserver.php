<?php

namespace App\Observers;

use App\IATI\Models\Organization\Organization;

class OrganizationObserver
{
    /**
     * @throws \JsonException
     */
    public function updated(Organization $organization): void
    {
        $organization->reporting_org_complete_status = $organization->getReportingOrgElementCompletedAttribute();

        $organization->saveQuietly();
    }
}
