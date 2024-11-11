<?php

namespace App\Console\Commands;

use App\IATI\Models\Activity\Activity;
use App\IATI\Services\Activity\TransactionService;
use App\IATI\Services\Organization\OrganizationService;
use App\IATI\Traits\CommandInputTrait;
use App\IATI\Traits\MigrateActivityResultsTrait;
use App\IATI\Traits\MigrateActivityTrait;
use App\IATI\Traits\MigrateActivityTransactionTrait;
use App\IATI\Traits\MigrateDocumentFileTrait;
use App\IATI\Traits\MigrateGeneralTrait;
use App\IATI\Traits\MigrateIndicatorPeriodTrait;
use App\IATI\Traits\MigrateOrganizationTrait;
use App\IATI\Traits\MigrateResultIndicatorTrait;
use App\IATI\Traits\MigrateSettingTrait;
use Illuminate\Console\Command;
use Illuminate\Database\DatabaseManager;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;

/**
 * Class CheckMigratedResults.
 */
class CheckMigratedResults extends Command
{
    use MigrateSettingTrait;
    use MigrateGeneralTrait;
    use MigrateOrganizationTrait;
    use MigrateActivityTrait;
    use MigrateActivityTransactionTrait;
    use CommandInputTrait;
    use MigrateActivityResultsTrait;
    use MigrateDocumentFileTrait;
    use MigrateResultIndicatorTrait;
    use MigrateIndicatorPeriodTrait;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:check-migrated-results';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Checks migrated results.';

