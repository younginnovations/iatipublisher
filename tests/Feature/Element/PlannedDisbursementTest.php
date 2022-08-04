<?php

namespace Tests\Feature\Element;

/**
 * Class PlannedDisbursementTest.
 */
class PlannedDisbursementTest extends ElementCompleteTest
{
    private string $element = 'planned_disbursement';

    /**
     * Mandatory attribute test.
     *
     * @return void
     * @throws \JsonException
     */
    public function test_humanitarian_scope_mandatory_attributes(): void
    {
        $this->test_mandatory_attributes($this->element, []);
    }

    /**
     * Mandatory sub element test.
     *
     * @return void
     * @throws \JsonException
     */
    public function test_humanitarian_scope_mandatory_sub_elements(): void
    {
        $this->test_mandatory_sub_elements($this->element, ['period_start' => ['iso_date'], 'period_end' => ['iso_date'], 'value' => ['amount', 'currency', 'value_date']]);
    }

    /**
     * Empty data test.
     *
     * @return void
     * @throws \JsonException
     */
    public function test_planned_disbursement_empty_data(): void
    {
        $actualData = '';

        $this->test_level_one_multi_dimensional_element_incomplete($this->element, $actualData);
    }

    /**
     * Empty array test.
     *
     * @return void
     * @throws \JsonException
     */
    public function test_planned_disbursement_empty_array(): void
    {
        $actualData = json_decode('[]', true);

        $this->test_level_one_multi_dimensional_element_incomplete($this->element, $actualData);
    }

    /**
     * Empty json array test.
     *
     * @return void
     * @throws \JsonException
     */
    public function test_planned_disbursement_empty_json_array(): void
    {
        $actualData = json_decode('[{}]', true);

        $this->test_level_two_multi_dimensional_element_incomplete($this->element, $actualData);
    }

    /**
     * Sub element period_start no key test.
     *
     * @return void
     * @throws \JsonException
     */
    public function test_planned_disbursement_sub_element_no_period_start_key(): void
    {
        $actualData = json_decode(
            '[{"planned_disbursement_type":"1","period_end":[{"iso_date":"2022-07-27"}],"value":[{"amount":"1111","currency":"AOA","value_date":"2022-07-30"}],"provider_org":[{"ref":"provider-org-ref","provider_activity_id":"123123123","type":"11","narrative":[{"narrative":"asdasdasdads","language":"ab"}]}],"receiver_org":[{"ref":"receiver-org-ref","provider_activity_id":"5555","type":"23","narrative":[{"narrative":"asdasdadasdasd","language":"af"}]}]}]',
            true,
            512,
            JSON_THROW_ON_ERROR
        );

        $this->test_level_two_multi_dimensional_element_incomplete($this->element, $actualData);
    }

    /**
     * Sub element period_end no key test.
     *
     * @return void
     * @throws \JsonException
     */
    public function test_planned_disbursement_sub_element_no_period_end_key(): void
    {
        $actualData = json_decode(
            '[{"planned_disbursement_type":"1","period_start":[{"iso_date":"2022-07-19"}],"value":[{"amount":"1111","currency":"AOA","value_date":"2022-07-30"}],"provider_org":[{"ref":"provider-org-ref","provider_activity_id":"123123123","type":"11","narrative":[{"narrative":"asdasdasdads","language":"ab"}]}],"receiver_org":[{"ref":"receiver-org-ref","provider_activity_id":"5555","type":"23","narrative":[{"narrative":"asdasdadasdasd","language":"af"}]}]}]',
            true,
            512,
            JSON_THROW_ON_ERROR
        );

        $this->test_level_two_multi_dimensional_element_incomplete($this->element, $actualData);
    }

