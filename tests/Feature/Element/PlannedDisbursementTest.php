<?php

declare(strict_types=1);

namespace Tests\Feature\Element;

use App\IATI\Models\Activity\Activity;
use Illuminate\Support\Arr;
use Tests\Traits\FilterMandatoryItemsTrait;

/**
 * Class PlannedDisbursementTest.
 */
class PlannedDisbursementTest extends ElementCompleteTest
{
    use FilterMandatoryItemsTrait;

    /**
     * Element planned_disbursement.
     *
     * @var string
     */
    private string $element = 'planned_disbursement';

    /**
     * @var array|string[]
     */
    private array $mandatorySubelements = [
        'sub_elements.period_start.attributes.date.criteria' => 'mandatory',
        'sub_elements.value.attributes.amount.criteria'      => 'mandatory',
        'sub_elements.value.attributes.currency.criteria'    => 'mandatory',
        'sub_elements.value.attributes.value_date.criteria'  => 'mandatory',
    ];

    /**
     * @var array|string[]
     */
    private array $mandatoryAttributes = [];

    /**
     * Mandatory attribute test.
     *
     * @return void
     * @throws \JsonException
     */
    public function test_humanitarian_scope_mandatory_attributes(): void
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
     * Mandatory sub element test.
     *
     * @return void
     * @throws \JsonException
     */
    public function test_humanitarian_scope_mandatory_sub_elements(): void
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

    public function test_planned_disbursement_null_value(): void
    {
        $actualData = null;
        $activity = new Activity();

        $activity->{$this->element} = $actualData;

        $this->assertFalse($this->elementCompleteService->isPlannedDisbursementElementCompleted($activity));
    }

    /**
     * Empty data test.
     *
     * @return void
     * @throws \JsonException
     */
    public function test_planned_disbursement_empty_string(): void
    {
        $actualData = '';
        $activity = new Activity();

        $activity->{$this->element} = $actualData;

        $this->assertFalse($this->elementCompleteService->isPlannedDisbursementElementCompleted($activity));
    }

    /**
     * Empty array test.
     *
     * @return void
     * @throws \JsonException
     */
    public function test_planned_disbursement_empty_array(): void
    {
        $actualData = [];
        $activity = new Activity();
        $activity->{$this->element} = $actualData;

        $this->assertFalse($this->elementCompleteService->isPlannedDisbursementElementCompleted($activity));
    }

    /**
     * Empty json array test.
     *
     * @return void
     * @throws \JsonException
     */
    public function test_planned_disbursement_empty_json_array(): void
    {
        $actualData = json_decode('[{}]');
        $activity = new Activity();
        $activity->{$this->element} = $actualData;

        $this->assertFalse($this->elementCompleteService->isPlannedDisbursementElementCompleted($activity));
    }

    /**
     * Test incomplete when mandatory subelements are null.
     *
     * @return void
     *
     * @throws \JsonException
     */
    public function test_planned_disbursement_incomplete_when_mandatory_subelement_keys_are_null(): void
    {
        $actualData = json_decode(
            '[{"planned_disbursement_type":"1","period_start":null,"period_end":[{"date":"2022-07-27"}],"value":null,"provider_org":[{"ref":"provider-org-ref","provider_activity_id":"123123123","type":"11","narrative":[{"narrative":"asdasdasdads","language":"ab"}]}],"receiver_org":[{"ref":"receiver-org-ref","provider_activity_id":"5555","type":"23","narrative":[{"narrative":"asdasdadasdasd","language":"af"}]}]}]',
            true,
            512,
            JSON_THROW_ON_ERROR
        );
        $activity = new Activity();
        $activity->{$this->element} = $actualData;

        $this->assertFalse($this->elementCompleteService->isPlannedDisbursementElementCompleted($activity));
    }

