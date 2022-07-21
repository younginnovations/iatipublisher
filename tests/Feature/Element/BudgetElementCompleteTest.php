<?php

namespace Tests\Feature\Element;

class BudgetElementCompleteTest extends ElementCompleteTest
{
    private string $element = 'budget';

    public function __construct(?string $name = null, array $data = [], $dataName = '')
    {
        parent::__construct($name, $data, $dataName);

        $this->activityObj->element = $this->element;
    }

    public function test_budget_mandatory_attributes()
    {
        $this->test_mandatory_attributes($this->element, []);
    }

    public function test_budget_mandatory_sub_elements()
    {
        $this->test_mandatory_sub_elements($this->element, ['period_start' => ['date'], 'period_end' => ['date'], 'budget_value' => ['value_date']]);
    }

    public function test_budget_empty_data()
    {
        $budgetData = '';

        $this->test_level_one_multi_dimensional_element_incomplete($this->element, $budgetData);
    }

    public function test_budget_empty_array()
    {
        $budgetData = json_decode('[]', true);

        $this->test_level_one_multi_dimensional_element_incomplete($this->element, $budgetData);
    }

    public function test_budget_empty_json_array()
    {
        $budgetData = json_decode('[{}]', true);

        $this->test_level_one_multi_dimensional_element_incomplete($this->element, $budgetData);
    }

    public function test_budget_sub_element_empty_period_start()
    {
        $budgetData = json_decode('[{"budget_type":"1","budget_status":"1","period_start":"","period_end":[{"date":"2016-12-02"}],"budget_value":[{"amount":"100","currency":"AFN","value_date":"2022-07-27"}]}]', true);

        $this->test_level_one_multi_dimensional_element_incomplete($this->element, $budgetData);
    }

    public function test_budget_sub_element_no_period_start_key()
    {
        $budgetData = json_decode('[{"budget_type":"1","budget_status":"1","period_end":[{"date":"2016-12-02"}],"budget_value":[{"amount":"100","currency":"AFN","value_date":"2022-07-27"}]}]', true);

        $this->test_level_one_multi_dimensional_element_incomplete($this->element, $budgetData);
    }

    public function test_budget_sub_element_empty_period_start_array()
    {
        $budgetData = json_decode('[{"budget_type":"1","budget_status":"1","period_start":[],"period_end":[{"date":"2016-12-02"}],"budget_value":[{"amount":"100","currency":"AFN","value_date":"2022-07-27"}]}]', true);

        $this->test_level_one_multi_dimensional_element_incomplete($this->element, $budgetData);
    }

    public function test_budget_sub_element_empty_period_start_json_array()
    {
        $budgetData = json_decode('[{"budget_type":"1","budget_status":"1","period_start":[{}],"period_end":[{"date":"2016-12-02"}],"budget_value":[{"amount":"100","currency":"AFN","value_date":"2022-07-27"}]}]', true);

        $this->test_level_one_multi_dimensional_element_incomplete($this->element, $budgetData);
    }

    public function test_budget_sub_element_period_start_empty_attribute_date()
    {
        $budgetData = json_decode('[{"budget_type":"1","budget_status":"1","period_start":[{"date":""}],"period_end":[{"date":"2016-12-02"}],"budget_value":[{"amount":"100","currency":"AFN","value_date":"2022-07-27"}]}]', true);

        $this->test_level_one_multi_dimensional_element_incomplete($this->element, $budgetData);
    }

    public function test_budget_sub_element_empty_period_end()
    {
        $budgetData = json_decode('[{"budget_type":"1","budget_status":"1","period_start":[{"date":"2016-12-02"}],"period_end":"","budget_value":[{"amount":"100","currency":"AFN","value_date":"2022-07-27"}]}]', true);

        $this->test_level_one_multi_dimensional_element_incomplete($this->element, $budgetData);
    }

    public function test_budget_sub_element_no_period_end_key()
    {
        $budgetData = json_decode(
            '[{"budget_type":"1","budget_status":"1","period_start":[{"date":"2016-12-02"}],"budget_value":[{"amount":"100","currency":"AFN","value_date":"2022-07-27"}]}]',
            true
        );

        $this->test_level_one_multi_dimensional_element_incomplete($this->element, $budgetData);
    }

