<?php

namespace Tests\Unit\Xml;

/**
 * Class TagXmlTest.
 */
class TagXmlTest extends XmlBaseTest
{
    /**
     * Throws validation messages for all invalid data.
     *
     * @return void
     * @test
     */
    public function throw_validation_invalid_data(): void
    {
        $rows = $this->invalid_data();
        $flattenErrors = $this->getErrors($rows);
        $this->assertContains('The tag vocabulary is invalid.', $flattenErrors);
        $this->assertContains('The tag SDG code is invalid', $flattenErrors);
        $this->assertContains('The tag SDG targets code is invalid.', $flattenErrors);
        $this->assertContains('The @vocabulary-uri field must be a valid url.', $flattenErrors);
    }

    /**
     * Invalid tag data.
     *
     * @return array
     */
    public function invalid_data(): array
    {
        $data = $this->completeXml;
        $data[0]['tag'] = [
            [
                'tag_vocabulary' => 'invalid vocabulary',
                'vocabulary_uri' => '',
                'tag_code' => '',
                'goals_tag_code' => '',
                'targets_tag_code' => 'invalid target',
                'tag_text' => '',
                'narrative' => [
                    [
                        'narrative' => '',
                        'language' => 'invalid language',
                    ],
                ],
            ],
            [
                'tag_vocabulary' => '99',
                'vocabulary_uri' => 'invalid uri',
                'tag_code' => '',
                'goals_tag_code' => '',
                'targets_tag_code' => '',
                'tag_text' => 'invalid tag text',
                'narrative' => [
                    [
                        'narrative' => 'narrativ eone',
                        'language' => 'en',
                    ],
                ],
            ],
            [
                'tag_vocabulary' => '2',
                'vocabulary_uri' => '',
                'tag_code' => '',
                'goals_tag_code' => 'invalid',
                'targets_tag_code' => '',
                'tag_text' => '',
                'narrative' => [
                    [
                        'narrative' => 'narrativ eone',
                        'language' => 'en',
                    ],
                ],
            ],
        ];

        return $data;
    }
}