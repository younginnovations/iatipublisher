<?php

namespace Tests\Feature\Element;

class HumanitarianScopeCompleteTest extends ElementCompleteTest
{
    private string $element = 'humanitarian_scope';

    public function __construct(?string $name = null, array $data = [], $dataName = '')
    {
        parent::__construct($name, $data, $dataName);

        $this->activityObj->element = $this->element;
    }

    public function test_humanitarian_scope_mandatory_attributes()
    {
        $this->test_mandatory_attributes($this->element, ['type', 'vocabulary', 'code']);
    }

    public function test_humanitarian_scope_mandatory_sub_elements()
    {
        $this->test_mandatory_sub_elements($this->element, []);
    }

    public function test_humanitarian_scope_empty_data()
    {
        $humanitarian_scopeData = '';

        $this->test_level_one_multi_dimensional_element_incomplete($this->element, $humanitarian_scopeData);
    }

    public function test_humanitarian_scope_empty_array()
    {
        $humanitarian_scopeData = json_decode('[]', true);

        $this->test_level_one_multi_dimensional_element_incomplete($this->element, $humanitarian_scopeData);
    }

    public function test_humanitarian_scope_empty_json_array()
    {
        $humanitarian_scopeData = json_decode('[{}]', true);

        $this->test_level_one_multi_dimensional_element_incomplete($this->element, $humanitarian_scopeData);
    }

    public function test_humanitarian_scope_empty_type_and_vocabulary()
    {
        $humanitarian_scopeData = json_decode('[{"type":"","vocabulary":"","code":"123","narrative":[{"narrative":"asd","language":"aa"}]}]', true);

        $this->test_level_one_multi_dimensional_element_incomplete($this->element, $humanitarian_scopeData);
    }

    public function test_humanitarian_scope_attribute_no_type_and_vocabulary_key()
    {
        $humanitarian_scopeData = json_decode('[{"code":"123","narrative":[{"narrative":"asd","language":"aa"}]}]', true);

        $this->test_level_one_multi_dimensional_element_incomplete($this->element, $humanitarian_scopeData);
    }

    public function test_humanitarian_scope_attribute_no_type_key()
    {
        $humanitarian_scopeData = json_decode('[{"vocabulary":"1-2","code":"123","narrative":[{"narrative":"asd","language":"aa"}]}]', true);

        $this->test_level_one_multi_dimensional_element_incomplete($this->element, $humanitarian_scopeData);
    }

    public function test_humanitarian_scope_attribute_no_vocabulary_key()
    {
        $humanitarian_scopeData = json_decode('[{"type":"1","code":"123","narrative":[{"narrative":"asd","language":"aa"}]}]', true);

        $this->test_level_one_multi_dimensional_element_incomplete($this->element, $humanitarian_scopeData);
    }

    public function test_humanitarian_scope_attribute_empty_code_for_vocab_1_2()
    {
        $humanitarian_scopeData = json_decode('[{"type":"1","vocabulary":"1-2","code":"","narrative":[{"narrative":"asd","language":"aa"}]}]', true);

        $this->test_level_one_multi_dimensional_element_incomplete($this->element, $humanitarian_scopeData);
    }

    public function test_humanitarian_scope_attribute_no_code_key_for_vocab_1_2()
    {
        $humanitarian_scopeData = json_decode('[{"type":"1","vocabulary":"1-2","narrative":[{"narrative":"asd","language":"aa"}]}]', true);

        $this->test_level_one_multi_dimensional_element_incomplete($this->element, $humanitarian_scopeData);
    }

    public function test_humanitarian_scope_attribute_empty_code_for_vocab_2_1()
    {
        $humanitarian_scopeData = json_decode('[{"type":"1","vocabulary":"2-1","code":"","narrative":[{"narrative":"asd","language":"aa"}]}]', true);

        $this->test_level_one_multi_dimensional_element_incomplete($this->element, $humanitarian_scopeData);
    }

    public function test_humanitarian_scope_attribute_no_code_key_for_vocab_2_1()
    {
        $humanitarian_scopeData = json_decode('[{"type":"1","vocabulary":"2-1","narrative":[{"narrative":"asd","language":"aa"}]}]', true);

        $this->test_level_one_multi_dimensional_element_incomplete($this->element, $humanitarian_scopeData);
    }

    public function test_humanitarian_scope_attribute_has_code_key_for_vocab_1_2()
    {
        $humanitarian_scopeData = json_decode('[{"type":"1","vocabulary":"1-2","code":"123123","narrative":[{"narrative":"asd","language":"aa"}]}]', true);

        $this->test_level_one_multi_dimensional_element_complete($this->element, $humanitarian_scopeData);
    }

    public function test_humanitarian_scope_attribute_has_code_key_for_vocab_2_1()
    {
        $humanitarian_scopeData = json_decode('[{"type":"1","vocabulary":"2-1","code":"123123","narrative":[{"narrative":"asd","language":"aa"}]}]', true);

        $this->test_level_one_multi_dimensional_element_complete($this->element, $humanitarian_scopeData);
    }

    public function test_humanitarian_scope_element_complete()
    {
        $humanitarian_scopeData = json_decode(
            '[{"type":"1","vocabulary":"1-2","code":"123","narrative":[{"narrative":"asd","language":"aa"}]},{"type":"1","vocabulary":"99","vocabulary_uri":"https:\/\/www.msn.com","code":"vocab-2-Appeal-99","narrative":[{"narrative":"asdad","language":"am"}]}]',
            true
        );

        $this->test_level_one_multi_dimensional_element_complete($this->element, $humanitarian_scopeData);
    }
}
