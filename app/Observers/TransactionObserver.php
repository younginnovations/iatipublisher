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
        $elementStatus = $transaction->activity->element_status;
        $elementStatus['transactions'] = $this->elementCompleteService->isTransactionsElementCompleted($transaction->activity);

        $transaction->activity->element_status = $elementStatus;
        $transaction->activity->saveQuietly();
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
