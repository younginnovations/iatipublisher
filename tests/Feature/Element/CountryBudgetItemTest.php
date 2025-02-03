<?php

declare(strict_types=1);

namespace Tests\Feature\Element;

use App\IATI\Models\Activity\Activity;
use Illuminate\Support\Arr;
use Tests\Traits\FilterMandatoryItemsTrait;

/**
 * Class CountryBudgetItemTest.
 */
class CountryBudgetItemTest extends ElementCompleteTest
{
    use FilterMandatoryItemsTrait;

    /**
     * Element country_budget_items.
     *
     * @var string
     */
    private string $element = 'country_budget_items';

    /**
     * @var array|string[]
     */
    private array $mandatorySubelements = ['sub_elements.budget_item.attributes.code.criteria' => 'mandatory'];

    /**
     * @var array|string[]
     */
    private array $mandatoryAttributes = ['attributes.country_budget_vocabulary.criteria' => 'mandatory'];

    /**
     * Test for ensuring mandatory attributes have not changed since the time of writing this test.
     *
     * @return void
     *
     * @throws \JsonException
     */
    public function test_contact_info_mandatory_attributes_have_not_changed(): void
    {
        $countryBudgetItemSchema = Arr::get(readElementJsonSchema(), $this->element, []);
        $countryBudgetItemFlattened = flattenArrayWithKeys($countryBudgetItemSchema);
        $countryBudgetItemFlattened = getItemsWhereKeyContains($countryBudgetItemFlattened, '.criteria');
        $mandatoryItemsInSchema = array_filter(
            $countryBudgetItemFlattened,
            fn ($item) => !empty($item) && $item == 'mandatory'
        );

        $this->unsetMandatorySubelements($mandatoryItemsInSchema);

        $this->assertEquals($mandatoryItemsInSchema, $this->mandatoryAttributes);
    }

    /**
     * Test for ensuring mandatory subelements have not changed since the time of writing this test.
     *
     * @return void
     *
     * @throws \JsonException
     */
    public function test_contact_info_subelements_have_not_changed(): void
    {
        $countryBudgetItemSchema = Arr::get(readElementJsonSchema(), $this->element, []);
        $countryBudgetItemFlattened = flattenArrayWithKeys($countryBudgetItemSchema);
        $countryBudgetItemFlattened = getItemsWhereKeyContains($countryBudgetItemFlattened, '.criteria');
        $mandatoryItemsInSchema = array_filter(
            $countryBudgetItemFlattened,
            fn ($item) => !empty($item) && $item == 'mandatory'
        );

        $this->unsetMandatoryAttributes($mandatoryItemsInSchema);

        $this->assertEquals($mandatoryItemsInSchema, $this->mandatorySubelements);
    }

    /**
     * Test for ensuring the contact info is not complete with null value.
     *
     * @return void
     *
     * @throws \JsonException
     */
    public function test_contact_info_is_not_complete_in_empty_null(): void
    {
        $actualData = null;
        $activity = new Activity();
        $activity->country_budget_items = $actualData;

        $this->assertFalse($this->elementCompleteService->isCountryBudgetItemsElementCompleted($activity));
    }

    /**
     * Test for ensuring the contact info is not complete with empty array as value.
     *
     * @return void
     *
     * @throws \JsonException
     */
    public function test_contact_info_is_not_complete_in_empty_array(): void
    {
        $actualData = [];
        $activity = new Activity();
        $activity->country_budget_items = $actualData;

        $this->assertFalse($this->elementCompleteService->isCountryBudgetItemsElementCompleted($activity));
    }

    /**
     * Test for ensuring the contact info is not complete with empty json array as value.
     *
     * @return void
     *
     * @throws \JsonException
     */
    public function test_contact_info_is_not_complete_in_empty_json_array(): void
    {
        $actualData = json_decode('[{}]');
        $activity = new Activity();
        $activity->country_budget_items = $actualData;

        $this->assertFalse($this->elementCompleteService->isCountryBudgetItemsElementCompleted($activity));
    }

