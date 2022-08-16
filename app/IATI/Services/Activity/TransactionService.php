<?php

declare(strict_types=1);

namespace App\IATI\Services\Activity;

use App\IATI\Elements\Builder\TransactionElementFormCreator;
use App\IATI\Repositories\Activity\TransactionRepository;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\LengthAwarePaginator;
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
     * @return Model|null
     */
    public function getTransaction($id, $activityId): ?Model
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

    /**
     * Generates transaction create form.
     *
     * @param $activityId
     *
     * @return Form
     */
    public function createFormGenerator($activityId): Form
    {
        $element = json_decode(file_get_contents(app_path('IATI/Data/elementJsonSchema.json')), true);
        $this->transactionElementFormCreator->url = route('admin.activity.transactions.store', $activityId);

        return $this->transactionElementFormCreator->editForm([], $element['transactions'], 'POST', '/activity/' . $activityId);
    }

    /**
     * Generates transaction edit form.
     *
     * @param $id
     *
     * @return Form
     */
    public function editFormGenerator($transactionId, $activityId): Form
    {
        $element = json_decode(file_get_contents(app_path('IATI/Data/elementJsonSchema.json')), true);
        $activityTransaction = $this->getTransaction($transactionId, $activityId);
        $this->transactionElementFormCreator->url = route('admin.activity.transactions.update', [$activityId, $transactionId]);

        return $this->transactionElementFormCreator->editForm($activityTransaction->transaction, $element['transactions'], 'PUT', '/activity/' . $activityId);
    }

    /*
     * Returns array of paginated transactions belonging to an activity.
     *
     * @param $activityId
     * @param $page
     *
     * return LengthAwarePaginator|Collection
     */
    public function getPaginatedTransaction($activityId, $page): LengthAwarePaginator|Collection
    {
        return $this->transactionRepository->getPaginatedTransaction($activityId, $page);
    }
}