    /**
     * Test incomplete when mandatory subelements are empty array.
     *
     * @return void
     *
     * @throws \JsonException
     */
    public function test_planned_disbursement_incomplete_when_mandatory_subelement_keys_are_empty_array(): void
    {
        $actualData = json_decode(
            '[{"planned_disbursement_type":"1","period_start":[],"period_end":[{"date":"2022-07-27"}],"value":[],"provider_org":[{"ref":"provider-org-ref","provider_activity_id":"123123123","type":"11","narrative":[{"narrative":"asdasdasdads","language":"ab"}]}],"receiver_org":[{"ref":"receiver-org-ref","provider_activity_id":"5555","type":"23","narrative":[{"narrative":"asdasdadasdasd","language":"af"}]}]}]',
            true,
            512,
            JSON_THROW_ON_ERROR
        );
        $activity = new Activity();
        $activity->{$this->element} = $actualData;

        $this->assertFalse($this->elementCompleteService->isPlannedDisbursementElementCompleted($activity));
    }

    /**
     * Test incomplete when mandatory subelements are null.
     *
     * @return void
     *
     * @throws \JsonException
     */
    public function test_planned_disbursement_incomplete_when_mandatory_subelement_keys_are_null_values(): void
    {
        $actualData = json_decode(
            '[{"planned_disbursement_type":"1","period_start":[{"date":null}],"period_end":[{"date":"2022-07-27"}],"value":[{"amount":null,"currency":null,"value_date":null}],"provider_org":[{"ref":"provider-org-ref","provider_activity_id":"123123123","type":"11","narrative":[{"narrative":"asdasdasdads","language":"ab"}]}],"receiver_org":[{"ref":"receiver-org-ref","provider_activity_id":"5555","type":"23","narrative":[{"narrative":"asdasdadasdasd","language":"af"}]}]}]',
            true,
            512,
            JSON_THROW_ON_ERROR
        );
        $activity = new Activity();
        $activity->{$this->element} = $actualData;

        $this->assertFalse($this->elementCompleteService->isPlannedDisbursementElementCompleted($activity));
    }

    /**
     * Test incomplete when mandatory subelements are missing.
     *
     * @return void
     * @throws \JsonException
     */
    public function test_planned_disbursement_incomplete_when_mandatory_subelement_keys_are_missing(): void
    {
        $actualData = json_decode(
            '[{"planned_disbursement_type":"1","period_end":[{"date":"2022-07-27"}],"provider_org":[{"ref":"provider-org-ref","provider_activity_id":"123123123","type":"11","narrative":[{"narrative":"asdasdasdads","language":"ab"}]}],"receiver_org":[{"ref":"receiver-org-ref","provider_activity_id":"5555","type":"23","narrative":[{"narrative":"asdasdadasdasd","language":"af"}]}]}]',
            true,
            512,
            JSON_THROW_ON_ERROR
        );
        $activity = new Activity();
        $activity->{$this->element} = $actualData;

        $this->assertFalse($this->elementCompleteService->isPlannedDisbursementElementCompleted($activity));
    }

    /**
     * Sub element period_start key missing test.
     *
     * @return void
     * @throws \JsonException
     */
    public function test_planned_disbursement_incomplete_when_period_start_key_is_missing(): void
    {
        $actualData = json_decode(
            '[{"planned_disbursement_type":"1","period_end":[{"date":"2022-07-27"}],"value":[{"amount":"1111","currency":"AOA","value_date":"2022-07-30"}],"provider_org":[{"ref":"provider-org-ref","provider_activity_id":"123123123","type":"11","narrative":[{"narrative":"asdasdasdads","language":"ab"}]}],"receiver_org":[{"ref":"receiver-org-ref","provider_activity_id":"5555","type":"23","narrative":[{"narrative":"asdasdadasdasd","language":"af"}]}]}]',
            true,
            512,
            JSON_THROW_ON_ERROR
        );
        $activity = new Activity();
        $activity->{$this->element} = $actualData;

        $this->assertFalse($this->elementCompleteService->isPlannedDisbursementElementCompleted($activity));
    }

