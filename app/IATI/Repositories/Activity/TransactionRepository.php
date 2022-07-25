<?php

declare(strict_types=1);

namespace App\IATI\Repositories\Activity;

use App\IATI\Models\Activity\Activity;
use App\IATI\Models\Activity\Transaction;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class TransactionRepository.
 */
class TransactionRepository
{
    /**
     * @var Activity
     */
    protected Activity $activity;

    /**
     * @var Transaction
     */
    protected Transaction $activityTransaction;

    /**
     * TransactionRepository Constructor.
     *
     * @param Activity $activity
     * @param Transaction $activityTransaction
     */
    public function __construct(Activity $activity, Transaction $activityTransaction)
    {
        $this->activity = $activity;
        $this->activityTransaction = $activityTransaction;
    }

    /**
     * Create a new Transaction.
     *
     * @param array $transactionData
     *
     * @return Model
     */
    public function create(array $transactionData): Model
    {
        $transactionData = $this->sanitizeTransactionData($transactionData);

        return $this->activityTransaction->create($transactionData);
    }

    /**
     * Update Transaction.
     *
     * @param array $transactionData
     * @param Transaction $activityTransaction
     *
     * @return bool
     */
    public function update(array $transactionData, Transaction $activityTransaction): bool
    {
        $transactionData = $this->sanitizeTransactionData($transactionData);
        $activityTransaction->transaction = $transactionData['transaction'];

        return $activityTransaction->save();
    }

    /**
     * Return specific transaction.
     *
     * @param $id
     * @param $activityId
     *
     * @return Model
     */
    public function getTransaction($id, $activityId): Model
    {
        return $this->activityTransaction->where('id', $id)->where('activity_id', $activityId)->first();
    }

    /**
     * Function to sanitize transaction data.
     *
     * @param array $transactionData
     *
     * @return array
     */
    public function sanitizeTransactionData(array $transactionData): array
    {
        foreach ($transactionData['transaction'] as $transaction_key => $transaction) {
            if (is_array($transaction)) {
                $transactionData['transaction'][$transaction_key] = array_values($transaction);

                foreach ($transaction as $sub_key => $sub_element) {
                    if (is_array($sub_element)) {
                        foreach ($sub_element as $inner_key => $inner_element) {
                            if (is_array($inner_element)) {
                                $transactionData['transaction'][$transaction_key][$sub_key][$inner_key] = array_values($inner_element);
                            }
                        }
                    }
                }
            }
        }

        return $transactionData;
    }

    /**
     * get the references of all transactions.
     *
     * @param $activityId
     *
     * @return array
     */
    public function getTransactionReferences($activityId): array
    {
        $transactions = $this->activityTransaction->where('activity_id', $activityId)->get();
        $references = [];

        foreach ($transactions as $transactionRow) {
            $references[$transactionRow->transaction['reference']] = $transactionRow->id;
        }

        return $references;
    }

    /**
     * get the references of all transactions except transactionId.
     *
     * @param $activityId
     * @param $transactionId
     *
     * @return array
     */
    public function getTransactionReferencesExcept($activityId, $transactionId): array
    {
        $transactions = $this->activityTransaction->where(
            function ($query) use ($activityId, $transactionId) {
                $query->where('id', '<>', $transactionId);
                $query->where('activity_id', '=', $activityId);
            }
        )->get();
        $references = [];

        foreach ($transactions as $transactionRow) {
            $references[$transactionRow->transaction['reference']] = $transactionRow->id;
        }

        return $references;
    }

    /**
     * Returns all transactions of a particular activity.
     *
     * @param $activityId
     *
     * @return Collection|null
     */
    public function getActivityTransactions($activityId): ?Collection
    {
        return $this->activityTransaction->where('activity_id', $activityId)->get();
    }
}
