<?php

namespace Tests\Feature\Element;

/**
 * Class TagCompleteTest.
 */
class TagCompleteTest extends ElementCompleteTest
{
    private string $element = 'tag';

    /**
     * Mandatory attribute test.
     *
     * @return void
     * @throws \JsonException
     */
    public function test_tag_type_mandatory_attributes(): void
    {
        $this->test_mandatory_attributes($this->element, ['goals_tag_code', 'targets_tag_code', 'tag_text']);
    }

    /**
     * Mandatory sub element test.
     *
     * @return void
     * @throws \JsonException
     */
    public function test_tag_mandatory_sub_elements(): void
    {
        $this->test_mandatory_sub_elements($this->element, []);
    }

    /**
     * Tag element complete test.
     *
     * @return void
     * @throws \JsonException
     */
    public function test_tag_element_complete(): void
    {
        $sector_typeData = json_decode(
            '[{"tag_vocabulary":"1","tag_text":"vocab-1","narrative":[{"narrative":null,"language":null}]},{"tag_vocabulary":"2","goals_tag_code":"1","narrative":[{"narrative":null,"language":null}]},{"tag_vocabulary":"3","targets_tag_code":"1.1","narrative":[{"narrative":null,"language":null}]},{"tag_vocabulary":"99","tag_text":"vocab-99","vocabulary_uri":"https:\/\/www.google.com","narrative":[{"narrative":null,"language":null}]}]',
            true,
            512,
            JSON_THROW_ON_ERROR
        );

        $this->test_level_one_multi_dimensional_element_complete($this->element, $sector_typeData);
    }
}