    /**
     * Sub element period_end key missing test.
     *
     * @return void
     * @throws \JsonException
     */
    public function test_planned_disbursement_complete_even_when_period_end_key_is_missing(): void
    {
        $actualData = json_decode(
            '[{"planned_disbursement_type":"1","period_start":[{"date":"2022-07-19"}],"value":[{"amount":"1111","currency":"AOA","value_date":"2022-07-30"}],"provider_org":[{"ref":"provider-org-ref","provider_activity_id":"123123123","type":"11","narrative":[{"narrative":"asdasdasdads","language":"ab"}]}],"receiver_org":[{"ref":"receiver-org-ref","provider_activity_id":"5555","type":"23","narrative":[{"narrative":"asdasdadasdasd","language":"af"}]}]}]',
            true,
            512,
            JSON_THROW_ON_ERROR
        );
        $activity = new Activity();
        $activity->{$this->element} = $actualData;

        $this->assertTrue($this->elementCompleteService->isPlannedDisbursementElementCompleted($activity));
    }

    /**
     * Sub element period_end key missing test.
     *
     * @return void
     * @throws \JsonException
     */
    public function test_planned_disbursement_incomplete_when_value_key_is_missing(): void
    {
        $actualData = json_decode(
            '[{"planned_disbursement_type":"1","period_start":[{"date":"2022-07-19"}],"period_end":[{"date":"2022-07-27"}],"provider_org":[{"ref":"provider-org-ref","provider_activity_id":"123123123","type":"11","narrative":[{"narrative":"asdasdasdads","language":"ab"}]}],"receiver_org":[{"ref":"receiver-org-ref","provider_activity_id":"5555","type":"23","narrative":[{"narrative":"asdasdadasdasd","language":"af"}]}]}]',
            true,
            512,
            JSON_THROW_ON_ERROR
        );
        $activity = new Activity();
        $activity->{$this->element} = $actualData;

        $this->assertFalse($this->elementCompleteService->isPlannedDisbursementElementCompleted($activity));
    }

    /**
     * Sub element provider_org key missing test.
     *
     * @return void
     * @throws \JsonException
     */
    public function test_planned_disbursement_complete_even_when_provider_org_key_is_missing(): void
    {
        $actualData = json_decode(
            '[{"planned_disbursement_type":"1","period_start":[{"date":"2022-07-19"}],"value":[{"amount":"1111","currency":"AOA","value_date":"2022-07-30"}],"receiver_org":[{"ref":"receiver-org-ref","provider_activity_id":"5555","type":"23","narrative":[{"narrative":"asdasdadasdasd","language":"af"}]}]}]',
            true,
            512,
            JSON_THROW_ON_ERROR
        );
        $activity = new Activity();
        $activity->{$this->element} = $actualData;

        $this->assertTrue($this->elementCompleteService->isPlannedDisbursementElementCompleted($activity));
    }

    /**
     * Sub element receiver_org key missing test.
     *
     * @return void
     * @throws \JsonException
     */
    public function test_planned_disbursement_complete_even_when_receiver_org_key_is_missing(): void
    {
        $actualData = json_decode(
            '[{"planned_disbursement_type":"1","period_start":[{"date":"2022-07-19"}],"value":[{"amount":"1111","currency":"AOA","value_date":"2022-07-30"}],"provider_org":[{"ref":"provider-org-ref","provider_activity_id":"123123123","type":"11","narrative":[{"narrative":"asdasdasdads","language":"ab"}]}]}]',
            true,
            512,
            JSON_THROW_ON_ERROR
        );

        $activity = new Activity();
        $activity->{$this->element} = $actualData;

        $this->assertTrue($this->elementCompleteService->isPlannedDisbursementElementCompleted($activity));
    }

