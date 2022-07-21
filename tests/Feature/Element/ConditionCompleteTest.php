<?php

namespace Tests\Feature\Element;

class ConditionCompleteTest extends ElementCompleteTest
{
    private string $element = 'conditions';

    public function __construct(?string $name = null, array $data = [], $dataName = '')
    {
        parent::__construct($name, $data, $dataName);

        $this->activityObj->element = $this->element;
    }

    public function test_condition_mandatory_attributes()
    {
        $this->test_mandatory_attributes($this->element, ['condition_attached']);
    }

    public function test_condition_mandatory_sub_elements()
    {
        $this->test_mandatory_sub_elements($this->element, ['condition' => ['condition_type']]);
    }

    public function test_condition_empty_data()
    {
        $humanitarian_scopeData = '';

        $this->test_level_two_single_dimensional_element_incomplete($this->element, $humanitarian_scopeData);
    }

    public function test_condition_empty_array()
    {
        $humanitarian_scopeData = json_decode('[]', true);

        $this->test_level_two_single_dimensional_element_incomplete($this->element, $humanitarian_scopeData);
    }

    public function test_condition_attribute_empty_condition_attached()
    {
        $humanitarian_scopeData = json_decode('{"condition_attached":"","condition":[{"condition_type":"1","narrative":[{"narrative":"asdads","language":"ab"}]}]}', true);

        $this->test_level_two_single_dimensional_element_incomplete($this->element, $humanitarian_scopeData);
    }

    public function test_condition_attribute_no_condition_attached_key()
    {
        $humanitarian_scopeData = json_decode('{"condition":[{"condition_type":"1","narrative":[{"narrative":"asdads","language":"ab"}]}]}', true);

        $this->test_level_two_single_dimensional_element_incomplete($this->element, $humanitarian_scopeData);
    }

    public function test_condition_sub_element_no_condition_key()
    {
        $humanitarian_scopeData = json_decode('{"condition_attached":""}', true);

        $this->test_level_two_single_dimensional_element_incomplete($this->element, $humanitarian_scopeData);
    }

    public function test_condition_sub_element_empty_condition()
    {
        $humanitarian_scopeData = json_decode('{"condition_attached":"","condition":""}', true);

        $this->test_level_two_single_dimensional_element_incomplete($this->element, $humanitarian_scopeData);
    }

    public function test_condition_sub_element_empty_condition_array()
    {
        $humanitarian_scopeData = json_decode('{"condition_attached":"","condition":[]}', true);

        $this->test_level_two_single_dimensional_element_incomplete($this->element, $humanitarian_scopeData);
    }

    public function test_condition_sub_element_empty_condition_json_array()
    {
        $humanitarian_scopeData = json_decode('{"condition_attached":"","condition":[{}]}', true);

        $this->test_level_two_single_dimensional_element_incomplete($this->element, $humanitarian_scopeData);
    }

    public function test_condition_sub_element_condition_attribute_no_condition_type_key()
    {
        $humanitarian_scopeData = json_decode('{"condition_attached":"","condition":[{"narrative":[{"narrative":"asdads","language":"ab"}]]}', true);

        $this->test_level_two_single_dimensional_element_incomplete($this->element, $humanitarian_scopeData);
    }

    public function test_condition_sub_element_condition_attribute_empty_condition_type()
    {
        $humanitarian_scopeData = json_decode('{"condition_attached":"","condition":[{"condition_type":"","narrative":[{"narrative":"asdads","language":"ab"}]]}', true);

        $this->test_level_two_single_dimensional_element_incomplete($this->element, $humanitarian_scopeData);
    }

    public function test_condition_element_complete()
    {
        $actualData = json_decode(
            '{"condition_attached":"1","condition":[{"condition_type":"1","narrative":[{"narrative":"asdads","language":"ab"}]},{"condition_type":"2","narrative":[{"narrative":"asdasdadad","language":"aa"}]}]}',
            true
        );

        $this->test_level_two_single_dimensional_element_complete($this->element, $actualData);
    }
}
