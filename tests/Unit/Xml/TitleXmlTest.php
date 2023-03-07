<?php

namespace Tests\Unit\Xml;

class TitleXmlTest extends XmlBaseTest
{
    /**
     * Pass if all valid data.
     *
     * @return void
     * @test
     */
    public function pass_if_all_valid_data(): void
    {
        $rows = $this->valid_data();
        $flattenErrors = $this->getErrors($rows);
        $this->assertEmpty($flattenErrors);
    }

    /**
     * @return array
     */
    public function valid_data(): array
    {
        return $this->completeXml;
    }

    /**
     * @test
     * @return void
     */
    public function throw_validation_if_invalid_data(): void
    {
        $rows = $this->invalid_data();
        $flattenErrors = $this->getErrors($rows);
        $this->assertContains('The first title is required.', $flattenErrors);
        $this->assertContains('The narrative is required when language is specified.', $flattenErrors);
        $this->assertContains('The title language field must be unique.', $flattenErrors);
    }

    /**
     * @return array
     */
    public function invalid_data(): array
    {
        $data = $this->valid_data();
        $data[0]['title'] = [
            [
                'narrative' => null,
                'language' => null,
            ],
            [
                'narrative' => null,
                'language' => null,
            ],
            [
                'narrative' => null,
                'language' => 'en',
            ],
        ];

        return $data;
    }
}
