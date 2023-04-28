<?php

declare(strict_types=1);

namespace App\Console\Commands;

use App\IATI\Models\Organization\Organization;
use App\IATI\Traits\MigrateActivityTrait;
use Exception;
use Illuminate\Console\Command;
use Illuminate\Database\DatabaseManager;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use App\IATI\Traits\MigrateOrganizationTrait;

/*
 * Class FixRegionIssues.
 */
class FixRegionIssues extends Command
{
    use MigrateOrganizationTrait;
    use MigrateActivityTrait;

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
        protected DatabaseManager $databaseManager
    ) {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return void
     * @throws Throwable|\Throwable
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

            $aidstreamOrganizationIdentifierArray =  $this->getAidstreamOrganizationIdentifier($aidstreamOrganizationIds);
            $recipientCountryBudgetArray = $aidstreamOrganizationDataCollectionArray->pluck('recipient_country_budget', 'organization_id');
            $recipientRegionBudgetArray = $aidstreamOrganizationDataCollectionArray->pluck('recipient_region_budget', 'organization_id');
            $aidstreamOrganizationIdentifierArray = array_map('strtolower', $aidstreamOrganizationIdentifierArray);

            $iatiOrganizations = Organization::whereIn('publisher_id', $aidstreamOrganizationIdentifierArray)->get();
            $iatiOrganizationIdArray  =  $iatiOrganizations->pluck('id', 'publisher_id');

            $idMap = $this->mapOrganizationIds($aidstreamOrganizationIdentifierArray, $iatiOrganizationIdArray);

            $flippedMap = array_flip($idMap);

            foreach ($iatiOrganizations as $iatiOrganization){
                $key =  Arr::get($flippedMap, $iatiOrganization->id, false);
                $defaultFieldValues = json_encode(
                    [
                        $iatiOrganization->settings->default_values
                    ]
                );

                if($key){
                    $recipientCountryBudgetData = $this->getOrganizationBudget($recipientCountryBudgetArray[$key], 'recipient_country', 'budget_line');
                    $recipientCountryBudgetData = $this->populateDefaultFields($recipientCountryBudgetData, $defaultFieldValues);
                    $recipientRegionBudgetData  = $this->getOrganizationRecipientRegionBudget($recipientRegionBudgetArray[$key]);
                    $recipientRegionBudgetData  = $this->populateDefaultFields($recipientRegionBudgetData, $defaultFieldValues);


                    $iatiOrganization->updateQuietly(
                        [
                            'recipient_country_budget'=> $recipientCountryBudgetData,
                            'recipient_region_budget'=>$recipientRegionBudgetData
                        ],
                        ['touch'=>false]
                    );
                }
            }

            $this->databaseManager->commit();

            info("Completed updating organization.");
        } catch(Exception $e) {
            $this->databaseManager->rollBack();

            logger()->error($e->getMessage());
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

    /**
     * Returns array of [organizationId => organizationIdentifier]
     *
     * @param $aidstreamOrganizationIds
     *
     * @return array
     */
    private function getAidstreamOrganizationIdentifier($aidstreamOrganizationIds): array {
        $returnArr = [];
        $aidStreamSettings = $this->db::connection('aidstream')->table('settings')
            ->whereIn('organization_id', $aidstreamOrganizationIds)
            ->get();

        if($aidStreamSettings){
            foreach ($aidStreamSettings as $aidStreamSetting) {
                if(in_array($aidStreamSetting->organization_id, $aidstreamOrganizationIds)){
                    $registryInfo = $aidStreamSetting->registry_info? json_decode($aidStreamSetting->registry_info): false;
                    $organizationIdentifier = $registryInfo[0]?->publisher_id;
                    $returnArr[$aidStreamSetting->organization_id] = $organizationIdentifier;
                }
            }
        }

        return $returnArr;
    }

    /**
     * Returns mapped array of ids
     * [aidstreamOrgId => iatiOrgId]
     *
     * @param array $aidstreamOrganizationIdentifierArray
     * @param $iatiOrganizationIdArray
     *
     * @return array
     */
    private function mapOrganizationIds(array $aidstreamOrganizationIdentifierArray, $iatiOrganizationIdArray): array
    {
        $returnArr = [];

        foreach ($aidstreamOrganizationIdentifierArray as $aidstreamId=>$identifier){
            $returnArr[$aidstreamId] = Arr::get($iatiOrganizationIdArray, $identifier, '');
        }

        return $returnArr;
    }
}
