<?php

declare(strict_types=1);

namespace App\IATI\Traits;

use App\Exceptions\PublishException;
use App\IATI\Models\Activity\ActivityPublished;
use App\IATI\Models\Organization\Organization;
use Exception;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection;

/**
 * Class MigrateActivityPublishedTrait.
 */
trait MigrateActivityPublishedTrait
{
    /**
     * Updates publisher id in organization level with that of settings.
     *
     * @param $iatiOrganization
     * @param $aidStreamOrganizationSetting
     * @param $aidStreamOrganization
     *
     * @return void
     */
    public function syncPublisherIdInSettingAndOrganizationLevel($iatiOrganization, $aidStreamOrganizationSetting, $aidStreamOrganization): void
    {
        $registryInfo = $aidStreamOrganizationSetting->registry_info;

        if ($registryInfo) {
            $registryInfo = json_decode($registryInfo)[0];

            if (($registryInfo->publisher_id !== $iatiOrganization->publisher_id) && !empty($registryInfo->publisher_id)) {
                $iatiOrganization->timestamps = false;
                $iatiOrganization->updateQuietly(['publisher_id' => $registryInfo->publisher_id], ['touch'=>false]);
            }
        } else {
            $message = "Registry info is null in Settings of Aidstream organization: {$aidStreamOrganization?->name}";
            $this->setGeneralError($message)->setDetailedError(
                $message,
                $aidStreamOrganization->id,
                'settings',
                $aidStreamOrganizationSetting->id,
                $iatiOrganization->id,
                '',
                'Settings > registry_info'
            );
            $this->logInfo($message);
        }
    }

    /**
     * Migrates activities published files.
     *
     * @param $aidStreamOrganization
     * @param $iatiOrganization
     * @param $migratedActivitiesLookupTable
     *
     * @return void
     *
     * @throws PublishException
     */
    public function migrateActivitiesPublishedFiles(
        $aidStreamOrganization,
        $iatiOrganization,
        $migratedActivitiesLookupTable
    ): void {
        $this->logInfo("Started Activity file migration for Aidstream org: {$aidStreamOrganization->id}.");
        $iatiActivityFilePath = 'xml/activityXmlFiles';
        $aidstreamActivityXmlFilePath = 'aidstream-xml';

        $aidstreamActivityXmlNameList = $this->getAidStreamActivityXmlNames($aidStreamOrganization);

        if ($aidstreamActivityXmlNameList) {
            $this->logInfo('Found ' . count($aidstreamActivityXmlNameList) . ' activity files to migrate.');

            foreach ($aidstreamActivityXmlNameList as $aidstreamId => $aidstreamXmlName) {
                $file = "{$aidstreamActivityXmlFilePath}/{$aidstreamXmlName}";
                $contents = awsGetFile($file);

                if ($contents && array_key_exists($aidstreamId, $migratedActivitiesLookupTable)) {
                    $contents = $this->replaceDocumentLinkInXml($contents, $iatiOrganization->id);
                    $iatiXmlFileName = $this->generateIatiActivityXmlFilename(
                        $iatiOrganization,
                        $migratedActivitiesLookupTable[$aidstreamId]
                    );
                    $destinationPath = "{$iatiActivityFilePath}/{$iatiXmlFileName}";

                    if (awsUploadFile($destinationPath, $contents)) {
                        $this->logInfo("Migrated file :{$aidstreamXmlName} as file :{$iatiXmlFileName}.");
                    } else {
                        $this->logInfo("Failed uploading file:{$aidstreamXmlName} to S3.");
                    }
                } else {
                    $message = "No Activity file named: {$aidstreamXmlName} found in S3 for Aidstream Organization: {$aidStreamOrganization->name}";
                    $this->setGeneralError($message)->setDetailedError(
                        $message,
                        $aidStreamOrganization->id,
                        'activity_published',
                        $aidstreamId,
                        'Activity file > migration',
                        $iatiOrganization->id,
                    );
                    $this->logInfo($message . " id: {$aidStreamOrganization->id}.");
                    throw new PublishException($iatiOrganization->id, $message);
                }
            }
        } else {
            $message = "No activity files to migrate for Aidstream org_id {$aidStreamOrganization->id}.";

            $this->logInfo($message);
        }

        $this->logInfo("Completed Activity file migration for Aidstream org: {$aidStreamOrganization->id}.");
    }