    /**
     * Test for ensuring the contact info is not complete when country budget vocabulary key is missing.
     *
     * @return void
     *
     * @throws \JsonException
     */
    public function test_country_budget_item_incomplete_when_country_budget_vocab_key_missing(): void
    {
        $actualData = json_decode(
            '{"budget_item":[{"code":null,"percentage":null,"description":[{"narrative":[{"narrative":null,"language":null}]}]}]}',
            true,
            512,
            JSON_THROW_ON_ERROR
        );

        $activity = new Activity();
        $activity->country_budget_items = $actualData;

        $this->assertFalse($this->elementCompleteService->isCountryBudgetItemsElementCompleted($activity));
    }

    /**
     * Test for ensuring the contact info is not complete when budget item key is missing.
     *
     * @return void
     * @throws \JsonException
     */
    public function test_country_budget_item_incomplete_when_budget_item_key_missing(): void
    {
        $actualData = json_decode(
            '{"country_budget_vocabulary":null}',
            true,
            512,
            JSON_THROW_ON_ERROR
        );

        $activity = new Activity();
        $activity->country_budget_items = $actualData;

        $this->assertFalse($this->elementCompleteService->isCountryBudgetItemsElementCompleted($activity));
    }

    /**
     * Test for ensuring the contact info is not complete when all values are null.
     *
     * @return void
     * @throws \JsonException
     */
    public function test_country_budget_item_incomplete_when_all_null(): void
    {
        $actualData = json_decode(
            '{"country_budget_vocabulary":null,"budget_item":[{"code":null,"percentage":null,"description":[{"narrative":[{"narrative":null,"language":null}]}]}]}',
            true,
            512,
            JSON_THROW_ON_ERROR
        );

        $activity = new Activity();
        $activity->country_budget_items = $actualData;

        $this->assertFalse($this->elementCompleteService->isCountryBudgetItemsElementCompleted($activity));
    }

    /**
     * Test for ensuring the contact info is not complete when only country budget vocab is filled.
     *
     * @return void
     *
     * @throws \JsonException
     */
    public function test_country_budget_item_incomplete_when_only_attribute_is_filled(): void
    {
        $actualData = json_decode(
            '{"country_budget_vocabulary":"2","budget_item":[{"code":null,"percentage":null,"description":[{"narrative":[{"narrative":null,"language":null}]}]}]}',
            true,
            512,
            JSON_THROW_ON_ERROR
        );

        $activity = new Activity();
        $activity->country_budget_items = $actualData;

        $this->assertFalse($this->elementCompleteService->isCountryBudgetItemsElementCompleted($activity));
    }

    /**
     * Test for ensuring the contact info is not complete when all mandatory empty string.
     *
     * @return void
     * @throws \JsonException
     */
    public function test_country_budget_items_when_all_mandatory_fields_are_empty_string(): void
    {
        $actualData = json_decode(
            '{"country_budget_vocabulary":"","budget_item":[{"code":"","percentage":null,"description":[{"narrative":[{"narrative":null,"language":null}]}]}]}',
            true,
            512,
            JSON_THROW_ON_ERROR
        );

        $activity = new Activity();
        $activity->country_budget_items = $actualData;

        $this->assertFalse($this->elementCompleteService->isCountryBudgetItemsElementCompleted($activity));
    }

    /**
     * Test for ensuring the contact info is not complete when some mandatory empty string.
     *
     * @return void
     * @throws \JsonException
     */
    public function test_country_budget_items_when_some_mandatory_fields_are_empty_string(): void
    {
        $actualData = json_decode(
            '{"country_budget_vocabulary":"2","budget_item":[{"code":"","percentage":null,"description":[{"narrative":[{"narrative":null,"language":null}]}]}]}',
            true,
            512,
            JSON_THROW_ON_ERROR
        );

        $activity = new Activity();
        $activity->country_budget_items = $actualData;

        $this->assertFalse($this->elementCompleteService->isCountryBudgetItemsElementCompleted($activity));
    }

