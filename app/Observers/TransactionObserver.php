<?php

namespace App\Observers;

use App\IATI\Models\Activity\Transaction;
use App\IATI\Services\ElementCompleteService;

class TransactionObserver
{
    protected ElementCompleteService $elementCompleteService;

    /**
     * Activity observer constructor.
     */
    public function __construct()
    {
        $this->elementCompleteService = new ElementCompleteService();
    }

    /**
     * @param $transaction
     *
     * @return void
     * @throws \JsonException
     */
    public function updateActivityElementStatus($transaction): void
    {
        $activityObj = $transaction->activity;
        $elementStatus = $activityObj->element_status;
        $elementStatus['transactions'] = $this->elementCompleteService->isTransactionsElementCompleted($transaction->activity);

        $activityObj->element_status = $elementStatus;
        $activityObj->saveQuietly();
    }

    /**
     * @param Transaction $transaction
     *
     * @return void
     * @throws \JsonException
     */
    public function created(Transaction $transaction): void
    {
        $this->updateActivityElementStatus($transaction);
    }

    /**
     * @param Transaction $transaction
     *
     * @return void
     * @throws \JsonException
     */
    public function updated(Transaction $transaction): void
    {
        $this->updateActivityElementStatus($transaction);
    }
}
