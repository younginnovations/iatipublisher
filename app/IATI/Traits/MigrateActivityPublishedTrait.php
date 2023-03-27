<?php

declare(strict_types=1);

namespace App\IATI\Traits;

use App\IATI\Models\Activity\ActivityPublished;
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
     *
     * @return void
     */
    public function syncPublisherIdInSettingAndOrganizationLevel($iatiOrganization, $aidStreamOrganizationSetting): void
    {
        $registryInfo = json_decode($aidStreamOrganizationSetting->registry_info)[0];

        if ($registryInfo->publisher_id != $iatiOrganization->publisher_id) {
            $iatiOrganization->updateQuietly(['publisher_id'=>$registryInfo->publisher_id]);
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
     */
    public function migrateActivitiesPublishedFiles($aidStreamOrganization, $iatiOrganization, $migratedActivitiesLookupTable): void
    {
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
                    $iatiXmlFileName = $this->generateIatiXmlFilename($iatiOrganization, $migratedActivitiesLookupTable[$aidstreamId]);
                    $destinationPath = "{$iatiActivityFilePath}/{$iatiXmlFileName}";

                    if (awsUploadFile($destinationPath, $contents)) {
                        $this->logInfo("Migrated file :{$aidstreamXmlName} as file :{$iatiXmlFileName}.");
                    }
                }
            }
        } else {
            $this->logInfo("No activity files to migrate for Aidstream org_id {$aidStreamOrganization->id}.");
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
    public function generateIatiXmlFilename($iatiOrganization, $id): string
    {
        return "{$iatiOrganization->publisher_id}-{$id}.xml";
    }

    /**
     * Returns merged filename for iati organization.
     *
     * @param $iatiOrganization
     *
     * @return string
     */
    public function generateMergedFileName($iatiOrganization): string
    {
        return "{$iatiOrganization->publisher_id}-activities.xml";
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
    public function migrateActivityPublishedTable($aidStreamOrganization, $iatiOrganization, $migratedActivitiesLookupTable): bool
    {
        $this->logInfo("Started ActivityPublished table migration for Aidstream org: {$aidStreamOrganization->id}.");
        $publishedActivitiesList = $this->getIatiActivityXmlNames($aidStreamOrganization, $iatiOrganization, $migratedActivitiesLookupTable);
        $settings = $iatiOrganization->settings;
        $generatedFilename = $this->getGeneratedFilename($aidStreamOrganization, $settings);
        $latestActivityPublished = $this->getLatestAidstreamActivityPublished($aidStreamOrganization);

        if (count($latestActivityPublished)) {
            $activitiesPublished = new ActivityPublished();

            $activitiesPublished->fill([
                'published_activities'  => array_values($publishedActivitiesList),
                'filename'              => $generatedFilename,
                'published_to_registry' => 1,
                'organization_id'       => $iatiOrganization->id,
                'created_at'            => $latestActivityPublished->isNotEmpty() ? $latestActivityPublished[0]->created_at : '',
                'updated_at'            => $latestActivityPublished->isNotEmpty() ? $latestActivityPublished[0]->updated_at : '',
            ])->save();

            $this->logInfo("Completed ActivityPublished table migration for Aidstream org: {$aidStreamOrganization->id}.");

            //Publish activity to registry if needed.
            if ($activitiesPublished && $activitiesPublished->published_to_registry) {
                $publishingInfo = $settings ? $settings->publishing_info : [];
                $this->logInfo("Publishing activity file: {$activitiesPublished->filename} for Aidstream org: {$aidStreamOrganization->id}.");
                $this->publisherService->publishFile($publishingInfo, $activitiesPublished, $iatiOrganization, false);
                $this->logInfo("Completed publishing activity file: {$activitiesPublished->filename} with updated at {$activitiesPublished->updated_at} for Aidstream org: {$aidStreamOrganization->id}.");
            }
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
                $publishedActivity = json_decode($publishedActivity);

                if ($publishedActivity) {
                    foreach ($publishedActivity as $xmlFileName) {
                        $explodedElements = explode('.', $xmlFileName);
                        $basename = $explodedElements[0];
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
    public function getIatiActivityXmlNames($aidStreamOrganization, $iatiOrganization, $migratedActivitiesLookupTable):array
    {
        $returnArray = [];
        $aidstreamActivityXmlNameList = $this->getAidStreamActivityXmlNames($aidStreamOrganization);

        foreach ($aidstreamActivityXmlNameList as $aidstreamId => $aidstreamXmlName) {
            if (array_key_exists($aidstreamId, $migratedActivitiesLookupTable)) {
                $returnArray[] = $this->generateIatiXmlFilename($iatiOrganization, $migratedActivitiesLookupTable[$aidstreamId]);
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
     *
     * @return string|null
     */
    public function getAidstreamMergedFileName($aidstreamOrganization): ?string
    {
        $activityPublished = $this->db::connection('aidstream')->table('activity_published')
            ->where('organization_id', $aidstreamOrganization->id)->get();

        if ($activityPublished) {
            if (count($activityPublished) > 1) {
                $setting = $this->db::connection('aidstream')->table('settings')->where('organization_id', $aidstreamOrganization->id)?->first();
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
     * @throws \DOMException
     */
    public function migrateActivityMergedFile($aidStreamOrganization, $iatiOrganization): void
    {
        $publishedFiles = $this->getIatiPublishedFilenames($iatiOrganization);

        if ($publishedFiles) {
            $aidstreamMergedFilePath = 'aidstream-xml';
            $aidstreamMergedFilename = $this->getAidStreamMergedFilename($aidStreamOrganization);

            $iatiMergedFilename = "{$iatiOrganization->publisher_id}-activities.xml";
            $iatiMergedFile = "xml/mergedActivityXml/{$iatiMergedFilename}";

            $this->logInfo("Started migration of merged file for Aidstream org: {$aidStreamOrganization->id}.");
            $existingContents = awsGetFile("{$aidstreamMergedFilePath}/{$aidstreamMergedFilename}");

            if ($existingContents) {
                awsUploadFile($iatiMergedFile, $existingContents);
            } else {
                $this->xmlGenerator->getMergeXml($publishedFiles, $iatiMergedFilename);
            }

            $this->logInfo("Completed migration of merged file for Aidstream org: {$aidStreamOrganization->id}.");
        } else {
            $this->logInfo('No activity file to merge.');
        }
    }

    /**
     * Returns array of published activity filename.
     *
     * @param $iatiOrganization
     *
     * @return array
     */
    public function getIatiPublishedFilenames($iatiOrganization): array
    {
        $activityPublished = (new ActivityPublished())->where('organization_id', $iatiOrganization->id)->first();

        return $activityPublished ? $activityPublished->published_activities : [];
    }
}
