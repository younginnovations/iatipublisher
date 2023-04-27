<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Validator;

/**
 * Class MigrateExistingOrganizationCommand.
 */
class MigrateExistingOrganizationCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'migrate:existing-organization';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Migrates the organization present on AidStream who have already created an account on IATI Publisher.';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        try {
//            $aidstreamOrganizationIdString = $this->askValid(
//                'Please enter the existing organization ids which you want to migrate separated by comma (Compulsory)',
//                'aidstreamOrganizationIdString',
//                ['required']
//            );
//
//            $aidstreamOrganizationIds = explode(',', $aidstreamOrganizationIdString);
//
//            // Convert all the values to integer.
//            foreach ($aidstreamOrganizationIds as $key => $aidstreamOrganizationId) {
//                $aidstreamOrganizationIds[$key] = (int) $aidstreamOrganizationId;
//            }

            $aidstreamOrganizationIds = [60];
        } catch (\Exception $exception) {
            logger()->channel('migration')->error($exception);
            $this->error($exception->getMessage());
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