    /**
     * Returns xml file name for iati activity.
     *
     * @param $iatiOrganization
     * @param $id
     *
     * @return string
     */
    public function generateIatiActivityXmlFilename($iatiOrganization, $id): string
    {
        return "{$iatiOrganization->publisher_id}-{$id}.xml";
    }

    /**
     * Returns merged filename for an organization.
     *
     * @param $organization
     *
     * @return string
     */
    public function generateMergedFileName($organization): string
    {
        return "{$organization->publisher_id}-activities.xml";
    }

    /**
     * Inserts record in Activities Published table.
     *
     * @param $aidStreamOrganization
     * @param $iatiOrganization
     * @param $migratedActivitiesLookupTable
     *
     * @return bool
     */
    public function migrateActivityPublishedTable(
        $aidStreamOrganization,
        $iatiOrganization,
        $migratedActivitiesLookupTable
    ): bool {
        $this->logInfo("Started ActivityPublished table migration for Aidstream org: {$aidStreamOrganization->id}.");
        $publishedActivitiesList = $this->getIatiActivityXmlNames(
            $aidStreamOrganization,
            $iatiOrganization,
            $migratedActivitiesLookupTable
        );
        $settings = $iatiOrganization->settings;
        $generatedFilename = $this->getGeneratedFilename($aidStreamOrganization, $settings);
        $latestActivityPublished = $this->getLatestAidstreamActivityPublished($aidStreamOrganization);

        if (count($latestActivityPublished)) {
            $activitiesPublished = new ActivityPublished();

            $activitiesPublished->fill([
                'published_activities' => array_values($publishedActivitiesList),
                'filename' => $generatedFilename,
                'published_to_registry' => 1,
                'organization_id' => $iatiOrganization->id,
                'created_at' => $latestActivityPublished->isNotEmpty() ? $latestActivityPublished[0]->created_at : '',
                'updated_at' => $latestActivityPublished->isNotEmpty() ? $latestActivityPublished[0]->updated_at : '',
            ])->save();

            $this->logInfo(
                "Completed ActivityPublished table migration for Aidstream org: {$aidStreamOrganization->id}."
            );
        }

        return true;
    }

    /**
     * Returns 1D array of all filenames of activities published by organization.
     *
     * @param $organization
     *
     * @return array
     */
    public function getAidStreamActivityXmlNames($organization): array
    {
        $publishedActivities = $this->db::connection('aidstream')->table('activity_published')
                                        ->where('organization_id', '=', $organization->id)
                                        ->where('published_to_register', '=', 1)
                                        ->get()?->pluck('published_activities');

        $allFileNames = [];

        if (count($publishedActivities)) {
            foreach ($publishedActivities as $publishedActivity) {
                if ($publishedActivity) {
                    $publishedActivity = json_decode($publishedActivity);

                    foreach ($publishedActivity as $xmlFileName) {
                        $explodedElements = explode('.', $xmlFileName);
                        $basename = Arr::get($explodedElements, 0, '');
                        $explodedBasename = explode('-', $basename);
                        $id = $explodedBasename[count($explodedBasename) - 1];

                        $allFileNames[$id] = $xmlFileName;
                    }
                }
            }
        }

        return $allFileNames;
    }

    /**
     * Returns Activity Xml filename list for iati.
     *
     * @param $aidStreamOrganization
     * @param $iatiOrganization
     * @param $migratedActivitiesLookupTable
     *
     * @return array
     */
    public function getIatiActivityXmlNames(
        $aidStreamOrganization,
        $iatiOrganization,
        $migratedActivitiesLookupTable
    ): array {
        $returnArray = [];
        $aidstreamActivityXmlNameList = $this->getAidStreamActivityXmlNames($aidStreamOrganization);

        foreach ($aidstreamActivityXmlNameList as $aidstreamId => $aidstreamXmlName) {
            if (array_key_exists($aidstreamId, $migratedActivitiesLookupTable)) {
                $returnArray[] = $this->generateIatiActivityXmlFilename(
                    $iatiOrganization,
                    $migratedActivitiesLookupTable[$aidstreamId]
                );
            }
        }

        return $returnArray;
    }

