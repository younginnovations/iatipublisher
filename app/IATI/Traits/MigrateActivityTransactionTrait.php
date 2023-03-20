<?php

declare(strict_types=1);

namespace App\IATI\Traits;

use Illuminate\Support\Arr;

/**
 * Class MigrateActivityTransactionTrait.
 */
trait MigrateActivityTransactionTrait
{
    /**
     * Contains key value pair to be replaced for particular vocabulary.
     *
     * @var array
     */
    protected array $transactionAidTypeReplaceArray
        = [
            '1' => [
                'default_aidtype_vocabulary' => 'aid_type_vocabulary',
                'default_aid_type'           => 'aid_type_code',
            ],
            '2' => [
                'default_aidtype_vocabulary'  => 'aid_type_vocabulary',
                'aidtype_earmarking_category' => 'earmarking_category',
            ],
            '3' => [
                'default_aidtype_vocabulary' => 'aid_type_vocabulary',
                'default_aid_type_text'      => 'earmarking_modality',
            ],
            '4' => [
                'default_aidtype_vocabulary' => 'aid_type_vocabulary',
            ],
        ];

    /**
     * Contains key value pair to be removed for particular vocabulary.
     *
     * @var array
     */
    protected array $transactionAidTypeRemoveArray
        = [
            '1' => [
                'default_aidtype_vocabulary',
                'default_aid_type',
                'aidtype_earmarking_category',
                'cash_and_voucher_modalities',
                'default_aid_type_text',
            ],
            '2' => [
                'default_aidtype_vocabulary',
                'default_aid_type',
                'aidtype_earmarking_category',
                'cash_and_voucher_modalities',
                'default_aid_type_text',
            ],
            '3' => [
                'default_aidtype_vocabulary',
                'default_aid_type',
                'aidtype_earmarking_category',
                'cash_and_voucher_modalities',
                'default_aid_type_text',
            ],
            '4' => [
                'default_aidtype_vocabulary',
                'default_aid_type',
                'aidtype_earmarking_category',
                'default_aid_type_text',
            ],
        ];

    /**
     * Empty transaction template.
     *
     * @var array
     */
    protected array $emptyTransaction
        = [
            'reference'             => null,
            'humanitarian'          => null,
            'transaction_type'      => [
                [
                    'transaction_type_code' => null,
                ],
            ],
            'transaction_date'      => [
                [
                    'date' => null,
                ],
            ],
            'value'                 => [
                [
                    'amount'   => null,
                    'date'     => null,
                    'currency' => null,
                ],
            ],
            'description'           => [
                [
                    'narrative' => [
                        [
                            'narrative' => null,
                            'language'  => null,
                        ],
                    ],
                ],
            ],
            'provider_organization' => [
                [
                    'organization_identifier_code' => null,
                    'provider_activity_id'         => null,
                    'type'                         => null,
                    'narrative'                    => [
                        [
                            'narrative' => null,
                            'language'  => null,
                        ],
                    ],
                ],
            ],
            'receiver_organization' => [
                [
                    'organization_identifier_code' => null,
                    'receiver_activity_id'         => null,
                    'type'                         => null,
                    'narrative'                    => [
                        [
                            'narrative' => null,
                            'language'  => null,
                        ],
                    ],
                ],
            ],
            'disbursement_channel'  => [
                [
                    'disbursement_channel_code' => null,
                ],
            ],
            'sector'                => [
                [
                    'sector_vocabulary' => null,
                    'text'              => null,
                    'narrative'         => [
                        [
                            'narrative' => null,
                            'language'  => null,
                        ],
                    ],
                ],
            ],
            'recipient_country'     => [
                [
                    'country_code' => null,
                    'narrative'    => [
                        [
                            'narrative' => null,
                            'language'  => null,
                        ],
                    ],
                ],
            ],
            'recipient_region'      => [
                [
                    'region_vocabulary' => null,
                    'custom_code'       => null,
                    'narrative'         => [
                        [
                            'narrative' => null,
                            'language'  => null,
                        ],
                    ],
                ],
            ],
            'flow_type'             => [
                [
                    'flow_type' => null,
                ],
            ],
            'finance_type'          => [
                [
                    'finance_type' => null,
                ],
            ],
            'aid_type'              => [
                [
                    'aid_type_vocabulary' => null,
                    'aid_type_code'       => null,
                ],
            ],
            'tied_status'           => [
                [
                    'tied_status_code' => null,
                ],
            ],
        ];

    /**
     * Migrates activity transactions from AidStream to IATI Publisher.
     *
     * @param $aidstreamActivityId
     * @param $iatiActivityId
     *
     * @return void
     *
     * @throws \JsonException
     */
    public function migrateActivityTransactions($aidstreamActivityId, $iatiActivityId): void
    {
        $aidstreamTransactions = $this->db::connection('aidstream')->table('activity_transactions')->where(
            'activity_id',
            $aidstreamActivityId
        )->get();

        if (count($aidstreamTransactions)) {
            $this->logInfo('Migrating activity transactions for activity id ' . $aidstreamActivityId);
            $iatiTransactions = [];

            foreach ($aidstreamTransactions as $aidstreamTransaction) {
                $iatiTransactions[] = [
                    'activity_id' => $iatiActivityId,
                    'transaction' => json_encode(
                        $this->getNewTransactionData($aidstreamTransaction->transaction),
                        JSON_THROW_ON_ERROR
                    ),
                    'created_at'  => $aidstreamTransaction->created_at,
                    'updated_at'  => $aidstreamTransaction->updated_at,
                ];
            }

            $this->transactionService->insert($iatiTransactions);
            $this->logInfo('Completed migrating activity transactions for activity id ' . $aidstreamActivityId);
        }
    }

