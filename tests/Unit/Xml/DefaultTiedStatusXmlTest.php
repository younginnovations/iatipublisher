<?php

namespace Tests\Unit\Xml;

/**
 * Class DefaultTiedStatusXmlTest.
 */
class DefaultTiedStatusXmlTest extends XmlBaseTest
{
    /**
     * Throws validation messages for all invalid data.
     *
     * @return void
     * @test
     */
    public function throw_validation_if_invalid_value(): void
    {
        $rows = $this->invalid_data();
        $flattenErrors = $this->getErrors($rows);
        $this->assertContains('The default tied status does not exist.', $flattenErrors);
        $this->assertContains('The default tied status must be 1 characters.', $flattenErrors);
    }

    /**
     * Invalid default tied status.
     *
     * @return array
     */
    public function invalid_data(): array
    {
        $data = $this->completeXml;
        $data[0]['default_tied_status'] = 'invalid';
        $data[1]['default_tied_status'] = ['1', '1'];

        return $data;
    }
}
