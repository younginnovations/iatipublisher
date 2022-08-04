<?php

namespace App\Observers;

use App\IATI\Models\Activity\Transaction;

class TransactionObserver
{
    public function updateActivityElementStatus($transaction)
    {
        $elementStatus = $transaction->activity->element_status;
        $elementStatus['transactions'] = $transaction->activity->getTransactionsElementCompletedAttribute();
        $transaction->activity->element_status = $elementStatus;
        $transaction->activity->save();
    }

    public function created(Transaction $transaction)
    {
        $this->updateActivityElementStatus($transaction);
    }

    public function updated(Transaction $transaction)
    {
        $this->updateActivityElementStatus($transaction);
    }
}
