<?php

namespace Tests\Unit\Xml;

class LocationXmlTest extends XmlBaseTest
{
    /**
     * Throws validation messages for all invalid data.
     * @return void
     * @test
     */
    public function throw_validation_if_invalid_data(): void
    {
        $rows = $this->invalid_data();
        $flattenErrors = $this->getErrors($rows);
        $this->assertContains('The location reference field shouldn\'t contain the symbols /, &, | or ?.', $flattenErrors);
        $this->assertContains('The location reach code is invalid.', $flattenErrors);
        $this->assertContains('The location exactness is invalid.', $flattenErrors);
        $this->assertContains('The location class is invalid.', $flattenErrors);
        $this->assertContains('The location feature designation is invalid.', $flattenErrors);
        $this->assertContains('The location id vocabulary is invalid.', $flattenErrors);
        $this->assertContains('The location administrative vocabulary is invalid.', $flattenErrors);
        $this->assertContains('The location administrative code is invalid.', $flattenErrors);
        $this->assertContains('The location administrative level must not have negative value.', $flattenErrors);
        $this->assertContains('The location administrative level must be an integer.', $flattenErrors);
        $this->assertContains('The pos latitude must be numeric', $flattenErrors);
        $this->assertContains('The pos longitude must be numeric', $flattenErrors);
    }

    /**
     * Invalid location.
     * @return array
     */
    public function invalid_data(): array
    {
        $data = $this->completeXml;
        $data[0]['location'] = [
            [
                'ref' => '/\&*^%',
                'location_reach' => [
                    [
                        'code' => 'invalid code',
                    ],
                ],
                'location_id' => [
                    [
                        'code' => '',
                        'vocabulary' => 'invalid vocab',
                    ],
                ],
                'name' => [
                    [
                        'narrative' => [
                            [
                                'narrative' => '',
                                'language' => '',
                            ],
                        ],
                    ],
                ],
                'description' => [
                    [
                        'narrative' => [
                            [
                                'narrative' => '',
                                'language' => '',
                            ],
                        ],
                    ],
                ],
                'activity_description' => [
                    [
                        'narrative' => [
                            [
                                'narrative' => '',
                                'language' => '',
                            ],
                        ],
                    ],
                ],
                'administrative' => [
                    [
                        'code' => 'invalid',
                        'vocabulary' => 'invalid',
                        'level' => '-2',
                    ],
                    [
                        'code' => 'A1',
                        'vocabulary' => '',
                        'level' => 'invalid',
                    ],
                ],
                'point' => [
                    [
                        'srs_name' => '',
                        'pos' => [
                            [
                                'latitude' => 'invalid',
                                'longitude' => 'invalid',
                            ],
                        ],
                    ],
                ],
                'exactness' => [
                    [
                        'code' => 'invalid',
                    ],
                ],
                'location_class' => [
                    [
                        'code' => 'invalid',
                    ],
                ],
                'feature_designation' => [
                    [
                        'code' => 'invalid',
                    ],
                ],
            ],
        ];

        return $data;
    }
}
