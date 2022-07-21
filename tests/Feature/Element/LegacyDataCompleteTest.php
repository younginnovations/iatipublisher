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
        $this->test_mandatory_attributes($this->element, ['legacy_name', 'value']);
    }

    public function test_legacy_data_mandatory_sub_elements()
    {
        $this->test_mandatory_sub_elements($this->element, []);
    }

    public function test_legacy_data_all_element_empty()
    {
        $actualData = json_decode('[{"legacy_name":"","value":"","iati_equivalent":"name 1 equivalent"}]', true);

        $this->test_level_one_multi_dimensional_element_incomplete($this->element, $actualData);
    }

    public function test_legacy_data_attribute_no_legacy_name_key()
    {
        $actualData = json_decode('[{"value":"","iati_equivalent":"name 1 equivalent"}]', true);

        $this->test_level_one_multi_dimensional_element_incomplete($this->element, $actualData);
    }

    public function test_legacy_data_attribute_empty_legacy_name()
    {
        $actualData = json_decode('[{"legacy_name":"", "value":"123","iati_equivalent":"name 1 equivalent"}]', true);

        $this->test_level_one_multi_dimensional_element_incomplete($this->element, $actualData);
    }

    public function test_legacy_data_attribute_no_value_key()
    {
        $actualData = json_decode('[{"legacy_name":"","iati_equivalent":"name 1 equivalent"}]', true);

        $this->test_level_one_multi_dimensional_element_incomplete($this->element, $actualData);
    }

    public function test_legacy_data_attribute_empty_value()
    {
        $actualData = json_decode('[{"legacy_name":"asdas", "value":"","iati_equivalent":"name 1 equivalent"}]', true);

        $this->test_level_one_multi_dimensional_element_incomplete($this->element, $actualData);
    }

    public function test_legacy_data_element_complete()
    {
        $actualData = json_decode('[{"legacy_name":"legacy name 1","value":"12345","iati_equivalent":"name 1 equivalent"},{"legacy_name":"legacy name 2","value":"234561","iati_equivalent":"name 2 eqv"},{"legacy_name":"legacy name 3","value":"3845879","iati_equivalent":"name 3 eqv"}]', true);

        $this->test_level_one_multi_dimensional_element_complete($this->element, $actualData);
    }
}
