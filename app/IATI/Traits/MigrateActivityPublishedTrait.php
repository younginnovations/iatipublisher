<?php

declare(strict_types=1);

namespace App\IATI\Traits;

use App\IATI\Models\Activity\ActivityPublished;
use Illuminate\Support\Facades\Storage;

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
     * @throws \DOMException
     */
    public function migrateActivitiesPublishedFiles($aidStreamOrganization, $iatiOrganization, $migratedActivitiesLookupTable): void
    {
        $this->logInfo("Started Activity file migration for Aidstream org: {$aidStreamOrganization->id}.");
        $iatiActivityFilePath = 'xml/activityXmlFiles';
        $iatiMergedFilename = "{$iatiOrganization->publisher_id}-activities.xml";
        $aidstreamActivityXmlFilePath = 'aidstream-xml';

        $aidstreamActivityXmlNameList = $this->getAidStreamActivityXmlNames($aidStreamOrganization);
        $iatiActivityXmlFilenameList = [];
        $this->logInfo('Found ' . count($aidstreamActivityXmlNameList) . ' activity files to migrate.');

        foreach ($aidstreamActivityXmlNameList as $aidstreamId => $aidstreamXmlName) {
            $file = "{$aidstreamActivityXmlFilePath}/{$aidstreamXmlName}";
            $contents = Storage::disk('s3')->get($file);

            $iatiXmlFileName = $this->generateIatiXmlFilename($iatiOrganization, $migratedActivitiesLookupTable[$aidstreamId]);
            $iatiActivityXmlFilenameList[] = $iatiXmlFileName;
            $destinationPath = "{$iatiActivityFilePath}/{$iatiXmlFileName}";

            Storage::disk('s3')->put($destinationPath, $contents);

            $this->logInfo("Migrated file: {$aidstreamXmlName} as file: {$iatiXmlFileName}.");
        }

        $this->logInfo("Migrated merged file for Aidstream org: {$aidStreamOrganization->id}.");
        $this->xmlGenerator->getMergeXml($iatiActivityXmlFilenameList, $iatiMergedFilename);
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
        $namePrefix = $iatiOrganization->publisher_id;

        return "{$namePrefix}-{$id}.xml";
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
        $namePrefix = $iatiOrganization->publisher_id;

        return "{$namePrefix}-activities.xml";
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
        $generatedFilename = $this->getGeneratedFilename($aidStreamOrganization);
        $activitiesPublished = new ActivityPublished();
        $this->logInfo("Completed ActivityPublished table migration for Aidstream org: {$aidStreamOrganization->id}.");

        return $activitiesPublished->fill([
            'published_activities'  => array_values($publishedActivitiesList),
            'filename'              => $generatedFilename,
            'published_to_registry' => 1,
            'organization_id'       => $iatiOrganization->id,
        ])->save();
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
            ->get()->pluck('published_activities');

        $allFileNames = [];

        foreach ($publishedActivities as $publishedActivity) {
            $publishedActivity = json_decode($publishedActivity);

            foreach ($publishedActivity as $xmlFileName) {
                $explodedElements = explode('.', $xmlFileName);
                $basename = $explodedElements[0];
                $explodedBasename = explode('-', $basename);
                $id = $explodedBasename[count($explodedBasename) - 1];

                $allFileNames[$id] = $xmlFileName;
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
            $returnArray[] = $this->generateIatiXmlFilename($iatiOrganization, $migratedActivitiesLookupTable[$aidstreamId]);
        }

        return $returnArray;
    }

    /**
     * Generates new xml filename for main xml.
     *
     * @param $organization
     *
     * @return string
     */
    public function getGeneratedFilename($organization): string
    {
        $basename = $organization->user_identifier;

        return "{$basename}-activities.xml";
    }
}
