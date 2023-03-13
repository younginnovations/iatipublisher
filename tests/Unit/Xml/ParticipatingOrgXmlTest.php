<?php

namespace Tests\Unit\Xml;

class ParticipatingOrgXmlTest extends XmlBaseTest
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
        $this->assertContains('The identifier must not contain symbols or blank space', $flattenErrors);
        $this->assertContains('The participating organisation role is invalid.', $flattenErrors);
        $this->assertContains('The participating organisation type is invalid.', $flattenErrors);
        $this->assertContains('The Crs Channel Code is invalid.', $flattenErrors);
        $this->assertContains('The @xml:lang field is invalid.', $flattenErrors);
        $this->assertContains('The narrative field is required with @xml:lang field.', $flattenErrors);
    }

    /**
     * Invalid participating org.
     * @return array
     */
    public function invalid_data(): array
    {
        $data = $this->completeXml;
        $data[0]['participating_org'] = [
            [
                'organization_role' => 'invalid role',
                'ref' => '123',
                'type' => 'invalid type',
                'identifier' => '/\*&&^',
                'crs_channel_code' => 'invalid',
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
