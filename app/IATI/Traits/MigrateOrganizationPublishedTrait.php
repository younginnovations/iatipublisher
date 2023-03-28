<?php

declare(strict_types=1);

namespace App\IATI\Traits;

use App\Exceptions\PublishException;
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
     * @throws PublishException
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

            if ($contents) {
                $contents = $this->replaceDocumentLinkInXml($contents, $iatiOrganization->id);
                if (awsUploadFile("$pathToIatiOrganizationFile/$iatiFilename", $contents)) {
                    $this->logInfo("Migrated organization file: {$aidstreamFilename} as file :{$iatiFilename}.");
                } else {
                    $message = "Failed to upload organization file: {$aidstreamFilename} as file :{$iatiFilename} to S3.";
                    $this->setDetailedError(
                        $message,
                        $aidStreamOrganization->id,
                        'organization_published',
                        $publishedOrganization->id,
                        $iatiOrganization->id,
                        '',
                        'Organization published > Upload xml after replacing document link',
                    );
                }
            } else {
                $message = "No Organization file named: {$aidstreamFilename} found in S3 for Aidstream Organization: {$aidStreamOrganization->name} id: {$aidStreamOrganization->id} .";
                $this->logInfo($message);
                throw new PublishException($iatiOrganization->id, $message);
            }
        }
    }

    /**
     * Migrates OrganizationPublished table record.
     *
     * @param $aidStreamOrganization
     * @param $iatiOrganization
     *
     * @return object|null
     *
     * @throws \Exception
     */
    public function migrateOrganizationPublishedTable($aidStreamOrganization, $iatiOrganization): ?object
    {
        $publishedOrganization = $this->db::connection('aidstream')->table('organization_published')
            ->where('organization_id', $aidStreamOrganization->id)
            ->first();

        if ($publishedOrganization) {
            $organizationPublished = new OrganizationPublished();

            $organizationPublished->fill([
                'filename'              => "{$iatiOrganization->publisher_id}-organisation.xml",
                'organization_id'       => $iatiOrganization->id,
                'published_to_registry' => (bool) $publishedOrganization->published_to_register,
                'created_at'            => $publishedOrganization->created_at,
                'updated_at'            => $publishedOrganization->updated_at,
            ])->save();

            return $organizationPublished;
        }

        return null;
    }
}
