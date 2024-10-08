<?php

declare(strict_types=1);

namespace Tests\Feature\Element;

/**
 * Class CountryBudgetItemTest.
 */
class CountryBudgetItemTest extends ElementCompleteTest
{
    /**
     * Element country_budget_items.
     *
     * @var string
     */
    private string $element = 'country_budget_items';

    /**
     * Mandatory attribute test.
     *
     * @return void
     * @throws \JsonException
     */
    public function test_country_budget_items_mandatory_attributes(): void
    {
        $this->test_mandatory_attributes($this->element, ['country_budget_vocabulary']);
    }

    /**
     * Mandatory sub element test.
     *
     * @return void
     * @throws \JsonException
     */
    public function test_country_budget_items_mandatory_sub_elements(): void
    {
        $this->test_mandatory_sub_elements($this->element, ['budget_item' => ['code']]);
    }

    /**
     * Empty all element test.
     *
     * @return void
     * @throws \JsonException
     */
    public function test_country_budget_items_all_empty(): void
    {
        $actualData = json_decode(
            '{"country_budget_vocabulary":"","budget_item":[{"code":"","percentage":"50","description":[{"narrative":[{"narrative":"","language":"aa"}]}]}]}',
            true,
            512,
            JSON_THROW_ON_ERROR
        );

        $this->test_level_three_single_dimensional_element_incomplete($this->element, $actualData);
    }

    /**
     * Attribute country_budget_vocabulary empty test.
     *
     * @return void
     * @throws \JsonException
     */
    public function test_country_budget_items_attribute_empty_country_budget_vocabulary(): void
    {
        $actualData = json_decode(
            '{"country_budget_vocabulary":"","budget_item":[{"code":"12","percentage":"50","description":[{"narrative":[{"narrative":"asdas","language":"aa"}]}]}]}',
            true,
            512,
            JSON_THROW_ON_ERROR
        );

        $this->test_level_three_single_dimensional_element_incomplete($this->element, $actualData);
    }

    /**
     * Sub element budget_item empty data test.
     *
     * @return void
     * @throws \JsonException
     */
    public function test_country_budget_items_sub_element_empty_budget_item(): void
    {
        $actualData = json_decode('{"country_budget_vocabulary":"2","budget_item":""}', true, 512, JSON_THROW_ON_ERROR);

        $this->test_level_three_single_dimensional_element_incomplete($this->element, $actualData);
    }

    /**
     * Sub element budget_item empty array test.
     *
     * @return void
     * @throws \JsonException
     */
    public function test_country_budget_items_sub_element_empty_budget_item_array(): void
    {
        $actualData = json_decode('{"country_budget_vocabulary":"2","budget_item":[]}', true, 512, JSON_THROW_ON_ERROR);

        $this->test_level_three_single_dimensional_element_incomplete($this->element, $actualData);
    }

    /**
     * Sub element budget_item empty json array test.
     *
     * @return void
     * @throws \JsonException
     */
    public function test_country_budget_items_sub_element_empty_budget_item_json_array(): void
    {
        $actualData = json_decode('{"country_budget_vocabulary":"2","budget_item":[{}]}', true, 512, JSON_THROW_ON_ERROR);

        $this->test_level_three_single_dimensional_element_incomplete($this->element, $actualData);
    }

    /**
     * Sub element budget_item attribute empty code test.
     *
     * @return void
     * @throws \JsonException
     */
    public function test_country_budget_items_sub_element_budget_item_attribute_empty_code(): void
    {
        $actualData = json_decode(
            '{"country_budget_vocabulary":"2","budget_item":[{"code":"","percentage":"50","description":[{"narrative":[{"narrative":"asdas","language":"aa"}]}]}]}',
            true,
            512,
            JSON_THROW_ON_ERROR
        );

        $this->test_level_three_single_dimensional_element_incomplete($this->element, $actualData);
    }

    /**
     * Sub element budget_item sub element empty description test.
     *
     * @return void
     * @throws \JsonException
     */
    public function test_country_budget_items_sub_element_budget_item_sub_element_empty_description(): void
    {
        $actualData = json_decode('{"country_budget_vocabulary":"2","budget_item":[{"code":"123","percentage":"50","description":""}]}', true, 512, JSON_THROW_ON_ERROR);

        $this->test_level_three_single_dimensional_element_incomplete($this->element, $actualData);
    }

