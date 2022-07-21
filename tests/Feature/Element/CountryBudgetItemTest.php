<?php

namespace Tests\Feature\Element;

class CountryBudgetItemTest extends ElementCompleteTest
{
    private string $element = 'country_budget_items';

    public function __construct(?string $name = null, array $data = [], $dataName = '')
    {
        parent::__construct($name, $data, $dataName);

        $this->activityObj->element = $this->element;
    }

    public function test_country_budget_items_element_complete()
    {
        $actualData = json_decode('{"country_budget_vocabulary":"2","budget_item":[{"code_text":"7689","code":null,"percentage":"100","description":[{"narrative":[{"narrative":"test","language":"ab"},{"narrative":"test 2","language":"ae"}]}]},{"code_text":"5","code":null,"percentage":"0","description":[{"narrative":[{"narrative":"test","language":"af"}]}]}]}', true);

        $this->test_level_three_single_dimensional_element_complete($this->element, $actualData);
    }
}
