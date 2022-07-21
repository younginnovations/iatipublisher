<?php

namespace Tests\Feature\Element;

class LegacyDataCompleteTest extends ElementCompleteTest
{
    private string $element = 'legacy_data';

    public function __construct(?string $name = null, array $data = [], $dataName = '')
    {
        parent::__construct($name, $data, $dataName);

        $this->activityObj->element = $this->element;
    }

    public function test_legacy_data_mandatory_attributes()
    {
        $this->test_mandatory_attributes($this->element, []);
    }

    public function test_legacy_data_mandatory_sub_elements()
    {
        $this->test_mandatory_sub_elements($this->element, []);
    }

    public function test_legacy_data_element_complete()
    {
        $actualData = json_decode('[{"legacy_name":"legacy name 1","value":"12345","iati_equivalent":"name 1 equivalent"},{"legacy_name":"legacy name 2","value":"234561","iati_equivalent":"name 2 eqv"},{"legacy_name":"legacy name 3","value":"3845879","iati_equivalent":"name 3 eqv"}]', true);

        $this->test_level_one_multi_dimensional_element_complete($this->element, $actualData);
    }
}
