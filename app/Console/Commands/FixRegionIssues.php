<?php

declare(strict_types=1);

namespace App\Console\Commands;

use App\IATI\Services\Organization\OrganizationService;
use App\IATI\Traits\MigrateActivityTrait;
use App\IATI\Traits\MigrateGeneralTrait;
use App\IATI\Traits\MigrateOrganizationTrait;
use Exception;
use Illuminate\Console\Command;
use Illuminate\Database\DatabaseManager;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Throwable;

/*
 * Class FixRegionIssues.
 */
class FixRegionIssues extends Command
{
    use MigrateOrganizationTrait;
    use MigrateActivityTrait;
    use MigrateGeneralTrait;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:FixRegionIssues';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    public function __construct(
        protected DB $db,
        protected DatabaseManager $databaseManager,
        protected OrganizationService $organizationService
    ) {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return void
     *
     * @throws Throwable
     */
    public function handle(): void
    {
        try {
            $aidstreamOrganizationIdString = $this->askValid(
                'Enter aidstream organization Ids (csv): ',
                'aidstreamOrganizationIdString',
                ['required']
            );

            $aidstreamOrganizationIds = explode(',', $aidstreamOrganizationIdString);

            foreach ($aidstreamOrganizationIds as $key => $aidstreamOrganizationId) {
                $aidstreamOrganizationIds[$key] = (int) $aidstreamOrganizationId;
            }

            $this->databaseManager->beginTransaction();

            $aidstreamOrganizationDataCollectionArray = $this->db::connection('aidstream')
                ->table('organization_data')
                ->whereIn('organization_id', $aidstreamOrganizationIds)
                ->where('is_reporting_org', true)
                ->get();

            $aidstreamOrganizationIdentifierArray = $this->getAidstreamOrganizationIdentifier($aidstreamOrganizationIds);
            $recipientCountryBudgetArray = $aidstreamOrganizationDataCollectionArray->pluck('recipient_country_budget', 'organization_id');
            $recipientRegionBudgetArray = $aidstreamOrganizationDataCollectionArray->pluck('recipient_region_budget', 'organization_id');
            $aidstreamOrganizationIdentifierArray = array_map('strtolower', $aidstreamOrganizationIdentifierArray);

            $iatiOrganizations = $this->organizationService->getOrganizationByPublisherIds($aidstreamOrganizationIdentifierArray);
            $iatiOrganizationIdArray = $iatiOrganizations->pluck('id', 'publisher_id');

            $idMap = $this->mapOrganizationIds($aidstreamOrganizationIdentifierArray, $iatiOrganizationIdArray);

            $flippedMap = array_flip($idMap);

            foreach ($iatiOrganizations as $iatiOrganization) {
                $key = Arr::get($flippedMap, $iatiOrganization->id, false);
                $defaultFieldValues = json_encode(
                    [
                        $iatiOrganization->settings->default_values,
                    ]
                );

                if ($key) {
                    $recipientCountryBudgetData = $this->getOrganizationBudget($recipientCountryBudgetArray[$key], 'recipient_country', 'budget_line');
                    $recipientCountryBudgetData = $this->populateDefaultFields($recipientCountryBudgetData, $defaultFieldValues);
                    $recipientRegionBudgetData = $this->getOrganizationRecipientRegionBudget($recipientRegionBudgetArray[$key]);
                    $recipientRegionBudgetData = $this->populateDefaultFields($recipientRegionBudgetData, $defaultFieldValues);

                    $iatiOrganization->timestamps = false;
                    $iatiOrganization->updateQuietly(
                        [
                            'recipient_country_budget'=> $recipientCountryBudgetData,
                            'recipient_region_budget'=>$recipientRegionBudgetData,
                        ],
                        ['touch'=>false]
                    );
                }
            }

            $this->databaseManager->commit();

            $this->info('Completed updating organization.');
        } catch(Exception $e) {
            $this->databaseManager->rollBack();
            logger()->error($e);
            $this->logInfo($e->getMessage());
        }
    }

    /**
     * Ask input from user and return value.
     *
     * @param $question
     * @param $field
     * @param $rules
     *
     * @return string
     */
    protected function askValid($question, $field, $rules): string
    {
        $value = $this->ask($question);
        $message = $this->validateInput($rules, $field, $value);

        if ($message) {
            $this->error($message);

            return $this->askValid($question, $field, $rules);
        }

        return $value;
    }

    /**
     * Validates input given by user.
     *
     * @param $rules
     * @param $fieldName
     * @param $value
     *
     * @return string|null
     */
    protected function validateInput($rules, $fieldName, $value): ?string
    {
        $validator = Validator::make([
            $fieldName => $value,
        ], [
            $fieldName => $rules,
        ]);

        return $validator->fails()
            ? $validator->errors()->first($fieldName)
            : null;
    }
}
