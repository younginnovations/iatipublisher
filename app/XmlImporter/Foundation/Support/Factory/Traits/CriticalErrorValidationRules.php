<?php

declare(strict_types=1);

namespace App\XmlImporter\Foundation\Support\Factory\Traits;

use App\Http\Requests\Activity\Transaction\TransactionRequest;
use Illuminate\Support\Arr;

/**
 * Class ErrorValidationRules.
 */
trait CriticalErrorValidationRules
{
    /**
     * @param $activity
     * @return array
     */
    public function getCriticalErrorsForTransactions($activity): array
    {
        $rules = [];
        $transactions = Arr::get($activity, 'transactions', []);

        foreach ($transactions as $idx => $transaction) {
            $tempRules = (new TransactionRequest())->getCriticalErrorsForTransaction($transaction, true, $activity, $transactions);

            foreach ($tempRules as $index => $rule) {
                $rules[$index] = $rule;
            }
        }

        return $rules;
    }
}
