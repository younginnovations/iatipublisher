<?php

declare(strict_types=1);

namespace App\Console\Commands;

use App\IATI\Elements\Xml\XmlGenerator;
use App\IATI\Models\Activity\Activity;
use App\IATI\Models\Activity\ActivityPublished;
use App\IATI\Models\Organization\Organization;
use Exception;
use Illuminate\Console\Command;
use Illuminate\Support\Arr;
use SimpleXMLElement;

/**
 * This command implements changes to fix the bug raised in issue 1363.
 * See issue: https://github.com/younginnovations/iatipublisher/issues/1363.
 *
 * [!!WARNING!!] This is a one time use command.
 *
 * This command does the following:
 * - Fetch all activities published on and after Dec-18. (Dec-18 is the date branch 1269 was merged and sent to production.)
 * - Unpublish all activities from registry.
 * - Generate new single xmls for each activity and store them to s3.
 * - Fix merged xml that is published to registry:
 *      - Remove bugged activity nodes.
 *      - Append fixed activity node.
 * - Publish merged xml to registry.
 *
 * @class FixPublishedXmlsForIssue1363Changes
 */
class FixPublishedXmlsForIssue1363Changes extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:FixPublishedXmlsForIssue1363Changes';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'This command implements changes to fix the bug raised in issue 1363.';

    public function __construct(protected XmlGenerator $xmlGenerator)
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return void
     */
    public function handle()
    {
        try {
            $affectedOrganizationAndActivities = $this->affectedOrganizationAndActivities();
            $possiblyAffectedMergedXml = $this->affectedOrganizationXml($affectedOrganizationAndActivities->keys());

            $returnVal = $this->extractAllActivityTransactionsReferences($affectedOrganizationAndActivities);
            $allOrganizationTransactionReferences = Arr::get($returnVal, 'organizationTransactionRefs');
            $activityIdsMappedToIdentifier = Arr::get($returnVal, 'activityIdsMappedToIdentifier');
            $brokenOrgs = $this->getAllAffectedOrganizationsWithBrokenActivityId($possiblyAffectedMergedXml, $activityIdsMappedToIdentifier, $allOrganizationTransactionReferences);

            logger('$affectedOrganizationAndActivities');
            logger($affectedOrganizationAndActivities);
            logger('$possiblyAffectedMergedXml');
            logger($possiblyAffectedMergedXml);
            logger('$allOrganizationTransactionReferences');
            logger($allOrganizationTransactionReferences);
            logger('$activityIdsMappedToIdentifier');
            logger($activityIdsMappedToIdentifier);
            logger('$brokenOrgs');
            logger($brokenOrgs);

            if ($this->backupMergedFiles($possiblyAffectedMergedXml)) {
                echo 'Do you want to continue? (yes/no): ';
                $confirmation = trim(fgets(STDIN));

                if (strtolower($confirmation) !== 'yes') {
                    echo "Operation aborted.\n";
                    exit;
                } else {
                    //                    foreach ($affectedMergedXmlFiles as $orgId => $mergedXmlFile) {
                    //                        if (awsHasFile("xml/mergedActivityXml/$mergedXmlFile")) {
                    //                            $mergedXmlContent = awsGetFile("xml/mergedActivityXml/$mergedXmlFile");
                    //                            $xml              = new SimpleXMLElement($mergedXmlContent);
                    //
                    //                            $transactions         = $xml->xpath('//transaction');
                    //                            $refValuesInMergedXml = [];
                    //
                    //                            foreach ($transactions as $transaction) {
                    //                                $refValuesInMergedXml[$orgId][] = (string)$transaction['ref'];
                    //                            }
                    //
                    //                            $mergedXmlHasMissingTransaction = array_diff($allOrganizationTransactionReferences[$orgId], $refValuesInMergedXml[$orgId]);
                    //
                    //                            logger('$mergedXmlHasMissingTransaction');
                    //                            logger($mergedXmlHasMissingTransaction);
                    //                            if (!empty($mergedXmlHasMissingTransaction)) {
                    //                                $orgsThatNeedFixing[] = $orgId;
                    //                            }
                    //                        }
                    //                    }

                    //                  foreach ($affectedOrganizationAndActivities as $orgId => $activities) {
                    foreach ($brokenOrgs as $orgId => $activityIds) {
                        $activities = Activity::whereIn('id', $activityIds)->get();
                        $organization = Organization::find($orgId);
                        $settings = $organization->settings;

                        try {
                            $message = "Attempting to generate merged file for OrgId: $orgId at: " . now();
                            logger($message);
                            $this->info($message);

                            $this->xmlGenerator->generateActivitiesXml($activities, $settings, $organization, false);
                        } catch (Exception $e) {
                            $message = "Merged xml file generation failed for OrgId: $orgId  generated at: " . now();
                            logger($message);
                            logger()->error($e);
                            $this->info($message);

                            continue;
                        }

                        $message = "Merged xml file for OrgId: $orgId  generated at: " . now();
                        logger($message);
                        $this->info($message);
                    }
                }
            }
        } catch (Exception $e) {
            logger()->error($e);
        }
    }

    /**
     * Initial filter query.
     *
     * @return mixed
     */
    private function affectedOrganizationAndActivities(): mixed
    {
        return Activity::where('status', 'published')
            ->where('linked_to_iati', true)
            ->where('updated_at', '>=', '2023-12-01')
            ->orderBy('org_id')
            ->get()
            ->groupBy('org_id');
    }

    /**
     * Returns merged filename from the database.
     *
     * @param $orgIds
     *
     * @return mixed
     */
    private function affectedOrganizationXml($orgIds): array
    {
        return ActivityPublished::whereIn('organization_id', $orgIds)->pluck('filename', 'organization_id')->toArray();
    }

    /**
     * Returns all affected transaction references mapped to orgId.
     *
     * @param $affectedOrganizationAndActivities
     *
     * @return array
     */
    private function extractAllActivityTransactionsReferences($affectedOrganizationAndActivities): array
    {
        $organizationTransactionRefs = [];
        $activityIdsMappedToIdentifier = [];

        foreach ($affectedOrganizationAndActivities as $orgId => $activities) {
            $organizationIdentifier = Organization::where('id', $orgId)->pluck('identifier')[0];

            foreach ($activities as $activity) {
                $activityIdentifier = $activity['iati_identifier']['activity_identifier'];
                $iatiText = "$organizationIdentifier-$activityIdentifier";
                $activityIdsMappedToIdentifier[$iatiText] = $activity->id;

                foreach ($activity->transactions as $transaction) {
                    $organizationTransactionRefs[$orgId][$iatiText][] = $transaction->transaction['reference'];
                }
            }
        }

        return [
            'organizationTransactionRefs' => $organizationTransactionRefs,
            'activityIdsMappedToIdentifier' => $activityIdsMappedToIdentifier,
        ];
    }

    /**
     * Return activity ids mapped to org id.
     *
     * @param $possiblyAffectedMergedXml
     * @param $activityIdsMappedToIdentifier
     * @param $allOrganizationTransactionReferences
     *
     * @return array
     *
     * @throws Exception
     */
    private function getAllAffectedOrganizationsWithBrokenActivityId($possiblyAffectedMergedXml, $activityIdsMappedToIdentifier, $allOrganizationTransactionReferences): array
    {
        $brokenOrg = [];

        foreach ($allOrganizationTransactionReferences as $orgId => $possiblyAffectedActivityIdentifiers) {
            $filename = $possiblyAffectedMergedXml[$orgId];

            if (awsHasFile("xml/mergedActivityXml/$filename")) {
                $mergedXmlFromS3 = awsGetFile("xml/mergedActivityXml/$filename");
                $mergedXmlFromS3 = new SimpleXMLElement($mergedXmlFromS3);

                foreach ($possiblyAffectedActivityIdentifiers as $activityIdentifier => $transactionRefs) {
                    $xpathExpression = "//iati-activity[iati-identifier='$activityIdentifier']";
                    $activityWithinXml = $mergedXmlFromS3->xpath($xpathExpression);

                    if (!empty($activityWithinXml)) {
                        $activityWithinXml = $activityWithinXml[0];
                        $transactionCount = count($activityWithinXml->transaction);

                        if ($transactionCount !== count($transactionRefs)) {
                            $brokenOrg[$orgId][] = $activityIdsMappedToIdentifier[$activityIdentifier];
                        }
                    }
                }
            } else {
                logger("Couldn't find merged file for: $orgId");
            }
        }

        return $brokenOrg;
    }

    /**
     * Create backups of merged xmls.
     *
     * @param array $affectedMergedXmlFiles
     *
     * @return bool
     */
    private function backupMergedFiles(array $affectedMergedXmlFiles): bool
    {
        $message = 'Started taking backup.....';
        $this->info($message);
        logger()->info($message);

        foreach ($affectedMergedXmlFiles as $filename) {
            $filepath = "xml/mergedActivityXml/$filename";

            if (awsHasFile($filepath)) {
                $mergedXml = awsGetFile($filepath);
                $backupPath = "backup/$filename";

                if (awsUploadFile($backupPath, $mergedXml)) {
                    $message = "Successfully backed up :$filepath";
                } else {
                    $message = "Failed to back up :$filepath";
                }
            } else {
                $message = "No merged file with name :$filepath";
            }
            $this->info($message);
            logger()->info($message);
        }

        $message = 'Completed taking backup.....';
        $this->info($message);
        logger()->info($message);

        return true;
    }
}
