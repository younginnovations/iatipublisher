<?php

namespace Tests\Feature\Element;

/**
 * Class LegacyDataCompleteTest.
 */
class LegacyDataCompleteTest extends ElementCompleteTest
{
    private string $element = 'legacy_data';

    /**
     * Construct function.
     *
     * @param string|null $name
     * @param array       $data
     * @param string      $dataName
     */
    public function __construct(?string $name = null, array $data = [], string $dataName = '')
    {
        parent::__construct($name, $data, $dataName);

        $this->activityObj->element = $this->element;
    }

    /**
     * Mandatory attribute test.
     *
     * @return void
     */
    public function test_legacy_data_mandatory_attributes(): void
    {
        $this->test_mandatory_attributes($this->element, ['legacy_name', 'value']);
    }

    /**
     * Mandatory sub element test.
     *
     * @return void
     */
    public function test_legacy_data_mandatory_sub_elements(): void
    {
        $this->test_mandatory_sub_elements($this->element, []);
    }

    /**
     * All attribute data empty test.
     *
     * @return void
     */
    public function test_legacy_data_all_element_empty(): void
    {
        $actualData = json_decode('[{"legacy_name":"","value":"","iati_equivalent":"name 1 equivalent"}]', true);

        $this->test_level_one_multi_dimensional_element_incomplete($this->element, $actualData);
    }

    /**
     * Attribute legacy_name no key test.
     *
     * @return void
     */
    public function test_legacy_data_attribute_no_legacy_name_key(): void
    {
        $actualData = json_decode('[{"value":"","iati_equivalent":"name 1 equivalent"}]', true);

        $this->test_level_one_multi_dimensional_element_incomplete($this->element, $actualData);
    }

    /**
     * Attribute legacy_name empty test.
     *
     * @return void
     */
    public function test_legacy_data_attribute_empty_legacy_name(): void
    {
        $actualData = json_decode('[{"legacy_name":"", "value":"123","iati_equivalent":"name 1 equivalent"}]', true);

        $this->test_level_one_multi_dimensional_element_incomplete($this->element, $actualData);
    }

    /**
     * Attribute value no key test.
     *
     * @return void
     */
    public function test_legacy_data_attribute_no_value_key(): void
    {
        $actualData = json_decode('[{"legacy_name":"","iati_equivalent":"name 1 equivalent"}]', true);

        $this->test_level_one_multi_dimensional_element_incomplete($this->element, $actualData);
    }

    /**
     * Attribute value empty test.
     *
     * @return void
     */
    public function test_legacy_data_attribute_empty_value(): void
    {
        $actualData = json_decode('[{"legacy_name":"asdas", "value":"","iati_equivalent":"name 1 equivalent"}]', true);

        $this->test_level_one_multi_dimensional_element_incomplete($this->element, $actualData);
    }

    /**
     * Legacy Data element complete test.
     *
     * @return void
     */
    public function test_legacy_data_element_complete(): void
    {
        $actualData = json_decode(
            '[{"legacy_name":"legacy name 1","value":"12345","iati_equivalent":"name 1 equivalent"},{"legacy_name":"legacy name 2","value":"234561","iati_equivalent":"name 2 eqv"},{"legacy_name":"legacy name 3","value":"3845879","iati_equivalent":"name 3 eqv"}]',
            true
        );

        $this->test_level_one_multi_dimensional_element_complete($this->element, $actualData);
    }
}
