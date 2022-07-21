<?php

namespace Tests\Feature\Element;

class PolicyMarkerCompleteTest extends ElementCompleteTest
{
    private string $element = 'policy_marker';

    public function __construct(?string $name = null, array $data = [], $dataName = '')
    {
        parent::__construct($name, $data, $dataName);

        $this->activityObj->element = $this->element;
    }

    public function test_policy_marker_type_mandatory_attributes()
    {
        $this->test_mandatory_attributes($this->element, ['policy_marker']);
    }

    public function test_policy_marker_mandatory_sub_elements()
    {
        $this->test_mandatory_sub_elements($this->element, []);
    }

    public function test_policy_marker_element_complete()
    {
        $sector_typeData = json_decode('[{"policy_marker_vocabulary":"1","significance":"1","policy_marker":"1","narrative":[{"narrative":"policy-marker-1-narrative1","language":"aa"}]},{"policy_marker_vocabulary":"99","vocabulary_uri":"https:\/\/google.com","significance":"2","policy_marker_text":"vocab-99","narrative":[{"narrative":"policy-marker-99-narrative1","language":"ak"}]}]', true);

        $this->test_level_one_multi_dimensional_element_complete($this->element, $sector_typeData);
    }
}
