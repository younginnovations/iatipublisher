<?php

declare(strict_types=1);

namespace Tests\Feature\Element;

/**
 * Class OtherIndentifierCompleteTest.
 */
class OtherIndentifierCompleteTest extends ElementCompleteTest
{
    /**
     * Element other_identifier.
     *
     * @var string
     */
    private string $element = 'other_identifier';

    /**
     * Mandatory attribute test.
     *
     * @return void
     * @throws \JsonException
     */
    public function test_other_identifier_mandatory_attributes(): void
    {
        $this->test_mandatory_attributes($this->element, ['reference', 'reference_type']);
    }

    /**
     * Mandatory sub element test.
     *
     * @return void
     * @throws \JsonException
     */
    public function test_other_identifier_mandatory_sub_elements(): void
    {
        $this->test_mandatory_sub_elements($this->element, []);
    }

    /**
     * Empty data test.
     *
     * @return void
     * @throws \JsonException
     */
    public function test_other_identifier_empty_data(): void
    {
        $actualData = '';

        $this->test_level_two_multi_dimensional_element_incomplete($this->element, $actualData);
    }

    /**
     * Empty json test.
     *
     * @return void
     * @throws \JsonException
     */
    public function test_other_identifier_empty_json(): void
    {
        $actualData = json_decode('{}', true, 512, JSON_THROW_ON_ERROR);

        $this->test_level_two_multi_dimensional_element_incomplete($this->element, $actualData);
    }

    /**
     * Attribute reference and reference_type empty test.
     *
     * @return void
     * @throws \JsonException
     */
    public function test_other_identifier_attribute_empty_reference_and_reference_type(): void
    {
        $actualData = json_decode(
            '[{"reference":"","reference_type":"","owner_org":[{"ref":"OwnerOrg Ref-1","narrative":[{"narrative":"","language":"aa"},{"narrative":"asdsasdasd","language":"ab"}]},{"ref":"OwnerOrg Ref-2","narrative":[{"narrative":"asdasd","language":"af"}]}]}]',
            true,
            512,
            JSON_THROW_ON_ERROR
        );

        $this->test_level_two_multi_dimensional_element_incomplete($this->element, $actualData);
    }

    /**
     * Attribute reference empty test.
     *
     * @return void
     * @throws \JsonException
     */
    public function test_other_identifier_attribute_empty_reference(): void
    {
        $actualData = json_decode(
            '[{"reference":"","reference_type":"A1","owner_org":[{"ref":"OwnerOrg Ref-1","narrative":[{"narrative":"","language":"aa"},{"narrative":"asdsasdasd","language":"ab"}]},{"ref":"OwnerOrg Ref-2","narrative":[{"narrative":"asdasd","language":"af"}]}]}]',
            true,
            512,
            JSON_THROW_ON_ERROR
        );

        $this->test_level_two_multi_dimensional_element_incomplete($this->element, $actualData);
    }

    /**
     * Attribute reference_type empty test.
     *
     * @return void
     * @throws \JsonException
     */
    public function test_other_identifier_attribute_empty_reference_type(): void
    {
        $actualData = json_decode(
            '[{"reference":"1","reference_type":"","owner_org":[{"ref":"OwnerOrg Ref-1","narrative":[{"narrative":"","language":"aa"},{"narrative":"asdsasdasd","language":"ab"}]},{"ref":"OwnerOrg Ref-2","narrative":[{"narrative":"asdasd","language":"af"}]}]}]',
            true,
            512,
            JSON_THROW_ON_ERROR
        );

        $this->test_level_two_multi_dimensional_element_incomplete($this->element, $actualData);
    }

    /**
     * Other Identifier element complete test.
     *
     * @return void
     * @throws \JsonException
     */
    public function test_other_identifier_element_complete(): void
    {
        $actualData = json_decode(
            '[{"reference":"1","reference_type":"A1","owner_org":[{"ref":"OwnerOrg Ref-1","narrative":[{"narrative":"","language":"aa"},{"narrative":"asdsasdasd","language":"ab"}]},{"ref":"OwnerOrg Ref-2","narrative":[{"narrative":"asdasd","language":"af"}]}]}]',
            true,
            512,
            JSON_THROW_ON_ERROR
        );

        $this->test_level_two_multi_dimensional_element_complete($this->element, $actualData);
    }
}
