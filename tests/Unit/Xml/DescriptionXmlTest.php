<?php

namespace Tests\Unit\Xml;

class DescriptionXmlTest extends XmlBaseTest
{
    /**
     * Throws validation messages for all invalid data.
     * @return void
     * @test
     */
    public function throw_validation_for_invalid_data(): void
    {
        $rows = $this->invalid_data();
        $flattenErrors = $this->getErrors($rows);
        $this->assertContains('The selected description type is invalid.', $flattenErrors);
        $this->assertContains('The narrative field is required with @xml:lang field.', $flattenErrors);
        $this->assertContains('The @xml:lang field is invalid.', $flattenErrors);
    }

    /**
     * Invalid description data.
     * @return array
     */
    public function invalid_data(): array
    {
        $data = $this->completeXml;
        $data[0]['description'] = [
             [
                 'type' => 'invalid type',
                 'narrative' => [
                     [
                         'narrative' => '',
                         'language' => 'easdfn',
                     ],
                 ],
             ],
        ];

        return $data;
    }
}
