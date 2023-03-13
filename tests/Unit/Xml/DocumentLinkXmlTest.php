<?php

namespace Tests\Unit\Xml;

class DocumentLinkXmlTest extends XmlBaseTest
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
        $this->assertContains('The document link format is invalid', $flattenErrors);
        $this->assertContains('The @url field must be a valid url.', $flattenErrors);
        $this->assertContains('The @iso-date field must be a proper date.', $flattenErrors);
        $this->assertContains('The @iso-date field must be a greater than 1900.', $flattenErrors);
        $this->assertContains('The document link category code field must be a unique.', $flattenErrors);
        $this->assertContains('The document link category code is invalid.', $flattenErrors);
        $this->assertContains('The document link language code field must be a unique.', $flattenErrors);
        $this->assertContains('The document link language code is invalid.', $flattenErrors);
        $this->assertContains('The @xml:lang field is invalid.', $flattenErrors);
        $this->assertContains('The narrative field is required with @xml:lang field.', $flattenErrors);
    }

    /**
     * Invalid document link.
     * @return array
     */
    public function invalid_data(): array
    {
        $data = $this->completeXml;
        $data[0]['document_link'] = [
            [
                 'url' => 'invalid url',
                 'format' => 'invalid format',
                 'title' => [
                     [
                         'narrative' => [
                             [
                                 'narrative' => '',
                                 'language' => 'invalid language',
                             ],
                         ],
                     ],
                 ],
                 'category' => [
                     [
                         'code' => 'invalid code',
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
                 'language' => [
                     [
                         'code' => 'en',
                     ],
                     [
                         'code' => 'en',
                     ],
                     [
                         'code' => 'invalid',
                     ],
                 ],
                 'document_date' => [
                     [
                         'date' => '1200-02-02',
                     ],
                 ],
             ],
            [
                'url' => 'https://www.google.com',
                'format' => 'application/1d-interleaved-parityfec',
                'title' => [
                    [
                        'narrative' => [
                            [
                                'narrative' => 'narrative one',
                                'language' => 'en',
                            ],
                        ],
                    ],
                ],
                'category' => [
                    [
                        'code' => 'A05',
                    ],
                    [
                        'code' => 'A05',
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
                'language' => [
                    [
                        'code' => 'invalid langugae',
                    ],
                ],
                'document_date' => [
                    [
                        'date' => 'invalid',
                    ],
                ],
            ],
        ];
        $data[1]['document_link'] = [
            [
                'url' => 'https://www.google.com',
                'format' => 'application/1d-interleaved-parityfec',
                'title' => [
                    [
                        'narrative' => [
                            [
                                'narrative' => 'narrative one',
                                'language' => 'en',
                            ],
                        ],
                    ],
                ],
                'category' => [
                    [
                        'code' => 'A05',
                    ],
                    [
                        'code' => 'A05',
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
                'language' => [
                    [
                        'language' => 'invalid langugae',
                    ],
                ],
                'document_date' => [
                    [
                        'date' => 'invalid',
                    ],
                ],
            ],
        ];

        return $data;
    }
}
