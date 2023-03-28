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
     * @param  bool  $changeUpdatedAt
     *
     * @return void
     *
     * @throws BindingResolutionException
     * @throws \JsonException
     */
    public function updateActivityElementStatus($transaction, bool $changeUpdatedAt = true): void
    {
        $activityObj = $transaction->activity;
        $elementStatus = $activityObj->element_status;
        $elementStatus['transactions'] = $this->elementCompleteService->isTransactionsElementCompleted($transaction->activity);

        if (!is_array_value_empty($transaction->transaction['sector'])) {
            $elementStatus['sector'] = true;
        }

        $transactionService = app()->make(TransactionService::class);

        if (is_array_value_empty($transaction->transaction['sector']) && !$transactionService->checkIfTransactionHasElementDefined($activityObj, 'sector')) {
            $elementStatus['sector'] = false;
        }

        if (is_array_value_empty($transaction->transaction['recipient_region']) || is_array_value_empty($transaction->transaction['recipient_country'])) {
            $elementStatus['recipient_region'] = true;
            $elementStatus['recipient_country'] = true;
        }

        $activityObj->element_status = $elementStatus;

        if (!$changeUpdatedAt) {
            $activityObj->timestamps = false;
        }

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
        $changeUpdatedAt = !$transaction->migrated_from_aidstream;

        $this->setTransactionDefaultValues($transaction, $changeUpdatedAt);
        $this->updateActivityElementStatus($transaction, $changeUpdatedAt);

        if ($changeUpdatedAt) {
            $this->resetActivityStatus($transaction);
        }
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
     *
     * @throws \JsonException
     */
    public function setTransactionDefaultValues($transaction, bool $changeUpdatedAt = true): void
    {
        $transactionData = $transaction->transaction;
        $updatedData = $this->elementCompleteService->setDefaultValues($transactionData, $transaction->activity);
        $transaction->transaction = $updatedData;

        if (!$changeUpdatedAt) {
            $transaction->timestamps = false;
        }

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
        $elementStatus = $activityObj->element_status;
        $transactionService = app()->make(TransactionService::class);
        $hasSectorDefinedInTransaction = $transactionService->checkIfTransactionHasElementDefined($activityObj, 'sector');
        $hasRecipientCountryDefinedInTransaction = $transactionService->checkIfTransactionHasElementDefined($activityObj, 'recipient_country');
        $hasRecipientRegionDefinedInTransaction = $transactionService->checkIfTransactionHasElementDefined($activityObj, 'recipient_region');

        if (!$hasSectorDefinedInTransaction) {
            $elementStatus['sector'] = false;
        }

        if (!count($activityObj->transactions) && empty($activityObj->recipient_region) && empty($activityObj->recipient_country)) {
            $elementStatus['recipient_region'] = false;
            $elementStatus['recipient_country'] = false;
            $elementStatus['transactions'] = false;
        }

        if ($hasRecipientCountryDefinedInTransaction && count($activityObj->transactions) > 1) {
            $elementStatus['recipient_country'] = false;

            if (!empty($activityObj->recipient_region)) {
                $elementStatus['recipient_region'] = false;
            }
        }

        if ($hasRecipientRegionDefinedInTransaction && count($activityObj->transactions) > 1) {
            $elementStatus['recipient_region'] = false;

            if (!empty($activityObj->recipient_region)) {
                $elementStatus['recipient_country'] = false;
            }
        }

        $activityObj->element_status = $elementStatus;
        $activityObj->save();
    }
}
