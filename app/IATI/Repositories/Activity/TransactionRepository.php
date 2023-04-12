<?php

declare(strict_types=1);

namespace App\IATI\Repositories\Activity;

use App\IATI\Models\Activity\Transaction;
use App\IATI\Models\Setting\Setting;
use App\IATI\Repositories\Repository;
use App\IATI\Traits\FillDefaultValuesTrait;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

/**
 * Class TransactionRepository.
 */
class TransactionRepository extends Repository
{
    use FillDefaultValuesTrait;

    /**
     * @return string
     */
    public function getModel(): string
    {
        return Transaction::class;
    }

    /**
     * Returns paginated transactions.
     *
     * @param int $activityId
     * @param int $page
     *
     * @return LengthAwarePaginator
     */
    public function getPaginatedTransaction(int $activityId, int $page = 1): LengthAwarePaginator
    {
        return $this->model->where('activity_id', $activityId)->orderBy('created_at', 'DESC')->paginate(10, ['*'], 'transaction', $page);
    }

    /**
     * Returns specific transaction of specific activity.
     *
     * @param int $activityId
     * @param int $id
     *
     * @return mixed
     */
    public function getActivityTransaction(int $activityId, int $id): mixed
    {
        return $this->model->where(['activity_id'=>$activityId, 'id'=>$id])->first();
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
     * Delete transactions with activity id.
     *
     * @param $activityId
     *
     * @return bool|int
     */
    public function deleteTransaction($activityId): bool|int
    {
        $transactions = $this->model->where('activity_id', $activityId)->get();

        if (!empty($transactions)) {
            $transactions->each->delete();
        }

        return false;
    }
}
