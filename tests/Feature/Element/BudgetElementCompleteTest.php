<?php

namespace Tests\Feature\Element;

/**
 * Class BudgetElementCompleteTest.
 */
class BudgetElementCompleteTest extends ElementCompleteTest
{
    private string $element = 'budget';

    /**
     * Mandatory attribute test.
     *
     * @return void
     * @throws \JsonException
     */
    public function test_budget_mandatory_attributes(): void
    {
        $this->test_mandatory_attributes($this->element, []);
    }

    /**
     * Mandatory sub element test.
     *
     * @return void
     * @throws \JsonException
     */
    public function test_budget_mandatory_sub_elements(): void
    {
        $this->test_mandatory_sub_elements($this->element, ['period_start' => ['date'], 'period_end' => ['date'], 'budget_value' => ['value_date']]);
    }

    /**
     * Empty budget data test.
     *
     * @return void
     * @throws \JsonException
     */
    public function test_budget_empty_data(): void
    {
        $budgetData = '';

        $this->test_level_one_multi_dimensional_element_incomplete($this->element, $budgetData);
    }

    /**
     * Empty budget array test.
     *
     * @return void
     * @throws \JsonException
     */
    public function test_budget_empty_array(): void
    {
        $budgetData = json_decode('[]', true, 512, JSON_THROW_ON_ERROR);

        $this->test_level_one_multi_dimensional_element_incomplete($this->element, $budgetData);
    }

    /**
     * Empty budget json array test.
     *
     * @return void
     * @throws \JsonException
     */
    public function test_budget_empty_json_array(): void
    {
        $budgetData = json_decode('[{}]', true, 512, JSON_THROW_ON_ERROR);

        $this->test_level_one_multi_dimensional_element_incomplete($this->element, $budgetData);
    }

    /**
     * Empty sub element period_start test.
     *
     * @return void
     * @throws \JsonException
     */
    public function test_budget_sub_element_empty_period_start(): void
    {
        $budgetData = json_decode(
            '[{"budget_type":"1","budget_status":"1","period_start":"","period_end":[{"date":"2016-12-02"}],"budget_value":[{"amount":"100","currency":"AFN","value_date":"2022-07-27"}]}]',
            true,
            512,
            JSON_THROW_ON_ERROR
        );

        $this->test_level_one_multi_dimensional_element_incomplete($this->element, $budgetData);
    }

    /**
     * No sub element period_start key test.
     *
     * @return void
     * @throws \JsonException
     */
    public function test_budget_sub_element_no_period_start_key(): void
    {
        $budgetData = json_decode(
            '[{"budget_type":"1","budget_status":"1","period_end":[{"date":"2016-12-02"}],"budget_value":[{"amount":"100","currency":"AFN","value_date":"2022-07-27"}]}]',
            true,
            512,
            JSON_THROW_ON_ERROR
        );

        $this->test_level_one_multi_dimensional_element_incomplete($this->element, $budgetData);
    }

    /**
     * Empty sub element period_start array test.
     *
     * @return void
     * @throws \JsonException
     */
    public function test_budget_sub_element_empty_period_start_array(): void
    {
        $budgetData = json_decode(
            '[{"budget_type":"1","budget_status":"1","period_start":[],"period_end":[{"date":"2016-12-02"}],"budget_value":[{"amount":"100","currency":"AFN","value_date":"2022-07-27"}]}]',
            true,
            512,
            JSON_THROW_ON_ERROR
        );

        $this->test_level_one_multi_dimensional_element_incomplete($this->element, $budgetData);
    }

    /**
     * Empty sub element period_start json array test.
     *
     * @return void
     * @throws \JsonException
     */
    public function test_budget_sub_element_empty_period_start_json_array(): void
    {
        $budgetData = json_decode(
            '[{"budget_type":"1","budget_status":"1","period_start":[{}],"period_end":[{"date":"2016-12-02"}],"budget_value":[{"amount":"100","currency":"AFN","value_date":"2022-07-27"}]}]',
            true,
            512,
            JSON_THROW_ON_ERROR
        );

        $this->test_level_one_multi_dimensional_element_incomplete($this->element, $budgetData);
    }

