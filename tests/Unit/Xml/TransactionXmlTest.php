<?php

namespace Tests\Unit\Xml;

class TransactionXmlTest extends XmlBaseTest
{
    /**
     * Pass even if duplicate reference.
     * @return void
     * @test
     */
    public function pass_when_duplicate_reference(): void
    {
        $rows = $this->duplicate_reference_data();
        $flattenErrors = $this->getErrors($rows);
        $this->assertEmpty($flattenErrors);
    }

    /**
     * Duplicate reference data.
     * @return array
     */
    public function duplicate_reference_data(): array
    {
        $data = $this->completeXml;
        $data[0]['transactions'] = [
            [
                'reference' => '12345',
                'humanitarian' => '',
                'transaction_type' => [
                    [
                        'transaction_type_code' => '8',
                    ],
                ],
                'transaction_date' => [
                    [
                        'date' => '2022-12-06',
                    ],
                ],
                'value' => [
                    [
                        'amount' => '1000',
                        'currency' => 'BSD',
                        'date' => '2022-12-13',
                    ],
                ],
                'description' => [
                     [
                         'narrative' => [
                            [
                                'narrative' => 'narrative one',
                                'language' => 'en',
                            ],
                         ],
                     ],
                ],
                'provider_organization' => [
                    [
                        'organization_identifier_code' => '1234',
                        'type' => '15',
                        'provider_activity_id' => 'activity-id',
                        'narrative' => [
                            [
                                'narrative' => 'narrative one',
                                'language' => 'en',
                            ],
                        ],
                    ],
                ],
                'receiver_organization' => [
                    [
                        'organization_identifier_code' => '1234',
                        'type' => '72',
                        'receiver_activity_id' => '234',
                        'narrative' => [
                            [
                                'narrative' => 'narrative one',
                                'language' => 'en',
                            ],
                        ],
                    ],
                ],
                'disbursement_channel' => [
                    [
                        'disbursement_channel_code' => '',
                    ],
                ],
                'sector' => [],
                'recipient_country' => [
                    [
                        'country_code' => '',
                        'narrative' => [
                            [
                                'narrative' => '',
                                'language' => '',
                            ],
                        ],
                    ],
                ],
                'recipient_region' => [
                    [
                        'region_code' => '',
                        'custom_code' => '',
                        'region_vocabulary' => '',
                        'vocabulary_uri' => '',
                        'narrative' => [
                            [
                                'narrative' => '',
                                'language' => '',
                            ],
                        ],
                    ],
                ],
                'flow_type' => [
                    [
                        'flow_type' => '',
                    ],
                ],
                'finance_type' => [
                    [
                        'finance_type' => '',
                    ],
                ],
                'aid_type' => [],
                'tied_status' => [
                    [
                        'tied_status_code' => '',
                    ],
                ],
            ],
            [
                'reference' => '12345',
                'humanitarian' => '',
                'transaction_type' => [
                    [
                        'transaction_type_code' => '8',
                    ],
                ],
                'transaction_date' => [
                    [
                        'date' => '2022-12-06',
                    ],
                ],
                'value' => [
                    [
                        'amount' => '1000',
                        'currency' => 'BSD',
                        'date' => '2022-12-13',
                    ],
                ],
                'description' => [
                    [
                        'narrative' => [
                            [
                                'narrative' => 'narrative one',
                                'language' => 'en',
                            ],
                        ],
                    ],
                ],
                'provider_organization' => [
                    [
                        'organization_identifier_code' => '1234',
                        'type' => '15',
                        'provider_activity_id' => 'activity-id',
                        'narrative' => [
                            [
                                'narrative' => 'narrative one',
                                'language' => 'en',
                            ],
                        ],
                    ],
                ],
                'receiver_organization' => [
                    [
                        'organization_identifier_code' => '1234',
                        'type' => '72',
                        'receiver_activity_id' => '234',
                        'narrative' => [
                            [
                                'narrative' => 'narrative one',
                                'language' => 'en',
                            ],
                        ],
                    ],
                ],
                'disbursement_channel' => [
                    [
                        'disbursement_channel_code' => '',
                    ],
                ],
                'sector' => [],
                'recipient_country' => [
                    [
                        'country_code' => '',
                        'narrative' => [
                            [
                                'narrative' => '',
                                'language' => '',
                            ],
                        ],
                    ],
                ],
                'recipient_region' => [
                    [
                        'region_code' => '',
                        'custom_code' => '',
                        'region_vocabulary' => '',
                        'vocabulary_uri' => '',
                        'narrative' => [
                            [
                                'narrative' => '',
                                'language' => '',
                            ],
                        ],
                    ],
                ],
                'flow_type' => [
                    [
                        'flow_type' => '',
                    ],
                ],
                'finance_type' => [
                    [
                        'finance_type' => '',
                    ],
                ],
                'aid_type' => [],
                'tied_status' => [
                    [
                        'tied_status_code' => '',
                    ],
                ],
            ],
        ];

        return $data;
    }

