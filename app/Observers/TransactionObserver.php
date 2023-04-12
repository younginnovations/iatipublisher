<?php

declare(strict_types=1);

namespace App\Observers;

use App\IATI\Models\Activity\Activity;
use App\IATI\Models\Activity\Transaction;
use App\IATI\Services\Activity\TransactionService;
use App\IATI\Services\ElementCompleteService;
use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Support\Arr;

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
        $isSectorFilledInActivityLevel = !is_array_value_empty($activityObj->sector);
        $isSectorCompletedInActivityLevel = Arr::get($elementStatus, 'sector', false);
        $transactionService = app()->make(TransactionService::class);
        $isSectorFilledInTransactionLevel = $transactionService->checkIfTransactionHasElementDefined($activityObj, 'sector');
        $isSectorCompleteInTransactionLevel = $this->elementCompleteService->isSectorElementCompleted(new Activity(['sector' => $transaction->transaction]));

        switch([
            $isSectorFilledInActivityLevel,
            $isSectorCompletedInActivityLevel,
            $isSectorFilledInTransactionLevel,
            $isSectorCompleteInTransactionLevel,
        ]) {
            case [0, 0, 1, 1]:
            case [0, 1, 1, 1]:
            case [1, 0, 1, 1]:
            case [1, 1, 0, 0]:
            case [1, 1, 0, 1]:
            case [1, 1, 1, 0]:
            case [1, 1, 1, 1]:
                $elementStatus['sector'] = true;
                break;
            default:
                $elementStatus['sector'] = false;
                break;
        }

        if (is_array_value_empty($transaction->transaction['recipient_region']) || is_array_value_empty($transaction->transaction['recipient_country'])) {
            $elementStatus['recipient_region'] = true;
            $elementStatus['recipient_country'] = true;
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