    /**
     * Test incomplete for value amount value is null.
     *
     * @return void
     *
     * @throws \JsonException
     */
    public function test_planned_disbursement_is_incomplete_when_value_amount_is_null()
    {
        $actualData = json_decode(
            '[{"planned_disbursement_type":"1","period_start":[{"date":"2023-11-12"}],"period_end":[{"date":"2023-11-13"}],"value":[{"amount":null,"currency":"AED","value_date":"2024-11-12"}],"provider_org":[{"ref":"provider ref val","provider_activity_id":"provider-activity-123","type":"10","narrative":[{"narrative":"narr","language":"ng"}]}],"receiver_org":[{"ref":"receiver ref val","receiver_activity_id":"receiver-activity-123","type":"21","narrative":[{"narrative":"narr","language":"ng"}]}]}]',
            true,
            512,
            JSON_THROW_ON_ERROR
        );

        $activity = new Activity();
        $activity->{$this->element} = $actualData;

        $this->assertFalse($this->elementCompleteService->isPlannedDisbursementElementCompleted($activity));
    }

    /**
     * Test incomplete for value amount value is empty string.
     *
     * @return void
     *
     * @throws \JsonException
     */
    public function test_planned_disbursement_is_incomplete_when_value_amount_is_empty_string()
    {
        $actualData = json_decode(
            '[{"planned_disbursement_type":"1","period_start":[{"date":"2023-11-12"}],"period_end":[{"date":"2023-11-13"}],"value":[{"amount":"","currency":"AED","value_date":"2024-11-12"}],"provider_org":[{"ref":"provider ref val","provider_activity_id":"provider-activity-123","type":"10","narrative":[{"narrative":"narr","language":"ng"}]}],"receiver_org":[{"ref":"receiver ref val","receiver_activity_id":"receiver-activity-123","type":"21","narrative":[{"narrative":"narr","language":"ng"}]}]}]',
            true,
            512,
            JSON_THROW_ON_ERROR
        );

        $activity = new Activity();
        $activity->{$this->element} = $actualData;

        $this->assertFalse($this->elementCompleteService->isPlannedDisbursementElementCompleted($activity));
    }

    /**
     * Test complete for value currency value is zero.
     *
     * @return void
     *
     * @throws \JsonException
     */
    public function test_planned_disbursement_is_complete_when_value_amount_is_zero()
    {
        $actualData = json_decode(
            '[{"planned_disbursement_type":"1","period_start":[{"date":"2023-11-12"}],"period_end":[{"date":"2023-11-13"}],"value":[{"amount":"0","currency":"AED","value_date":"2024-11-12"}],"provider_org":[{"ref":"provider ref val","provider_activity_id":"provider-activity-123","type":"10","narrative":[{"narrative":"narr","language":"ng"}]}],"receiver_org":[{"ref":"receiver ref val","receiver_activity_id":"receiver-activity-123","type":"21","narrative":[{"narrative":"narr","language":"ng"}]}]}]',
            true,
            512,
            JSON_THROW_ON_ERROR
        );

        $activity = new Activity();
        $activity->{$this->element} = $actualData;

        $this->assertTrue($this->elementCompleteService->isPlannedDisbursementElementCompleted($activity));
    }

    /**
     * Test incomplete for value currency value null.
     *
     * @return void
     *
     * @throws \JsonException
     */
    public function test_planned_disbursement_is_incomplete_when_value_currency_is_null()
    {
        $actualData = json_decode(
            '[{"planned_disbursement_type":"1","period_start":[{"date":"2023-11-12"}],"period_end":[{"date":"2023-11-13"}],"value":[{"amount":"12345","currency":null,"value_date":"2024-11-12"}],"provider_org":[{"ref":"provider ref val","provider_activity_id":"provider-activity-123","type":"10","narrative":[{"narrative":"narr","language":"ng"}]}],"receiver_org":[{"ref":"receiver ref val","receiver_activity_id":"receiver-activity-123","type":"21","narrative":[{"narrative":"narr","language":"ng"}]}]}]',
            true,
            512,
            JSON_THROW_ON_ERROR
        );

        $activity = new Activity();
        $activity->{$this->element} = $actualData;

        $this->assertFalse($this->elementCompleteService->isPlannedDisbursementElementCompleted($activity));
    }

