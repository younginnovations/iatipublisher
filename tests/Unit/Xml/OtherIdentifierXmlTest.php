<?php

namespace Tests\Unit\Xml;

class OtherIdentifierXmlTest extends XmlBaseTest
{
    /**
     * @return void
     * @test
     */
    public function check_if_throws_validation_when_invalid_data(): void
    {
        $rows = $this->invalid_other_identifier_data();
        $flattenErrors = $this->getErrors($rows);
        $this->assertContains('The other identifier type is not valid.', $flattenErrors);
        $this->assertContains("The other identifier reference field shouldn't contain the symbols /, &, | or ?.", $flattenErrors);
        $this->assertContains("The owner org reference field shouldn't contain the symbols /, &, | or ?.", $flattenErrors);
        $this->assertContains('The @xml:lang field is invalid.', $flattenErrors);
        $this->assertContains('The narrative field is required with @xml:lang field.', $flattenErrors);
    }

    /**
     * @return array
     */
    public function invalid_other_identifier_data(): array
    {
        $data = $this->completeXml;
        $data[0]['other_identifier'] = [
            [
                'reference' => '/\ssss',
                'reference_type' => 'Invalid type',
                'owner_org' => [
                    [
                        'ref' => '//\rrrrr',
                        'narrative' => [
                            [
                                'narrative' => 'narrative one',
                                'language' => 'invalid language',
                            ],
                        ],
                    ],
                ],
            ],
            [
                'reference' => '/\ssss',
                'reference_type' => 'Invalid type',
                'owner_org' => [
                    [
                        'ref' => '//\rrrrr',
                        'narrative' => [
                            [
                                'narrative' => '',
                                'language' => 'en',
                            ],
                        ],
                    ],
                ],
            ],
        ];

        return $data;
    }
}
