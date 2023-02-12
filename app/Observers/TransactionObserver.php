<?php

declare(strict_types=1);

namespace App\Observers;

use App\IATI\Models\Activity\Transaction;
use App\IATI\Services\Activity\TransactionService;
use App\IATI\Services\ElementCompleteService;
use Illuminate\Contracts\Container\BindingResolutionException;

/**
 * Class TransactionObserver.
 */
class TransactionObserver
{
    /**
     * @var ElementCompleteService
     */
    protected ElementCompleteService $elementCompleteService;

    /**
     * Transaction observer constructor.
     */
    public function __construct()
    {
        $this->elementCompleteService = new ElementCompleteService();
    }

    /**
     * Updates the transactions complete status.
     *
     * @param $transaction
     *
     * @return void
     * @throws \JsonException
     * @throws BindingResolutionException
     */
    public function updateActivityElementStatus($transaction): void
    {
        $activityObj = $transaction->activity;
        $elementStatus = $activityObj->element_status;
        $elementStatus['transactions'] = $this->elementCompleteService->isTransactionsElementCompleted($transaction->activity);

        if (!is_variable_null($transaction->transaction['sector'])) {
            $elementStatus['sector'] = true;
        }

        $transactionService = app()->make(TransactionService::class);

        if (is_variable_null($transaction->transaction['sector']) && !$transactionService->checksIfTransactionHasSectorDefined($activityObj)) {
            $elementStatus['sector'] = false;
        }

        $activityObj->element_status = $elementStatus;
        $activityObj->saveQuietly();
    }

    /**
     * Handle the Transaction "created" event.
     *
     * @param Transaction $transaction
     *
     * @return void
     * @throws \JsonException
     */
    public function created(Transaction $transaction): void
    {
        $this->setTransactionDefaultValues($transaction);
        $this->updateActivityElementStatus($transaction);
        $this->resetActivityStatus($transaction);
    }

    /**
     * Handle the Transaction "updated" event.
     *
     * @param Transaction $transaction
     *
     * @return void
     * @throws \JsonException
     */
    public function updated(Transaction $transaction): void
    {
        $this->updateActivityElementStatus($transaction);
        $this->resetActivityStatus($transaction);
        $this->setTransactionDefaultValues($transaction);
    }

    /**
     * Resets activity status to draft.
     *
     * @param $transaction
     *
     * @return void
     */
    public function resetActivityStatus($transaction): void
    {
        $activityObject = $transaction->activity;
        $activityObject->status = 'draft';
        $activityObject->saveQuietly();
    }

    /**
     * Sets default values for language and currency for transaction.
     *
     * @param $transaction
     *
     * @return void
     */
    public function setTransactionDefaultValues($transaction): void
    {
        $transactionData = $transaction->transaction;
        $updatedData = $this->elementCompleteService->setDefaultValues($transactionData, $transaction->activity);
        $transaction->transaction = $updatedData;
        $transaction->saveQuietly();
    }

    /**
     * Handles transaction "Deleted" Event.
     *
     * @param Transaction $transaction
     * @return void
     * @throws BindingResolutionException
     */
    public function deleted(Transaction $transaction): void
    {
        $activityObj = $transaction->activity;
        $transactionService = app()->make(TransactionService::class);
        $hasSectorDefinedInTransaction = $transactionService->checksIfTransactionHasSectorDefined($activityObj);

        if (!$hasSectorDefinedInTransaction) {
            $elementStatus = $activityObj->element_status;
            $elementStatus['sector'] = false;
            $activityObj->element_status = $elementStatus;
            $activityObj->save();
        }
    }
}