    /**
     * Throw validation if sector already at activity.
     * @return void
     * @test
     */
    public function throw_validation_if_sector_at_activity_and_transaction(): void
    {
        $rows = $this->sector_activity_transaction_level_data();
        $flattenErrors = $this->getErrors($rows);
        $this->assertContains('Sector has already been declared at activity level. You can’t declare a sector at the transaction level. To declare at transaction level, you need to remove sector at activity level.', $flattenErrors);
    }

    /**
     * Sector at activity and transaction.
     * @return array
     */
    public function sector_activity_transaction_level_data(): array
    {
        $data = $this->completeXml;
        $data[0]['transactions'] = [
            [
                'reference' => '12345',
                'humanitarian' => '',
                'transaction_type' => [
                    [
                        'transaction_type_code' => '8',
                    ],
                ],
                'transaction_date' => [
                    [
                        'date' => '2022-12-06',
                    ],
                ],
                'value' => [
                    [
                        'amount' => '1000',
                        'currency' => 'BSD',
                        'date' => '2022-12-13',
                    ],
                ],
                'description' => [
                    [
                        'narrative' => [
                            [
                                'narrative' => 'narrative one',
                                'language' => 'en',
                            ],
                        ],
                    ],
                ],
                'provider_organization' => [
                    [
                        'organization_identifier_code' => '1234',
                        'type' => '15',
                        'provider_activity_id' => 'activity-id',
                        'narrative' => [
                            [
                                'narrative' => 'narrative one',
                                'language' => 'en',
                            ],
                        ],
                    ],
                ],
                'receiver_organization' => [
                    [
                        'organization_identifier_code' => '1234',
                        'type' => '72',
                        'receiver_activity_id' => '234',
                        'narrative' => [
                            [
                                'narrative' => 'narrative one',
                                'language' => 'en',
                            ],
                        ],
                    ],
                ],
                'disbursement_channel' => [
                    [
                        'disbursement_channel_code' => '',
                    ],
                ],
                'sector' => [
                    [
                        'sector_vocabulary' => '1',
                        'vocabulary_uri' => '',
                        'code' => '11130',
                        'category_code' => '',
                        'sdg_goal' => '',
                        'sdg_target' => '',
                        'text' => '',
                        'percentage' => '100',
                        'narrative' => [
                            [
                                'narrative' => 'narrative one',
                                'language' => 'en',
                            ],
                        ],
                    ],
                ],
                'recipient_country' => [
                    [
                        'country_code' => '',
                        'narrative' => [
                            [
                                'narrative' => '',
                                'language' => '',
                            ],
                        ],
                    ],
                ],
                'recipient_region' => [
                    [
                        'region_code' => '',
                        'custom_code' => '',
                        'region_vocabulary' => '',
                        'vocabulary_uri' => '',
                        'narrative' => [
                            [
                                'narrative' => '',
                                'language' => '',
                            ],
                        ],
                    ],
                ],
                'flow_type' => [
                    [
                        'flow_type' => '',
                    ],
                ],
                'finance_type' => [
                    [
                        'finance_type' => '',
                    ],
                ],
                'aid_type' => [],
                'tied_status' => [
                    [
                        'tied_status_code' => '',
                    ],
                ],
            ],
        ];

        return $data;
    }

     /**
      * Sector at one transaction but empty at other.
      * @return void
      * @test
      */
     public function throw_validation_if_sector_at_one_transaction_empty_at_another_transaction(): void
     {
         $rows = $this->sector_at_one_transaction_empty_at_another_transaction_data();
         $flattenErrors = $this->getErrors($rows);
         $this->assertContains('You have declared sector at transaction level so you must declare sector for all the transactions.', $flattenErrors);
     }

