<?php

declare(strict_types=1);

namespace App\IATI\Services\Activity;

use App\IATI\Elements\Builder\TransactionElementFormCreator;
use App\IATI\Repositories\Activity\TransactionRepository;
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
    use XmlBaseElement;

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
        $this->transactionElementFormCreator->url = route('admin.activities.transactions.store', $activityId);

        return $this->transactionElementFormCreator->editForm([], $element['transactions'], 'POST', '/activities/' . $activityId);
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
        $this->transactionElementFormCreator->url = route('admin.activities.transactions.update', [$activityId, $transactionId]);

        return $this->transactionElementFormCreator->editForm($activityTransaction->transaction, $element['transactions'], 'PUT', '/activities/' . $activityId);
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

                    switch ($vocabulary) {
                        case '1':
                            $sectorValue = Arr::get($sectorData, 'code', null);
                            break;
                        case '2':
                            $sectorValue = Arr::get($sectorData, 'category_code', null);
                            break;
                        case '7':
                            $sectorValue = Arr::get($sectorData, 'sdg_goal', null);
                            break;
                        case '8':
                            $sectorValue = Arr::get($sectorData, 'sdg_target', null);
                            break;
                        default:
                            $sectorValue = Arr::get($sectorData, 'text', null);
                            break;
                    }

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
                foreach (Arr::get($transaction, 'aid_type') as $aidType) {
                    $vocabulary = Arr::get($aidType, 'aidtype_vocabulary', null);

                    switch ($vocabulary) {
                        case '1':
                            $code = Arr::get($aidType, 'aid_type_code', null);
                            break;
                        case '2':
                            $code = Arr::get($aidType, 'earmarking_category', null);
                            break;
                        case '3':
                            $code = Arr::get($aidType, 'earmarking_modality', null);
                            break;
                        case '4':
                            $code = Arr::get($aidType, 'cash_and_voucher_modalities', null);
                            break;
                        default:
                            $code = Arr::get($aidType, 'aid_type_code', null);
                    }

                    $aidType[] = [
                        '@attributes' => [
                            'code'       => $code,
                            'vocabulary' => $vocabulary,
                        ],
                    ];
                }
            }

            $transactionData[] = [
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

        return $transactionData;
    }
}
