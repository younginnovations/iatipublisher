<?php

declare(strict_types=1);

namespace Tests\Feature\Element;

/**
 * Class ConditionCompleteTest.
 */
class ConditionCompleteTest extends ElementCompleteTest
{
    /**
     * Element conditions.
     *
     * @var string
     */
    private string $element = 'conditions';

    /**
     * Mandatory attribute test.
     *
     * @return void
     * @throws \JsonException
     */
    public function test_condition_mandatory_attributes(): void
    {
        $this->test_mandatory_attributes($this->element, ['condition_attached']);
    }

    /**
     * Mandatory sub element test.
     *
     * @return void
     * @throws \JsonException
     */
    public function test_condition_mandatory_sub_elements(): void
    {
        $this->test_mandatory_sub_elements($this->element, ['condition' => ['condition_type']]);
    }

    /**
     * Empty condition test.
     *
     * @return void
     * @throws \JsonException
     */
    public function test_condition_empty_data(): void
    {
        $humanitarian_scopeData = '';

        $this->test_level_two_single_dimensional_element_incomplete($this->element, $humanitarian_scopeData);
    }

    /**
     * Empty condition array test.
     *
     * @return void
     * @throws \JsonException
     */
    public function test_condition_empty_array(): void
    {
        $humanitarian_scopeData = json_decode('[]', true, 512, JSON_THROW_ON_ERROR);

        $this->test_level_two_single_dimensional_element_incomplete($this->element, $humanitarian_scopeData);
    }

    /**
     * Attribute condition_attached empty test.
     *
     * @return void
     * @throws \JsonException
     */
    public function test_condition_attribute_empty_condition_attached(): void
    {
        $humanitarian_scopeData = json_decode('{"condition_attached":"","condition":[{"condition_type":"1","narrative":[{"narrative":"asdads","language":"ab"}]}]}', true, 512, JSON_THROW_ON_ERROR);

        $this->test_level_two_single_dimensional_element_incomplete($this->element, $humanitarian_scopeData);
    }

    /**
     * Attribute condition_attached no key test.
     *
     * @return void
     * @throws \JsonException
     */
    public function test_condition_attribute_no_condition_attached_key(): void
    {
        $humanitarian_scopeData = json_decode('{"condition":[{"condition_type":"1","narrative":[{"narrative":"asdads","language":"ab"}]}]}', true, 512, JSON_THROW_ON_ERROR);

        $this->test_level_two_single_dimensional_element_incomplete($this->element, $humanitarian_scopeData);
    }

    /**
     * Sub element condition no key test.
     *
     * @return void
     * @throws \JsonException
     */
    public function test_condition_sub_element_no_condition_key(): void
    {
        $humanitarian_scopeData = json_decode('{"condition_attached":""}', true, 512, JSON_THROW_ON_ERROR);

        $this->test_level_two_single_dimensional_element_incomplete($this->element, $humanitarian_scopeData);
    }

    /**
     * Sub element condition empty test.
     *
     * @return void
     * @throws \JsonException
     */
    public function test_condition_sub_element_empty_condition(): void
    {
        $humanitarian_scopeData = json_decode('{"condition_attached":"1","condition":""}', true, 512, JSON_THROW_ON_ERROR);

        $this->test_level_two_single_dimensional_element_incomplete($this->element, $humanitarian_scopeData);
    }

    /**
     * Sub element condition empty array test.
     *
     * @return void
     * @throws \JsonException
     */
    public function test_condition_sub_element_empty_condition_array(): void
    {
        $humanitarian_scopeData = json_decode('{"condition_attached":"1","condition":[]}', true, 512, JSON_THROW_ON_ERROR);

        $this->test_level_two_single_dimensional_element_incomplete($this->element, $humanitarian_scopeData);
    }

    /**
     * Sub element condition empty json array test.
     *
     * @return void
     * @throws \JsonException
     */
    public function test_condition_sub_element_empty_condition_json_array(): void
    {
        $humanitarian_scopeData = json_decode('{"condition_attached":"1","condition":[{}]}', true, 512, JSON_THROW_ON_ERROR);

        $this->test_level_two_single_dimensional_element_incomplete($this->element, $humanitarian_scopeData);
    }

    /**
     * Sub element condition attribute condition_type no key test.
     *
     * @return void
     * @throws \JsonException
     */
    public function test_condition_sub_element_condition_attribute_no_condition_type_key(): void
    {
        $humanitarian_scopeData = json_decode('{"condition_attached":"1","condition":[{"narrative":[{"narrative":"asdads","language":"ab"}]}]}', true, 512, JSON_THROW_ON_ERROR);

        $this->test_level_two_single_dimensional_element_incomplete($this->element, $humanitarian_scopeData);
    }

    /**
     * Sub element condition attribute condition_type empty test.
     *
     * @return void
     * @throws \JsonException
     */
    public function test_condition_sub_element_condition_attribute_empty_condition_type(): void
    {
        $humanitarian_scopeData = json_decode('{"condition_attached":"1","condition":[{"condition_type":"","narrative":[{"narrative":"asdads","language":"ab"}]}]}', true, 512, JSON_THROW_ON_ERROR);

        $this->test_level_two_single_dimensional_element_incomplete($this->element, $humanitarian_scopeData);
    }

    /**
     * Condition element complete test.
     *
     * @return void
     * @throws \JsonException
     */
    public function test_condition_element_complete(): void
    {
        $actualData = json_decode(
            '{"condition_attached":"1","condition":[{"condition_type":"1","narrative":[{"narrative":"asdads","language":"ab"}]},{"condition_type":"2","narrative":[{"narrative":"asdasdadad","language":"aa"}]}]}',
            true,
            512,
            JSON_THROW_ON_ERROR
        );

        $this->test_level_two_single_dimensional_element_complete($this->element, $actualData);
    }
}