     /**
      * sector at one but empty at other.
      * @return array
      */
     public function sector_at_one_transaction_empty_at_another_transaction_data(): array
     {
         $data = $this->completeXml;
         $data[0]['sector'] = [];
         $data[0]['transactions'] = [
             [
                 'reference' => '12345',
                 'humanitarian' => '',
                 'transaction_type' => [
                     [
                         'transaction_type_code' => '8',
                     ],
                 ],
                 'transaction_date' => [
                     [
                         'date' => '2022-12-06',
                     ],
                 ],
                 'value' => [
                     [
                         'amount' => '1000',
                         'currency' => 'BSD',
                         'date' => '2022-12-13',
                     ],
                 ],
                 'description' => [
                     [
                         'narrative' => [
                             [
                                 'narrative' => 'narrative one',
                                 'language' => 'en',
                             ],
                         ],
                     ],
                 ],
                 'provider_organization' => [
                     [
                         'organization_identifier_code' => '1234',
                         'type' => '15',
                         'provider_activity_id' => 'activity-id',
                         'narrative' => [
                             [
                                 'narrative' => 'narrative one',
                                 'language' => 'en',
                             ],
                         ],
                     ],
                 ],
                 'receiver_organization' => [
                     [
                         'organization_identifier_code' => '1234',
                         'type' => '72',
                         'receiver_activity_id' => '234',
                         'narrative' => [
                             [
                                 'narrative' => 'narrative one',
                                 'language' => 'en',
                             ],
                         ],
                     ],
                 ],
                 'disbursement_channel' => [
                     [
                         'disbursement_channel_code' => '',
                     ],
                 ],
                 'sector' => [
                     [
                         'sector_vocabulary' => '2',
                         'code' => '',
                         'category_code' => '111',
                         'text' => '',
                         'vocabulary_uri' => '',
                         'narrative' => [
                             [
                                 'narrative' => 'narrative one',
                                 'language' => 'en',
                             ],
                         ],
                     ],
                 ],
                 'recipient_country' => [
                     [
                         'country_code' => '',
                         'narrative' => [
                             [
                                 'narrative' => '',
                                 'language' => '',
                             ],
                         ],
                     ],
                 ],
                 'recipient_region' => [
                     [
                         'region_code' => '',
                         'custom_code' => '',
                         'region_vocabulary' => '',
                         'vocabulary_uri' => '',
                         'narrative' => [
                             [
                                 'narrative' => '',
                                 'language' => '',
                             ],
                         ],
                     ],
                 ],
                 'flow_type' => [
                     [
                         'flow_type' => '',
                     ],
                 ],
                 'finance_type' => [
                     [
                         'finance_type' => '',
                     ],
                 ],
                 'aid_type' => [],
                 'tied_status' => [
                     [
                         'tied_status_code' => '',
                     ],
                 ],
             ],
             [
                 'reference' => '12345888',
                 'humanitarian' => '',
                 'transaction_type' => [
                     [
                         'transaction_type_code' => '8',
                     ],
                 ],
                 'transaction_date' => [
                     [
                         'date' => '2022-12-06',
                     ],
                 ],
                 'value' => [
                     [
                         'amount' => '1000',
                         'currency' => 'BSD',
                         'date' => '2022-12-13',
                     ],
                 ],
                 'description' => [
                     [
                         'narrative' => [
                             [
                                 'narrative' => 'narrative one',
                                 'language' => 'en',
                             ],
                         ],
                     ],
                 ],
                 'provider_organization' => [
                     [
                         'organization_identifier_code' => '1234',
                         'type' => '15',
                         'provider_activity_id' => 'activity-id',
                         'narrative' => [
                             [
                                 'narrative' => 'narrative one',
                                 'language' => 'en',
                             ],
                         ],
                     ],
                 ],
                 'receiver_organization' => [
                     [
                         'organization_identifier_code' => '1234',
                         'type' => '72',
                         'receiver_activity_id' => '234',
                         'narrative' => [
                             [
                                 'narrative' => 'narrative one',
                                 'language' => 'en',
                             ],
                         ],
                     ],
                 ],
                 'disbursement_channel' => [
                     [
                         'disbursement_channel_code' => '',
                     ],
                 ],
                 'sector' => [],
                 'recipient_country' => [
                     [
                         'country_code' => '',
                         'narrative' => [
                             [
                                 'narrative' => '',
                                 'language' => '',
                             ],
                         ],
                     ],
                 ],
                 'recipient_region' => [
                     [
                         'region_code' => '',
                         'custom_code' => '',
                         'region_vocabulary' => '',
                         'vocabulary_uri' => '',
                         'narrative' => [
                             [
                                 'narrative' => '',
                                 'language' => '',
                             ],
                         ],
                     ],
                 ],
                 'flow_type' => [
                     [
                         'flow_type' => '',
                     ],
                 ],
                 'finance_type' => [
                     [
                         'finance_type' => '',
                     ],
                 ],
                 'aid_type' => [],
                 'tied_status' => [
                     [
                         'tied_status_code' => '',
                     ],
                 ],
             ],
         ];

         return $data;
     }