    /**
     * Sub element value no key test.
     *
     * @return void
     * @throws \JsonException
     */
    public function test_planned_disbursement_sub_element_no_value_key(): void
    {
        $actualData = json_decode(
            '[{"planned_disbursement_type":"1","period_start":[{"iso_date":"2022-07-19"}],"period_end":[{"iso_date":"2022-07-27"}],"provider_org":[{"ref":"provider-org-ref","provider_activity_id":"123123123","type":"11","narrative":[{"narrative":"asdasdasdads","language":"ab"}]}],"receiver_org":[{"ref":"receiver-org-ref","provider_activity_id":"5555","type":"23","narrative":[{"narrative":"asdasdadasdasd","language":"af"}]}]}]',
            true,
            512,
            JSON_THROW_ON_ERROR
        );

        $this->test_level_two_multi_dimensional_element_incomplete($this->element, $actualData);
    }

    /**
     * Sub element receiver_org no key test.
     *
     * @return void
     * @throws \JsonException
     */
    public function test_planned_disbursement_sub_element_no_receiver_org_key(): void
    {
        $actualData = json_decode(
            '[{"planned_disbursement_type":"1","period_start":[{"iso_date":"2022-07-19"}],"value":[{"amount":"1111","currency":"AOA","value_date":"2022-07-30"}],"provider_org":[{"ref":"provider-org-ref","provider_activity_id":"123123123","type":"11","narrative":[{"narrative":"asdasdasdads","language":"ab"}]}]}]',
            true,
            512,
            JSON_THROW_ON_ERROR
        );

        $this->test_level_two_multi_dimensional_element_incomplete($this->element, $actualData);
    }

    /**
     * All element empty test.
     *
     * @return void
     * @throws \JsonException
     */
    public function test_planned_disbursement_all_element_empty(): void
    {
        $actualData = json_decode(
            '[{"planned_disbursement_type":"","period_start":[{"iso_date":""}],"period_end":[{"iso_date":""}],"value":[{"amount":"","currency":"","value_date":""}],"provider_org":[{"ref":"","provider_activity_id":"","type":"","narrative":[{"narrative":"","language":"ab"}]}],"receiver_org":[{"ref":"","provider_activity_id":"","type":"","narrative":[{"narrative":"","language":"af"}]}]}]',
            true,
            512,
            JSON_THROW_ON_ERROR
        );

        $this->test_level_two_multi_dimensional_element_incomplete($this->element, $actualData);
    }

    /**
     * Sub element period_start empty test.
     *
     * @return void
     * @throws \JsonException
     */
    public function test_planned_disbursement_sub_element_empty_period_start(): void
    {
        $actualData = json_decode(
            '[{"planned_disbursement_type":"1","period_start":"","period_end":[{"iso_date":"2022-07-27"}],"value":[{"amount":"1111","currency":"AOA","value_date":"2022-07-30"}],"provider_org":[{"ref":"provider-org-ref","provider_activity_id":"123123123","type":"11","narrative":[{"narrative":"asdasdasdads","language":"ab"}]}],"receiver_org":[{"ref":"receiver-org-ref","provider_activity_id":"5555","type":"23","narrative":[{"narrative":"asdasdadasdasd","language":"af"}]}]}]',
            true,
            512,
            JSON_THROW_ON_ERROR
        );

        $this->test_level_two_multi_dimensional_element_incomplete($this->element, $actualData);
    }

    /**
     * Sub element period_start empty arary test.
     *
     * @return void
     * @throws \JsonException
     */
    public function test_planned_disbursement_sub_element_empty_period_start_array(): void
    {
        $actualData = json_decode(
            '[{"planned_disbursement_type":"1","period_start":[],"period_end":[{"iso_date":"2022-07-27"}],"value":[{"amount":"1111","currency":"AOA","value_date":"2022-07-30"}],"provider_org":[{"ref":"provider-org-ref","provider_activity_id":"123123123","type":"11","narrative":[{"narrative":"asdasdasdads","language":"ab"}]}],"receiver_org":[{"ref":"receiver-org-ref","provider_activity_id":"5555","type":"23","narrative":[{"narrative":"asdasdadasdasd","language":"af"}]}]}]',
            true,
            512,
            JSON_THROW_ON_ERROR
        );

        $this->test_level_two_multi_dimensional_element_incomplete($this->element, $actualData);
    }

