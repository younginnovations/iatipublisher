<?php

namespace Tests\Feature\Element;

class ActivityDateCompleteTest extends ElementCompleteTest
{
    private string $element = 'activity_date';

    public function __construct(?string $name = null, array $data = [], $dataName = '')
    {
        parent::__construct($name, $data, $dataName);

        $this->activityObj->element = $this->element;
    }

    public function test_activity_date_mandatory_attributes()
    {
        $this->test_mandatory_attributes($this->element, ['type', 'date']);
    }

    public function test_activity_date_mandatory_sub_elements()
    {
        $this->test_mandatory_sub_elements($this->element, []);
    }

    public function test_activity_date_empty_data()
    {
        $activity_dateData = '';

        $this->test_level_one_multi_dimensional_element_incomplete($this->element, $activity_dateData);
    }

    public function test_activity_date_empty_array()
    {
        $activity_dateData = json_decode('[]', true);

        $this->test_level_one_multi_dimensional_element_incomplete($this->element, $activity_dateData);
    }

    public function test_activity_date_empty_json_array()
    {
        $activity_dateData = json_decode('[{}]', true);

        $this->test_level_one_multi_dimensional_element_incomplete($this->element, $activity_dateData);
    }

    public function test_activity_date_attribute_empty_type_and_date()
    {
        $activity_dateData = json_decode('[{"type":"","date":""}]', true);

        $this->test_level_one_multi_dimensional_element_incomplete($this->element, $activity_dateData);
    }

    public function test_activity_date_attribute_no_type_key()
    {
        $activity_dateData = json_decode('[{"date":"2022-02-02"}]', true);

        $this->test_level_one_multi_dimensional_element_incomplete($this->element, $activity_dateData);
    }

    public function test_activity_date_attribute_no_date_key()
    {
        $activity_dateData = json_decode('[{"type":"1"}]', true);

        $this->test_level_one_multi_dimensional_element_incomplete($this->element, $activity_dateData);
    }

    public function test_activity_date_attribute_empty_type()
    {
        $activity_dateData = json_decode('[{"type":"","date":"2020-02-02"}]', true);

        $this->test_level_one_multi_dimensional_element_incomplete($this->element, $activity_dateData);
    }

    public function test_activity_date_attribute_empty_date()
    {
        $activity_dateData = json_decode('[{"type":"1","date":""}]', true);

        $this->test_level_one_multi_dimensional_element_incomplete($this->element, $activity_dateData);
    }

    public function test_activity_date_element_complete()
    {
        $activity_dateData = json_decode(
            '[{"type":"1","date":"2020-02-02","narrative":[{"narrative":"DGGF Track 3 English","language":"en"},{"narrative":"DGGF Track 3 French","language":"fr"}]}]',
            true
        );

        $this->test_level_one_multi_dimensional_element_complete($this->element, $activity_dateData);
    }
}
