<?php

namespace Tests\Unit\Xml;

class CapitalSpendXmlTest extends XmlBaseTest
{
    /**
     * @return void
     * @test
     */
    public function throw_validation_if_invalid_value(): void
    {
        $rows = $this->invalid_data();
        $flattenErrors = $this->getErrors($rows);
        $this->assertContains('The capital spend must be a number between 0 and 100', $flattenErrors);
        $this->assertContains('The capital spend must be a number', $flattenErrors);
    }

    /**
     * @return array
     */
    public function invalid_data(): array
    {
        $data = $this->completeXml;
        $data[0]['capital_spend'] = 'invalid';
        $data[1]['capital_spend'] = '-99';

        return $data;
    }
}
