<?php

namespace Tests\Unit\Xml;

class CollaborationTypeXmlTest extends XmlBaseTest
{
    /**
     * @return void
     * @test
     */
    public function throw_validation_if_invalid_value(): void
    {
        $rows = $this->invalid_data();
        $flattenErrors = $this->getErrors($rows);
        $this->assertContains('The collaboration type does not exist.', $flattenErrors);
        $this->assertContains('The collaboration type must be 1 characters.', $flattenErrors);
    }

    /**
     * @return array
     */
    public function invalid_data(): array
    {
        $data = $this->completeXml;
        $data[0]['collaboration_type'] = 'invalid collaboration';
        $data[1]['collaboration_type'] = ['1', '1'];

        return $data;
    }
}
