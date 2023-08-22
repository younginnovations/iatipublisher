<?php

declare(strict_types=1);

namespace App\IATI\Services\Organization;

use App\IATI\Repositories\Organization\OrganizationPublishedRepository;
use Illuminate\Database\Eloquent\Model;

/**
 * Class OrganizationPublishedService.
 */
class OrganizationPublishedService
{
    /**
     * @var OrganizationPublishedRepository
     */
    protected OrganizationPublishedRepository $organizationPublishedRepository;

    /**
     * OrganizationPublishedService constructor.
     *
     * @param OrganizationPublishedRepository $organizationPublishedRepository
     */
    public function __construct(OrganizationPublishedRepository $organizationPublishedRepository)
    {
        $this->organizationPublishedRepository = $organizationPublishedRepository;
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
        return $this->organizationPublishedRepository->findOrCreate($filename, $organizationId);
    }

    /**
     * Returns activity published data.
     *
     * @param $organization_id
     *
     * @return Model
     */
    public function getOrganizationPublished($organization_id): ?Model
    {
        return $this->organizationPublishedRepository->getOrganizationPublished($organization_id);
    }

    /**
     * Updates activity published data.
     *
     * @param $publishedFile
     * @param $newPublishedFiles
     *
     * @return bool
     */
    public function updateOrganizationPublished($publishedFile, $newPublishedFiles): bool
    {
        return $this->organizationPublishedRepository->updateOrganizationPublished($publishedFile, $newPublishedFiles);
    }

    /**
     * Updates organization published table.
     *
     * @param $organization_id
     * @param $status
     *
     * @return void
     */
    public function updateStatus($organization_id, $status): void
    {
        $this->organizationPublishedRepository->update($organization_id, [
            'published_to_registry' => $status ? 1 : 0,
        ]);
    }
}
