<?php

namespace Tests\Unit\Xml;

class HumanitarianScopeXmlTest extends XmlBaseTest
{
    /**
     * Throws validation messages for all invalid data.
     * @return void
     * @test
     */
    public function throw_all_possible_validation_for_invalid_data(): void
    {
        $rows = $this->invalid_data();
        $flattenErrors = $this->getErrors($rows);
        $this->assertContains('The humanitarian scope type is invalid.', $flattenErrors);
        $this->assertContains('The humanitarian scope vocabulary is invalid.', $flattenErrors);
        $this->assertContains('The humanitarian scope vocabulary-uri must be a proper url.', $flattenErrors);
        $this->assertContains('The @xml:lang field is invalid.', $flattenErrors);
        $this->assertContains('The narrative field is required with @xml:lang field.', $flattenErrors);
    }

    /**
     * Invalid humanitarian scope.
     * @return array
     */
    public function invalid_data(): array
    {
        $data = $this->completeXml;
        $data[0]['humanitarian_scope'] = [
            [
                'type' => 'invalid type',
                'vocabulary' => 'invalid vocab',
                'vocabulary_uri' => 'invalid uri',
                'code' => '123456',
                'narrative' => [
                    [
                        'narrative' => '',
                        'language' => 'invalid language',
                    ],
                ],
            ],
        ];

        return $data;
    }
}
