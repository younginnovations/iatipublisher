<?php

declare(strict_types=1);

namespace Tests\Feature\Element;

/**
 * Class HumanitarianScopeCompleteTest.
 */
class HumanitarianScopeCompleteTest extends ElementCompleteTest
{
    /**
     * Element humanitarian_scope.
     *
     * @var string
     */
    private string $element = 'humanitarian_scope';

    /**
     * Mandatory attribute test.
     *
     * @return void
     * @throws \JsonException
     */
    public function test_humanitarian_scope_mandatory_attributes(): void
    {
        $this->test_mandatory_attributes($this->element, ['type', 'vocabulary', 'code']);
    }

    /**
     * Mandatory sub element test.
     *
     * @return void
     * @throws \JsonException
     */
    public function test_humanitarian_scope_mandatory_sub_elements(): void
    {
        $this->test_mandatory_sub_elements($this->element, []);
    }

    /**
     * Empty data test.
     *
     * @return void
     * @throws \JsonException
     */
    public function test_humanitarian_scope_empty_data(): void
    {
        $humanitarian_scopeData = '';

        $this->test_level_one_multi_dimensional_element_incomplete($this->element, $humanitarian_scopeData);
    }

    /**
     * Empty array test.
     *
     * @return void
     * @throws \JsonException
     */
    public function test_humanitarian_scope_empty_array(): void
    {
        $humanitarian_scopeData = json_decode('[]', true, 512, JSON_THROW_ON_ERROR);

        $this->test_level_one_multi_dimensional_element_incomplete($this->element, $humanitarian_scopeData);
    }

    /**
     * Empty json array test.
     *
     * @return void
     * @throws \JsonException
     */
    public function test_humanitarian_scope_empty_json_array(): void
    {
        $humanitarian_scopeData = json_decode('[{}]', true, 512, JSON_THROW_ON_ERROR);

        $this->test_level_one_multi_dimensional_element_incomplete($this->element, $humanitarian_scopeData);
    }

    /**
     * All attribute empty test.
     *
     * @return void
     * @throws \JsonException
     */
    public function test_humanitarian_scope_all_attribute_empty_test(): void
    {
        $humanitarian_scopeData = json_decode('[{"type":"","vocabulary":"","code":"123","narrative":[{"narrative":"asd","language":"aa"}]}]', true, 512, JSON_THROW_ON_ERROR);

        $this->test_level_one_multi_dimensional_element_incomplete($this->element, $humanitarian_scopeData);
    }

    /**
     * All attribute no key test.
     *
     * @return void
     * @throws \JsonException
     */
    public function test_humanitarian_scope_attribute_no_type_and_vocabulary_key(): void
    {
        $humanitarian_scopeData = json_decode('[{"code":"123","narrative":[{"narrative":"asd","language":"aa"}]}]', true, 512, JSON_THROW_ON_ERROR);

        $this->test_level_one_multi_dimensional_element_incomplete($this->element, $humanitarian_scopeData);
    }

    /**
     * Attribute type no key test.
     *
     * @return void
     * @throws \JsonException
     */
    public function test_humanitarian_scope_attribute_no_type_key(): void
    {
        $humanitarian_scopeData = json_decode('[{"vocabulary":"1-2","code":"123","narrative":[{"narrative":"asd","language":"aa"}]}]', true, 512, JSON_THROW_ON_ERROR);

        $this->test_level_one_multi_dimensional_element_incomplete($this->element, $humanitarian_scopeData);
    }

    /**
     * Attribute type no key test.
     *
     * @return void
     * @throws \JsonException
     */
    public function test_humanitarian_scope_attribute_no_vocabulary_key(): void
    {
        $humanitarian_scopeData = json_decode('[{"type":"1","code":"123","narrative":[{"narrative":"asd","language":"aa"}]}]', true, 512, JSON_THROW_ON_ERROR);

        $this->test_level_one_multi_dimensional_element_incomplete($this->element, $humanitarian_scopeData);
    }

