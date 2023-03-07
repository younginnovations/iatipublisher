<?php

namespace Tests\Unit\Xml;

class RelatedActivityXmlTest extends XmlBaseTest
{
    /**
     * @return void
     * @test
     */
    public function throw_validation_if_invalid_data(): void
    {
        $rows = $this->invalid_data();
        $flattenErrors = $this->getErrors($rows);
        $this->assertContains('The relationship type in related activity is invalid.', $flattenErrors);
    }

    /**
     * @return array
     */
    public function invalid_data(): array
    {
        $data = $this->completeXml;
        $data[0]['related_activity'] = [
            [
                'relationship_type' => 'invalid',
                'activity_identifier' => 'invalid',
            ],
        ];

        return $data;
    }
}
