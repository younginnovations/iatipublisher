<?php

declare(strict_types=1);

namespace App\IATI\Repositories\Activity;

use App\IATI\Models\Activity\Transaction;
use App\IATI\Repositories\Repository;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class TransactionRepository.
 */
class TransactionRepository extends Repository
{
    /**
     * @return string
     */
    public function getModel(): string
    {
        return Transaction::class;
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
        return $this->model->where('id', $id)->where('activity_id', $activityId)->first();
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
        $transactions = $this->model->where('activity_id', $activityId)->get();
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
        $transactions = $this->model->where(
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
     * Returns all transactions belonging to activityId.
     *
     * @param int $activityId
     * @param int $page
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getPaginatedTransaction($activityId, $page = 1): Collection | \Illuminate\Pagination\LengthAwarePaginator
    {
        return $this->model->where('activity_id', $activityId)->orderBy('created_at', 'DESC')->paginate(10, ['*'], 'transaction', $page);
    }
}