    /**
     * Returns transaction data.
     *
     * @param $aidstreamTransaction
     *
     * @return array
     *
     * @throws \JsonException
     */
    public function getNewTransactionData($aidstreamTransaction): array
    {
        if (!$aidstreamTransaction) {
            return $this->emptyTransaction;
        }

        $aidstreamTransactionArray = json_decode($aidstreamTransaction, true, 512, JSON_THROW_ON_ERROR);

        return [
            'reference'             => Arr::get(
                $aidstreamTransactionArray,
                'reference',
                $this->emptyTransaction['reference']
            ),
            'humanitarian'          => Arr::get(
                $aidstreamTransactionArray,
                'humanitarian',
                $this->emptyTransaction['humanitarian']
            ),
            'transaction_type'      => Arr::get(
                $aidstreamTransactionArray,
                'transaction_type',
                $this->emptyTransaction['transaction_type']
            ),
            'transaction_date'      => Arr::get(
                $aidstreamTransactionArray,
                'transaction_date',
                $this->emptyTransaction['transaction_date']
            ),
            'value'                 => Arr::get($aidstreamTransactionArray, 'value', $this->emptyTransaction['value']),
            'description'           => Arr::get(
                $aidstreamTransactionArray,
                'description',
                $this->emptyTransaction['description']
            ),
            'provider_organization' => Arr::get(
                $aidstreamTransactionArray,
                'provider_organization',
                $this->emptyTransaction['provider_organization']
            ),
            'receiver_organization' => Arr::get(
                $aidstreamTransactionArray,
                'receiver_organization',
                $this->emptyTransaction['receiver_organization']
            ),
            'disbursement_channel'  => Arr::get(
                $aidstreamTransactionArray,
                'disbursement_channel',
                $this->emptyTransaction['disbursement_channel']
            ),
            'sector'                => array_key_exists(
                'sector',
                $aidstreamTransactionArray
            ) ? $this->getActivityUpdatedVocabularyData(
                json_encode($aidstreamTransactionArray['sector'], JSON_THROW_ON_ERROR),
                'sector_vocabulary',
                $this->sectorReplaceArray,
                $this->sectorRemoveArray,
                '1'
            ) : $this->emptyTransaction['sector'],
            'recipient_country'     => Arr::get(
                $aidstreamTransactionArray,
                'recipient_country',
                $this->emptyTransaction['recipient_country']
            ),
            'recipient_region'      => $this->getTransactionRecipientRegionData(
                Arr::get($aidstreamTransactionArray, 'recipient_region', $this->emptyTransaction['recipient_region'])
            ),
            'flow_type'             => Arr::get(
                $aidstreamTransactionArray,
                'flow_type',
                $this->emptyTransaction['flow_type']
            ),
            'finance_type'          => Arr::get(
                $aidstreamTransactionArray,
                'finance_type',
                $this->emptyTransaction['finance_type']
            ),
            'aid_type'              => $this->getActivityUpdatedVocabularyData(
                json_encode(
                    Arr::get($aidstreamTransactionArray, 'aid_type.0.aid_type', $this->emptyTransaction['aid_type']),
                    JSON_THROW_ON_ERROR
                ),
                'default_aidtype_vocabulary',
                $this->transactionAidTypeReplaceArray,
                $this->transactionAidTypeRemoveArray,
                '1'
            ),
            'tied_status'           => Arr::get(
                $aidstreamTransactionArray,
                'tied_status',
                $this->emptyTransaction['tied_status']
            ),
        ];
    }

    /**
     * Returns transaction recipient region data.
     *
     * @param $recipientRegion
     *
     * @return array
     */
    public function getTransactionRecipientRegionData($recipientRegion): array
    {
        $newRecipientRegion[0] = [
            'region_vocabulary' => Arr::get($recipientRegion, '0.vocabulary', null),
            'narrative'         => Arr::get($recipientRegion, '0.narrative', null),
        ];

        if (Arr::get($recipientRegion, '0.vocabulary', null) === '1') {
            $newRecipientRegion[0]['region_code'] = Arr::get($recipientRegion, '0.region_code', null);
        } else {
            $newRecipientRegion[0]['custom_code'] = !empty(
                Arr::get(
                    $recipientRegion,
                    '0.region_code_input',
                    null
                )
            ) ? Arr::get($recipientRegion, '0.custom_code', null) : Arr::get($recipientRegion, '0.region_code', null);

            if (Arr::get($recipientRegion, '0.vocabulary', null) === '99') {
                $newRecipientRegion[0]['vocabulary_uri'] = Arr::get(
                    $recipientRegion,
                    '0.vocabulary_uri',
                    null
                );
            }
        }

        return $newRecipientRegion;
    }
}
