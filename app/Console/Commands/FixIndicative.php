<?php

declare(strict_types=1);

namespace App\Console\Commands;

use App\IATI\Services\Organization\OrganizationService;
use App\IATI\Traits\MigrateActivityTrait;
use App\IATI\Traits\MigrateGeneralTrait;
use App\IATI\Traits\MigrateOrganizationTrait;
use Illuminate\Console\Command;
use Illuminate\Database\DatabaseManager;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Throwable;

/*
 * Class FixIndicative
 */
class FixIndicative extends Command
{
    use MigrateOrganizationTrait;
    use MigrateActivityTrait;
    use MigrateGeneralTrait;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:FixIndicative';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Adds indicative to recipient country budget >> status for migrated organizations';

    /**
     * Constructor.
     *
     * @param DB $db
     * @param DatabaseManager $databaseManager
     * @param OrganizationService $organizationService
     */
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

            $aidstreamOrganizationIdentifierArray = $this->getAidstreamOrganizationIdentifier($aidstreamOrganizationIds);
            $aidstreamOrganizationIdentifierArray = array_map('strtolower', $aidstreamOrganizationIdentifierArray);
            $iatiOrganizations = $this->organizationService->getOrganizationByPublisherIds($aidstreamOrganizationIdentifierArray);

            foreach ($iatiOrganizations as $iatiOrganization) {
                $recipientCountryBudgets = $iatiOrganization->recipient_country_budget;

                if (!empty($recipientCountryBudgets)) {
                    foreach ($recipientCountryBudgets as $key => $recipientCountryBudget) {
                        if (empty($recipientCountryBudget['status'])) {
                            $recipientCountryBudgets[$key]['status'] = '1';
                        }
                    }

                    $iatiOrganization->timestamps = false;
                    $iatiOrganization->updateQuietly(
                        ['recipient_country_budget'=>$recipientCountryBudgets],
                        ['touch'                   =>false]
                    );
                }
            }

            $this->databaseManager->commit();

            $this->info('Completed updating organization.');
        } catch(\Exception $e) {
            $this->databaseManager->rollBack();
            $this->logInfo($e->getMessage());
            logger()->error($e);
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
