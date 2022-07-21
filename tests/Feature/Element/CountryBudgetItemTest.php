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

    public function test_country_budget_items_mandatory_attributes()
    {
        $this->test_mandatory_attributes($this->element, ['country_budget_vocabulary']);
    }

    public function test_country_budget_items_mandatory_sub_elements()
    {
        $this->test_mandatory_sub_elements($this->element, ['budget_item' => ['code_text', 'code']]);
    }

    public function test_country_budget_items_all_empty()
    {
        $actualData = json_decode('{"country_budget_vocabulary":"","budget_item":[{"code_text":"","code":"","percentage":"50","description":[{"narrative":[{"narrative":"","language":"aa"}]}]}]}', true);

        $this->test_level_three_single_dimensional_element_incomplete($this->element, $actualData);
    }

    public function test_country_budget_items_attribute_no_country_budget_vocabulary_key()
    {
        $actualData = json_decode('{"budget_item":[{"code_text":"asd","code":"12","percentage":"50","description":[{"narrative":[{"narrative":"asdas","language":"aa"}]}]}]}', true);

        $this->test_level_three_single_dimensional_element_incomplete($this->element, $actualData);
    }

    public function test_country_budget_items_attribute_empty_country_budget_vocabulary()
    {
        $actualData = json_decode('{"country_budget_vocabulary":"","budget_item":[{"code_text":"asd","code":"12","percentage":"50","description":[{"narrative":[{"narrative":"asdas","language":"aa"}]}]}]}', true);

        $this->test_level_three_single_dimensional_element_incomplete($this->element, $actualData);
    }

    public function test_country_budget_items_sub_element_empty_budget_item()
    {
        $actualData = json_decode('{"country_budget_vocabulary":"2","budget_item":""}', true);

        $this->test_level_three_single_dimensional_element_incomplete($this->element, $actualData);
    }

    public function test_country_budget_items_sub_element_empty_budget_item_array()
    {
        $actualData = json_decode('{"country_budget_vocabulary":"2","budget_item":[]}', true);

        $this->test_level_three_single_dimensional_element_incomplete($this->element, $actualData);
    }

    public function test_country_budget_items_sub_element_empty_budget_item_json_array()
    {
        $actualData = json_decode('{"country_budget_vocabulary":"2","budget_item":[{}]}', true);

        $this->test_level_three_single_dimensional_element_incomplete($this->element, $actualData);
    }

    public function test_country_budget_items_sub_element_budget_item_attribute_no_code_text_key()
    {
        $actualData = json_decode('{"country_budget_vocabulary":"2","budget_item":[{"code":"asd","percentage":"50","description":[{"narrative":[{"narrative":"asdas","language":"aa"}]}]}]}', true);

        $this->test_level_three_single_dimensional_element_incomplete($this->element, $actualData);
    }

    public function test_country_budget_items_sub_element_budget_item_attribute_empty_code_text()
    {
        $actualData = json_decode('{"country_budget_vocabulary":"2","budget_item":[{"code_text":"","code":"asd","percentage":"50","description":[{"narrative":[{"narrative":"asdas","language":"aa"}]}]}]}', true);

        $this->test_level_three_single_dimensional_element_incomplete($this->element, $actualData);
    }

    public function test_country_budget_items_sub_element_budget_item_attribute_no_code_key()
    {
        $actualData = json_decode(
            '{"country_budget_vocabulary":"2","budget_item":[{"code_text":"asd","percentage":"50","description":[{"narrative":[{"narrative":"asdas","language":"aa"}]}]}]}',
            true
        );

        $this->test_level_three_single_dimensional_element_incomplete($this->element, $actualData);
    }

    public function test_country_budget_items_sub_element_budget_item_attribute_empty_code()
    {
        $actualData = json_decode('{"country_budget_vocabulary":"2","budget_item":[{"code_text":"asd","code":"","percentage":"50","description":[{"narrative":[{"narrative":"asdas","language":"aa"}]}]}]}', true);

        $this->test_level_three_single_dimensional_element_incomplete($this->element, $actualData);
    }

    public function test_country_budget_items_sub_element_budget_item_sub_element_empty_description()
    {
        $actualData = json_decode('{"country_budget_vocabulary":"2","budget_item":[{"code_text":"asd","code":"123","percentage":"50","description":""}]}', true);

        $this->test_level_three_single_dimensional_element_incomplete($this->element, $actualData);
    }

    public function test_country_budget_items_sub_element_budget_item_sub_element_empty_description_array()
    {
        $actualData = json_decode('{"country_budget_vocabulary":"2","budget_item":[{"code_text":"asd","code":"123","percentage":"50","description":[]}]}', true);

        $this->test_level_three_single_dimensional_element_incomplete($this->element, $actualData);
    }

    public function test_country_budget_items_sub_element_budget_item_sub_element_empty_description_json_array()
    {
        $actualData = json_decode('{"country_budget_vocabulary":"2","budget_item":[{"code_text":"asd","code":"123","percentage":"50","description":[{}]}]}', true);

        $this->test_level_three_single_dimensional_element_incomplete($this->element, $actualData);
    }

    public function test_country_budget_items_sub_element_budget_item_sub_element_description_empty_narrative()
    {
        $actualData = json_decode('{"country_budget_vocabulary":"2","budget_item":[{"code_text":"asd","code":"123","percentage":"50","description":[{"narrative":""}]}]}', true);

        $this->test_level_three_single_dimensional_element_incomplete($this->element, $actualData);
    }

    public function test_country_budget_items_sub_element_budget_item_sub_element_description_empty_narrative_array()
    {
        $actualData = json_decode('{"country_budget_vocabulary":"2","budget_item":[{"code_text":"asd","code":"123","percentage":"50","description":[{"narrative":[]}]}]}', true);

        $this->test_level_three_single_dimensional_element_incomplete($this->element, $actualData);
    }

    public function test_country_budget_items_sub_element_budget_item_sub_element_description_empty_narrative_json_array()
    {
        $actualData = json_decode('{"country_budget_vocabulary":"2","budget_item":[{"code_text":"asd","code":"123","percentage":"50","description":[{"narrative":[{}]}]}]}', true);

        $this->test_level_three_single_dimensional_element_incomplete($this->element, $actualData);
    }

    public function test_country_budget_items_sub_element_budget_item_sub_element_description_sub_element_narrative_no_narrative_key()
    {
        $actualData = json_decode(
            '{"country_budget_vocabulary":"2","budget_item":[{"code_text":"asd","code":"123","percentage":"50","description":[{"narrative":[{"language":"en"}]}]}]}',
            true
        );

        $this->test_level_three_single_dimensional_element_incomplete($this->element, $actualData);
    }

    public function test_country_budget_items_sub_element_budget_item_sub_element_description_sub_element_narrative_empty_narrative()
    {
        $actualData = json_decode(
            '{"country_budget_vocabulary":"2","budget_item":[{"code_text":"asd","code":"123","percentage":"50","description":[{"narrative":[{"narrative":"","language":"en"}]}]}]}',
            true
        );

        $this->test_level_three_single_dimensional_element_incomplete($this->element, $actualData);
    }

    public function test_country_budget_items_element_complete()
    {
        $actualData = json_decode('{"country_budget_vocabulary":"2","budget_item":[{"code_text":"code text","code":"asdasd","percentage":"50","description":[{"narrative":[{"narrative":"asdas","language":"aa"}]}]},{"code_text":"code-text1","code":"asdad","percentage":"50","description":[{"narrative":[{"narrative":"asdadasddad","language":"ae"}]}]}]}', true);

        $this->test_level_three_single_dimensional_element_complete($this->element, $actualData);
    }
}