    /**
     * Test incomplete for value currency value is empty string.
     *
     * @return void
     *
     * @throws \JsonException
     */
    public function test_planned_disbursement_is_incomplete_when_value_currency_is_empty_string()
    {
        $actualData = json_decode(
            '[{"planned_disbursement_type":"1","period_start":[{"date":"2023-11-12"}],"period_end":[{"date":"2023-11-13"}],"value":[{"amount":"12345","currency":"","value_date":"2024-11-12"}],"provider_org":[{"ref":"provider ref val","provider_activity_id":"provider-activity-123","type":"10","narrative":[{"narrative":"narr","language":"ng"}]}],"receiver_org":[{"ref":"receiver ref val","receiver_activity_id":"receiver-activity-123","type":"21","narrative":[{"narrative":"narr","language":"ng"}]}]}]',
            true,
            512,
            JSON_THROW_ON_ERROR
        );

        $activity = new Activity();
        $activity->{$this->element} = $actualData;

        $this->assertFalse($this->elementCompleteService->isPlannedDisbursementElementCompleted($activity));
    }

    /**
     * Test incomplete for value date value null.
     *
     * @return void
     *
     * @throws \JsonException
     */
    public function test_planned_disbursement_is_incomplete_when_value_value_date_is_null()
    {
        $actualData = json_decode(
            '[{"planned_disbursement_type":"1","period_start":[{"date":"2023-11-12"}],"period_end":[{"date":"2023-11-13"}],"value":[{"amount":"12345","currency":"AED","value_date":null}],"provider_org":[{"ref":"provider ref val","provider_activity_id":"provider-activity-123","type":"10","narrative":[{"narrative":"narr","language":"ng"}]}],"receiver_org":[{"ref":"receiver ref val","receiver_activity_id":"receiver-activity-123","type":"21","narrative":[{"narrative":"narr","language":"ng"}]}]}]',
            true,
            512,
            JSON_THROW_ON_ERROR
        );

        $activity = new Activity();
        $activity->{$this->element} = $actualData;

        $this->assertFalse($this->elementCompleteService->isPlannedDisbursementElementCompleted($activity));
    }

    /**
     * Test incomplete for value date value empty string.
     *
     * @return void
     *
     * @throws \JsonException
     */
    public function test_planned_disbursement_is_incomplete_when_value_value_date_is_empty_string()
    {
        $actualData = json_decode(
            '[{"planned_disbursement_type":"1","period_start":[{"date":"2023-11-12"}],"period_end":[{"date":"2023-11-13"}],"value":[{"amount":"12345","currency":"AED","value_date":""}],"provider_org":[{"ref":"provider ref val","provider_activity_id":"provider-activity-123","type":"10","narrative":[{"narrative":"narr","language":"ng"}]}],"receiver_org":[{"ref":"receiver ref val","receiver_activity_id":"receiver-activity-123","type":"21","narrative":[{"narrative":"narr","language":"ng"}]}]}]',
            true,
            512,
            JSON_THROW_ON_ERROR
        );

        $activity = new Activity();
        $activity->{$this->element} = $actualData;

        $this->assertFalse($this->elementCompleteService->isPlannedDisbursementElementCompleted($activity));
    }