    /**
     * Generates new xml filename for main xml.
     *
     * @param $organization
     * @param $settings
     *
     * @return string
     */
    public function getGeneratedFilename($organization, $settings): string
    {
        $basename = $organization->user_identifier;
        $publisherId = $settings ? Arr::get($settings->publishing_info, 'publisher_id', $basename) : $basename;

        return "{$publisherId}-activities.xml";
    }

    /**
     * Returns the latest activity_published of an organization.
     *
     * @param $organization
     *
     * @return Collection
     */
    public function getLatestAidstreamActivityPublished($organization): Collection
    {
        return $this->db::connection('aidstream')->table('activity_published')
                        ->where('organization_id', '=', $organization->id)
                        ->where('published_to_register', '=', 1)
                        ->latest()->get();
    }

    /**
     * Return merged activity filename.
     *
     * @param $aidstreamOrganization
     * @param $activityPublished
     *
     * @return string|null
     */
    public function getAidstreamMergedFileName($aidstreamOrganization, $activityPublished): ?string
    {
        if (count($activityPublished)) {
            if (count($activityPublished) > 1 || $this->filenameHasSegmentedLastname($activityPublished->first()->filename)) {
                $setting = $this->db::connection('aidstream')->table('settings')->where(
                    'organization_id',
                    $aidstreamOrganization->id
                )?->first();
                $registryInfo = json_decode($setting->registry_info)[0];
                $publisherId = $registryInfo->publisher_id;

                return "{$publisherId}-activities.xml";
            }

            return $activityPublished->first()->filename;
        }

        return null;
    }

    /**
     * Migrate merged file.
     *
     * @param $aidStreamOrganization
     * @param $iatiOrganization
     *
     * @return object|null
     *
     * @throws \DOMException
     */
    public function migrateActivityMergedFile($aidStreamOrganization, $iatiOrganization): ?object
    {
        $activityPublished = $this->getIatiActivityPublished($iatiOrganization);
        $publishedFiles = $activityPublished ? $activityPublished->published_activities : [];

        if ($publishedFiles) {
            $aidstreamActivityPublished = $this->db::connection('aidstream')->table('activity_published')
                                                   ->where('organization_id', $aidStreamOrganization->id)->where(
                                                       'published_to_register',
                                                       1
                                                   )->get();
            $aidstreamMergedFilePath = 'aidstream-xml';
            $aidstreamMergedFilename = $this->getAidStreamMergedFilename(
                $aidStreamOrganization,
                $aidstreamActivityPublished
            );

            $iatiMergedFilename = "{$iatiOrganization->publisher_id}-activities.xml";
            $iatiMergedFile = "xml/mergedActivityXml/{$iatiMergedFilename}";

            $this->logInfo("Started migration of merged file for Aidstream org: {$aidStreamOrganization->id}.");
            $existingContents = awsGetFile("{$aidstreamMergedFilePath}/{$aidstreamMergedFilename}");

            if ($existingContents) {
                $existingContents = $this->replaceDocumentLinkInXml($existingContents, $iatiOrganization->id);
                awsUploadFile($iatiMergedFile, $existingContents);
            } else {
                $this->xmlGenerator->getMergeXml($publishedFiles, $iatiMergedFilename);
                $mergedContents = awsGetFile($iatiMergedFile);
                $mergedContents = $this->replaceDocumentLinkInXml($mergedContents, $iatiOrganization->id);
                awsUploadFile($iatiMergedFile, $mergedContents);
            }

            $this->logInfo("Completed migration of merged file for Aidstream org: {$aidStreamOrganization->id}.");
        } else {
            $message = 'No activity file to merge.';
            $this->logInfo($message);
        }

        return $activityPublished;
    }

    /**
     * Returns the latest activity_published of an organization.
     *
     * @param $iatiOrganization
     *
     * @return ?object
     */
    public function getIatiActivityPublished($iatiOrganization): ?object
    {
        return (new ActivityPublished())->where('organization_id', $iatiOrganization->id)?->first();
    }