    /**
     * Sub element period_start empty json array test.
     *
     * @return void
     * @throws \JsonException
     */
    public function test_planned_disbursement_sub_element_empty_period_start_json_array(): void
    {
        $actualData = json_decode(
            '[{"planned_disbursement_type":"1","period_start":[{}],"period_end":[{"iso_date":"2022-07-27"}],"value":[{"amount":"1111","currency":"AOA","value_date":"2022-07-30"}],"provider_org":[{"ref":"provider-org-ref","provider_activity_id":"123123123","type":"11","narrative":[{"narrative":"asdasdasdads","language":"ab"}]}],"receiver_org":[{"ref":"receiver-org-ref","provider_activity_id":"5555","type":"23","narrative":[{"narrative":"asdasdadasdasd","language":"af"}]}]}]',
            true,
            512,
            JSON_THROW_ON_ERROR
        );

        $this->test_level_two_multi_dimensional_element_incomplete($this->element, $actualData);
    }

    /**
     * Sub element period_start empty iso_date test.
     *
     * @return void
     * @throws \JsonException
     */
    public function test_planned_disbursement_sub_element_period_start_attribute_empty_iso_date(): void
    {
        $actualData = json_decode(
            '[{"planned_disbursement_type":"1","period_start":[{"iso_date":""}],"period_end":[{"iso_date":"2022-07-27"}],"value":[{"amount":"1111","currency":"AOA","value_date":"2022-07-30"}],"provider_org":[{"ref":"provider-org-ref","provider_activity_id":"123123123","type":"11","narrative":[{"narrative":"asdasdasdads","language":"ab"}]}],"receiver_org":[{"ref":"receiver-org-ref","provider_activity_id":"5555","type":"23","narrative":[{"narrative":"asdasdadasdasd","language":"af"}]}]}]',
            true,
            512,
            JSON_THROW_ON_ERROR
        );

        $this->test_level_two_multi_dimensional_element_incomplete($this->element, $actualData);
    }

    /**
     * Sub element period_end empty test.
     *
     * @return void
     * @throws \JsonException
     */
    public function test_planned_disbursement_sub_element_empty_period_end(): void
    {
        $actualData = json_decode(
            '[{"planned_disbursement_type":"1","period_start":[{"iso_date":"2022-07-27"}],"period_end":"","value":[{"amount":"1111","currency":"AOA","value_date":"2022-07-30"}],"provider_org":[{"ref":"provider-org-ref","provider_activity_id":"123123123","type":"11","narrative":[{"narrative":"asdasdasdads","language":"ab"}]}],"receiver_org":[{"ref":"receiver-org-ref","provider_activity_id":"5555","type":"23","narrative":[{"narrative":"asdasdadasdasd","language":"af"}]}]}]',
            true,
            512,
            JSON_THROW_ON_ERROR
        );

        $this->test_level_two_multi_dimensional_element_incomplete($this->element, $actualData);
    }

    /**
     * Sub element period_end empty array test.
     *
     * @return void
     * @throws \JsonException
     */
    public function test_planned_disbursement_sub_element_empty_period_end_array(): void
    {
        $actualData = json_decode(
            '[{"planned_disbursement_type":"1","period_start":[{"iso_date":"2022-07-27"}],"period_end":[],"value":[{"amount":"1111","currency":"AOA","value_date":"2022-07-30"}],"provider_org":[{"ref":"provider-org-ref","provider_activity_id":"123123123","type":"11","narrative":[{"narrative":"asdasdasdads","language":"ab"}]}],"receiver_org":[{"ref":"receiver-org-ref","provider_activity_id":"5555","type":"23","narrative":[{"narrative":"asdasdadasdasd","language":"af"}]}]}]',
            true,
            512,
            JSON_THROW_ON_ERROR
        );

        $this->test_level_two_multi_dimensional_element_incomplete($this->element, $actualData);
    }

