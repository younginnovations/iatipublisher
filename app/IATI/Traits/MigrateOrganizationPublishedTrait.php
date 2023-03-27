<?php

declare(strict_types=1);

namespace App\IATI\Traits;

use App\IATI\Models\Organization\OrganizationPublished;

/**
 * Class MigrateOrganizationPublishedTrait.
 */
trait MigrateOrganizationPublishedTrait
{
    /**
     * Migrates OrganizationPublished XML file.
     *
     * @param $aidStreamOrganization
     * @param $iatiOrganization
     *
     * @return void
     */
    public function migrateOrganizationPublishedFile($aidStreamOrganization, $iatiOrganization): void
    {
        $publishedOrganization = $this->db::connection('aidstream')->table('organization_published')
            ->where('organization_id', '=', $aidStreamOrganization->id)
            ->where('published_to_register', '=', 1)
            ->first();

        if ($publishedOrganization) {
            $pathToAidstreamOrganizationFile = 'aidstream-xml';
            $aidstreamFilename = $publishedOrganization->filename;
            $pathToIatiOrganizationFile = 'organizationXmlFiles';
            $iatiFilename = "{$iatiOrganization->publisher_id}-organisation.xml";

            $contents = awsGetFile("{$pathToAidstreamOrganizationFile}/$aidstreamFilename");

            if ($contents && awsUploadFile("$pathToIatiOrganizationFile/$iatiFilename", $contents)) {
                $this->logInfo("Migrated organization file :{$aidstreamFilename} as file :{$iatiFilename}.");
            }
        }
    }

    /**
     * Migrates OrganizationPublished table record.
     *
     * @param $aidStreamOrganization
     * @param $iatiOrganization
     *
     * @return bool
     */
    public function migrateOrganizationPublishedTable($aidStreamOrganization, $iatiOrganization): bool
    {
        $publishedOrganization = $this->db::connection('aidstream')->table('organization_published')
            ->where('organization_id', $aidStreamOrganization->id)
            ->first();

        if ($publishedOrganization) {
            $organizationPublished = new OrganizationPublished();

            return $organizationPublished->fill([
                'filename'              => "{$iatiOrganization->publisher_id}-organisation.xml",
                'organization_id'       => $iatiOrganization->id,
                'published_to_registry' => (bool) $publishedOrganization->published_to_register,
                'created_at'            => $publishedOrganization->created_at,
                'updated_at'            => $publishedOrganization->updated_at,
            ])->save();
        }

        return true;
    }
}
