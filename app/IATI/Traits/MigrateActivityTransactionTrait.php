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
     * @param $aidstreamActivity
     * @param $iatiActivity
     *
     * @return void
     *
     * @throws \JsonException
     */
    public function migrateActivityTransactions($aidstreamActivity, $iatiActivity): void
    {
        $aidstreamActivityId = $aidstreamActivity->id;
        $iatiActivityId = $iatiActivity->id;

        $this->db::connection('aidstream')->table('activity_transactions')->where(
            'activity_id',
            $aidstreamActivityId
        )->orderBy('id')->chunk(10, function ($aidstreamTransactions) use ($aidstreamActivityId, $iatiActivityId, $iatiActivity) {
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
                        'migrated_from_aidstream' => true,
                        'created_at'  => $aidstreamTransaction->created_at,
                        'updated_at'  => $aidstreamTransaction->updated_at,
                    ];
                }

                $defaultValues = json_encode([$iatiActivity->default_field_values]);

                foreach ($iatiTransactions as $index => $iatiTransaction) {
                    $tempTransactionField = json_decode($iatiTransaction['transaction'], true);
                    $iatiTransaction['transaction'] = $this->populateDefaultFields($tempTransactionField, $defaultValues);
                    $this->transactionService->create($iatiTransaction);
                }

                $this->logInfo('Completed migrating activity transactions for activity id ' . $aidstreamActivityId);
            }
        });
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
            'description'           => $this->getTransactionDescription(
                Arr::get(
                    $aidstreamTransactionArray,
                    'description',
                    $this->emptyTransaction['description']
                )
            ),
            'provider_organization' => $this->getTransactionProviderReceiverOrgData(
                Arr::get(
                    $aidstreamTransactionArray,
                    'provider_organization',
                    $this->emptyTransaction['provider_organization']
                ),
                'provider_activity_id'
            ),
            'receiver_organization' => $this->getTransactionProviderReceiverOrgData(
                Arr::get(
                    $aidstreamTransactionArray,
                    'receiver_organization',
                    $this->emptyTransaction['receiver_organization']
                ),
                'receiver_activity_id'
            ),
            'disbursement_channel'  => Arr::get(
                $aidstreamTransactionArray,
                'disbursement_channel',
                $this->emptyTransaction['disbursement_channel']
            ),
            'sector'                => array_key_exists(
                'sector',
                $aidstreamTransactionArray
            ) ? $this->getTransactionSectorData(
                $aidstreamTransactionArray['sector']
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
            'aid_type'              => $this->getTransactionAidTypeData(
                Arr::get($aidstreamTransactionArray, 'aid_type.0.aid_type', $this->emptyTransaction['aid_type'])
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
        $vocabulary = (string) Arr::get($recipientRegion, '0.vocabulary', null);

        if ($vocabulary === '') {
            return [
                [
                    'region_vocabulary' => null,
                    'region_code'       => null,
                    'narrative'         => $this->emptyNarrativeTemplate,
                ],
            ];
        }

        $newRecipientRegion[0] = [
            'region_vocabulary' => $vocabulary,
            'narrative'         => Arr::get($recipientRegion, '0.narrative', null),
        ];

        if ($vocabulary === '1') {
            $newRecipientRegion[0]['region_code'] = Arr::get($recipientRegion, '0.region_code', null);
        } else {
            $newRecipientRegion[0]['custom_code'] = !empty(
                Arr::get(
                    $recipientRegion,
                    '0.region_code_input',
                    null
                )
            ) ? Arr::get($recipientRegion, '0.region_code', null) : Arr::get($recipientRegion, '0.custom_code', null);

            if ($vocabulary === '99') {
                $newRecipientRegion[0]['vocabulary_uri'] = Arr::get(
                    $recipientRegion,
                    '0.vocabulary_uri',
                    null
                );
                if (Arr::get($recipientRegion, '0.custom', false)) {
                    $newRecipientRegion[0]['vocabulary_uri'] = $this->getCustomVocabularyUrl();
                    $this->customVocabCurrentlyUsedByActivity['region'][] = $newRecipientRegion[0]['region_code'];
                }
            }
        }

        return $newRecipientRegion;
    }

    /**
     * Returns transaction provider receiver org data.
     *
     * @param $providerReceiverOrgs
     * @param $activityIdCode
     *
     * @return array
     */
    public function getTransactionProviderReceiverOrgData($providerReceiverOrgs, $activityIdCode): array
    {
        if (empty($providerReceiverOrgs) && $activityIdCode === 'provider_activity_id') {
            return $this->emptyTransaction['provider_organization'];
        }

        if (empty($providerReceiverOrgs) && $activityIdCode === 'receiver_activity_id') {
            return $this->emptyTransaction['receiver_organization'];
        }

        $newProviderReceiverOrgs = [];

        if (count($providerReceiverOrgs)) {
            foreach (array_values($providerReceiverOrgs) as $key => $providerReceiverOrg) {
                $newProviderReceiverOrgs[$key] = [
                    'organization_identifier_code' => Arr::get(
                        $providerReceiverOrg,
                        'organization_identifier_code',
                        null
                    ),
                    $activityIdCode                => Arr::get($providerReceiverOrg, $activityIdCode, null),
                    'type'                         => Arr::get($providerReceiverOrg, 'type', null),
                    'narrative'                    => Arr::get(
                        $providerReceiverOrg,
                        'narrative',
                        $this->emptyNarrativeTemplate
                    ),
                ];
            }
        }

        return !empty($newProviderReceiverOrgs) ? $newProviderReceiverOrgs :
            ($activityIdCode === 'provider_activity_id' ? $this->emptyTransaction['provider_organization'] : $this->emptyTransaction['receiver_organization']);
    }

    /**
     * Returns transaction aid type data.
     *
     * @param $aidTypes
     *
     * @return array
     */
    public function getTransactionAidTypeData($aidTypes): array
    {
        if (empty($aidTypes)) {
            return $this->emptyTransaction['aid_type'];
        }

        $newAidTypes = [];

        if (count($aidTypes)) {
            foreach (array_values($aidTypes) as $key => $aidType) {
                $newAidTypes[$key] = match ((string) Arr::get($aidType, 'default_aidtype_vocabulary', null)) {
                    '1' => [
                        'aid_type_vocabulary' => '1',
                        'aid_type_code'       => $this->getAidTypeCode(
                            Arr::get($aidType, 'default_aid_type', null),
                            'default_aid_type'
                        ),
                    ],
                    '2' => [
                        'aid_type_vocabulary' => '2',
                        'earmarking_category' => $this->getAidTypeCode(
                            Arr::get($aidType, 'aidtype_earmarking_category', null),
                            'aidtype_earmarking_category'
                        ),
                    ],
                    '3' => [
                        'aid_type_vocabulary' => '3',
                        'earmarking_modality' => $this->getAidTypeCode(
                            Arr::get($aidType, 'default_aid_type_text', null),
                            'default_aid_type_text'
                        ),
                    ],
                    '4' => [
                        'aid_type_vocabulary'         => '4',
                        'cash_and_voucher_modalities' => $this->getAidTypeCode(
                            Arr::get($aidType, 'cash_and_voucher_modalities', null),
                            'cash_and_voucher_modalities'
                        ),
                    ],
                    default => [
                        'aid_type_vocabulary' => null,
                        'aid_type_code'       => null,
                    ],
                };
            }
        }

        return count($newAidTypes) ? $newAidTypes : $this->emptyTransaction['aid_type'];
    }

    /**
     * Returns transaction sector data.
     *
     * @param $sectors
     *
     * @return array
     *
     * @throws \JsonException
     */
    public function getTransactionSectorData($sectors): array
    {
        if (empty($sectors)) {
            return $this->emptyTransaction['sector'];
        }

        if (!empty(Arr::get($sectors, '0.sector_vocabulary', null))) {
            $newSectors = $this->getActivityUpdatedVocabularyData(
                json_encode($sectors, JSON_THROW_ON_ERROR),
                'sector_vocabulary',
                $this->sectorReplaceArray,
                $this->sectorRemoveArray,
                '1'
            );

            return $newSectors ?: $this->emptyTransaction['sector'];
        }

        return $this->emptyTransaction['sector'];
    }

    /**
     * Returns aid type code.
     *
     * @param $aidTypeCode
     *
     * @param $key
     *
     * @return string|null
     */
    public function getAidTypeCode($aidTypeCode, $key): ?string
    {
        if (!is_array($aidTypeCode)) {
            return $aidTypeCode;
        }

        return $this->getAidTypeCode(Arr::get($aidTypeCode, '0.' . $key, null), $key);
    }

    /**
     * Returns transaction description.
     *
     * @param $descriptions
     *
     * @return array
     */
    public function getTransactionDescription($descriptions): array
    {
        if (empty($descriptions) || empty(Arr::get($descriptions, '0.narrative', null))) {
            return $this->emptyTransaction['description'];
        }

        $newDescriptions = [];

        if (count($descriptions)) {
            foreach (array_values(Arr::get($descriptions, '0.narrative', $this->emptyNarrativeTemplate)) as $key => $description) {
                $newDescriptions[0]['narrative'][$key] = [
                    'narrative' => Arr::get($description, 'narrative', null),
                    'language' => Arr::get($description, 'language', null),
                ];
            }
        }

        return count($newDescriptions) ? $newDescriptions : $this->emptyTransaction['description'];
    }
}
