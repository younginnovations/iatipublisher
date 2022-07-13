<?php

declare(strict_types=1);

namespace App\IATI\Repositories\Organization;

use App\IATI\Models\Organization\OrganizationPublish;
use Illuminate\Database\Eloquent\Model;

/**
 * Class OrganizationPublishRepository.
 */
class OrganizationPublishRepository
{
    /**
     * @var OrganizationPublish
     */
    protected OrganizationPublish $OrganizationPublish;

    /**
     * OrganizationPublishRepository Constructor.
     * @param OrganizationPublish $OrganizationPublish
     */
    public function __construct(OrganizationPublish $OrganizationPublish)
    {
        $this->OrganizationPublish = $OrganizationPublish;
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
        $published = $this->OrganizationPublish->firstOrNew([
            'filename' => $filename,
            'organization_id' => $organizationId,
        ]);

        $published->touch();

        return $published;
    }

    /**
     * Updates existing record in activity published table.
     *
     * @param $OrganizationPublish
     * @param $publishedActivities
     *
     * @return bool
     */
    public function update($OrganizationPublish, $publishedActivities): bool
    {
        $OrganizationPublish->published_activities = $publishedActivities;

        return $OrganizationPublish->save();
    }

    /**
     * Returns activity published data.
     *
     * @param $organization_id
     *
     * @return Model
     */
    public function getOrganizationPublish($organization_id): Model
    {
        return $this->OrganizationPublish->where('organization_id', $organization_id)->first();
    }

    /**
     * Updates activity published data.
     *
     * @param $publishedFile
     * @param $newPublishedFiles
     *
     * @return bool
     */
    public function updateOrganizationPublish($publishedFile, $newPublishedFiles): bool
    {
        $publishedFile->published_activities = array_values($newPublishedFiles);

        return $publishedFile->save();
    }
}