    /**
     * Sub element period_end empty json array test.
     *
     * @return void
     * @throws \JsonException
     */
    public function test_planned_disbursement_sub_element_empty_period_end_json_array(): void
    {
        $actualData = json_decode(
            '[{"planned_disbursement_type":"1","period_start":[{"iso_date":"2022-07-27"}],"period_end":[{}],"value":[{"amount":"1111","currency":"AOA","value_date":"2022-07-30"}],"provider_org":[{"ref":"provider-org-ref","provider_activity_id":"123123123","type":"11","narrative":[{"narrative":"asdasdasdads","language":"ab"}]}],"receiver_org":[{"ref":"receiver-org-ref","provider_activity_id":"5555","type":"23","narrative":[{"narrative":"asdasdadasdasd","language":"af"}]}]}]',
            true,
            512,
            JSON_THROW_ON_ERROR
        );

        $this->test_level_two_multi_dimensional_element_incomplete($this->element, $actualData);
    }

    /**
     * Sub element period_end empty iso_date test.
     *
     * @return void
     * @throws \JsonException
     */
    public function test_planned_disbursement_sub_element_period_end_attribute_empty_iso_date(): void
    {
        $actualData = json_decode(
            '[{"planned_disbursement_type":"1","period_start":[{"iso_date":"2022-07-27"}],"period_end":[{"iso_date":""}],"value":[{"amount":"1111","currency":"AOA","value_date":"2022-07-30"}],"provider_org":[{"ref":"provider-org-ref","provider_activity_id":"123123123","type":"11","narrative":[{"narrative":"asdasdasdads","language":"ab"}]}],"receiver_org":[{"ref":"receiver-org-ref","provider_activity_id":"5555","type":"23","narrative":[{"narrative":"asdasdadasdasd","language":"af"}]}]}]',
            true,
            512,
            JSON_THROW_ON_ERROR
        );

        $this->test_level_two_multi_dimensional_element_incomplete($this->element, $actualData);
    }

    /**
     * Sub element value empty test.
     *
     * @return void
     * @throws \JsonException
     */
    public function test_planned_disbursement_sub_element_empty_value(): void
    {
        $actualData = json_decode(
            '[{"planned_disbursement_type":"1","period_start":[{"iso_date":"2022-07-19"}],"period_end":[{"iso_date":"2022-07-27"}],"value":"","provider_org":[{"ref":"provider-org-ref","provider_activity_id":"123123123","type":"11","narrative":[{"narrative":"asdasdasdads","language":"ab"}]}],"receiver_org":[{"ref":"receiver-org-ref","provider_activity_id":"5555","type":"23","narrative":[{"narrative":"asdasdadasdasd","language":"af"}]}]}]',
            true,
            512,
            JSON_THROW_ON_ERROR
        );

        $this->test_level_two_multi_dimensional_element_incomplete($this->element, $actualData);
    }

    /**
     * Sub element value empty array test.
     *
     * @return void
     * @throws \JsonException
     */
    public function test_planned_disbursement_sub_element_empty_value_array(): void
    {
        $actualData = json_decode(
            '[{"planned_disbursement_type":"1","period_start":[{"iso_date":"2022-07-19"}],"period_end":[{"iso_date":"2022-07-27"}],"value":[],"provider_org":[{"ref":"provider-org-ref","provider_activity_id":"123123123","type":"11","narrative":[{"narrative":"asdasdasdads","language":"ab"}]}],"receiver_org":[{"ref":"receiver-org-ref","provider_activity_id":"5555","type":"23","narrative":[{"narrative":"asdasdadasdasd","language":"af"}]}]}]',
            true,
            512,
            JSON_THROW_ON_ERROR
        );

        $this->test_level_two_multi_dimensional_element_incomplete($this->element, $actualData);
    }

    /**
     * Sub element value empty json array test.
     *
     * @return void
     * @throws \JsonException
     */
    public function test_planned_disbursement_sub_element_empty_value_json_array(): void
    {
        $actualData = json_decode(
            '[{"planned_disbursement_type":"1","period_start":[{"iso_date":"2022-07-19"}],"period_end":[{"iso_date":"2022-07-27"}],"value":[{}],"provider_org":[{"ref":"provider-org-ref","provider_activity_id":"123123123","type":"11","narrative":[{"narrative":"asdasdasdads","language":"ab"}]}],"receiver_org":[{"ref":"receiver-org-ref","provider_activity_id":"5555","type":"23","narrative":[{"narrative":"asdasdadasdasd","language":"af"}]}]}]',
            true,
            512,
            JSON_THROW_ON_ERROR
        );

        $this->test_level_two_multi_dimensional_element_incomplete($this->element, $actualData);
    }