    /**
     * Sub element budget_item sub element empty description array test.
     *
     * @return void
     * @throws \JsonException
     */
    public function test_country_budget_items_sub_element_budget_item_sub_element_empty_description_array(): void
    {
        $actualData = json_decode('{"country_budget_vocabulary":"2","budget_item":[{"code":"123","percentage":"50","description":[]}]}', true, 512, JSON_THROW_ON_ERROR);

        $this->test_level_three_single_dimensional_element_incomplete($this->element, $actualData);
    }

    /**
     * Sub element budget_item sub element empty description json array test.
     *
     * @return void
     * @throws \JsonException
     */
    public function test_country_budget_items_sub_element_budget_item_sub_element_empty_description_json_array(): void
    {
        $actualData = json_decode('{"country_budget_vocabulary":"2","budget_item":[{"code":"123","percentage":"50","description":[{}]}]}', true, 512, JSON_THROW_ON_ERROR);

        $this->test_level_three_single_dimensional_element_incomplete($this->element, $actualData);
    }

    /**
     * Sub element budget_item sub element description empty narrative test.
     *
     * @return void
     * @throws \JsonException
     */
    public function test_country_budget_items_sub_element_budget_item_sub_element_description_empty_narrative(): void
    {
        $actualData = json_decode('{"country_budget_vocabulary":"2","budget_item":[{"code":"123","percentage":"50","description":[{"narrative":""}]}]}', true, 512, JSON_THROW_ON_ERROR);

        $this->test_level_three_single_dimensional_element_incomplete($this->element, $actualData);
    }

    /**
     * Sub element budget_item sub element description empty narrative array test.
     *
     * @return void
     * @throws \JsonException
     */
    public function test_country_budget_items_sub_element_budget_item_sub_element_description_empty_narrative_array(): void
    {
        $actualData = json_decode('{"country_budget_vocabulary":"2","budget_item":[{"code":"123","percentage":"50","description":[{"narrative":[]}]}]}', true, 512, JSON_THROW_ON_ERROR);

        $this->test_level_three_single_dimensional_element_incomplete($this->element, $actualData);
    }

    /**
     * Sub element budget_item sub element description empty narrative json array test.
     *
     * @return void
     * @throws \JsonException
     */
    public function test_country_budget_items_sub_element_budget_item_sub_element_description_empty_narrative_json_array(): void
    {
        $actualData = json_decode('{"country_budget_vocabulary":"2","budget_item":[{"code":"123","percentage":"50","description":[{"narrative":[{}]}]}]}', true, 512, JSON_THROW_ON_ERROR);

        $this->test_level_three_single_dimensional_element_incomplete($this->element, $actualData);
    }

    /**
     * Sub element budget_item sub element description no narrative key test.
     *
     * @return void
     * @throws \JsonException
     */
    public function test_country_budget_items_sub_element_budget_item_sub_element_description_sub_element_narrative_no_narrative_key(): void
    {
        $actualData = json_decode(
            '{"country_budget_vocabulary":"2","budget_item":[{"code":"123","percentage":"50","description":[{"narrative":[{"language":"en"}]}]}]}',
            true,
            512,
            JSON_THROW_ON_ERROR
        );

        $this->test_level_three_single_dimensional_element_incomplete($this->element, $actualData);
    }

    /**
     * Sub element budget_item sub element description empty narrative test.
     *
     * @return void
     * @throws \JsonException
     */
    public function test_country_budget_items_sub_element_budget_item_sub_element_description_sub_element_narrative_empty_narrative(): void
    {
        $actualData = json_decode(
            '{"country_budget_vocabulary":"2","budget_item":[{"code":"123","percentage":"50","description":[{"narrative":[{"narrative":"","language":"en"}]}]}]}',
            true,
            512,
            JSON_THROW_ON_ERROR
        );

        $this->test_level_three_single_dimensional_element_incomplete($this->element, $actualData);
    }

    /**
     * Country Budget Items element complete test.
     *
     * @return void
     * @throws \JsonException
     */
    public function test_country_budget_items_element_complete(): void
    {
        $actualData = json_decode(
            '{"country_budget_vocabulary":"2","budget_item":[{"code":"asdasd","percentage":"50","description":[{"narrative":[{"narrative":"asdas","language":"aa"}]}]},{"code":"asdad","percentage":"50","description":[{"narrative":[{"narrative":"asdadasddad","language":"ae"}]}]}]}',
            true,
            512,
            JSON_THROW_ON_ERROR
        );

        $this->test_level_three_single_dimensional_element_complete($this->element, $actualData);
    }
}
