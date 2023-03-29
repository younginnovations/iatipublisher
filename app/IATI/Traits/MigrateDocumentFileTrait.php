<?php

declare(strict_types=1);

namespace App\IATI\Traits;

use Illuminate\Support\Collection;

/**
 * Class MigrateDocumentFileTrait.
 */
trait MigrateDocumentFileTrait
{
    /**
     * Migrate document files.
     *
     * @param $aidstreamOrganization
     * @param $iatiOrganization
     *
     * @return void
     */
    public function migrateDocumentFiles($aidstreamOrganization, $iatiOrganization): void
    {
        $this->logInfo('Started migration of Document file.');
        $migratableDocuments = $this->getDocumentFiles($aidstreamOrganization->id);

        if (count($migratableDocuments)) {
            $migratableFiles = $migratableDocuments->pluck('filename', 'id');
            $aidstreamDocumentPath = 'aidstream-documents';
            $iatiDocumentPath = "document-link/{$iatiOrganization->id}";

            foreach ($migratableFiles as $key => $filename) {
                $filePath = "{$aidstreamDocumentPath}/{$filename}";
                $contents = awsGetFile($filePath);
                $filePath = "{$iatiDocumentPath}/{$filename}";

                if ($contents && awsUploadFile($filePath, $contents)) {
                    $this->logInfo("Migrated Document file :{$filename}.");
                } else {
                    $message = "No Document file named: {$filename} found in S3 for Aidstream Organization id: $aidstreamOrganization->id.";
                    $this->setFileMigrationError($message, $aidstreamOrganization->id, $iatiOrganization->id, $filename, '', $key);
                    $this->logInfo($message);
                }
            }
        } else {
            $message = 'No Document file to migrate.';
            $this->setFileMigrationError($message, $aidstreamOrganization->id, $iatiOrganization->id);
            $this->logInfo($message);
        }

        $this->logInfo('Completed migration of Document file.');
    }

    /**
     * Return documents that need to be migrated.
     *
     * @param $aidstreamOrganizationId
     *
     * @return Collection
     */
    public function getDocumentFiles($aidstreamOrganizationId): Collection
    {
        return $this->db::connection('aidstream')->table('documents')
            ->where('org_id', $aidstreamOrganizationId)
            ->whereNotNull('filename')
            ->get();
    }
}