    /**
     *  Test incomplete for single.
     *
     * @return void
     *
     * @throws \JsonException
     */
    public function test_planned_disbursement_is_complete_when_all_fields_are_filled()
    {
        $actualData = json_decode(
            '[{"planned_disbursement_type":"1","period_start":[{"date":"2023-11-12"}],"period_end":[{"date":"2023-11-13"}],"value":[{"amount":"12345","currency":"AED","value_date":"2024-12-13"}],"provider_org":[{"ref":"provider ref val","provider_activity_id":"provider-activity-123","type":"10","narrative":[{"narrative":"narr","language":"ng"}]}],"receiver_org":[{"ref":"receiver ref val","receiver_activity_id":"receiver-activity-123","type":"21","narrative":[{"narrative":"narr","language":"ng"}]}]}]',
            true,
            512,
            JSON_THROW_ON_ERROR
        );

        $activity = new Activity();
        $activity->{$this->element} = $actualData;

        $this->assertTrue($this->elementCompleteService->isPlannedDisbursementElementCompleted($activity));
    }

    /**
     * Test complete for multiple.
     *
     * @return void
     *
     * @throws \JsonException
     */
    public function test_planned_disbursement_is_complete_when_all_fields_for_multiple_disbursement_are_filled()
    {
        $actualData = json_decode(
            '[{"planned_disbursement_type":"1","period_start":[{"date":"2023-11-12"}],"period_end":[{"date":"2023-11-13"}],"value":[{"amount":"12345","currency":"AED","value_date":"2024-12-13"}],"provider_org":[{"ref":"provider ref val","provider_activity_id":"provider-activity-123","type":"10","narrative":[{"narrative":"narr","language":"ng"}]}],"receiver_org":[{"ref":"receiver ref val","receiver_activity_id":"receiver-activity-123","type":"21","narrative":[{"narrative":"narr","language":"ng"}]}]},{"planned_disbursement_type":"1","period_start":[{"date":"2023-11-12"}],"period_end":[{"date":"2023-11-13"}],"value":[{"amount":"12345","currency":"AED","value_date":"2024-12-13"}],"provider_org":[{"ref":"provider ref val","provider_activity_id":"provider-activity-123","type":"10","narrative":[{"narrative":"narr","language":"ng"}]}],"receiver_org":[{"ref":"receiver ref val","receiver_activity_id":"receiver-activity-123","type":"21","narrative":[{"narrative":"narr","language":"ng"}]}]}]',
            true,
            512,
            JSON_THROW_ON_ERROR
        );

        $activity = new Activity();
        $activity->{$this->element} = $actualData;

        $this->assertTrue($this->elementCompleteService->isPlannedDisbursementElementCompleted($activity));
    }

    /**
     * Test incomplete for multiple.
     *
     * @return void
     *
     * @throws \JsonException
     */
    public function test_planned_disbursement_is_incomplete_when_some_required_fields_are_not_field_for_multiple_disbursement(
    ) {
        $actualData = json_decode(
            '[{"planned_disbursement_type":"1","period_start":[{"date":null}],"period_end":[{"date":"2023-11-13"}],"value":[{"amount":"12345","currency":"AED","value_date":"2024-12-13"}],"provider_org":[{"ref":"provider ref val","provider_activity_id":"provider-activity-123","type":"10","narrative":[{"narrative":"narr","language":"ng"}]}],"receiver_org":[{"ref":"receiver ref val","receiver_activity_id":"receiver-activity-123","type":"21","narrative":[{"narrative":"narr","language":"ng"}]}]},{"planned_disbursement_type":"1","period_start":[{"date":"2023-11-12"}],"period_end":[{"date":"2023-11-13"}],"value":[{"amount":"12345","currency":"AED","value_date":"2024-12-13"}],"provider_org":[{"ref":"provider ref val","provider_activity_id":"provider-activity-123","type":"10","narrative":[{"narrative":"narr","language":"ng"}]}],"receiver_org":[{"ref":"receiver ref val","receiver_activity_id":"receiver-activity-123","type":"21","narrative":[{"narrative":"narr","language":"ng"}]}]}]',
            true,
            512,
            JSON_THROW_ON_ERROR
        );

        $activity = new Activity();
        $activity->{$this->element} = $actualData;

        $this->assertFalse($this->elementCompleteService->isPlannedDisbursementElementCompleted($activity));
    }
}
