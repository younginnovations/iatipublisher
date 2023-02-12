<?php

declare(strict_types=1);

namespace App\IATI\Services\Activity;

use App\IATI\Elements\Builder\TransactionElementFormCreator;
use App\IATI\Repositories\Activity\TransactionRepository;
use App\IATI\Traits\DataSanitizeTrait;
use App\IATI\Traits\XmlBaseElement;
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
    use XmlBaseElement, DataSanitizeTrait;

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
    public function __construct(
        TransactionRepository $transactionRepository,
        TransactionElementFormCreator $transactionElementFormCreator
    ) {
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
        $transactionData['transaction'] = $this->sanitizeData($transactionData['transaction']);

        return $this->transactionRepository->store($transactionData);
    }

    /**
     * Update Activity Transaction.
     *
     * @param       $id
     * @param       $transactionData
     *
     * @return bool
     */
    public function update($id, $transactionData): bool
    {
        return $this->transactionRepository->update($id, ['transaction'=>$this->sanitizeData($transactionData)]);
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
        $activityTransaction = $this->getTransaction($transactionId);
        $this->transactionElementFormCreator->url = route(
            'admin.activity.transaction.update',
            [$activityId, $transactionId]
        );

        return $this->transactionElementFormCreator->editForm(
            $activityTransaction->transaction,
            $element,
            'PUT',
            '/activity/' . $activityId
        );
    }

    /**
     * Returns data in required xml array format.
     *
     * @param $transactions
     *
     * @return array
     */
    public function getXmlData($transactions): array
    {
        $transactionData = [];

        foreach ($transactions as $totalTransaction) {
            $transaction = $totalTransaction->transaction;
            $sector = [];

            foreach (Arr::get($transaction, 'sector', []) as $sectorData) {
                if ($sectorData) {
                    $vocabulary = Arr::get($sectorData, 'sector_vocabulary', null);
                    $sectorValue = $this->getSectorValue($vocabulary, $sectorData);

                    $sector[] = [
                        '@attributes' => [
                            'vocabulary'     => $vocabulary,
                            'vocabulary-uri' => Arr::get($sectorData, 'vocabulary_uri', null),
                            'code'           => $sectorValue,
                        ],
                        'narrative'   => $this->buildNarrative(Arr::get($sectorData, 'narrative', [])),
                    ];
                }
            }

            $recipientCountry = [];

            if (Arr::get($transaction, 'recipient_country', null)) {
                $recipientCountry = [
                    '@attributes' => [
                        'code' => Arr::get($transaction, 'recipient_country.0.country_code', null),
                    ],
                    'narrative'   => $this->buildNarrative(Arr::get($transaction, 'recipient_country.0.narrative', [])),
                ];
            }

            $recipientRegion = [];

            if (Arr::get($transaction, 'recipient_region', null)) {
                $recipientRegion = [
                    '@attributes' => [
                        'code'           => Arr::get(
                            $transaction,
                            'recipient_region.0.region_vocabulary',
                            null
                        ) == 1 ? Arr::get(
                            $transaction,
                            'recipient_region.0.region_code',
                            null
                        ) : Arr::get($transaction, 'recipient_region.0.custom_code', null),
                        'vocabulary'     => Arr::get($transaction, 'recipient_region.0.region_vocabulary', null),
                        'vocabulary-uri' => Arr::get($transaction, 'recipient_region.0.vocabulary_uri', null),
                    ],
                    'narrative'   => $this->buildNarrative(Arr::get($transaction, 'recipient_region.0.narrative', [])),
                ];
            }

            $aidType = [];

            if (Arr::get($transaction, 'aid_type', null)) {
                foreach (Arr::get($transaction, 'aid_type', []) as $transactionAidType) {
                    $vocabulary = Arr::get($transactionAidType, 'aid_type_vocabulary', null);
                    $code = $this->getAidTypeCode($vocabulary, $transactionAidType);

                    $aidType[] = [
                        '@attributes' => [
                            'code'       => $code,
                            'vocabulary' => $vocabulary,
                        ],
                    ];
                }
            }

            $transactionData[] = $this->getTransactionData(
                $transaction,
                $sector,
                $recipientCountry,
                $recipientRegion,
                $aidType
            );
        }

        return $transactionData;
    }

    /**
     * Returns sector value based on vocabulary.
     *
     * @param $vocabulary
     * @param $sectorData
     *
     * @return string|null
     */
    public function getSectorValue($vocabulary, $sectorData): ?string
    {
        switch ($vocabulary) {
            case '1':
                return Arr::get($sectorData, 'code', null);
            case '2':
                return Arr::get($sectorData, 'category_code', null);
            case '7':
                return Arr::get($sectorData, 'sdg_goal', null);
            case '8':
                return Arr::get($sectorData, 'sdg_target', null);
            default:
                return Arr::get($sectorData, 'text', null);
        }
    }

    /**
     * Returns aid type code according to vocabulary.
     *
     * @param $vocabulary
     * @param $aidType
     *
     * @return string|null
     */
    public function getAidTypeCode($vocabulary, $aidType): ?string
    {
        switch ($vocabulary) {
            case '2':
                return Arr::get($aidType, 'earmarking_category', null);
            case '3':
                return Arr::get($aidType, 'earmarking_modality', null);
            case '4':
                return Arr::get($aidType, 'cash_and_voucher_modalities', null);
            default:
                return Arr::get($aidType, 'aid_type_code', null);
        }
    }

    /**
     * Returns array required for creating xml.
     *
     * @param $transaction
     * @param $sector
     * @param $recipientCountry
     * @param $recipientRegion
     * @param $aidType
     *
     * @return array
     */
    public function getTransactionData($transaction, $sector, $recipientCountry, $recipientRegion, $aidType): array
    {
        return [
            '@attributes'          => [
                'ref'          => Arr::get($transaction, 'reference', null),
                'humanitarian' => Arr::get($transaction, 'humanitarian', null),
            ],
            'transaction-type'     => [
                '@attributes' => [
                    'code' => Arr::get($transaction, 'transaction_type.0.transaction_type_code', null),
                ],
            ],
            'transaction-date'     => [
                '@attributes' => [
                    'iso-date' => Arr::get($transaction, 'transaction_date.0.date', null),
                ],
            ],
            'value'                => [
                '@attributes' => [
                    'currency'   => Arr::get($transaction, 'value.0.currency', null),
                    'value-date' => Arr::get($transaction, 'value.0.date', null),
                ],
                '@value'      => Arr::get($transaction, 'value.0.amount', null),
            ],
            'description'          => [
                'narrative' => $this->buildNarrative(Arr::get($transaction, 'description.0.narrative', [])),
            ],
            'provider-org'         => [
                '@attributes' => [
                    'ref'                  => Arr::get(
                        $transaction,
                        'provider_organization.0.organization_identifier_code',
                        null
                    ),
                    'provider-activity-id' => Arr::get(
                        $transaction,
                        'provider_organization.0.provider_activity_id',
                        null
                    ),
                    'type'                 => Arr::get($transaction, 'provider_organization.0.type', null),
                ],
                'narrative'   => $this->buildNarrative(
                    Arr::get($transaction, 'provider_organization.0.narrative', [])
                ),
            ],
            'receiver-org'         => [
                '@attributes' => [
                    'ref'                  => Arr::get(
                        $transaction,
                        'receiver_organization.0.organization_identifier_code',
                        null
                    ),
                    'receiver-activity-id' => Arr::get(
                        $transaction,
                        'receiver_organization.0.receiver_activity_id',
                        null
                    ),
                    'type'                 => Arr::get($transaction, 'receiver_organization.0.type', null),
                ],
                'narrative'   => $this->buildNarrative(
                    Arr::get($transaction, 'receiver_organization.0.narrative', [])
                ),
            ],
            'disbursement-channel' => [
                '@attributes' => [
                    'code' => Arr::get($transaction, 'disbursement_channel.0.disbursement_channel_code', null),
                ],
            ],
            'sector'               => $sector,
            'recipient-country'    => $recipientCountry,
            'recipient-region'     => $recipientRegion,
            'flow-type'            => [
                '@attributes' => [
                    'code' => Arr::get($transaction, 'flow_type.0.flow_type', null),
                ],
            ],
            'finance-type'         => [
                '@attributes' => [
                    'code' => Arr::get($transaction, 'finance_type.0.finance_type', null),
                ],
            ],
            'aid-type'             => $aidType,
            'tied-status'          => [
                '@attributes' => [
                    'code' => Arr::get($transaction, 'tied_status.0.tied_status_code', null),
                ],
            ],
        ];
    }

    /**
     * Deletes specific transaction.
     *
     * @param $id
     *
     * @return bool
     */
    public function deleteTransaction($id): bool
    {
        return $this->transactionRepository->delete($id);
    }

     /**
     * Checks if sector defined in one of the activity transaction.
     *
     * @param $activityId
     * @return bool
     */
    public function hasSectorDefinedInTransaction($activityId): bool
    {
        $transactionData = $this->getActivityTransactions($activityId);

        if (!empty($transactionData)) {
            foreach ($transactionData as $transactionDatum) {
                if (
                    isset($transactionDatum->transaction['sector'])
                    && !is_variable_null($transactionDatum->transaction['sector'])
                ) {
                    return true;
                }
            }
        }

        return false;
    }

    /**
     * Checks if Transaction has Sector Defined.
     *
     * @param $activity
     * @return bool
     */
    public function checksIfTransactionHasSectorDefinedInTransaction($activity): bool
    {
        $hasDefined = false;
        $transactionData = $activity->transactions()->get()->toArray();

        if (!empty($transactionData)) {
            foreach ($transactionData as $transactionDatum) {
                if (
                    isset($transactionDatum['transaction']['sector'])
                    && !is_variable_null($transactionDatum['transaction']['sector'])
                ) {
                    $hasDefined = true;
                }
            }
        }

        return $hasDefined;
    }

    /**
     *  Checks if recipient region or country defined in transaction
     *
     * @param [type] $activityId
     * @return boolean
     */
    public function hasRecipientRegionOrCountryDefinedInTransaction($activityId): bool
    {
        $hasDefined = false;
        $transactions = $this->getActivityTransactions($activityId);

        foreach ($transactions as $transaction) {
            $recipientRegion = $transaction->transaction['recipient_region'];
            $recipientCountry = $transaction->transaction['recipient_country'];

            if (!is_variable_null($recipientCountry) || !is_variable_null($recipientRegion)) {
                $hasDefined = true;
                break;
            }
        }

        return $hasDefined;
    }
}
