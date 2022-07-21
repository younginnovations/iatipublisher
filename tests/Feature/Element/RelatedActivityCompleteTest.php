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
        $this->test_mandatory_attributes($this->element, []);
    }

    public function test_related_activity_mandatory_sub_elements()
    {
        $this->test_mandatory_sub_elements($this->element, []);
    }

    public function test_related_activity_element_complete()
    {
        $related_activityData = json_decode('[{"activity_identifier":"DK-CVR-31378028-SPA-2020-edited","relationship_type":"1"}]', true);

        $this->test_level_one_multi_dimensional_element_complete($this->element, $related_activityData);
    }
}
