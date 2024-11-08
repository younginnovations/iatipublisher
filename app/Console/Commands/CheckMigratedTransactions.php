<?php

namespace App\Console\Commands;

use App\IATI\Models\Activity\Activity;
use App\IATI\Services\Activity\TransactionService;
use App\IATI\Services\Organization\OrganizationService;
use App\IATI\Traits\CommandInputTrait;
use App\IATI\Traits\MigrateActivityTrait;
use App\IATI\Traits\MigrateActivityTransactionTrait;
use App\IATI\Traits\MigrateGeneralTrait;
use App\IATI\Traits\MigrateOrganizationTrait;
use App\IATI\Traits\MigrateSettingTrait;
use Illuminate\Console\Command;
use Illuminate\Database\DatabaseManager;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;

/**
 * Class CheckMigratedTransactions.
 */
class CheckMigratedTransactions extends Command
{
    use MigrateSettingTrait;
    use MigrateGeneralTrait;
    use MigrateOrganizationTrait;
    use MigrateActivityTrait;
    use MigrateActivityTransactionTrait;
    use CommandInputTrait;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:check-migrated-transactions';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Checks migrated transactions and updates if required.';

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
//            $aidstreamOrganizationIds = [2310,
//                2427,
//                1543,
//                1070,
//                1585,
//                2509,
//                576,
//                2505,
//                869,
//                259,
//                466,
//                1686,
//                1302,
//                2202,
//                2441,
//                2254,
//                1408,
//                2562,
//                1592,
//                1117,
//                2568,
//                5,
//                1009,
//                2107,
//                1386,
//                2550,
//                1891,
//                2073,
//                1979,
//                1720,
//                2241,
//                1064,
//                217,
//                1426,
//                2586
//                1578];

            $aidstreamOrganizationIdString = $this->askValid(
                'Please enter the organization ids for which you want to check and migrate transactions separated by comma (Compulsory)',
                'aidstreamOrganizationIdString',
                ['required']
            );

            $aidstreamOrganizationIds = explode(',', $aidstreamOrganizationIdString);

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

                $this->logInfo("Checking for organization with id: {$aidstreamOrganizationId}");
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
                        )->with('transactions')->first();

                        if (!$iatiActivity) {
                            logger()->channel('migration')->error(
                                "Activity with identifier {$aidstreamActivityIdentifier} does not exist in IATI Publisher."
                            );

                            $this->error(
                                "Activity with identifier {$aidstreamActivityIdentifier} does not exist in IATI Publisher."
                            );

                            continue;
                        }

                        $aidstreamActivityTransactions = $this->db::connection('aidstream')->table(
                            'activity_transactions'
                        )->where(
                            'activity_id',
                            $aidstreamActivity->id
                        )->get();

                        $iatiActivityTransactions = $iatiActivity->transactions->pluck('transaction');

//                        $aidstreamActivityTransactionsCount = count($aidstreamActivityTransactions);
//                        $iatiActivityTransactionsCount = count($iatiActivityTransactions);
                        $defaultValues = json_encode([$iatiActivity->default_field_values]);

//                        if ($aidstreamActivityTransactionsCount !== $iatiActivityTransactionsCount) {
//                            $this->logInfo(
//                                "AidStream Organization Id: {$aidstreamOrganizationId} \n
//                                IATI Organization Id: {$iatiOrganization->id} \n
//                                Publisher Id: {$iatiOrganization->publisher_id} \n
//                                AidStream Activity Id: {$aidstreamActivity->id} \n
//                                IATI Activity Id: {$iatiActivity->id} \n
//                                Activity Identifier: {$aidstreamActivityIdentifier} \n
//                                AidStream Activity Transactions Count: {$aidstreamActivityTransactionsCount} \n
//                                IATI Activity Transactions Count: {$iatiActivityTransactionsCount} \n"
//                            );

                        $this->info("Checking and updating transaction data for activity with identifier {$aidstreamActivityIdentifier}.");
                        $existingIatiTransactions = $iatiActivityTransactions->toArray();

                        foreach ($aidstreamActivityTransactions as $aidstreamTransaction) {
                            $requiredTransactionData = [
                                'activity_id' => $iatiActivity->id,
                                'transaction' => $this->getRequiredTransactionData(
                                    $aidstreamTransaction,
                                    $defaultValues
                                ),
                                'migrated_from_aidstream' => true,
                                'created_at' => $aidstreamTransaction->created_at,
                                'updated_at' => $aidstreamTransaction->updated_at,
                            ];

                            if (!$this->checkArrayPresent($existingIatiTransactions, $requiredTransactionData['transaction'])) {
                                $this->logInfo(
                                    "Transaction with aidstream id {$aidstreamTransaction->id} does not exist for aidstream activity id {$aidstreamActivity->id}.
                                        Creating transaction data for AidStream Transaction."
                                );
                                $this->transactionService->create($requiredTransactionData);
                                $this->logInfo(
                                    "Created transaction data for AidStream Transaction Id: {$aidstreamTransaction->id}"
                                );
                            }
                        }
//                        }

                        $this->info(
                            "Checking completed for activity with identifier {$aidstreamActivityIdentifier} for organization {$aidStreamOrganization->name} with id $aidStreamOrganization->id"
                        );
                    }
                }

                $this->logInfo("Checking completed for organization with id: {$aidstreamOrganizationId}");
            }
        } catch (\Exception $e) {
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
     *
     * @return bool
     */
    public function checkArrayPresent($allArray, $search): bool
    {
        $secondArray = Arr::dot($search);

        foreach ($allArray as $array) {
            $firstArray = Arr::dot($array);

            if ($this->checkArrayIdentical($firstArray, $secondArray)) {
                return true;
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

            if ($value !== $secondArray[$key]) {
                return false;
            }
        }

        return true;
    }
}
