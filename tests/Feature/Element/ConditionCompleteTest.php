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

    public function test_condition_first_level_mandatory_attributes()
    {
        $this->test_mandatory_attributes($this->element, []);
    }

    public function test_condition_element_complete()
    {
        $actualData = json_decode('{"condition_attached":"1","condition":[{"condition_type":"1","narrative":[{"narrative":"asdads","language":"ab"}]},{"condition_type":"2","narrative":[{"narrative":"asdasdadad","language":"aa"}]}]}', true);

        $this->test_level_two_single_dimensional_element_complete($this->element, $actualData);
    }
}
