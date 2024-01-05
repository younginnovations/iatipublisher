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

            foreach ($migratableFiles as $documentId => $filename) {
                $filePath = "{$aidstreamDocumentPath}/{$filename}";
                $contents = awsGetFile($filePath);
                $filePath = "{$iatiDocumentPath}/{$filename}";

                if ($contents && awsUploadFile($filePath, $contents)) {
                    $this->logInfo("Migrated Document file :{$filename}.");
                } else {
                    $message = "No Document file named: {$filename} found in S3 for Aidstream Organization: {$aidstreamOrganization?->name}";
                    $this->setGeneralError($message)->setDetailedError(
                        $message,
                        $aidstreamOrganization->id,
                        'documents',
                        $documentId,
                        $iatiOrganization->id,
                        '',
                        'Document file > migration'
                    );
                    $this->logInfo($message . " id: {$aidstreamOrganization->id}.");
                }
            }
        } else {
            $message = 'No Document file to migrate.';
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

    /**
     * Updates organization document link.
     *
     * @param $aidStreamOrganizationId
     * @param $iatiOrganization
     *
     * @return void
     */
    public function updateOrganizationDocumentLinkUrl($aidStreamOrganizationId, $iatiOrganization): void
    {
        if (!empty($iatiOrganization) && !empty($aidStreamOrganizationId)) {
            $documentLink = [];
            $orgDocumentLinks = $iatiOrganization->document_link;

            if ($orgDocumentLinks && count($orgDocumentLinks)) {
                foreach ($orgDocumentLinks as $data) {
                    $data['url'] = $this->replaceDocumentLinkUrl($data['url'], $iatiOrganization->id);
                    $documentLink[] = $data;
                }
            }

            $iatiOrganization->document_link = count($documentLink) ? $documentLink : null;
            $iatiOrganization->timestamps = false;
            $iatiOrganization->saveQuietly(['touch'=>false]);
        }
    }

    /**
     * Migrates Aid stream document data to iati document table.
     *
     * @param $aidstreamOrganizationId
     * @param $iatiOrganization
     * @param $migratedActivitiesLookupTable
     *
     * @return void
     *
     * @throws \JsonException
     */
    public function migrateDocuments($aidstreamOrganizationId, $iatiOrganization, $migratedActivitiesLookupTable): void
    {
        $aidStreamDocument = $this->db::connection('aidstream')->table('documents')
            ->where('org_id', $aidstreamOrganizationId)
            ->get();

        if (count($aidStreamDocument)) {
            $iatiDocuments = [];

            foreach ($aidStreamDocument as $aidDocument) {
                $iatiDocuments[] = [
                    'activity_id'     => null,
                    'activities'      => $this->fillActivitiesId(
                        $aidDocument->activities,
                        $migratedActivitiesLookupTable
                    ),
                    'organization_id' => $iatiOrganization->id,
                    'filename'        => $aidDocument->filename,
                    'extension'       => getFileNameExtension($aidDocument->filename),
                    'size'            => $aidDocument->file_size,
                    'created_at'      => $aidDocument->created_at,
                    'updated_at'      => $aidDocument->updated_at,
                ];
            }

            $this->documentService->insert($iatiDocuments);
            $this->logInfo('Completed migrating documents for organization id ' . $aidstreamOrganizationId);
        }
    }

    /**
     * Map new activity id into json format.
     *
     * @param $aidStreamActivitiesId
     * @param $migratedActivitiesLookupTable
     *
     * @return string|null
     *
     * @throws \JsonException
     */
    public function fillActivitiesId($aidStreamActivitiesId, $migratedActivitiesLookupTable): null|string
    {
        $aidStreamActivitiesId = !empty($aidStreamActivitiesId) ? json_decode(
            $aidStreamActivitiesId,
            true,
            512,
            JSON_THROW_ON_ERROR
        ) : null;

        $updatedActivityIds = [];

        if (!empty($aidStreamActivitiesId)) {
            if (is_string($aidStreamActivitiesId)) {
                $aidStreamActivitiesId = json_decode($aidStreamActivitiesId, true, 512, JSON_THROW_ON_ERROR);
            }

            foreach ($aidStreamActivitiesId as $aidActivityId => $identifier) {
                if (!isset($migratedActivitiesLookupTable[$aidActivityId])) {
                    continue;
                }

                $updatedActivityIds[] = $migratedActivitiesLookupTable[$aidActivityId];
            }
        }

        return count($updatedActivityIds) ? json_encode($updatedActivityIds, JSON_THROW_ON_ERROR) : null;
    }

    /**
     * replace aid stream url to s3 bucket url.
     *
     * @param $url
     * @param $iatiOrganizationId
     *
     * @return null|string
     */
    public function replaceDocumentLinkUrl($url, $iatiOrganizationId): ?string
    {
        if ($url) {
            $parsedUrl = parse_url($url);

            if (isset($parsedUrl['host']) && in_array($parsedUrl['host'], ['www.aidstream.org', 'aidstream.org', 'www.aidstream.s3.us-west-2.amazonaws.com', 'aidstream.s3.us-west-2.amazonaws.com'])) {
                $explodedPath = explode('/', $parsedUrl['path']);
                $fileName = end($explodedPath);
                $path = '/document-link/' . $iatiOrganizationId . '/' . $fileName;
                $url = awsUrl($path);
            }

            return $url;
        }

        return null;
    }
}