     /**
      * Pass even if negative value is passed.
      * @return void
      * @test
      */
     public function pass_if_negative_value_passed_in_transaction(): void
     {
         $rows = $this->negative_value_in_transaction();
         $flattenErrors = $this->getErrors($rows);
         $this->assertEmpty($flattenErrors);
     }

     /**
      * Negative value transaction.
      * @return array
      */
     public function negative_value_in_transaction(): array
     {
         $data = $this->completeXml;
         $data[0]['transactions'][0]['value'] = [
             [
                 'amount' => '-1000',
                 'currency' => 'BSD',
                 'date' => '2022-12-13',
             ],
         ];

         return $data;
     }

     /**
      * Throws validation messages for all invalid data.
      * @return void
      * @test
      */
     public function throw_all_possible_validation_for_invalid_data(): void
     {
         $rows = $this->invalid_data();
         $flattenErrors = $this->getErrors($rows);
         $this->assertContains('The transaction type is invalid.', $flattenErrors);
         $this->assertContains('The @amount field must be a number.', $flattenErrors);
         $this->assertContains('The transaction provider org type is invalid.', $flattenErrors);
         $this->assertContains('The transaction receiver org type is invalid.', $flattenErrors);
         $this->assertContains('The @iso-date field must be a valid date.', $flattenErrors);
         $this->assertContains('The @value-date field must be a valid date.', $flattenErrors);
         $this->assertContains('The @iso-date must not be in future.', $flattenErrors);
         $this->assertContains('The @value-date must not be in future.', $flattenErrors);
         $this->assertContains('validation.exclude_operators', $flattenErrors);
         $this->assertContains('The transaction sector vocabulary is invalid.', $flattenErrors);
         $this->assertContains('The transaction recipient country code is invalid.', $flattenErrors);
         $this->assertContains('The transaction sector code is invalid.', $flattenErrors);
         $this->assertContains('The transaction sector vocabulary-uri field must be a valid url.', $flattenErrors);
     }

