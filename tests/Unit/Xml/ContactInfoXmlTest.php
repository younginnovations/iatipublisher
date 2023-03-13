<?php

namespace Tests\Unit\Xml;

class ContactInfoXmlTest extends XmlBaseTest
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
        $this->assertContains('The contact info type is invalid.', $flattenErrors);
        $this->assertContains('The contact info telephone number is invalid.', $flattenErrors);
        $this->assertContains('The contact info telephone number must have atleast 7 digits.', $flattenErrors);
        $this->assertContains('The contact info telephone number must not have more than 20 digits.', $flattenErrors);
        $this->assertContains('The contact info email must be valid.', $flattenErrors);
        $this->assertContains('The contact info website url must be valid url.', $flattenErrors);
    }

    /**
     * Invalid contact info data.
     * @return array
     */
    public function invalid_data(): array
    {
        $data = $this->completeXml;
        $data[0]['contact_info'] = [
            [
                'type' => 'invalid',
                'organization' => [
                    [
                        'narrative' => [
                            [
                                'narrative' => '',
                                'language' => 'invalid langugae',
                            ],
                        ],
                    ],
                ],
                'department' => [
                    [
                        'narrative' => [
                            [
                                'narrative' => '',
                                'language' => '',
                            ],
                        ],
                    ],
                ],
                'person_name' => [
                    [
                        'narrative' => [
                            [
                                'narrative' => '',
                                'language' => '',
                            ],
                        ],
                    ],
                ],
                'job_title' => [
                    [
                        'narrative' => [
                            [
                                'narrative' => '',
                                'language' => '',
                            ],
                        ],
                    ],
                ],
                'telephone' => [
                    [
                        'telephone' => 'invalid',
                    ],
                    [
                        'telephone' => '123',
                    ],
                    [
                        'telephone' => '123456789012345678905',
                    ],
                ],
                'email' => [
                    [
                        'email' => 'invalid',
                    ],
                ],
                'website' => [
                    [
                        'website' => 'invalid',
                    ],
                ],
                'mailing_address' => [
                    [
                        'narrative' => [
                            [
                                'narrative' => '',
                                'language' => '',
                            ],
                        ],
                    ],
                ],
                'organisation' => [
                    [
                        'narrative' => [
                            [
                                'narrative' => '',
                                'language' => '',
                            ],
                        ],
                    ],
                ],
            ],
        ];

        return $data;
    }
}
