<?php

namespace Tests\Unit\Xml;

/**
 * Class RecipientCountryXmlTest.
 */
class RecipientCountryXmlTest extends XmlBaseTest
{
    /**
     * All valid data.
     *
     * @return array
     */
    public function valid_data(): array
    {
        return $this->completeXml;
    }

    /**
     * Pass if all valid data.
     *
     * @test
     * @return void
     */
    public function pass_if_all_valid_data(): void
    {
        $rows = $this->valid_data();
        $flattenErrors = $this->getErrors($rows);
        $this->assertEmpty($flattenErrors);
    }

    /**
     * Throws validation messages for all invalid data.
     *
     * @return void
     * @test
     */
    public function throw_validation_if_invalid_data(): void
    {
        $rows = $this->invalid_data();
        $flattenErrors = $this->getErrors($rows);

        $this->assertContains('The recipient country code is invalid.', $flattenErrors);
        $this->assertContains('The Country Code cannot be redundant.', $flattenErrors);
        $this->assertContains('The recipient country percentage must be a number.', $flattenErrors);
        $this->assertContains('The sum of recipient country percentage cannot be greater than 100', $flattenErrors);
        $this->assertContains('The recipient country percentage must be at least 0.', $flattenErrors);
    }

    /**
     * Invalid recipient country data.
     *
     * @return array
     */
    public function invalid_data(): array
    {
        $data = $this->valid_data();
        $data[0]['recipient_country'] = [
            [
                'country_code' => 'AF',
                'percentage' => 'invalid percentage',
                'narrative' => [
                    [
                        'narrative' => 'narrative one',
                        'language' => 'en',
                    ],
                ],
            ],
            [
                'country_code' => 'AF',
                'percentage' => '-50',
                'narrative' => [
                    [
                        'narrative' => 'narrative one',
                        'language' => 'en',
                    ],
                ],
            ],
        ];
        $data[0]['recipient_region'] = [
            [
                'region_code' => '88',
                'region_vocabulary' => '1',
                'vocabulary_uri' => null,
                'percentage' => '20',
                'narrative' => [
                    [
                        'narrative' => 'narrative one ',
                        'language' => 'en',
                    ],
                ],
            ],
        ];
        $data[1]['recipient_country'] = [
            [
                'country_code' => 'invalid country code',
                'percentage' => '10000',
                'narrative' => [
                    [
                        'narrative' => 'narrative one',
                        'language' => 'en',
                    ],
                ],
            ],
        ];
        $data[1]['recipient_region'] = [
            [
                'region_code' => '88',
                'region_vocabulary' => '1',
                'vocabulary_uri' => null,
                'percentage' => '',
                'narrative' => [
                    [
                        'narrative' => 'narrative one ',
                        'language' => 'en',
                    ],
                ],
            ],
        ];

        return $data;
    }

    /**
     * Throw validation if recipient country already at activity level.
     * @return void
     * @test
     */
    public function throw_validation_if_already_at_activity_level(): void
    {
        $rows = $this->country_at_transaction_data();
        $flattenErrors = $this->getErrors($rows);
        $this->assertContains('Recipient Region or Recipient Country is already added at activity level. You can add a Recipient Region and or Recipient Country either at activity level or at transaction level.', $flattenErrors);
    }

    /**
     * Country at transaction data.
     * @return array
     */
    public function country_at_transaction_data(): array
    {
        $data = $this->valid_data();
        $data[0]['transactions'][0]['recipient_country'] = [
            [
                'country_code' => 'NP',
                'narrative' => [
                    [
                        'narrative' => 'narrative one',
                        'language' => 'en',
                    ],
                ],
            ],
        ];

        return $data;
    }

    /**
     * Throw validation when sum of region and country percentage not equal to 100.
     *
     * @return void
     * @test
     */
    public function throws_validation_if_region_country_percentage_sum_not_100(): void
    {
        $rows = $this->invalid_percentage_data();
        $flattenErrors = $this->getErrors($rows);
        $this->assertContains('The recipient country percentage must be at least 0.', $flattenErrors);
        $this->assertContains('The Country Code cannot be redundant.', $flattenErrors);
        $this->assertContains('The recipient country code is invalid.', $flattenErrors);
        $this->assertContains('The sum of recipient country percentage cannot be greater than 100', $flattenErrors);
    }

    /**
     * Invalid percentage data.
     *
     * @return array
     */
    public function invalid_percentage_data(): array
    {
        $data = $this->valid_data();

        $data[0]['recipient_country'] = [
            [
                'country_code' => 'AF',
                'percentage' => '-50',
                'narrative' => [
                    [
                        'narrative' => 'narrative one',
                        'language' => 'en',
                    ],
                ],
            ],
            [
                'country_code' => 'AF',
                'percentage' => null,
                'narrative' => [
                    [
                        'narrative' => 'narrative one',
                        'language' => 'en',
                    ],
                ],
            ],
            [
                'country_code' => 'invalid country code',
                'percentage' => '10000',
                'narrative' => [
                    [
                        'narrative' => 'narrative one',
                        'language' => 'en',
                    ],
                ],
            ],
        ];

        $data[0]['recipient_region'] = [
            [
                'region_code' => '289',
                'region_vocabulary' => null,
                'vocabulary_uri' => '',
                'percentage' => '',
                'narrative' => [
                    [
                        'narrative' => 'narrative',
                        'language' => 'en',
                    ],
                ],
            ],
        ];

        return $data;
    }

    /**
     * Throw validation if both have 100% region or country.
     *
     * @return void
     * @test
     */
    public function throw_validation_if_country_region_both_have_100_percentage(): void
    {
        $rows = $this->country_region_100_data();
        $flattenErrors = $this->getErrors($rows);
        $this->assertContains('Recipient Country’s percentage is already 100%. The sum of the percentages of Recipient Country and Recipient Region must be 100%', $flattenErrors);
    }

    /**
     * Country 100 and region 100 percentage data.
     *
     * @return array
     */
    public function country_region_100_data(): array
    {
        $data = $this->valid_data();
        $data[0]['recipient_country'] = [
            [
                'country_code' => 'AF',
                'percentage' => '100.0',
                'narrative' => [
                    [
                        'narrative' => 'narrative one',
                        'language' => 'en',
                    ],
                ],
            ],
        ];
        $data[0]['recipient_region'] = [
            [
                'region_code' => '289',
                'region_vocabulary' => null,
                'vocabulary_uri' => '',
                'percentage' => '100.0',
                'narrative' => [
                    [
                        'narrative' => 'narrative',
                        'language' => 'en',
                    ],
                ],
            ],
        ];

        return $data;
    }
}
