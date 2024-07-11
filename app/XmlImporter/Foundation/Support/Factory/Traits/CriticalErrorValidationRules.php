<?php

declare(strict_types=1);

namespace App\XmlImporter\Foundation\Support\Factory\Traits;

use App\Http\Requests\Activity\Transaction\TransactionRequest;
use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Support\Arr;

/**
 * Class ErrorValidationRules.
 */
trait CriticalErrorValidationRules
{
    /**
     * @param $activity
     * @return array
     * @throws BindingResolutionException
     */
    protected function getCriticalErrorsForTransactions($activity): array
    {
        $rules = [];
        $transactions = Arr::get($activity, 'transactions', []);

        foreach ($transactions as $idx => $transaction) {
            $tempRules = $this->getBaseRules((new TransactionRequest())->getCriticalErrorsForTransaction($transaction, true, $activity, $transactions), 'transactions.' . $idx, $transaction, false);

            foreach ($tempRules as $index => $rule) {
                $rules[$index] = $rule;
            }
        }

        return $rules;
    }
}
