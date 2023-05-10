<?php

declare(strict_types=1);

namespace App\Console\Commands;

use App\IATI\Services\Activity\ActivityService;
use App\IATI\Services\Organization\OrganizationService;
use App\IATI\Traits\MigrateGeneralTrait;
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
    use MigrateGeneralTrait;

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
    public function __construct(
        protected DB $db,
        protected DatabaseManager $databaseManager,
        protected ActivityService $activityService,
        protected OrganizationService $organizationService
    ) {
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
            logger()->error($e);
            $this->logInfo($e->getMessage());
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
}
