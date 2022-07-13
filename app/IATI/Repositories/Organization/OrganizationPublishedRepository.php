<?php

declare(strict_types=1);

namespace App\IATI\Repositories\Organization;

use App\IATI\Models\Organization\OrganizationPublished;
use Illuminate\Database\Eloquent\Model;

/**
 * Class OrganizationPublishedRepository.
 */
class OrganizationPublishedRepository
{
    /**
     * @var OrganizationPublished
     */
    protected OrganizationPublished $organizationPublished;

    /**
     * OrganizationPublishedRepository Constructor.
     * @param OrganizationPublished $organizationPublished
     */
    public function __construct(OrganizationPublished $organizationPublished)
    {
        $this->organizationPublished = $organizationPublished;
    }

    /**
     * Creates new record or updates existing record in activity published table.
     *
     * @param $filename
     * @param $organizationId
     *
     * @return Model
     */
    public function findOrCreate($filename, $organizationId): Model
    {
        $published = $this->organizationPublished->firstOrNew([
            'filename' => $filename,
            'organization_id' => $organizationId,
            'published_to_registry' => true,
        ]);

        $published->touch();

        return $published;
    }

    /**
     * Updates existing record in activity published table.
     *
     * @param $organizationPublished
     * @param $publishedActivities
     *
     * @return bool
     */
    public function update($organizationPublished, $publishedActivities): bool
    {
        $organizationPublished->published_activities = $publishedActivities;

        return $organizationPublished->save();
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
        return $this->organizationPublished->where('organization_id', $organization_id)->first();
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
        $publishedFile->published_activities = array_values($newPublishedFiles);

        return $publishedFile->save();
    }
}
