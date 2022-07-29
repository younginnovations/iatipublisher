<?php

namespace Tests\Feature\Element;

/**
 * Class ActivityDateCompleteTest.
 */
class ActivityDateCompleteTest extends ElementCompleteTest
{
    private string $element = 'activity_date';

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
    public function test_activity_date_mandatory_attributes(): void
    {
        $this->test_mandatory_attributes($this->element, ['type', 'date']);
    }

    /**
     * Mandatory sub element test.
     *
     * @return void
     */
    public function test_activity_date_mandatory_sub_elements(): void
    {
        $this->test_mandatory_sub_elements($this->element, []);
    }

    /**
     * Empty activity_date test.
     *
     * @return void
     */
    public function test_activity_date_empty_data(): void
    {
        $activity_dateData = '';

        $this->test_level_one_multi_dimensional_element_incomplete($this->element, $activity_dateData);
    }

    /**
     * Empty activity_date array test.
     *
     * @return void
     */
    public function test_activity_date_empty_array(): void
    {
        $activity_dateData = json_decode('[]', true);

        $this->test_level_one_multi_dimensional_element_incomplete($this->element, $activity_dateData);
    }

    /**
     * Empty activity_date json array test.
     *
     * @return void
     */
    public function test_activity_date_empty_json_array(): void
    {
        $activity_dateData = json_decode('[{}]', true);

        $this->test_level_one_multi_dimensional_element_incomplete($this->element, $activity_dateData);
    }

    /**
     * Empty all element test.
     *
     * @return void
     */
    public function test_activity_date_attribute_empty_type_and_date(): void
    {
        $activity_dateData = json_decode('[{"type":"","date":""}]', true);

        $this->test_level_one_multi_dimensional_element_incomplete($this->element, $activity_dateData);
    }

    /**
     * No attribute type key test.
     *
     * @return void
     */
    public function test_activity_date_attribute_no_type_key(): void
    {
        $activity_dateData = json_decode('[{"date":"2022-02-02"}]', true);

        $this->test_level_one_multi_dimensional_element_incomplete($this->element, $activity_dateData);
    }

    /**
     * No attribute date key test.
     *
     * @return void
     */
    public function test_activity_date_attribute_no_date_key(): void
    {
        $activity_dateData = json_decode('[{"type":"1"}]', true);

        $this->test_level_one_multi_dimensional_element_incomplete($this->element, $activity_dateData);
    }

    /**
     * Empty attribute type test.
     *
     * @return void
     */
    public function test_activity_date_attribute_empty_type(): void
    {
        $activity_dateData = json_decode('[{"type":"","date":"2020-02-02"}]', true);

        $this->test_level_one_multi_dimensional_element_incomplete($this->element, $activity_dateData);
    }

    /**
     * Empty attribute date test.
     *
     * @return void
     */
    public function test_activity_date_attribute_empty_date(): void
    {
        $activity_dateData = json_decode('[{"type":"1","date":""}]', true);

        $this->test_level_one_multi_dimensional_element_incomplete($this->element, $activity_dateData);
    }

    /**
     * Complete activity_date test.
     *
     * @return void
     */
    public function test_activity_date_element_complete(): void
    {
        $activity_dateData = json_decode(
            '[{"type":"1","date":"2020-02-02","narrative":[{"narrative":"DGGF Track 3 English","language":"en"},{"narrative":"DGGF Track 3 French","language":"fr"}]}]',
            true
        );

        $this->test_level_one_multi_dimensional_element_complete($this->element, $activity_dateData);
    }
}