     /**
      * Invalid ata.
      * @return array
      */
     public function invalid_data(): array
     {
         $data = $this->completeXml;
         $data[0]['sector'] = [];
         $data[0]['recipient_country'] = [];
         $data[0]['recipient_region'] = [];
         $data[0]['transactions'] = [
             [
                 'reference' => '12345',
                 'humanitarian' => '',
                 'transaction_type' => [
                     [
                         'transaction_type_code' => '1111111', // invalid transaction type
                     ],
                 ],
                 'transaction_date' => [
                     [
                         'date' => '4000-12-06', // future date
                     ],
                 ],
                 'value' => [
                     [
                         'amount' => 'invalid value',
                         'currency' => 'BSD',
                         'date' => '4000-12-13',
                     ],
                 ],
                 'description' => [
                     [
                         'narrative' => [
                             [
                                 'narrative' => 'narrative one',
                                 'language' => 'en',
                             ],
                         ],
                     ],
                 ],
                 'provider_organization' => [
                     [
                         'organization_identifier_code' => '1234',
                         'type' => 'invalid organization type',
                         'provider_activity_id' => '123*(&)',
                         'narrative' => [
                             [
                                 'narrative' => 'narrative one',
                                 'language' => 'en',
                             ],
                         ],
                     ],
                 ],
                 'receiver_organization' => [
                     [
                         'organization_identifier_code' => '1234',
                         'type' => '11110',
                         'receiver_activity_id' => '12*(&)3',
                         'narrative' => [
                             [
                                 'narrative' => 'narrative one',
                                 'language' => 'en',
                             ],
                         ],
                     ],
                 ],
                 'disbursement_channel' => [
                     [
                         'disbursement_channel_code' => '',
                     ],
                 ],
                 'sector' => [
                     [
                         'sector_vocabulary' => '2',
                         'code' => '',
                         'category_code' => '111',
                         'text' => '',
                         'vocabulary_uri' => '',
                         'narrative' => [
                             [
                                 'narrative' => 'narrative one',
                                 'language' => 'en',
                             ],
                         ],
                     ],
                 ],
                 'recipient_country' => [
                     [
                         'country_code' => '',
                         'narrative' => [
                             [
                                 'narrative' => '',
                                 'language' => '',
                             ],
                         ],
                     ],
                 ],
                 'recipient_region' => [
                     [
                         'region_code' => '',
                         'custom_code' => '',
                         'region_vocabulary' => '',
                         'vocabulary_uri' => '',
                         'narrative' => [
                             [
                                 'narrative' => '',
                                 'language' => '',
                             ],
                         ],
                     ],
                 ],
                 'flow_type' => [
                     [
                         'flow_type' => '',
                     ],
                 ],
                 'finance_type' => [
                     [
                         'finance_type' => '',
                     ],
                 ],
                 'aid_type' => [],
                 'tied_status' => [
                     [
                         'tied_status_code' => '',
                     ],
                 ],
             ],
             [
                 'reference' => '12345888',
                 'humanitarian' => '',
                 'transaction_type' => [
                     [
                         'transaction_type_code' => '8',
                     ],
                 ],
                 'transaction_date' => [
                     [
                         'date' => 'invalid date',
                     ],
                 ],
                 'value' => [
                     [
                         'amount' => '1000',
                         'currency' => 'BSD',
                         'date' => 'invalid date',
                     ],
                 ],
                 'description' => [
                     [
                         'narrative' => [
                             [
                                 'narrative' => 'narrative one',
                                 'language' => 'en',
                             ],
                         ],
                     ],
                 ],
                 'provider_organization' => [
                     [
                         'organization_identifier_code' => '1234',
                         'type' => '15',
                         'provider_activity_id' => 'activity-id',
                         'narrative' => [
                             [
                                 'narrative' => 'narrative one',
                                 'language' => 'en',
                             ],
                         ],
                     ],
                 ],
                 'receiver_organization' => [
                     [
                         'organization_identifier_code' => '1234',
                         'type' => '72',
                         'receiver_activity_id' => '234',
                         'narrative' => [
                             [
                                 'narrative' => 'narrative one',
                                 'language' => 'en',
                             ],
                         ],
                     ],
                 ],
                 'disbursement_channel' => [
                     [
                         'disbursement_channel_code' => '',
                     ],
                 ],
                 'sector' => [
                     [
                         'sector_vocabulary' => 'invalid vocabulary',
                         'code' => '',
                         'category_code' => 'invalid code',
                         'text' => '',
                         'vocabulary_uri' => '',
                         'narrative' => [
                             [
                                 'narrative' => 'narrative one',
                                 'language' => 'en',
                             ],
                         ],
                     ],
                     [
                         'sector_vocabulary' => '99',
                         'code' => '',
                         'category_code' => '',
                         'text' => 'invalid url',
                         'vocabulary_uri' => 'invalid url',
                         'narrative' => [
                             [
                                 'narrative' => 'narrative one',
                                 'language' => 'en',
                             ],
                         ],
                     ],
                 ],
                 'recipient_country' => [
                     [
                         'country_code' => 'asdf',
                         'narrative' => [
                             [
                                 'narrative' => '',
                                 'language' => '',
                             ],
                         ],
                     ],
                 ],
                 'recipient_region' => [
                     [
                         'region_code' => '',
                         'custom_code' => '',
                         'region_vocabulary' => '',
                         'vocabulary_uri' => '',
                         'narrative' => [
                             [
                                 'narrative' => '',
                                 'language' => '',
                             ],
                         ],
                     ],
                 ],
                 'flow_type' => [
                     [
                         'flow_type' => '',
                     ],
                 ],
                 'finance_type' => [
                     [
                         'finance_type' => '',
                     ],
                 ],
                 'aid_type' => [],
                 'tied_status' => [
                     [
                         'tied_status_code' => '',
                     ],
                 ],
             ],
         ];

         return $data;
     }