    /**
     * MigrateOrganizationCommand Constructor.
     *
     * @return void
     */
    public function __construct(
        protected DB $db,
        protected DatabaseManager $databaseManager,
        protected OrganizationService $organizationService,
        protected TransactionService $transactionService,
    ) {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return void
     */
    public function handle(): void
    {
        try {
//            $aidstreamOrganizationIdString = $this->askValid(
//                'Please enter the organization ids for which you want to check and migrate transactions separated by comma (Compulsory)',
//                'aidstreamOrganizationIdString',
//                ['required']
//            );

//            $aidstreamOrganizationIds = explode(',', $aidstreamOrganizationIdString);
            $aidstreamOrganizationIds = [2310,
                2427,
                1543,
                1070,
                1585,
                2509,
                576,
                2505,
                869,
                259,
                466,
                1686,
                1302,
                2202,
                2441,
                2254,
                1408,
                2562,
                1592,
                1117,
                2568,
                5,
                1009,
                2107,
                1386,
                2550,
                1891,
                2073,
                1979,
                1720,
                2241,
                1064,
                217,
                1426,
                2586,
                1578, ];

            foreach ($aidstreamOrganizationIds as $key => $aidstreamOrganizationId) {
                $aidstreamOrganizationIds[$key] = (int) $aidstreamOrganizationId;
            }

            foreach ($aidstreamOrganizationIds as $aidstreamOrganizationId) {
                $aidStreamOrganization = $this->db::connection('aidstream')->table('organizations')->where(
                    'id',
                    $aidstreamOrganizationId
                )->first();

                if (!$aidStreamOrganization) {
                    logger()->channel('migration')->error(
                        "Organization with id {$aidstreamOrganizationId} does not exist in aidstream."
                    );

                    $this->error("Organization with id {$aidstreamOrganizationId} does not exist in aidstream.");
                    continue;
                }

                $aidStreamOrganizationSetting = $this->db::connection('aidstream')->table('settings')->where(
                    'organization_id',
                    $aidstreamOrganizationId
                )->first();

                $aidstreamPublisherId = $aidStreamOrganization->user_identifier;

                if ($aidStreamOrganizationSetting) {
                    $aidstreamPublisherId = $this->getSettingsPublisherId(
                        $aidStreamOrganizationSetting,
                        $aidStreamOrganization->user_identifier
                    );
                }

                $iatiOrganization = $this->organizationService->getOrganizationByPublisherId(
                    strtolower($aidstreamPublisherId)
                );

                if (!$iatiOrganization) {
                    logger()->channel('migration')->error(
                        "Organization with aidstream id {$aidstreamOrganizationId} publisher id {$aidstreamPublisherId} does not exist in IATI Publisher."
                    );

                    $this->error(
                        "Organization with aidstream id {$aidstreamOrganizationId} publisher id {$aidstreamPublisherId} does not exist in IATI Publisher."
                    );
                }

                $this->logInfo("Checking for organization with id: {$aidstreamOrganizationId} ({$aidStreamOrganization->name})", true);
                // Checking for activities
                $aidstreamActivities = $this->db::connection('aidstream')->table('activity_data')->where(
                    'organization_id',
                    $aidstreamOrganizationId
                )->get();

                if (count($aidstreamActivities)) {
                    foreach ($aidstreamActivities as $aidstreamActivity) {
                        $aidstreamActivityIdentifier = Arr::get(
                            json_decode(
                                $aidstreamActivity->identifier,
                                true,
                                512,
                                JSON_THROW_ON_ERROR
                            ),
                            'activity_identifier'
                        );

                        $this->info(
                            "Checking for activity with identifier {$aidstreamActivityIdentifier} for organization {$aidStreamOrganization->name} with id $aidStreamOrganization->id"
                        );
//                        $this->logInfo(
//                            "Checking for activity with identifier {$aidstreamActivityIdentifier} for organization {$aidStreamOrganization->name} with id $aidStreamOrganization->id"
//                        );

                        $iatiActivity = Activity::whereRaw(
                            "(iati_identifier->>'activity_identifier')::text ilike ?",
                            $aidstreamActivityIdentifier
                        )->with('results.indicators.periods')->first();

                        if (!$iatiActivity) {
                            logger()->channel('migration')->error(
                                "Activity with identifier {$aidstreamActivityIdentifier} does not exist in IATI Publisher."
                            );

                            $this->error(
                                "Activity with identifier {$aidstreamActivityIdentifier} does not exist in IATI Publisher."
                            );

                            continue;
                        }

                        $iatiActivityResults = $iatiActivity->results->toArray();
                        $aidstreamActivityResults = $this->getAidStreamActivityResult($aidstreamActivity->id, $iatiOrganization);
                        $activityTitle = $this->getTitle($aidstreamActivity->title, '0.narrative');

                        if (count($aidstreamActivityResults)) {
                            $this->info("Checking results for AidStream activity {$aidstreamActivity->id}");

                            foreach ($aidstreamActivityResults as $aidstreamActivityResult) {
                                $result = $this->unsetNotNeededKeys($aidstreamActivityResult, ['id', 'created_at', 'updated_at']);
                                $resultTitle = $this->getTitle($result['title'], '0.narrative.0.narrative');
                                $presentIatiResultId = $this->getArrayPresentId($iatiActivityResults, $result, 'result');

                                if (!$presentIatiResultId) {
                                    $this->logInfo(
                                        "Activity Id {$aidstreamActivity->id}: {$activityTitle} \n
                                        Result Id {$aidstreamActivityResult['id']}: {$resultTitle}",
                                        true
                                    );

                                    continue;
                                }

                                $this->info("IATI Activity result id: {$presentIatiResultId} found. Checking indicators.");

                                $iatiResults = array_filter($iatiActivityResults, function ($result) use ($presentIatiResultId) {
                                    return (int) $result['id'] === $presentIatiResultId;
                                });

                                $iatiResultIndicators = Arr::get($iatiResults, '0.indicators', []);

                                // Removing the unnecessary created_at and updated_at
                                if (count($iatiResultIndicators)) {
                                    $iatiResultIndicators = array_map(function ($indicator) {
                                        unset($indicator['indicator']['created_at'], $indicator['indicator']['updated_at']);

                                        return $indicator;
                                    }, $iatiResultIndicators);
                                }

                                $aidstreamResultIndicators = $this->db::connection('aidstream')->table('activity_result_indicators_new')->where(
                                    'result_id',
                                    $aidstreamActivityResult['id']
                                )->get();

                                if (count($aidstreamResultIndicators)) {
                                    $this->info("Checking indicators for AidStream result {$aidstreamActivityResult['id']} activity {$aidstreamActivity->id}");

                                    foreach ($aidstreamResultIndicators as $aidstreamResultIndicator) {
                                        $indicatorData = $this->getNewIndicatorData($aidstreamResultIndicator, $iatiOrganization);
                                        $presentIatiIndicatorId = $this->getArrayPresentId($iatiResultIndicators, $indicatorData, 'indicator');
                                        $indicatorTitle = $this->getTitle($aidstreamResultIndicator->title, '0.narrative.0.narrative');

                                        if (!$presentIatiIndicatorId) {
                                            $this->logInfo(
                                                "Activity Id {$aidstreamActivity->id}: {$activityTitle} \n
                                                Result Id {$aidstreamActivityResult['id']}: {$resultTitle} \n
                                                Indicator Id {$aidstreamResultIndicator->id}: {$indicatorTitle}",
                                                true
                                            );

                                            continue;
                                        }

                                        $this->info("IATI Activity indicator id: {$presentIatiIndicatorId} found. Checking periods.");

                                        $iatiIndicators = array_filter($iatiResultIndicators, function ($indicator) use ($presentIatiIndicatorId) {
                                            return (int) $indicator['id'] === $presentIatiIndicatorId;
                                        });

                                        $iatiIndicatorPeriods = Arr::get($iatiIndicators, '0.periods', []);

                                        $aidstreamIndicatorPeriods = $this->db::connection('aidstream')->table('indicator_periods')->where(
                                            'indicator_id',
                                            $aidstreamResultIndicator->id
                                        )->get();

                                        if (count($aidstreamIndicatorPeriods)) {
                                            foreach ($aidstreamIndicatorPeriods as $aidstreamIndicatorPeriod) {
                                                $periodData = $this->getNewPeriodData($aidstreamIndicatorPeriod, $iatiOrganization);
                                                $presentIatiPeriodId = $this->getArrayPresentId($iatiIndicatorPeriods, $periodData, 'period');

                                                if (!$presentIatiPeriodId) {
                                                    $this->logInfo(
                                                        "Activity Id {$aidstreamActivity->id}: {$activityTitle} \n
                                                        Result Id {$aidstreamActivityResult['id']}: {$resultTitle} \n
                                                        Indicator Id {$aidstreamResultIndicator->id}: {$indicatorTitle} \n
                                                        Period Id {$aidstreamIndicatorPeriod->id}"
                                                    );

                                                    continue;
                                                }

                                                $this->info("IATI Activity period id: {$presentIatiPeriodId} found. Checking periods.");
                                            }
                                        }
                                    }
                                }
                            }
                        }
                    }
                }

                $this->logInfo("Checking completed for organization with id: {$aidstreamOrganizationId}", true);
            }
        } catch (\Exception $e) {
            dd($e);
            logger()->channel('migration')->error($e->getMessage());

            $this->error($e->getMessage());
        }
    }

    /**
     * @param $aidstreamTransaction
     * @param $defaultValues
     *
     * @return array
     *
     * @throws \JsonException
     */
    public function getRequiredTransactionData($aidstreamTransaction, $defaultValues): array
    {
        $newData = $this->getNewTransactionData($aidstreamTransaction->transaction);

        return $this->populateDefaultFields(
            $newData,
            $defaultValues
        );
    }

    /**
     * @param $allArray
     * @param $search
     * @param $key
     *
     * @return bool|int
     */
    public function getArrayPresentId($allArray, $search, $key): bool|int
    {
        $secondArray = Arr::dot($search);

        foreach ($allArray as $array) {
            $firstArray = Arr::dot($array[$key]);

            if ($this->checkArrayIdentical($firstArray, $secondArray)) {
                return $array['id'];
            }
        }

        return false;
    }

    /**
     * @param $firstArray
     * @param $secondArray
     *
     * @return bool
     */
    public function checkArrayIdentical($firstArray, $secondArray): bool
    {
        foreach ($firstArray as $key => $value) {
            if (!array_key_exists($key, $secondArray)) {
                return false;
            }

            if (preg_replace('/[\r\n\t\f\v]/', '', $value) !== preg_replace('/[\r\n\t\f\v]/', '', $secondArray[$key])) {
//                dd($key, preg_replace('/[\r\n\t\f\v]/', '', $value), preg_replace('/[\r\n\t\f\v]/', '', $secondArray[$key]));
                return false;
            }
        }

        return true;
    }

    /**
     * @param $data
     * @param $key
     *
     * @return string
     *
     * @throws \JsonException
     */
    public function getTitle($data, $key): string
    {
        if ($data && !is_array($data)) {
            $data = json_decode($data, true, 512, JSON_THROW_ON_ERROR);
        }

        return preg_replace('/[\r\n\t\f\v]/', '', Arr::get($data, $key, 'Not Available'));
    }
}
