<?php

declare(strict_types=1);

namespace App\IATI\Services\Activity;

use App\IATI\Elements\Builder\TransactionElementFormCreator;
use App\IATI\Repositories\Activity\TransactionRepository;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Arr;
use Kris\LaravelFormBuilder\Form;

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
     * @var TransactionElementFormCreator
     */
    protected TransactionElementFormCreator $transactionElementFormCreator;

    /**
     * TransactionService constructor.
     *
     * @param TransactionRepository $transactionRepository
     * @param TransactionElementFormCreator $transactionElementFormCreator
     */
    public function __construct(TransactionRepository $transactionRepository, TransactionElementFormCreator $transactionElementFormCreator)
    {
        $this->transactionRepository = $transactionRepository;
        $this->transactionElementFormCreator = $transactionElementFormCreator;
    }

    /**
     * @param int $activityId
     * @param int $page
     *
     * @return LengthAwarePaginator|Collection
     */
    public function getPaginatedTransaction(int $activityId, int $page): LengthAwarePaginator|Collection
    {
        return $this->transactionRepository->getPaginatedTransaction($activityId, $page);
    }

    /**
     * Return specific transaction.
     *
     * @param $id
     *
     * @return object|null
     */
    public function getTransaction($id): ?object
    {
        return $this->transactionRepository->find($id);
    }

    /**
     * Checks if specific transactions exists for specific activity.
     *
     * @param int $activityId
     * @param int $id
     *
     * @return bool
     */
    public function activityTransactionExists(int $activityId, int $id): bool
    {
        return $this->getActivityTransaction($activityId, $id) !== null;
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
        return $this->transactionRepository->getActivityTransaction($activityId, $id);
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
        return $this->transactionRepository->store($this->sanitizeTransactionData($transactionData));
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
        return $this->transactionRepository->update($activityTransaction->id, ['transaction' => Arr::get($this->sanitizeTransactionData($transactionData), 'transaction', [])]);
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
     * @return object|null
     */
    public function getActivityTransactions($activityId): ?object
    {
        return $this->transactionRepository->findAllBy('activity_id', $activityId);
    }

    /**
     * Generates transaction create form.
     *
     * @param $activityId
     *
     * @return Form
     * @throws \JsonException
     */
    public function createFormGenerator($activityId): Form
    {
        $element = getElementSchema('transactions');
        $this->transactionElementFormCreator->url = route('admin.activity.transaction.store', $activityId);

        return $this->transactionElementFormCreator->editForm([], $element, 'POST', '/activity/' . $activityId);
    }

    /**
     * Generates transaction edit form.
     *
     * @param $transactionId
     * @param $activityId
     *
     * @return Form
     * @throws \JsonException
     */
    public function editFormGenerator($transactionId, $activityId): Form
    {
        $element = getElementSchema('transactions');
        $activityTransaction = $this->getTransaction($transactionId, $activityId);
        $this->transactionElementFormCreator->url = route('admin.activity.transaction.update', [$activityId, $transactionId]);

        return $this->transactionElementFormCreator->editForm($activityTransaction->transaction, $element, 'PUT', '/activity/' . $activityId);
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
}
