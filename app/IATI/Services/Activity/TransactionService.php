<?php

declare(strict_types=1);

namespace App\IATI\Services\Activity;

use App\IATI\Repositories\Activity\TransactionRepository;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class TransactionService.
 */
class TransactionService
{
    /**
     * @var TransactionRepository
     */
    protected TransactionRepository $transactionRepository;

    /**
     * TransactionService constructor.
     *
     * @param TransactionRepository $transactionRepository
     */
    public function __construct(TransactionRepository $transactionRepository)
    {
        $this->transactionRepository = $transactionRepository;
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
        return $this->transactionRepository->create($transactionData);
    }

    /**
     * Update Activity Transaction.
     *
     * @param array $transactionData
     * @param $activityTransaction
     *
     * @return bool
     */
    public function update(array $transactionData, $activityTransaction): bool
    {
        return $this->transactionRepository->update($transactionData, $activityTransaction);
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
        return $this->transactionRepository->getTransaction($id, $activityId);
    }

    /**
     * get the references of all s.
     *
     * @param $activityId
     *
     * @return array
     */
    public function getTransactionReferences($activityId): array
    {
        return $this->transactionRepository->getTransactionReferences($activityId);
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
        return $this->transactionRepository->getTransactionReferencesExcept($activityId, $transactionId);
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
        return $this->transactionRepository->getActivityTransactions($activityId);
    }
}