    /**
     * Sub element period_start empty attribute date test.
     *
     * @return void
     * @throws \JsonException
     */
    public function test_budget_sub_element_period_start_empty_attribute_date(): void
    {
        $budgetData = json_decode(
            '[{"budget_type":"1","budget_status":"1","period_start":[{"date":""}],"period_end":[{"date":"2016-12-02"}],"budget_value":[{"amount":"100","currency":"AFN","value_date":"2022-07-27"}]}]',
            true,
            512,
            JSON_THROW_ON_ERROR
        );

        $this->test_level_one_multi_dimensional_element_incomplete($this->element, $budgetData);
    }

    /**
     * Empty sub element period_end data test.
     *
     * @return void
     * @throws \JsonException
     */
    public function test_budget_sub_element_empty_period_end(): void
    {
        $budgetData = json_decode(
            '[{"budget_type":"1","budget_status":"1","period_start":[{"date":"2016-12-02"}],"period_end":"","budget_value":[{"amount":"100","currency":"AFN","value_date":"2022-07-27"}]}]',
            true,
            512,
            JSON_THROW_ON_ERROR
        );

        $this->test_level_one_multi_dimensional_element_incomplete($this->element, $budgetData);
    }

    /**
     * No sub element period_end key test.
     *
     * @return void
     * @throws \JsonException
     */
    public function test_budget_sub_element_no_period_end_key(): void
    {
        $budgetData = json_decode(
            '[{"budget_type":"1","budget_status":"1","period_start":[{"date":"2016-12-02"}],"budget_value":[{"amount":"100","currency":"AFN","value_date":"2022-07-27"}]}]',
            true,
            512,
            JSON_THROW_ON_ERROR
        );

        $this->test_level_one_multi_dimensional_element_incomplete($this->element, $budgetData);
    }

    /**
     * Empty sub element period_end array test.
     *
     * @return void
     * @throws \JsonException
     */
    public function test_budget_sub_element_empty_period_end_array(): void
    {
        $budgetData = json_decode(
            '[{"budget_type":"1","budget_status":"1","period_start":[{"date":"2016-12-02"}],"period_end":[],"budget_value":[{"amount":"100","currency":"AFN","value_date":"2022-07-27"}]}]',
            true,
            512,
            JSON_THROW_ON_ERROR
        );

        $this->test_level_one_multi_dimensional_element_incomplete($this->element, $budgetData);
    }

    /**
     * Empty sub element period_end json array test.
     *
     * @return void
     * @throws \JsonException
     */
    public function test_budget_sub_element_empty_period_end_json_array(): void
    {
        $budgetData = json_decode(
            '[{"budget_type":"1","budget_status":"1","period_start":[{"date":"2016-12-02"}],"period_end":[{}],"budget_value":[{"amount":"100","currency":"AFN","value_date":"2022-07-27"}]}]',
            true,
            512,
            JSON_THROW_ON_ERROR
        );

        $this->test_level_one_multi_dimensional_element_incomplete($this->element, $budgetData);
    }

    /**
     * Sub element period_end empty attribute date test.
     *
     * @return void
     * @throws \JsonException
     */
    public function test_budget_sub_element_period_end_empty_attribute_date(): void
    {
        $budgetData = json_decode(
            '[{"budget_type":"1","budget_status":"1","period_start":[{"date":"2016-12-02"}],"period_end":[{"date":""}],"budget_value":[{"amount":"100","currency":"AFN","value_date":"2022-07-27"}]}]',
            true,
            512,
            JSON_THROW_ON_ERROR
        );

        $this->test_level_one_multi_dimensional_element_incomplete($this->element, $budgetData);
    }

    /**
     * Sub element budget_value empty data test.
     *
     * @return void
     * @throws \JsonException
     */
    public function test_budget_sub_element_empty_budget_value(): void
    {
        $budgetData = json_decode(
            '[{"budget_type":"1","budget_status":"1","period_start":[{"date":"2016-12-02"}],"period_end":[{"date":"2016-12-02"}],"budget_value":""}]',
            true,
            512,
            JSON_THROW_ON_ERROR
        );

        $this->test_level_one_multi_dimensional_element_incomplete($this->element, $budgetData);
    }

