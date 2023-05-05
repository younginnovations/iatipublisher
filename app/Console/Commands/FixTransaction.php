<?php

declare(strict_types=1);

namespace App\Console\Commands;

use App\IATI\Services\Activity\ActivityService;
use App\IATI\Services\Organization\OrganizationService;
use App\IATI\Traits\MigrateOrganizationTrait;
use Illuminate\Console\Command;
use Illuminate\Database\DatabaseManager;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

/*
 * Class FixTransaction
 */
class FixTransaction extends Command
{
    use MigrateOrganizationTrait;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:FixTransaction';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Constructor.
     *
     * @param DB $db
     * @param DatabaseManager $databaseManager
     * @param ActivityService $activityService
     * @param OrganizationService $organizationService
     */
    public function __construct(protected DB $db,
        protected DatabaseManager $databaseManager,
        protected ActivityService $activityService,
        protected OrganizationService $organizationService
    )
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     *
     * @throws \Throwable
     */
    public function handle()
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

            $aidstreamOrganizationIdentifierArray = $this->getAidstreamOrganizationIdentifier($aidstreamOrganizationIds);
            $aidstreamOrganizationIdentifierArray = array_map('strtolower', $aidstreamOrganizationIdentifierArray);

            $iatiOrganizations = $this->organizationService->getOrganizationByPublisherIds($aidstreamOrganizationIdentifierArray);
            $iatiOrganizationIdArray = $iatiOrganizations->pluck('id', 'publisher_id');

            $idMap = $this->mapOrganizationIds($aidstreamOrganizationIdentifierArray, $iatiOrganizationIdArray);
            $activities = $this->activityService->getActivitiesByOrgIds($idMap);

            foreach ($activities as $activity) {
                $this->fixAllTransaction($activity);
            }

            $this->databaseManager->commit();
            $this->info('Completed fixing transactions.');
        } catch(\Exception $e) {
            logger($e->getMessage());
            $this->databaseManager->rollBack();
        }

        return 0;
    }

    /**
     * Populate default values from activity and update transaction.
     *
     * @param $activity
     *
     * @return void
     */
    private function fixAllTransaction($activity): void
    {
        if ($activity->default_field_values) {
            $defaultValues = json_encode([$activity->default_field_values]);
            $transactions = $activity->transactions ?? [];

            foreach ($transactions as $transaction) {
                $tempTransaction = $transaction->transaction;
                $tempTransaction = $this->populateDefaultFields($tempTransaction, $defaultValues);
                $transaction->timestamps = false;
                $transaction->updateQuietly(['transaction'=>$tempTransaction], ['touch'=>false]);
            }
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
     * Returns array of [organizationId => organizationIdentifier].
     *
     * @param $aidstreamOrganizationIds
     *
     * @return array
     */
    private function getAidstreamOrganizationIdentifier($aidstreamOrganizationIds): array
    {
        $aidstreamOrganizationsArray = [];
        $aidStreamSettings = $this->db::connection('aidstream')->table('settings')
            ->whereIn('organization_id', $aidstreamOrganizationIds)
            ->get();

        $userIdentifierArray = $this->db::connection('aidstream')->table('organizations')
            ->whereIn('id', $aidstreamOrganizationIds)
            ->get()->pluck('user_identifier', 'id');

        if ($aidStreamSettings) {
            foreach ($aidStreamSettings as $aidStreamSetting) {
                if (in_array($aidStreamSetting->organization_id, $aidstreamOrganizationIds)) {
                    $registryInfo = $aidStreamSetting->registry_info ? json_decode($aidStreamSetting->registry_info) : false;

                    if ($registryInfo) {
                        $organizationIdentifier = $registryInfo[0]?->publisher_id;
                        $aidstreamOrganizationsArray[$aidStreamSetting->organization_id] = $organizationIdentifier;
                    } else {
                        $aidstreamOrganizationsArray[$aidStreamSetting->organization_id] = strtolower($userIdentifierArray[$aidStreamSetting->organization_id]);
                    }
                }
            }
        }

        return $aidstreamOrganizationsArray;
    }

    /**
     * Returns mapped array of ids
     * [aidstreamOrgId => iatiOrgId].
     *
     * @param array $aidstreamOrganizationIdentifierArray
     * @param $iatiOrganizationIdArray
     *
     * @return array
     */
    private function mapOrganizationIds(array $aidstreamOrganizationIdentifierArray, $iatiOrganizationIdArray): array
    {
        $mappedOrganizationsIdArray = [];

        foreach ($aidstreamOrganizationIdentifierArray as $aidstreamId=>$identifier) {
            $mappedOrganizationsIdArray[$aidstreamId] = Arr::get($iatiOrganizationIdArray, $identifier, '');
        }

        return $mappedOrganizationsIdArray;
    }
}
