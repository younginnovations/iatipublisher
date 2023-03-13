<?php

namespace Tests\Unit\Xml;

/**
 * Class ActivityDateXmlTest.
 */
class ActivityDateXmlTest extends XmlBaseTest
{
    /**
     * Throw validation for all invalid data.
     *
     * @return void
     * @test
     */
    public function throw_all_validation_if_invalid_data(): void
    {
        $rows = $this->invalid_data();
        $flattenErrors = $this->getErrors($rows);
        $this->assertContains('Date is invalid.', $flattenErrors);
        $this->assertContains('Actual start and end dates may not be in the future.', $flattenErrors);
        $this->assertContains('End date must be later than the start date.', $flattenErrors);
        $this->assertContains('The @xml:lang field is invalid.', $flattenErrors);
        $this->assertContains('The narrative field is required with @xml:lang field.', $flattenErrors);
        $this->assertContains('The selected type is invalid.', $flattenErrors);
    }

    /**
     * All invalid data.
     *
     * @return array
     */
    public function invalid_data(): array
    {
        $data = $this->completeXml;
        $data[0]['activity_date'] = [
            [
                 'date' => 'invalid date',
                 'type' => 'invalid type',
                 'narrative' => [
                     [
                         'narrative' => '',
                         'language' => 'invalid language',
                     ],
                 ],
             ],
            [
                'date' => '4000-01-01',
                'type' => '2',
                'narrative' => [
                    [
                        'narrative' => 'narrative one',
                        'language' => 'en',
                    ],
                ],
            ],
            [
                'date' => '2000-01-01',
                'type' => '4',
                'narrative' => [
                    [
                        'narrative' => 'narrative one',
                        'language' => 'en',
                    ],
                ],
            ],
        ];

        return $data;
    }
}
