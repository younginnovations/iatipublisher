<?php

namespace Tests\Unit\Xml;

/**
 * Class PolicyMarkerXmlTest.
 */
class PolicyMarkerXmlTest extends XmlBaseTest
{
    /**
     * Throws validation messages for all invalid data.
     *
     * @return void
     * @test
     */
    public function throw_all_possible_validation_if_invalid_data(): void
    {
        $rows = $this->invalid_data();
        $flattenErrors = $this->getErrors($rows);
        $this->assertContains('The policy marker vocabulary is invalid.', $flattenErrors);
        $this->assertContains('The policy marker significance is invalid', $flattenErrors);
        $this->assertContains('The policy marker code is invalid.', $flattenErrors);
        $this->assertContains('The @vocabulary-uri field must be a valid url.', $flattenErrors);
        $this->assertContains('The Narrative field is required when vocabulary is reporting organisation.', $flattenErrors);
        $this->assertContains('The @xml:lang field is invalid.', $flattenErrors);
        $this->assertContains('The Narrative field is required with @xml:lang field.', $flattenErrors);
    }

    /**
     * Invalid policy marker data.
     *
     * @return array
     */
    public function invalid_data(): array
    {
        $data = $this->completeXml;
        $data[0]['policy_marker'] = [
            [
                'policy_marker_vocabulary' => 'invalid vocabulary',
                'vocabulary_uri' => 'invalid uri',
                'significance' => 'invalid significance',
                'policy_marker' => 'invalid marker code',
                'policy_marker_text' => '8',
                'narrative' => [
                    [
                        'narrative' => '',
                        'language' => 'invalid language',
                    ],
                ],
            ],
            [
                'policy_marker_vocabulary' => '99',
                'vocabulary_uri' => 'https://www.google.com',
                'significance' => '0',
                'policy_marker' => '',
                'policy_marker_text' => '8',
                'narrative' => [
                    [
                        'narrative' => '',
                        'language' => '',
                    ],
                ],
            ],
        ];

        return $data;
    }
}
