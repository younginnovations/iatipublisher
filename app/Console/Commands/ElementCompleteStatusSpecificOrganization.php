<?php

declare(strict_types=1);

namespace App\Console\Commands;

use App\IATI\Models\Activity\Activity;
use App\Observers\TransactionObserver;
use Illuminate\Console\Command;
use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Support\Facades\Validator;

/**
 * Class ElementCompleteStatusSpecificOrganization.
 */
class ElementCompleteStatusSpecificOrganization extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'complete-transaction:specific-organization';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = "This command checks for the specific organization's activities transaction and their completion status. If any activities are incomplete, it marks them as complete. ";

    /**
     * Execute the console command.
     *
     * @return int
     * @throws \JsonException|BindingResolutionException
     */
    public function handle()
    {
        $organizationIds = $this->askValid(
            'Please enter the organization ids',
            'organization_id',
            ['required', 'numeric']
        );

        $organizationIdInArray = explode(',', $organizationIds);

        Activity::query()->whereIn('org_id', $organizationIdInArray)->chunk(10, function ($activities) {
            $transactionObserver = new TransactionObserver();

            foreach ($activities as $activity) {
                foreach ($activity->transactions as $transaction) {
                    $transactionObserver->updateActivityElementStatus($transaction, changeUpdatedAt: false);
                }
            }
        });
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