    /**
     * Returns array for segmented files.
     *
     * @param $aidstreamPublishedFiles
     *
     * @return array
     */
    public function getSegmentedFiles($aidstreamPublishedFiles): array
    {
        $segmentedFiles = [];

        if (!$aidstreamPublishedFiles) {
            return $segmentedFiles;
        }

        if (count($aidstreamPublishedFiles)) {
            foreach ($aidstreamPublishedFiles as $aidstreamPublishedFile) {
                $explodedElements = explode('.', $aidstreamPublishedFile->filename);
                $basename = $explodedElements[0];
                $explodedBasename = explode('-', $basename);
                $lastName = $explodedBasename[count($explodedBasename) - 1];

                if ($lastName !== 'activities') {
                    $segmentedFiles[] = $basename;
                }
            }
        }

        return $segmentedFiles;
    }

    /**
     * Unpublishes segmented files if present.
     *
     * @param $apiToken
     * @param $aidstreamPublishedFiles
     * @param $aidstreamOrganizationId
     * @param $iatiOrganizationId
     *
     * @return void
     *
     * @throws PublishException
     */
    public function unpublishSegmentedFiles(
        $apiToken,
        $aidstreamPublishedFiles,
        $aidstreamOrganizationId,
        $iatiOrganizationId
    ): void {
        try {
            $segmentedFiles = $this->getSegmentedFiles($aidstreamPublishedFiles);

            if (count($segmentedFiles)) {
                $this->logInfo('Unpublishing segmented files for Aidstream org: ' . $aidstreamOrganizationId . '.');
                $this->publisherService->unlink($apiToken, $segmentedFiles);
                $this->logInfo(
                    'Completed unpublishing segmented files for Aidstream org: ' . $aidstreamOrganizationId . '.'
                );
            }
        } catch (\Exception $exception) {
            $message = "Error while unpublishing segmented files for Aidstream org: {$aidstreamOrganizationId} with error: {$exception->getMessage()}.";
            $this->setGeneralError($message)->setDetailedError(
                $message,
                $aidstreamOrganizationId,
                'activity_published',
                '',
                'Activity file > segmented > unpublishing',
                $iatiOrganizationId,
            );

            throw new PublishException($iatiOrganizationId, $message);
        }
    }

    /**
     * Returns true if filename does not end in 'activities'.
     *
     * @param $filename
     *
     * @return bool
     */
    public function filenameHasSegmentedLastname($filename): bool
    {
        $explodedElements = explode('.', $filename);
        $basename = $explodedElements[0];
        $explodedBasename = explode('-', $basename);
        $suffix = $explodedBasename[count($explodedBasename) - 1];

        return $suffix !== 'activities';
    }

    /**
     * Replaces document link in xml.
     *
     * @param $contents
     * @param $iatiOrganizationId
     *
     * @return string
     */
    public function replaceDocumentLinkInXml($contents, $iatiOrganizationId): string
    {
        return str_replace(
            [
                'https://www.aidstream.org/files/documents',
                'https://aidstream.org/files/documents',
                'http://www.aidstream.org/files/documents',
                'http://aidstream.org/files/documents',
            ],
            awsUrl("document-link/{$iatiOrganizationId}"),
            $contents
        );
    }

    /**
     * @param $aidStreamOrganization
     * @param $iatiOrganization
     * @param $activityPublished
     *
     * @return void
     *
     * @throws PublishException
     */
    private function tryPublishingActivityFile($aidStreamOrganization, $iatiOrganization, $activityPublished): void
    {
        $settings = $iatiOrganization->settings;
        $publishingInfo = $settings ? $settings->publishing_info : [];
        $this->logInfo("Publishing activity file: {$activityPublished->filename} for Aidstream org: {$aidStreamOrganization->id}.");

        try {
            $this->publisherService->publishFile(
                $publishingInfo,
                $activityPublished,
                $iatiOrganization,
                false
            );
            $this->logInfo(
                "Completed publishing activity file: {$activityPublished->filename} with updated at {$activityPublished->updated_at} for Aidstream org: {$aidStreamOrganization->id}."
            );
        } catch (Exception $exception) {
            $message = "Activity file: {$activityPublished->filename} with updated at: {$activityPublished->updated_at} not published with error: {$exception->getMessage()}.";
            $this->setGeneralError($message)->setDetailedError(
                $message,
                $aidStreamOrganization->id,
                'activity_published',
                $activityPublished->id,
                $iatiOrganization->id
            );
            $this->logInfo($message);

            throw new PublishException($iatiOrganization->id, $message);
        }
    }
}