     /**
      * Throw validation if already at activity level.
      * @return void
      * @test
      */
     public function throw_validation_if__country_already_activity_level(): void
     {
         $rows = $this->country_already_at_activity_level_data();
         $flattenErrors = $this->getErrors($rows);
         $this->assertContains('Recipient Region or Recipient Country is already added at activity level. You can add a Recipient Region and or Recipient Country either at activity level or at transaction level.', $flattenErrors);
     }

     /**
      * Country already at activity level.
      * @return array
      */
     public function country_already_at_activity_level_data(): array
     {
         $data = $this->completeXml;
         $data[0]['transactions'][0]['recipient_country'] = [
             [
                 'country_code' => 'AF',
                 'narrative' => [
                     [
                         'narrative' => '',
                         'language' => '',
                     ],
                 ],
             ],
         ];

         return $data;
     }

     /**
      * Throw validation if region at activity level.
      * @return void
      * @test
      */
     public function throw_validation_if_region_already_activity_level(): void
     {
         $rows = $this->region_already_at_activity_level_data();
         $flattenErrors = $this->getErrors($rows);
         $this->assertContains('Recipient Region or Recipient Country is already added at activity level. You can add a Recipient Region and or Recipient Country either at activity level or at transaction level.', $flattenErrors);
     }

     /**
      * region at activity level.
      * @return array
      */
     public function region_already_at_activity_level_data(): array
     {
         $data = $this->completeXml;
         $data[0]['transactions'][0]['recipient_region'] = [
             [
                 'region_code' => '88',
                 'custom_code' => '',
                 'region_vocabulary' => '1',
                 'vocabulary_uri' => '',
                 'narrative' => [
                     [
                         'narrative' => '',
                         'language' => '',
                     ],
                 ],
             ],
         ];

         return $data;
     }

     /**
      * region or country at transaciton level.
      * @return void
      * @test
      */
     public function throw_validation_if_both_region_or_country_at_transaction(): void
     {
         $rows = $this->both_region_and_country_at_transaction_level_data();
         $flattenErrors = $this->getErrors($rows);
         $this->assertContains('You must add either recipient country or recipient region.', $flattenErrors);
     }

     /**
      * region and country both at transaction level.
      * @return array
      */
     public function both_region_and_country_at_transaction_level_data(): array
     {
         $data = $this->completeXml;
         $data[0]['recipient_country'] = [];
         $data[0]['recipient_region'] = [];
         $data[0]['transactions'][0]['recipient_country'] = [
             [
                 'country_code' => 'AF',
                 'narrative' => [
                     [
                         'narrative' => '',
                         'language' => '',
                     ],
                 ],
             ],
         ];
         $data[0]['transactions'][0]['recipient_region'] = [
             [
                 'region_code' => '88',
                 'custom_code' => '',
                 'region_vocabulary' => '1',
                 'vocabulary_uri' => '',
                 'narrative' => [
                     [
                         'narrative' => '',
                         'language' => '',
                     ],
                 ],
             ],
         ];

         return $data;
     }

     /**
      * Throw validation if region or country at one transaction but empty at other.
      * @return void
      * @test
      */
     public function throw_validation_if_region_or_country_at_one_transaction_empty_at_another_transaction(): void
     {
         $rows = $this->region_or_country_at_one_transaction_empty_at_another_transaction_data();
         $flattenErrors = $this->getErrors($rows);
         $this->assertContains('You must add either recipient country or recipient region.', $flattenErrors);
     }

     /**
      * region or country at one transactino empty at another transaction data.
      * @return array
      */
     public function region_or_country_at_one_transaction_empty_at_another_transaction_data(): array
     {
         $data = $this->completeXml;
         $data[0]['recipient_country'] = [];
         $data[0]['recipient_region'] = [];
         $data[1]['recipient_country'] = [];
         $data[1]['recipient_region'] = [];
         $data[0]['transactions'][0]['recipient_country'] = [
             [
                 'country_code' => 'AF',
                 'narrative' => [
                     [
                         'narrative' => '',
                         'language' => '',
                     ],
                 ],
             ],
         ];

         return $data;
     }
}