    /**
     * No sub element budget_value key test.
     *
     * @return void
     * @throws \JsonException
     */
    public function test_budget_sub_element_no_budget_value_key(): void
    {
        $budgetData = json_decode('[{"budget_type":"1","budget_status":"1","period_start":[{"date":"2016-12-02"}],"period_end":[{"date":"2016-12-02"}]}]', true, 512, JSON_THROW_ON_ERROR);

        $this->test_level_one_multi_dimensional_element_incomplete($this->element, $budgetData);
    }

    /**
     * Empty sub element budget_value array test.
     *
     * @return void
     * @throws \JsonException
     */
    public function test_budget_sub_element_empty_budget_value_array(): void
    {
        $budgetData = json_decode(
            '[{"budget_type":"1","budget_status":"1","period_start":[{"date":"2016-12-02"}],"period_end":[{"date":"2016-12-02"}],"budget_value":[]}]',
            true,
            512,
            JSON_THROW_ON_ERROR
        );

        $this->test_level_one_multi_dimensional_element_incomplete($this->element, $budgetData);
    }

    /**
     * Empty sub element budget_value json array test.
     *
     * @return void
     * @throws \JsonException
     */
    public function test_budget_sub_element_empty_budget_value_json_array(): void
    {
        $budgetData = json_decode(
            '[{"budget_type":"1","budget_status":"1","period_start":[{"date":"2016-12-02"}],"period_end":[{"date":"2016-12-02"}],"budget_value":[{}]}]',
            true,
            512,
            JSON_THROW_ON_ERROR
        );

        $this->test_level_one_multi_dimensional_element_incomplete($this->element, $budgetData);
    }

    /**
     * Sub element budget_value empty attribute value_date test.
     *
     * @return void
     * @throws \JsonException
     */
    public function test_budget_sub_element_budget_value_empty_attribute_value_date(): void
    {
        $budgetData = json_decode(
            '[{"budget_type":"1","budget_status":"1","period_start":[{"date":"2016-12-02"}],"period_end":[{"date":"2016-12-02"}],"budget_value":[{"amount":"100","currency":"AFN","value_date":""}]}]',
            true,
            512,
            JSON_THROW_ON_ERROR
        );

        $this->test_level_one_multi_dimensional_element_incomplete($this->element, $budgetData);
    }

    /**
     * Sub element budget_value no attribute value_date key test.
     *
     * @return void
     * @throws \JsonException
     */
    public function test_budget_sub_element_budget_value_no_attribute_value_date(): void
    {
        $budgetData = json_decode(
            '[{"budget_type":"1","budget_status":"1","period_start":[{"date":"2016-12-02"}],"period_end":[{"date":"2016-12-02"}],"budget_value":[{"amount":"100","currency":"AFN"}]}]',
            true,
            512,
            JSON_THROW_ON_ERROR
        );

        $this->test_level_one_multi_dimensional_element_incomplete($this->element, $budgetData);
    }

    /**
     * Budget data complete test.
     *
     * @return void
     * @throws \JsonException
     */
    public function test_budget_element_complete(): void
    {
        $budgetData = json_decode(
            '[{"budget_type":"1","budget_status":"1","period_start":[{"date":"2016-10-18"}],"period_end":[{"date":"2016-12-02"}],"budget_value":[{"amount":"100","currency":"AFN","value_date":"2022-07-27"}]},{"budget_type":"2","budget_status":"2","period_start":[{"date":"2022-07-20"}],"period_end":[{"date":"2022-07-29"}],"budget_value":[{"amount":"4444","currency":"AFN","value_date":"2022-08-04"}]}]',
            true,
            512,
            JSON_THROW_ON_ERROR
        );

        $this->test_level_one_multi_dimensional_element_complete($this->element, $budgetData);
    }
}