    /**
     * Attribute code empty for vocabulary 1-2 test.
     *
     * @return void
     * @throws \JsonException
     */
    public function test_humanitarian_scope_attribute_empty_code_for_vocab_1_2(): void
    {
        $humanitarian_scopeData = json_decode('[{"type":"1","vocabulary":"1-2","code":"","narrative":[{"narrative":"asd","language":"aa"}]}]', true, 512, JSON_THROW_ON_ERROR);

        $this->test_level_one_multi_dimensional_element_incomplete($this->element, $humanitarian_scopeData);
    }

    /**
     * Attribute code no key for vocabulary 1-2 test.
     *
     * @return void
     * @throws \JsonException
     */
    public function test_humanitarian_scope_attribute_no_code_key_for_vocab_1_2(): void
    {
        $humanitarian_scopeData = json_decode('[{"type":"1","vocabulary":"1-2","narrative":[{"narrative":"asd","language":"aa"}]}]', true, 512, JSON_THROW_ON_ERROR);

        $this->test_level_one_multi_dimensional_element_incomplete($this->element, $humanitarian_scopeData);
    }

    /**
     * Attribute code empty for vocabulary 2-1 test.
     *
     * @return void
     * @throws \JsonException
     */
    public function test_humanitarian_scope_attribute_empty_code_for_vocab_2_1(): void
    {
        $humanitarian_scopeData = json_decode('[{"type":"1","vocabulary":"2-1","code":"","narrative":[{"narrative":"asd","language":"aa"}]}]', true, 512, JSON_THROW_ON_ERROR);

        $this->test_level_one_multi_dimensional_element_incomplete($this->element, $humanitarian_scopeData);
    }

    /**
     * Attribute code no key for vocabulary 2-1 test.
     *
     * @return void
     * @throws \JsonException
     */
    public function test_humanitarian_scope_attribute_no_code_key_for_vocab_2_1(): void
    {
        $humanitarian_scopeData = json_decode('[{"type":"1","vocabulary":"2-1","narrative":[{"narrative":"asd","language":"aa"}]}]', true, 512, JSON_THROW_ON_ERROR);

        $this->test_level_one_multi_dimensional_element_incomplete($this->element, $humanitarian_scopeData);
    }

    /**
     * Attribute code complete for vocabulary 1-2 test.
     *
     * @return void
     * @throws \JsonException
     */
    public function test_humanitarian_scope_attribute_has_code_key_for_vocab_1_2(): void
    {
        $humanitarian_scopeData = json_decode('[{"type":"1","vocabulary":"1-2","code":"123123","narrative":[{"narrative":"asd","language":"aa"}]}]', true, 512, JSON_THROW_ON_ERROR);

        $this->test_level_one_multi_dimensional_element_complete($this->element, $humanitarian_scopeData);
    }

    /**
     * Attribute code complete for vocabulary 2-1 test.
     *
     * @return void
     * @throws \JsonException
     */
    public function test_humanitarian_scope_attribute_has_code_key_for_vocab_2_1(): void
    {
        $humanitarian_scopeData = json_decode('[{"type":"1","vocabulary":"2-1","code":"123123","narrative":[{"narrative":"asd","language":"aa"}]}]', true, 512, JSON_THROW_ON_ERROR);

        $this->test_level_one_multi_dimensional_element_complete($this->element, $humanitarian_scopeData);
    }

    /**
     * Humanitarian Scope element complete test.
     *
     * @return void
     * @throws \JsonException
     */
    public function test_humanitarian_scope_element_complete(): void
    {
        $humanitarian_scopeData = json_decode(
            '[{"type":"1","vocabulary":"1-2","code":"123","narrative":[{"narrative":"asd","language":"aa"}]},{"type":"1","vocabulary":"99","vocabulary_uri":"https:\/\/www.msn.com","code":"vocab-2-Appeal-99","narrative":[{"narrative":"asdad","language":"am"}]}]',
            true,
            512,
            JSON_THROW_ON_ERROR
        );

        $this->test_level_one_multi_dimensional_element_complete($this->element, $humanitarian_scopeData);
    }
}