    public function test_budget_sub_element_empty_period_end_array()
    {
        $budgetData = json_decode('[{"budget_type":"1","budget_status":"1","period_start":[{"date":"2016-12-02"}],"period_end":[],"budget_value":[{"amount":"100","currency":"AFN","value_date":"2022-07-27"}]}]', true);

        $this->test_level_one_multi_dimensional_element_incomplete($this->element, $budgetData);
    }

    public function test_budget_sub_element_empty_period_end_json_array()
    {
        $budgetData = json_decode('[{"budget_type":"1","budget_status":"1","period_start":[{"date":"2016-12-02"}],"period_end":[{}],"budget_value":[{"amount":"100","currency":"AFN","value_date":"2022-07-27"}]}]', true);

        $this->test_level_one_multi_dimensional_element_incomplete($this->element, $budgetData);
    }

    public function test_budget_sub_element_period_end_empty_attribute_date()
    {
        $budgetData = json_decode('[{"budget_type":"1","budget_status":"1","period_start":[{"date":"2016-12-02"}],"period_end":[{"date":""}],"budget_value":[{"amount":"100","currency":"AFN","value_date":"2022-07-27"}]}]', true);

        $this->test_level_one_multi_dimensional_element_incomplete($this->element, $budgetData);
    }

    public function test_budget_sub_element_empty_budget_value()
    {
        $budgetData = json_decode('[{"budget_type":"1","budget_status":"1","period_start":[{"date":"2016-12-02"}],"period_end":[{"date":"2016-12-02"}],"budget_value":""}]', true);

        $this->test_level_one_multi_dimensional_element_incomplete($this->element, $budgetData);
    }

    public function test_budget_sub_element_no_budget_value_key()
    {
        $budgetData = json_decode('[{"budget_type":"1","budget_status":"1","period_start":[{"date":"2016-12-02"}],"period_end":[{"date":"2016-12-02"}]}]', true);

        $this->test_level_one_multi_dimensional_element_incomplete($this->element, $budgetData);
    }

    public function test_budget_sub_element_empty_budget_value_array()
    {
        $budgetData = json_decode('[{"budget_type":"1","budget_status":"1","period_start":[{"date":"2016-12-02"}],"period_end":[{"date":"2016-12-02"}],"budget_value":[]}]', true);

        $this->test_level_one_multi_dimensional_element_incomplete($this->element, $budgetData);
    }

    public function test_budget_sub_element_empty_budget_value_json_array()
    {
        $budgetData = json_decode('[{"budget_type":"1","budget_status":"1","period_start":[{"date":"2016-12-02"}],"period_end":[{"date":"2016-12-02"}],"budget_value":[{}]}]', true);

        $this->test_level_one_multi_dimensional_element_incomplete($this->element, $budgetData);
    }

    public function test_budget_sub_element_budget_value_empty_attribute_value_date()
    {
        $budgetData = json_decode('[{"budget_type":"1","budget_status":"1","period_start":[{"date":"2016-12-02"}],"period_end":[{"date":"2016-12-02"}],"budget_value":[{"amount":"100","currency":"AFN","value_date":""}]}]', true);

        $this->test_level_one_multi_dimensional_element_incomplete($this->element, $budgetData);
    }

    public function test_budget_sub_element_budget_value_no_attribute_value_date()
    {
        $budgetData = json_decode('[{"budget_type":"1","budget_status":"1","period_start":[{"date":"2016-12-02"}],"period_end":[{"date":"2016-12-02"}],"budget_value":[{"amount":"100","currency":"AFN"}]}]', true);

        $this->test_level_one_multi_dimensional_element_incomplete($this->element, $budgetData);
    }

    public function test_budget_element_complete()
    {
        $budgetData = json_decode('[{"budget_type":"1","budget_status":"1","period_start":[{"date":"2016-10-18"}],"period_end":[{"date":"2016-12-02"}],"budget_value":[{"amount":"100","currency":"AFN","value_date":"2022-07-27"}]},{"budget_type":"2","budget_status":"2","period_start":[{"date":"2022-07-20"}],"period_end":[{"date":"2022-07-29"}],"budget_value":[{"amount":"4444","currency":"AFN","value_date":"2022-08-04"}]}]', true);

        $this->test_level_one_multi_dimensional_element_complete($this->element, $budgetData);
    }
}