    /**
     * Sub element value attributes empty test.
     *
     * @return void
     * @throws \JsonException
     */
    public function test_planned_disbursement_sub_element_value_attribute_empty_amount_and_currency_and_value_date(): void
    {
        $actualData = json_decode(
            '[{"planned_disbursement_type":"1","period_start":[{"iso_date":"2022-07-19"}],"period_end":[{"iso_date":"2022-07-27"}],"value":[{"amount":"","currency":"","value_date":""}],"provider_org":[{"ref":"provider-org-ref","provider_activity_id":"123123123","type":"11","narrative":[{"narrative":"asdasdasdads","language":"ab"}]}],"receiver_org":[{"ref":"receiver-org-ref","provider_activity_id":"5555","type":"23","narrative":[{"narrative":"asdasdadasdasd","language":"af"}]}]}]',
            true,
            512,
            JSON_THROW_ON_ERROR
        );

        $this->test_level_two_multi_dimensional_element_incomplete($this->element, $actualData);
    }

    /**
     * Sub element value attribute amount empty test.
     *
     * @return void
     * @throws \JsonException
     */
    public function test_planned_disbursement_sub_element_value_attribute_empty_amount(): void
    {
        $actualData = json_decode(
            '[{"planned_disbursement_type":"1","period_start":[{"iso_date":"2022-07-19"}],"period_end":[{"iso_date":"2022-07-27"}],"value":[{"amount":"","currency":"AOA","value_date":"2022-07-30"}],"provider_org":[{"ref":"provider-org-ref","provider_activity_id":"123123123","type":"11","narrative":[{"narrative":"asdasdasdads","language":"ab"}]}],"receiver_org":[{"ref":"receiver-org-ref","provider_activity_id":"5555","type":"23","narrative":[{"narrative":"asdasdadasdasd","language":"af"}]}]}]',
            true,
            512,
            JSON_THROW_ON_ERROR
        );

        $this->test_level_two_multi_dimensional_element_incomplete($this->element, $actualData);
    }

    /**
     * Sub element value attribute currency empty test.
     *
     * @return void
     * @throws \JsonException
     */
    public function test_planned_disbursement_sub_element_value_attribute_empty_currency(): void
    {
        $actualData = json_decode(
            '[{"planned_disbursement_type":"1","period_start":[{"iso_date":"2022-07-19"}],"period_end":[{"iso_date":"2022-07-27"}],"value":[{"amount":"1111","currency":"","value_date":"2022-07-30"}],"provider_org":[{"ref":"provider-org-ref","provider_activity_id":"123123123","type":"11","narrative":[{"narrative":"asdasdasdads","language":"ab"}]}],"receiver_org":[{"ref":"receiver-org-ref","provider_activity_id":"5555","type":"23","narrative":[{"narrative":"asdasdadasdasd","language":"af"}]}]}]',
            true,
            512,
            JSON_THROW_ON_ERROR
        );

        $this->test_level_two_multi_dimensional_element_incomplete($this->element, $actualData);
    }

    /**
     * Sub element value attribute value_date empty test.
     *
     * @return void
     * @throws \JsonException
     */
    public function test_planned_disbursement_sub_element_value_attribute_empty_value_date(): void
    {
        $actualData = json_decode(
            '[{"planned_disbursement_type":"1","period_start":[{"iso_date":"2022-07-19"}],"period_end":[{"iso_date":"2022-07-27"}],"value":[{"amount":"1111","currency":"AOA","value_date":""}],"provider_org":[{"ref":"provider-org-ref","provider_activity_id":"123123123","type":"11","narrative":[{"narrative":"asdasdasdads","language":"ab"}]}],"receiver_org":[{"ref":"receiver-org-ref","provider_activity_id":"5555","type":"23","narrative":[{"narrative":"asdasdadasdasd","language":"af"}]}]}]',
            true,
            512,
            JSON_THROW_ON_ERROR
        );

        $this->test_level_two_multi_dimensional_element_incomplete($this->element, $actualData);
    }

