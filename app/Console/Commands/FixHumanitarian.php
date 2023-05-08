<?php

declare(strict_types=1);

namespace App\Console\Commands;

use App\IATI\Traits\MigrateGeneralTrait;
use Illuminate\Console\Command;
use Illuminate\Database\DatabaseManager;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use PHPUnit\Exception;
use Throwable;

/**
 * Class Fix Humanitarian.
 */
class FixHumanitarian extends Command
{
    use MigrateGeneralTrait;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:FixHumanitarian';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * @param  DB  $db
     * @param  DatabaseManager  $databaseManager
     */
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

            $aidStreamActivities = $this->db::connection('aidstream')->table('activity_data')->whereIn('organization_id', $aidstreamOrganizationIds)->get();
            $aidStreamActivityIdentifiersJsonArray = $aidStreamActivities->pluck('identifier', 'id');
            $aidStreamActivityDefaultValuesJsonArray = $aidStreamActivities->pluck('default_field_values', 'id');
            $aidStreamActivityIdWhereHumanitarianIsZero = $this->getActivityWithHumanitarianIsZero($aidStreamActivityDefaultValuesJsonArray);
            $iatiIdentifierTextArray = $this->getIatiIdentifierTextArray($aidStreamActivityIdWhereHumanitarianIsZero, $aidStreamActivityIdentifiersJsonArray);

            $concatQuery = "CONCAT(org.identifier, '-', activities.iati_identifier->>'activity_identifier')";

            DB::table('activities')->select(['activities.id'])
               ->leftJoin('organizations as org', 'activities.org_id', '=', 'org.id')
               ->whereIn(DB::raw($concatQuery), array_values($iatiIdentifierTextArray))
               ->update(['activities.default_field_values->humanitarian'=> '0', 'updated_at' => DB::raw('updated_at')]);

            $this->info('Complete updating humanitarian value.');

            $this->databaseManager->commit();
        } catch(Exception $e) {
            $this->databaseManager->rollBack();
            logger()->error($e);
            $this->infoLog($e->getMessage());
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
     * Return array of id of activities where default_field_values->humanitarian = no.
     *
     * @param $activityDefaultValuesJsonArray
     *
     * @return array
     */
    private function getActivityWithHumanitarianIsZero($activityDefaultValuesJsonArray): array
    {
        $returnArray = [];

        foreach ($activityDefaultValuesJsonArray as $id => $item) {
            $item = $item ? json_decode($item, true) : false;
            if ($item) {
                if (Arr::get($item, '0.humanitarian', false) === 0 || Arr::get($item, '0.humanitarian', false) === '0') {
                    $returnArray[] = $id;
                }
            }
        }

        return $returnArray;
    }

    /**
     * Returns IatiIdentifierText of needed activities.
     *
     * @param $activityIdWhereHumanitarianIsZero
     * @param $activityIdentifiersJsonArray
     *
     * @return array
     */
    private function getIatiIdentifierTextArray($activityIdWhereHumanitarianIsZero, $activityIdentifiersJsonArray): array
    {
        $returnArr = [];

        foreach ($activityIdWhereHumanitarianIsZero as $aidstreamActivityId) {
            $activityIdentifierJson = $activityIdentifiersJsonArray[$aidstreamActivityId];
            $activityIdentifierJson = json_decode($activityIdentifierJson);

            if ($activityIdentifierJson && ($activityIdentifierJson->iati_identifier_text ?? false)) {
                $returnArr[] = $activityIdentifierJson->iati_identifier_text;
            }
        }

        return $returnArr;
    }
}
