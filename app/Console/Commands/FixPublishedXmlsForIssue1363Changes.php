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
use Illuminate\Support\Facades\Mail;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use SimpleXMLElement;

/**
 * This command implements changes to fix the bug raised in issue 1363.
 * See issue: https://github.com/younginnovations/iatipublisher/issues/1363.
 *
 * [!!WARNING!!] This is a one time use command.
 *
 * This command does the following:
 * - Fetch all activities published on and after Dec-1, 2023. (Dec is the month, branch 1269 was merged and sent to production.)
 * - Generate new single xmls for each activity and store them to s3.
 * - Backup merged xmls
 * - Generate report
 * - Fix merged xml that is published to registry:
 *      - Remove bugged activity nodes.
 *      - Append fixed activity node.
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
            $assumedAffectedOrgAndActivities = $this->affectedOrganizationAndActivities();
            $assumedMergedXmlsMappedToOrgId = $this->affectedOrganizationXml($assumedAffectedOrgAndActivities->keys());

            $returnVal = $this->extractAllActivityTransactionsReferences($assumedAffectedOrgAndActivities);
            $allOrganizationTransactionReferences = Arr::get($returnVal, 'organizationTransactionRefs');
            $activityIdsMappedToIdentifier = Arr::get($returnVal, 'activityIdsMappedToIdentifier');

            $backupMergedFiles = $this->backupMergedFiles($assumedMergedXmlsMappedToOrgId);

            $confirmedActivitiesMappedToOrgId = $this->getAllAffectedOrganizationsWithBrokenActivityId(
                $assumedMergedXmlsMappedToOrgId,
                $activityIdsMappedToIdentifier,
                $allOrganizationTransactionReferences
            );

            if ($backupMergedFiles) {
                echo 'Do you want to continue? (yes/no): ';
                $confirmation = trim(fgets(STDIN));

                if (strtolower($confirmation) !== 'yes') {
                    echo "Operation aborted.\n";
                    exit;
                } else {
                    logger('$confirmedActivitiesMappedToOrgId');
                    logger($confirmedActivitiesMappedToOrgId);
                    foreach ($confirmedActivitiesMappedToOrgId as $orgId => $activityIds) {
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
        logger()->info('Resolving all affected organizations with broken activity id');
        $this->info('Resolving all affected organizations with broken activity id');

        $brokenOrg = [];
        $dataFrame = [];

        $headers = ['Org Id', 'Publisher Id', 'Activity Id', 'Activity Title', 'Activity Identifier Text in DB', 'Activity Identifier Text in XML', 'Transaction Count in DB', 'Transaction Count in XML', 'Is Broken', 'Last updated at in XML'];
        $dataFrame[] = $headers;

        foreach ($allOrganizationTransactionReferences as $orgId => $possiblyAffectedActivityIdentifiers) {
            logger()->info("Iterating over Organization: $orgId");
            $this->info("Iterating over Organization: $orgId");

            $filename = $possiblyAffectedMergedXml[$orgId];
            $organization = Organization::find($orgId);

            if (awsHasFile("xml/mergedActivityXml/$filename")) {
                logger()->info('Has merged file');
                $this->info('Has merged file');

                $mergedXmlFromS3 = awsGetFile("xml/mergedActivityXml/$filename");
                $mergedXmlFromS3 = new SimpleXMLElement($mergedXmlFromS3);

                foreach ($possiblyAffectedActivityIdentifiers as $activityIdentifier => $transactionRefs) {
                    logger()->info("Iterating over Activity: $activityIdentifier");
                    $this->info("Iterating over Activity: $activityIdentifier");

                    $activityId = $activityIdsMappedToIdentifier[$activityIdentifier];
                    $activity = Activity::find($activityId);

                    $xpathExpression = "//iati-activity[iati-identifier='$activityIdentifier']";
                    $activityWithinXml = $mergedXmlFromS3->xpath($xpathExpression);

                    if (!empty($activityWithinXml)) {
                        $activityWithinXml = $activityWithinXml[0];
                        $transactionCountInXml = count($activityWithinXml->transaction);

                        $isBroken = ($transactionCountInXml !== count($transactionRefs)) ? 1 : 0;

                        if ($isBroken) {
                            $brokenOrg[$orgId][] = $activityId;
                        }

                        $rowVal = [
                            $orgId,
                            $organization->publisher_id,
                            $activityId,
                            $activity->title[0]['narrative'],
                            $activity->iati_identifier['iati_identifier_text'],
                            $activityIdentifier,
                            count($activity->transactions),
                            $transactionCountInXml,
                            $isBroken ? 'yes' : 'no',
                            getTimestampFromSingleXml($organization->publisher_id, $activity),
                        ];
                    } else {
                        $rowVal = [
                            $orgId,
                            $organization->publisher_id,
                            $activityId,
                            $activity->title[0]['narrative'],
                            $activity->iati_identifier['iati_identifier_text'],
                            'Activity with identifier not found.',
                            count($activity->transactions),
                            '---',
                            'yes',
                            getTimestampFromSingleXml($organization->publisher_id, $activity),
                        ];
                    }

                    $dataFrame[] = $rowVal;
                }
            } else {
                logger("Couldn't find merged file for: $orgId");
                $dataFrame[] = [
                    $orgId,
                    $organization->publisher_id,
                    'Merged file not found.',
                    '---',
                    '---',
                    '---',
                    '---',
                    '---',
                    'yes',
                    getTimestampFromSingleXml($organization->publisher_id, $activity),
                ];
            }
        }

        $this->generateReport($dataFrame);

        logger()->info('Resolved all affected organizations with broken activity id');
        $this->info('Resolved all affected organizations with broken activity id');

        return $brokenOrg;
    }

    /**
     * Generate report.
     *
     * @param array $dataFrame
     *
     * @return void
     */
    private function generateReport(array $dataFrame): void
    {
        logger()->info('Generating report...');
        $this->info('Generating report...');

        $xlsFilePath = public_path('broken_org_report' . now()->toString() . '.xlsx');
        $spreadsheet = new Spreadsheet();
        $spreadsheet->getActiveSheet()->fromArray($dataFrame, null, 'A1');
        $xlsWriter = new Xlsx($spreadsheet);
        $xlsWriter->save($xlsFilePath);

        logger()->info('Generated report...');
        $this->info('Generated report...');

        $this->sendReportEmail($xlsFilePath);
    }

    /**
     * Send email with report attached.
     *
     * @param $filePath
     *
     * @return void
     */
    private function sendReportEmail($filePath): void
    {
        $toEmails = ['momik.shrestha@yipl.com.np', 'sarina.sindurakar@yipl.com.np', 'aashish.magar@yipl.com.np'];
        $subject = 'Broken org report';

        Mail::send([], [], function ($message) use ($toEmails, $subject, $filePath) {
            $message->to($toEmails)
                ->subject($subject)
                ->attach($filePath);
        });
    }
}
