<?php

declare(strict_types=1);

namespace App\Observers;

use App\IATI\Models\Organization\Organization;
use App\IATI\Services\ElementCompleteService;

/**
 * Class OrganizationObserver.
 */
class OrganizationObserver
{
    /**
     * @var ElementCompleteService
     */
    protected ElementCompleteService $elementCompleteService;

    /**
     * Organization observer constructor.
     */
    public function __construct()
    {
        $this->elementCompleteService = new ElementCompleteService();
    }

    /**
     * @param $updatedAttributes
     *
     * @return array
     * @throws \JsonException
     */
    public function getUpdatedElement($updatedAttributes): array
    {
        $elements = getElements();
        $updatedElements = [];

        foreach ($updatedAttributes as $element => $updatedAttribute) {
            if (in_array($element, $elements, true)) {
                $updatedElements[$element] = $updatedAttribute;
            }
        }

        return $updatedElements;
    }

    /**
     * Sets the complete status of elements.
     *
     * @param      $model
     * @param bool $isNew
     *
     * @return void
     * @throws \JsonException
     */
    public function setElementStatus($model, bool $isNew = false): void
    {
        $elementStatus = $model->element_status;
        $updatedElements = ($isNew) ? $this->getUpdatedElement($model->getAttributes()) : $this->getUpdatedElement($model->getChanges());

        foreach ($updatedElements as $attribute => $value) {
            $elementStatus[$attribute] = call_user_func([$this->elementCompleteService, dashesToCamelCase('is_' . $attribute . '_element_completed')], $model);
        }

        $model->element_status = $elementStatus;
    }

    /**
     * Handle the Organization "created" event.
     *
     * @param Organization $organization
     *
     * @return void
     * @throws \JsonException
     */
    public function created(Organization $organization): void
    {
        $this->setElementStatus($organization, true);
        $this->resetOrganizationStatus($organization);
        $organization->saveQuietly();
    }

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
        $this->setElementStatus($organization);
        $this->resetOrganizationStatus($organization);
        $organization->saveQuietly();
    }

    /**
     * Resets Organization status to draft.
     *
     * @param $model
     *
     * @return void
     */
    public function resetOrganizationStatus($model)
    {
        $model->status = 'draft';
    }

    // /**
    //  * Handle the Organization "updated" event.
    //  *
    //  * @param Organization $organization
    //  *
    //  * @return void
    //  * @throws \JsonException
    //  */
    // public function updated(Organization $organization): void
    // {
    //     $organization->reporting_org_complete_status = $organization->getReportingOrgElementCompletedAttribute();

    //     $organization->saveQuietly();
    // }
}