    /**
     * Test for ensuring the contact info is complete when mandatory fields are filled + percentage is null.
     *
     * @return void
     * @throws \JsonException
     */
    public function test_country_budget_items_when_mandatory_fields_are_filled_and_percentage_is_null(): void
    {
        $actualData = json_decode(
            '{"country_budget_vocabulary":"2","budget_item":[{"code":"1.2.1","percentage":null,"description":[{"narrative":[{"narrative":null,"language":null}]}]}]}',
            true,
            512,
            JSON_THROW_ON_ERROR
        );

        $activity = new Activity();
        $activity->country_budget_items = $actualData;

        $this->assertTrue($this->elementCompleteService->isCountryBudgetItemsElementCompleted($activity));
    }

    /**
     * Test for ensuring the contact info is complete when mandatory fields are filled + percentage is 100.
     *
     * @return void
     *
     * @throws \JsonException
     */
    public function test_country_budget_items_when_mandatory_fields_are_filled_and_percentage_is_100(): void
    {
        $actualData = json_decode(
            '{"country_budget_vocabulary":"2","budget_item":[{"code":"1.2.1","percentage":"100","description":[{"narrative":[{"narrative":null,"language":null}]}]}]}',
            true,
            512,
            JSON_THROW_ON_ERROR
        );

        $activity = new Activity();
        $activity->country_budget_items = $actualData;

        $this->assertTrue($this->elementCompleteService->isCountryBudgetItemsElementCompleted($activity));
    }

    /**
     * Test for ensuring the contact info is not complete when
     * multiple budget item are filled but some of them are incomplete.
     *
     * @return void
     *
     * @throws \JsonException
     */
    public function test_country_budget_items_when_multiple_budget_items_are_filled_with_some_mandatory_fields_not_filled(
    ): void {
        $actualData = json_decode(
            '{"country_budget_vocabulary":"2","budget_item":[{"code":"1.2.1","percentage":"50","description":[{"narrative":[{"narrative":null,"language":null}]}]},{"code":null,"percentage":"50","description":[{"narrative":[{"narrative":null,"language":null}]}]}]}',
            true,
            512,
            JSON_THROW_ON_ERROR
        );

        $activity = new Activity();
        $activity->country_budget_items = $actualData;

        $this->assertFalse($this->elementCompleteService->isCountryBudgetItemsElementCompleted($activity));
    }

    /**
     * Test for ensuring the contact info is not complete when
     * multiple budget item are filled and all their required fields are filled.
     *
     * @return void
     *
     * @throws \JsonException
     */
    public function test_country_budget_items_when_multiple_budget_items_are_filled_with_mandatory_fields_filled(): void
    {
        $actualData = json_decode(
            '{"country_budget_vocabulary":"2","budget_item":[{"code":"1.2.1","percentage":"50","description":[{"narrative":[{"narrative":null,"language":null}]}]},{"code":"1.1.1","percentage":"50","description":[{"narrative":[{"narrative":null,"language":null}]}]}]}',
            true,
            512,
            JSON_THROW_ON_ERROR
        );

        $activity = new Activity();
        $activity->country_budget_items = $actualData;

        $this->assertTrue($this->elementCompleteService->isCountryBudgetItemsElementCompleted($activity));
    }

    /**
     * Test for ensuring the contact info is not complete when
     * multiple budget item are filled and all their required fields are filled.
     *
     * @return void
     *
     * @throws \JsonException
     */
    public function test_country_budget_items_when_multiple_budget_items_are_filled_and_everything_is_filled(): void
    {
        $actualData = json_decode(
            '{"country_budget_vocabulary":"2","budget_item":[{"code":"1.2.1","percentage":"41","description":[{"narrative":[{"narrative":null,"language":null}]}]},{"code":"1.2.1","percentage":"59","description":[{"narrative":[{"narrative":"budget item 2 description","language":"ak"}]}]}]}',
            true,
            512,
            JSON_THROW_ON_ERROR
        );

        $activity = new Activity();
        $activity->country_budget_items = $actualData;

        $this->assertTrue($this->elementCompleteService->isCountryBudgetItemsElementCompleted($activity));
    }
}
