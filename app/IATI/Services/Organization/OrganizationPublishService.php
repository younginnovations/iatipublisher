<?php

declare(strict_types=1);

namespace App\IATI\Services\Organization;

use App\IATI\Repositories\Organization\OrganizationPublishRepository;
use Illuminate\Database\Eloquent\Model;

/**
 * Class OrganizationPublishService.
 */
class OrganizationPublishService
{
    /**
     * @var OrganizationPublishRepository
     */
    protected OrganizationPublishRepository $OrganizationPublishRepository;

    /**
     * OrganizationPublishService constructor.
     *
     * @param OrganizationPublishRepository $OrganizationPublishRepository
     */
    public function __construct(OrganizationPublishRepository $OrganizationPublishRepository)
    {
        $this->OrganizationPublishRepository = $OrganizationPublishRepository;
    }

    /**
     * Returns new record or existing record in activity published table.
     *
     * @param $filename
     * @param $organizationId
     *
     * @return Model
     */
    public function findOrCreate($filename, $organizationId): Model
    {
        return $this->OrganizationPublishRepository->findOrCreate($filename, $organizationId);
    }

    /**
     * Updates existing record in activity published table.
     *
     * @param $activityPublished
     * @param $publishedActivities
     *
     * @return bool
     */
    public function update($activityPublished, $publishedActivities): bool
    {
        return $this->OrganizationPublishRepository->update($activityPublished, $publishedActivities);
    }

    /**
     * Returns activity published data.
     *
     * @param $organization_id
     *
     * @return Model
     */
    public function getActivityPublished($organization_id): Model
    {
        return $this->OrganizationPublishRepository->getActivityPublished($organization_id);
    }

    /**
     * Updates activity published data.
     *
     * @param $publishedFile
     * @param $newPublishedFiles
     *
     * @return bool
     */
    public function updateActivityPublished($publishedFile, $newPublishedFiles): bool
    {
        return $this->OrganizationPublishRepository->updateActivityPublished($publishedFile, $newPublishedFiles);
    }
}
