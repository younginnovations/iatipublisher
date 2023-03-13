<?php

namespace Tests\Unit\Xml;

/**
 * Class DefaultAidTypeXmltest.
 */
class DefaultAidTypeXmlTest extends XmlBaseTest
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
        $this->assertContains('The default aid type is invalid.', $flattenErrors);
        $this->assertContains('The default aid type vocabulary is invalid.', $flattenErrors);
        $this->assertContains('The default aid type cash and voucher modalities is invalid.', $flattenErrors);
        $this->assertContains('The default aid type earmarking modality is invalid.', $flattenErrors);
        $this->assertContains('The default aid type earmarking category is invalid.', $flattenErrors);
    }

    /**
     * Invalid default aid type.
     *
     * @return array
     */
    public function invalid_data(): array
    {
        $data = $this->completeXml;
        $data[0]['default_aid_type'] = [
            [
                'default_aid_type' => 'invalid',
                'default_aid_type_vocabulary' => 'invalid vocabulary',
                'earmarking_category' => 'invalid',
                'earmarking_modality' => 'invalid',
                'cash_and_voucher_modalities' => 'invalid',
            ],
        ];

        return $data;
    }
}
