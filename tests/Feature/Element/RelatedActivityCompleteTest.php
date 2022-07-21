<?php

namespace Tests\Feature\Element;

class RelatedActivityCompleteTest extends ElementCompleteTest
{
    private string $element = 'related_activity';

    public function __construct(?string $name = null, array $data = [], $dataName = '')
    {
        parent::__construct($name, $data, $dataName);

        $this->activityObj->element = $this->element;
    }

    public function test_related_activity_mandatory_attributes()
    {
        $this->test_mandatory_attributes($this->element, ['activity_identifier', 'relationship_type']);
    }

    public function test_related_activity_mandatory_sub_elements()
    {
        $this->test_mandatory_sub_elements($this->element, []);
    }

    public function test_related_activity_all_element_empty()
    {
        $related_activityData = json_decode('[{"activity_identifier":"","relationship_type":""}]', true);

        $this->test_level_one_multi_dimensional_element_incomplete($this->element, $related_activityData);
    }

    public function test_related_activity_attribute_no_activity_identifier_key()
    {
        $related_activityData = json_decode('[{"relationship_type":"123"}]', true);

        $this->test_level_one_multi_dimensional_element_incomplete($this->element, $related_activityData);
    }

    public function test_related_activity_attribute_empty_activity_identifier()
    {
        $related_activityData = json_decode('[{"activity_identifier":"","relationship_type":"123"}]', true);

        $this->test_level_one_multi_dimensional_element_incomplete($this->element, $related_activityData);
    }

    public function test_related_activity_attribute_no_relationship_type_key()
    {
        $related_activityData = json_decode('[{"activity_identifier":"123"}]', true);

        $this->test_level_one_multi_dimensional_element_incomplete($this->element, $related_activityData);
    }

    public function test_related_activity_attribute_empty_relationship_type()
    {
        $related_activityData = json_decode('[{"activity_identifier":"123","relationship_type":""}]', true);

        $this->test_level_one_multi_dimensional_element_incomplete($this->element, $related_activityData);
    }

    public function test_related_activity_element_complete()
    {
        $related_activityData = json_decode('[{"activity_identifier":"DK-CVR-31378028-SPA-2020-edited","relationship_type":"1"}]', true);

        $this->test_level_one_multi_dimensional_element_complete($this->element, $related_activityData);
    }
}