    /**
     * Sub element value attribute amount no key test.
     *
     * @return void
     * @throws \JsonException
     */
    public function test_planned_disbursement_sub_element_value_attribute_no_amount_key(): void
    {
        $actualData = json_decode(
            '[{"planned_disbursement_type":"1","period_start":[{"iso_date":"2022-07-19"}],"period_end":[{"iso_date":"2022-07-27"}],"value":[{"currency":"AOA","value_date":"2022-07-30"}],"provider_org":[{"ref":"provider-org-ref","provider_activity_id":"123123123","type":"11","narrative":[{"narrative":"asdasdasdads","language":"ab"}]}],"receiver_org":[{"ref":"receiver-org-ref","provider_activity_id":"5555","type":"23","narrative":[{"narrative":"asdasdadasdasd","language":"af"}]}]}]',
            true,
            512,
            JSON_THROW_ON_ERROR
        );

        $this->test_level_two_multi_dimensional_element_incomplete($this->element, $actualData);
    }

    /**
     * Sub element value attribute currency no key test.
     *
     * @return void
     * @throws \JsonException
     */
    public function test_planned_disbursement_sub_element_value_attribute_no_currency_key(): void
    {
        $actualData = json_decode(
            '[{"planned_disbursement_type":"1","period_start":[{"iso_date":"2022-07-19"}],"period_end":[{"iso_date":"2022-07-27"}],"value":[{"amount":"1111","value_date":"2022-07-30"}],"provider_org":[{"ref":"provider-org-ref","provider_activity_id":"123123123","type":"11","narrative":[{"narrative":"asdasdasdads","language":"ab"}]}],"receiver_org":[{"ref":"receiver-org-ref","provider_activity_id":"5555","type":"23","narrative":[{"narrative":"asdasdadasdasd","language":"af"}]}]}]',
            true,
            512,
            JSON_THROW_ON_ERROR
        );

        $this->test_level_two_multi_dimensional_element_incomplete($this->element, $actualData);
    }

    /**
     * Sub element value attribute value_date no key test.
     *
     * @return void
     * @throws \JsonException
     */
    public function test_planned_disbursement_sub_element_value_attribute_no_value_date_key(): void
    {
        $actualData = json_decode(
            '[{"planned_disbursement_type":"1","period_start":[{"iso_date":"2022-07-19"}],"period_end":[{"iso_date":"2022-07-27"}],"value":[{"amount":"1111","currency":"AOA"}],"provider_org":[{"ref":"provider-org-ref","provider_activity_id":"123123123","type":"11","narrative":[{"narrative":"asdasdasdads","language":"ab"}]}],"receiver_org":[{"ref":"receiver-org-ref","provider_activity_id":"5555","type":"23","narrative":[{"narrative":"asdasdadasdasd","language":"af"}]}]}]',
            true,
            512,
            JSON_THROW_ON_ERROR
        );

        $this->test_level_two_multi_dimensional_element_incomplete($this->element, $actualData);
    }

    /**
     * Planned Disbursement element complete test.
     *
     * @return void
     * @throws \JsonException
     */
    public function test_planned_disbursement_element_complete(): void
    {
        $actualData = json_decode(
            '[{"planned_disbursement_type":"1","period_start":[{"iso_date":"2022-07-19"}],"period_end":[{"iso_date":"2022-07-27"}],"value":[{"amount":"1111","currency":"AOA","value_date":"2022-07-30"}],"provider_org":[{"ref":"provider-org-ref","provider_activity_id":"123123123","type":"11","narrative":[{"narrative":"asdasdasdads","language":"ab"}]}],"receiver_org":[{"ref":"receiver-org-ref","provider_activity_id":"5555","type":"23","narrative":[{"narrative":"asdasdadasdasd","language":"af"}]}]}]',
            true,
            512,
            JSON_THROW_ON_ERROR
        );

        $this->test_level_two_multi_dimensional_element_complete($this->element, $actualData);
    }
}
