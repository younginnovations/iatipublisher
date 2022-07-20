<?php

namespace Tests\Feature\Element;

class DescriptionCompleteTest extends ElementCompleteTest
{
    private string $element = 'description';

    public function __construct(?string $name = null, array $data = [], $dataName = '')
    {
        parent::__construct($name, $data, $dataName);

        $this->activityObj->element = $this->element;
    }

    public function test_description_mandatory_attributes()
    {
        $this->test_mandatory_attributes($this->element, ['type']);
    }

    public function test_description_mandatory_sub_elements()
    {
        $this->test_mandatory_sub_elements($this->element, ['narrative' => ['narrative', 'language']]);
    }

    public function test_description_element_empty()
    {
        $descriptionData = '';

        $this->test_level_one_multi_dimensional_element_incomplete($this->element, $descriptionData);
    }

    public function test_description_element_empty_array()
    {
        $descriptionData = json_decode('[]', true);

        $this->test_level_one_multi_dimensional_element_incomplete($this->element, $descriptionData);
    }

    public function test_description_element_empty_json_array()
    {
        $descriptionData = json_decode('[{}]', true);

        $this->test_level_one_multi_dimensional_element_incomplete($this->element, $descriptionData);
    }

    public function test_description_element_type_and_narrative_and_description_empty()
    {
        $descriptionData = json_decode('[{"type":"","narrative":[{"narrative":"","language":""}]}]', true);

        $this->test_level_one_multi_dimensional_element_incomplete($this->element, $descriptionData);
    }

    public function test_description_no_type_key()
    {
        $descriptionData = json_decode('[{"narrative":[{"narrative":"test-narrative","language":"en"}]}]', true);

        $this->test_level_one_multi_dimensional_element_incomplete($this->element, $descriptionData);
    }

    public function test_description_no_narrative_key()
    {
        $descriptionData = json_decode('[{"type":"1"}]', true);

        $this->test_level_one_multi_dimensional_element_incomplete($this->element, $descriptionData);
    }

    public function test_description_empty_type()
    {
        $descriptionData = json_decode('[{"type":"","narrative":[{"narrative":"test-narrative","language":"en"}]}]', true);

        $this->test_level_one_multi_dimensional_element_incomplete($this->element, $descriptionData);
    }

    public function test_description_empty_narrative()
    {
        $descriptionData = json_decode('[{"type":"1","narrative":""}]', true);

        $this->test_level_one_multi_dimensional_element_incomplete($this->element, $descriptionData);
    }

    public function test_description_empty_narrative_array()
    {
        $descriptionData = json_decode('[{"type":"1","narrative":[]}]', true);

        $this->test_level_one_multi_dimensional_element_incomplete($this->element, $descriptionData);
    }

    public function test_description_empty_narrative_json_array()
    {
        $descriptionData = json_decode('[{"type":"","narrative":[{}]}]', true);

        $this->test_level_one_multi_dimensional_element_incomplete($this->element, $descriptionData);
    }

    public function test_description_element_empty_narrative_and_empty_language()
    {
        $descriptionData = json_decode('[{"type":"1","narrative":[{"narrative":"","language":""}]}]', true);

        $this->test_level_one_multi_dimensional_element_incomplete($this->element, $descriptionData);
    }

    public function test_description_no_inner_narrative_key()
    {
        $descriptionData = json_decode('[{"type":"1", "narrative":[{"language":"en"}]}]', true);

        $this->test_level_one_multi_dimensional_element_incomplete($this->element, $descriptionData);
    }

    public function test_description_no_inner_language_key()
    {
        $descriptionData = json_decode('[{"type":"1", "narrative":[{"narrative":"test-narrative"}]}]', true);

        $this->test_level_one_multi_dimensional_element_incomplete($this->element, $descriptionData);
    }

    public function test_description_element_empty_narrative()
    {
        $descriptionData = json_decode('[{"type":"1","narrative":[{"narrative":"","language":"en"}]}]', true);

        $this->test_level_one_multi_dimensional_element_incomplete($this->element, $descriptionData);
    }

    public function test_description_element_empty_language()
    {
        $descriptionData = json_decode('[{"type":"1","narrative":[{"narrative":"asdasd","language":""}]}]', true);

        $this->test_level_one_multi_dimensional_element_incomplete($this->element, $descriptionData);
    }

    public function test_description_element_complete()
    {
        $descriptionData = json_decode('[{"type":"1","narrative":[{"narrative":"DGGF Track 3 English","language":"en"},{"narrative":"DGGF Track 3 French","language":"fr"}]}]', true);

        $this->test_level_one_multi_dimensional_element_complete($this->element, $descriptionData);
    }
}
