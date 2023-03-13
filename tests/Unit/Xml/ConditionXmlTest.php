<?php

namespace Tests\Unit\Xml;

class ConditionXmlTest extends XmlBaseTest
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
        $this->assertContains('The condition type is invalid.', $flattenErrors);
        $this->assertContains('The @xml:lang field is invalid.', $flattenErrors);
        $this->assertContains('The narrative field is required with @xml:lang field.', $flattenErrors);
    }

    /**
     * All invalid data.
     * @return array
     */
    public function invalid_data(): array
    {
        $data = $this->completeXml;
        $data[0]['conditions'] = [
            'condition_attached' => '1',
            'condition' => [
                    [
                        'condition_type' => 'invalid type',
                        'narrative' => [
                            [
                                'narrative' => '',
                                'language' => 'invalid language',
                            ],
                        ],
                    ],
                ],
        ];

        return $data;
    }
}
