<?php

declare(strict_types=1);

namespace App\IATI\Traits;

use Illuminate\Support\Str;

/**
 * Class MigrateDocumentFileTrait.
 */
trait MigrateDocumentFileTrait
{
    /**
     * Migrate document files.
     *
     * @param $aidstreamOrganizationId
     *
     * @return void
     */
    public function migrateDocumentFiles($aidstreamOrganizationId): void
    {
        $migratableDocuments = $this->getDocumentFiles($aidstreamOrganizationId);
        $migratableFiles = $migratableDocuments->pluck('filename', 'id');
        $aidstreamDocumentPath = '';
        $iatiDocumentPath = '';

        foreach ($migratableFiles as $filename) {
            $filePath = "{$aidstreamDocumentPath}/{$filename}";
            $contents = awsGetFile($filePath);
            $filePath = "{$iatiDocumentPath}/{$filename}";

            if ($contents && awsUploadFile($filePath, $contents)) {
                $this->logInfo("Migrated Document file :{$filename}.");
            }
        }
    }

    /**
     * Return documents that need to be migrated.
     *
     * @param $aidstreamOrganizationId
     *
     * @return mixed
     */
    public function getDocumentFiles($aidstreamOrganizationId): mixed
    {
        $unfilteredDocuments = $this->db::connection('aidstream')->table('documents')
            ->where('org_id', $aidstreamOrganizationId)
            ->whereNotNull('filename')
            ->get();

        return $this->unsetItemsWithMatchingBaseUrl($unfilteredDocuments);
    }

    /**
     * Unsets url that do not have baseurl : %aidstream.org%.
     *
     * @param $unfilteredDocuments
     *
     * @return mixed
     */
    public function unsetItemsWithMatchingBaseUrl($unfilteredDocuments): mixed
    {
        foreach ($unfilteredDocuments as $key=>$unfilteredDocument) {
            if (!$this->containsAidstreamUrl($unfilteredDocument->url)) {
                unset($unfilteredDocuments[$key]);
            }
        }

        return $unfilteredDocuments;
    }

    /**
     * Check if unfilteredUrl contains aidstream baseurl.
     *
     * @param $unfilteredUrl
     *
     * @return bool
     */
    public function containsAidstreamUrl($unfilteredUrl): bool
    {
        $baseUrls = [
            'http://aidstream.org', 'http://www.aidstream.org', "http:\/\/www.aidstream.org", "http:\/\/aidstream.org", "http:\/\/www.aidstream.org",
        ];

        foreach ($baseUrls as $baseurl) {
            if (Str::contains($unfilteredUrl, $baseurl)) {
                return true;
            }
        }

        return false;
    }
}
