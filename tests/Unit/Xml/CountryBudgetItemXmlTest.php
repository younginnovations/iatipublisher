<?php

namespace Tests\Unit\Xml;

/**
 * Class CountryBudgetItemXmlTest.
 */
class CountryBudgetItemXmlTest extends XmlBaseTest
{
    /**
     * Throws validation messages for all invalid data.
     *
     * @return void
     * @test
     */
    public function throw_possible_validation_for_invalid_error(): void
    {
        $rows = $this->invalid_data();
        $flattenErrors = $this->getErrors($rows);

        $this->assertContains('The country budget item vocabulary is invalid.', $flattenErrors);
        $this->assertContains('The budget item code is invalid.', $flattenErrors);
        $this->assertContains('The budget item percentage field must be a number.', $flattenErrors);
        $this->assertContains('The sum of percentage with budget items must add up to 100.', $flattenErrors);
        $this->assertContains('The budget item percentage field should be 100 when there is only one budget item.', $flattenErrors);
        $this->assertContains('The @xml:lang field is invalid.', $flattenErrors);
        $this->assertContains('The Narrative field is required with @xml:lang field.', $flattenErrors);
    }

    /**
     * Invalid country budget item.
     *
     * @return array
     */
    public function invalid_data(): array
    {
        $data = $this->completeXml;
        $data[0]['country_budget_items'] = [
            [
                'country_budget_vocabulary' => 'invalid',
                'budget_item' => [
                    [
                        'code' => 'invalid',
                        'percentage' => 'invalid',
                        'description' => [
                            [
                                'narrative' => [
                                    [
                                        'narrative' => '',
                                        'language' => 'invalid language',
                                    ],
                                ],
                            ],
                        ],
                    ],
                ],
            ],
        ];
        $data[1]['country_budget_items'] = [
            [
                'country_budget_vocabulary' => '2',
                'budget_item' => [
                    [
                        'code' => '1.2.1',
                        'percentage' => '10',
                        'description' => [
                            [
                                'narrative' => [
                                    [
                                        'narrative' => 'narr',
                                        'language' => 'en',
                                    ],
                                ],
                            ],
                        ],
                    ],
                    [
                        'code' => '1.2.1',
                        'percentage' => '10',
                        'description' => [
                            [
                                'narrative' => [
                                    [
                                        'narrative' => 'narr',
                                        'language' => 'en',
                                    ],
                                ],
                            ],
                        ],
                    ],
                ],
            ],
        ];

        return $data;
    }
}
