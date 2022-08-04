<?php

namespace Tests\Feature\Element;

/**
 * Class RecipientRegionCompleteTest.
 */
class RecipientRegionCompleteTest extends ElementCompleteTest
{
    private string $element = 'recipient_region';

    /**
     * Mandatory attribute test.
     *
     * @return void
     * @throws \JsonException
     */
    public function test_recipient_region_type_mandatory_attributes(): void
    {
        $this->test_mandatory_attributes($this->element, ['region_code', 'custom_code']);
    }

    /**
     * Mandatory sub element test.
     *
     * @return void
     * @throws \JsonException
     */
    public function test_recipient_region_mandatory_sub_elements(): void
    {
        $this->test_mandatory_sub_elements($this->element, []);
    }

    /**
     * Recipient Region element complete test.
     *
     * @return void
     * @throws \JsonException
     */
    public function test_recipient_region_element_complete(): void
    {
        $sector_typeData = json_decode(
            '[{"region_vocabulary":"1","region_code":"88","percentage":"100","narrative":[{"narrative":null,"language":null}]},{"region_vocabulary":"2","custom_code":"vocab-2","percentage":"100","narrative":[{"narrative":null,"language":null}]},{"region_vocabulary":"99","custom_code":"vocab-99","vocabulary_uri":"https:\/\/www.google.com","percentage":"100","narrative":[{"narrative":null,"language":null}]}]',
            true,
            512,
            JSON_THROW_ON_ERROR
        );

        $this->test_level_one_multi_dimensional_element_complete($this->element, $sector_typeData);
    }
}
