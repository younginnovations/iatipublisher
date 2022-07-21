<?php

namespace Tests\Feature\Element;

class PlannedDisbursementTest extends ElementCompleteTest
{
    private string $element = 'planned_disbursement';

    public function __construct(?string $name = null, array $data = [], $dataName = '')
    {
        parent::__construct($name, $data, $dataName);

        $this->activityObj->element = $this->element;
    }

    public function test_humanitarian_scope_mandatory_attributes()
    {
        $this->test_mandatory_attributes($this->element, []);
    }

    public function test_humanitarian_scope_mandatory_sub_elements()
    {
        $this->test_mandatory_sub_elements($this->element, ['period_start'=>['iso_date'], 'period_end'=>['iso_date'], 'value'=>['amount', 'currency', 'value_date']]);
    }

    public function test_planned_disbursement_empty_data()
    {
        $actualData = '';

        $this->test_level_one_multi_dimensional_element_incomplete($this->element, $actualData);
    }

    public function test_planned_disbursement_empty_array()
    {
        $actualData = json_decode('[]', true);

        $this->test_level_one_multi_dimensional_element_incomplete($this->element, $actualData);
    }

    public function test_planned_disbursement_empty_json_array()
    {
        $actualData = json_decode('[{}]', true);

        $this->test_level_two_multi_dimensional_element_incomplete($this->element, $actualData);
    }

    /*public function test_planned_disbursement_attribute_no_planned_disbursement_type_key()
    {
        $actualData = json_decode(
            '[{"period_start":[{"iso_date":"2022-07-19"}],"period_end":[{"iso_date":"2022-07-27"}],"value":[{"amount":"1111","currency":"AOA","value_date":"2022-07-30"}],"provider_org":[{"ref":"provider-org-ref","provider_activity_id":"123123123","type":"11","narrative":[{"narrative":"asdasdasdads","language":"ab"}]}],"receiver_org":[{"ref":"receiver-org-ref","provider_activity_id":"5555","type":"23","narrative":[{"narrative":"asdasdadasdasd","language":"af"}]}]}]',
            true
        );

        $this->test_level_two_multi_dimensional_element_incomplete($this->element, $actualData);
    }*/

    public function test_planned_disbursement_sub_element_no_period_start_key()
    {
        $actualData = json_decode(
            '[{"planned_disbursement_type":"1","period_end":[{"iso_date":"2022-07-27"}],"value":[{"amount":"1111","currency":"AOA","value_date":"2022-07-30"}],"provider_org":[{"ref":"provider-org-ref","provider_activity_id":"123123123","type":"11","narrative":[{"narrative":"asdasdasdads","language":"ab"}]}],"receiver_org":[{"ref":"receiver-org-ref","provider_activity_id":"5555","type":"23","narrative":[{"narrative":"asdasdadasdasd","language":"af"}]}]}]',
            true
        );

        $this->test_level_two_multi_dimensional_element_incomplete($this->element, $actualData);
    }

    public function test_planned_disbursement_sub_element_no_period_end_key()
    {
        $actualData = json_decode(
            '[{"planned_disbursement_type":"1","period_start":[{"iso_date":"2022-07-19"}],"value":[{"amount":"1111","currency":"AOA","value_date":"2022-07-30"}],"provider_org":[{"ref":"provider-org-ref","provider_activity_id":"123123123","type":"11","narrative":[{"narrative":"asdasdasdads","language":"ab"}]}],"receiver_org":[{"ref":"receiver-org-ref","provider_activity_id":"5555","type":"23","narrative":[{"narrative":"asdasdadasdasd","language":"af"}]}]}]',
            true
        );

        $this->test_level_two_multi_dimensional_element_incomplete($this->element, $actualData);
    }

    public function test_planned_disbursement_sub_element_no_value_key()
    {
        $actualData = json_decode(
            '[{"planned_disbursement_type":"1","period_start":[{"iso_date":"2022-07-19"}],"period_end":[{"iso_date":"2022-07-27"}],"provider_org":[{"ref":"provider-org-ref","provider_activity_id":"123123123","type":"11","narrative":[{"narrative":"asdasdasdads","language":"ab"}]}],"receiver_org":[{"ref":"receiver-org-ref","provider_activity_id":"5555","type":"23","narrative":[{"narrative":"asdasdadasdasd","language":"af"}]}]}]',
            true
        );

        $this->test_level_two_multi_dimensional_element_incomplete($this->element, $actualData);
    }

    /*public function test_planned_disbursement_sub_element_no_provider_org_key()
    {
        $actualData = json_decode(
            '[{"planned_disbursement_type":"1","period_start":[{"iso_date":"2022-07-19"}],"value":[{"amount":"1111","currency":"AOA","value_date":"2022-07-30"}],"receiver_org":[{"ref":"receiver-org-ref","provider_activity_id":"5555","type":"23","narrative":[{"narrative":"asdasdadasdasd","language":"af"}]}]}]',
            true
        );

        $this->test_level_two_multi_dimensional_element_incomplete($this->element, $actualData);
    }*/

    public function test_planned_disbursement_sub_element_no_receiver_org_key()
    {
        $actualData = json_decode(
            '[{"planned_disbursement_type":"1","period_start":[{"iso_date":"2022-07-19"}],"value":[{"amount":"1111","currency":"AOA","value_date":"2022-07-30"}],"provider_org":[{"ref":"provider-org-ref","provider_activity_id":"123123123","type":"11","narrative":[{"narrative":"asdasdasdads","language":"ab"}]}]}]',
            true
        );

        $this->test_level_two_multi_dimensional_element_incomplete($this->element, $actualData);
    }

    public function test_planned_disbursement_all_element_empty()
    {
        $actualData = json_decode(
            '[{"planned_disbursement_type":"","period_start":[{"iso_date":""}],"period_end":[{"iso_date":""}],"value":[{"amount":"","currency":"","value_date":""}],"provider_org":[{"ref":"","provider_activity_id":"","type":"","narrative":[{"narrative":"","language":"ab"}]}],"receiver_org":[{"ref":"","provider_activity_id":"","type":"","narrative":[{"narrative":"","language":"af"}]}]}]',
            true
        );

        $this->test_level_two_multi_dimensional_element_incomplete($this->element, $actualData);
    }

    /*public function test_planned_disbursement_attribute_empty_planned_disbursement_type()
    {
        $actualData = json_decode(
            '[{"planned_disbursement_type":"","period_start":[{"iso_date":"2022-07-19"}],"period_end":[{"iso_date":"2022-07-27"}],"value":[{"amount":"1111","currency":"AOA","value_date":"2022-07-30"}],"provider_org":[{"ref":"provider-org-ref","provider_activity_id":"123123123","type":"11","narrative":[{"narrative":"asdasdasdads","language":"ab"}]}],"receiver_org":[{"ref":"receiver-org-ref","provider_activity_id":"5555","type":"23","narrative":[{"narrative":"asdasdadasdasd","language":"af"}]}]}]',
            true
        );

        $this->test_level_two_multi_dimensional_element_incomplete($this->element, $actualData);
    }*/

    public function test_planned_disbursement_sub_element_empty_period_start()
    {
        $actualData = json_decode(
            '[{"planned_disbursement_type":"1","period_start":"","period_end":[{"iso_date":"2022-07-27"}],"value":[{"amount":"1111","currency":"AOA","value_date":"2022-07-30"}],"provider_org":[{"ref":"provider-org-ref","provider_activity_id":"123123123","type":"11","narrative":[{"narrative":"asdasdasdads","language":"ab"}]}],"receiver_org":[{"ref":"receiver-org-ref","provider_activity_id":"5555","type":"23","narrative":[{"narrative":"asdasdadasdasd","language":"af"}]}]}]',
            true
        );

        $this->test_level_two_multi_dimensional_element_incomplete($this->element, $actualData);
    }

    public function test_planned_disbursement_sub_element_empty_period_start_array()
    {
        $actualData = json_decode(
            '[{"planned_disbursement_type":"1","period_start":[],"period_end":[{"iso_date":"2022-07-27"}],"value":[{"amount":"1111","currency":"AOA","value_date":"2022-07-30"}],"provider_org":[{"ref":"provider-org-ref","provider_activity_id":"123123123","type":"11","narrative":[{"narrative":"asdasdasdads","language":"ab"}]}],"receiver_org":[{"ref":"receiver-org-ref","provider_activity_id":"5555","type":"23","narrative":[{"narrative":"asdasdadasdasd","language":"af"}]}]}]',
            true
        );

        $this->test_level_two_multi_dimensional_element_incomplete($this->element, $actualData);
    }

    public function test_planned_disbursement_sub_element_empty_period_start_json_array()
    {
        $actualData = json_decode(
            '[{"planned_disbursement_type":"1","period_start":[{}],"period_end":[{"iso_date":"2022-07-27"}],"value":[{"amount":"1111","currency":"AOA","value_date":"2022-07-30"}],"provider_org":[{"ref":"provider-org-ref","provider_activity_id":"123123123","type":"11","narrative":[{"narrative":"asdasdasdads","language":"ab"}]}],"receiver_org":[{"ref":"receiver-org-ref","provider_activity_id":"5555","type":"23","narrative":[{"narrative":"asdasdadasdasd","language":"af"}]}]}]',
            true
        );

        $this->test_level_two_multi_dimensional_element_incomplete($this->element, $actualData);
    }

    public function test_planned_disbursement_sub_element_period_start_attribute_empty_iso_date()
    {
        $actualData = json_decode(
            '[{"planned_disbursement_type":"1","period_start":[{"iso_date":""}],"period_end":[{"iso_date":"2022-07-27"}],"value":[{"amount":"1111","currency":"AOA","value_date":"2022-07-30"}],"provider_org":[{"ref":"provider-org-ref","provider_activity_id":"123123123","type":"11","narrative":[{"narrative":"asdasdasdads","language":"ab"}]}],"receiver_org":[{"ref":"receiver-org-ref","provider_activity_id":"5555","type":"23","narrative":[{"narrative":"asdasdadasdasd","language":"af"}]}]}]',
            true
        );

        $this->test_level_two_multi_dimensional_element_incomplete($this->element, $actualData);
    }

    public function test_planned_disbursement_sub_element_empty_period_end()
    {
        $actualData = json_decode(
            '[{"planned_disbursement_type":"1","period_start":[{"iso_date":"2022-07-27"}],"period_end":"","value":[{"amount":"1111","currency":"AOA","value_date":"2022-07-30"}],"provider_org":[{"ref":"provider-org-ref","provider_activity_id":"123123123","type":"11","narrative":[{"narrative":"asdasdasdads","language":"ab"}]}],"receiver_org":[{"ref":"receiver-org-ref","provider_activity_id":"5555","type":"23","narrative":[{"narrative":"asdasdadasdasd","language":"af"}]}]}]',
            true
        );

        $this->test_level_two_multi_dimensional_element_incomplete($this->element, $actualData);
    }

    public function test_planned_disbursement_sub_element_empty_period_end_array()
    {
        $actualData = json_decode(
            '[{"planned_disbursement_type":"1","period_start":[{"iso_date":"2022-07-27"}],"period_end":[],"value":[{"amount":"1111","currency":"AOA","value_date":"2022-07-30"}],"provider_org":[{"ref":"provider-org-ref","provider_activity_id":"123123123","type":"11","narrative":[{"narrative":"asdasdasdads","language":"ab"}]}],"receiver_org":[{"ref":"receiver-org-ref","provider_activity_id":"5555","type":"23","narrative":[{"narrative":"asdasdadasdasd","language":"af"}]}]}]',
            true
        );

        $this->test_level_two_multi_dimensional_element_incomplete($this->element, $actualData);
    }

    public function test_planned_disbursement_sub_element_empty_period_end_json_array()
    {
        $actualData = json_decode(
            '[{"planned_disbursement_type":"1","period_start":[{"iso_date":"2022-07-27"}],"period_end":[{}],"value":[{"amount":"1111","currency":"AOA","value_date":"2022-07-30"}],"provider_org":[{"ref":"provider-org-ref","provider_activity_id":"123123123","type":"11","narrative":[{"narrative":"asdasdasdads","language":"ab"}]}],"receiver_org":[{"ref":"receiver-org-ref","provider_activity_id":"5555","type":"23","narrative":[{"narrative":"asdasdadasdasd","language":"af"}]}]}]',
            true
        );

        $this->test_level_two_multi_dimensional_element_incomplete($this->element, $actualData);
    }

    public function test_planned_disbursement_sub_element_period_end_attribute_empty_iso_date()
    {
        $actualData = json_decode(
            '[{"planned_disbursement_type":"1","period_start":[{"iso_date":"2022-07-27"}],"period_end":[{"iso_date":""}],"value":[{"amount":"1111","currency":"AOA","value_date":"2022-07-30"}],"provider_org":[{"ref":"provider-org-ref","provider_activity_id":"123123123","type":"11","narrative":[{"narrative":"asdasdasdads","language":"ab"}]}],"receiver_org":[{"ref":"receiver-org-ref","provider_activity_id":"5555","type":"23","narrative":[{"narrative":"asdasdadasdasd","language":"af"}]}]}]',
            true
        );

        $this->test_level_two_multi_dimensional_element_incomplete($this->element, $actualData);
    }

    public function test_planned_disbursement_sub_element_empty_value()
    {
        $actualData = json_decode(
            '[{"planned_disbursement_type":"1","period_start":[{"iso_date":"2022-07-19"}],"period_end":[{"iso_date":"2022-07-27"}],"value":"","provider_org":[{"ref":"provider-org-ref","provider_activity_id":"123123123","type":"11","narrative":[{"narrative":"asdasdasdads","language":"ab"}]}],"receiver_org":[{"ref":"receiver-org-ref","provider_activity_id":"5555","type":"23","narrative":[{"narrative":"asdasdadasdasd","language":"af"}]}]}]',
            true
        );

        $this->test_level_two_multi_dimensional_element_incomplete($this->element, $actualData);
    }

    public function test_planned_disbursement_sub_element_empty_value_array()
    {
        $actualData = json_decode(
            '[{"planned_disbursement_type":"1","period_start":[{"iso_date":"2022-07-19"}],"period_end":[{"iso_date":"2022-07-27"}],"value":[],"provider_org":[{"ref":"provider-org-ref","provider_activity_id":"123123123","type":"11","narrative":[{"narrative":"asdasdasdads","language":"ab"}]}],"receiver_org":[{"ref":"receiver-org-ref","provider_activity_id":"5555","type":"23","narrative":[{"narrative":"asdasdadasdasd","language":"af"}]}]}]',
            true
        );

        $this->test_level_two_multi_dimensional_element_incomplete($this->element, $actualData);
    }

    public function test_planned_disbursement_sub_element_empty_value_json_array()
    {
        $actualData = json_decode(
            '[{"planned_disbursement_type":"1","period_start":[{"iso_date":"2022-07-19"}],"period_end":[{"iso_date":"2022-07-27"}],"value":[{}],"provider_org":[{"ref":"provider-org-ref","provider_activity_id":"123123123","type":"11","narrative":[{"narrative":"asdasdasdads","language":"ab"}]}],"receiver_org":[{"ref":"receiver-org-ref","provider_activity_id":"5555","type":"23","narrative":[{"narrative":"asdasdadasdasd","language":"af"}]}]}]',
            true
        );

        $this->test_level_two_multi_dimensional_element_incomplete($this->element, $actualData);
    }

    public function test_planned_disbursement_sub_element_value_attribute_empty_amount_and_currency_and_value_date()
    {
        $actualData = json_decode(
            '[{"planned_disbursement_type":"1","period_start":[{"iso_date":"2022-07-19"}],"period_end":[{"iso_date":"2022-07-27"}],"value":[{"amount":"","currency":"","value_date":""}],"provider_org":[{"ref":"provider-org-ref","provider_activity_id":"123123123","type":"11","narrative":[{"narrative":"asdasdasdads","language":"ab"}]}],"receiver_org":[{"ref":"receiver-org-ref","provider_activity_id":"5555","type":"23","narrative":[{"narrative":"asdasdadasdasd","language":"af"}]}]}]',
            true
        );

        $this->test_level_two_multi_dimensional_element_incomplete($this->element, $actualData);
    }

    public function test_planned_disbursement_sub_element_value_attribute_empty_amount()
    {
        $actualData = json_decode(
            '[{"planned_disbursement_type":"1","period_start":[{"iso_date":"2022-07-19"}],"period_end":[{"iso_date":"2022-07-27"}],"value":[{"amount":"","currency":"AOA","value_date":"2022-07-30"}],"provider_org":[{"ref":"provider-org-ref","provider_activity_id":"123123123","type":"11","narrative":[{"narrative":"asdasdasdads","language":"ab"}]}],"receiver_org":[{"ref":"receiver-org-ref","provider_activity_id":"5555","type":"23","narrative":[{"narrative":"asdasdadasdasd","language":"af"}]}]}]',
            true
        );

        $this->test_level_two_multi_dimensional_element_incomplete($this->element, $actualData);
    }

    public function test_planned_disbursement_sub_element_value_attribute_empty_currency()
    {
        $actualData = json_decode(
            '[{"planned_disbursement_type":"1","period_start":[{"iso_date":"2022-07-19"}],"period_end":[{"iso_date":"2022-07-27"}],"value":[{"amount":"1111","currency":"","value_date":"2022-07-30"}],"provider_org":[{"ref":"provider-org-ref","provider_activity_id":"123123123","type":"11","narrative":[{"narrative":"asdasdasdads","language":"ab"}]}],"receiver_org":[{"ref":"receiver-org-ref","provider_activity_id":"5555","type":"23","narrative":[{"narrative":"asdasdadasdasd","language":"af"}]}]}]',
            true
        );

        $this->test_level_two_multi_dimensional_element_incomplete($this->element, $actualData);
    }

    public function test_planned_disbursement_sub_element_value_attribute_empty_value_date()
    {
        $actualData = json_decode(
            '[{"planned_disbursement_type":"1","period_start":[{"iso_date":"2022-07-19"}],"period_end":[{"iso_date":"2022-07-27"}],"value":[{"amount":"1111","currency":"AOA","value_date":""}],"provider_org":[{"ref":"provider-org-ref","provider_activity_id":"123123123","type":"11","narrative":[{"narrative":"asdasdasdads","language":"ab"}]}],"receiver_org":[{"ref":"receiver-org-ref","provider_activity_id":"5555","type":"23","narrative":[{"narrative":"asdasdadasdasd","language":"af"}]}]}]',
            true
        );

        $this->test_level_two_multi_dimensional_element_incomplete($this->element, $actualData);
    }

    public function test_planned_disbursement_sub_element_value_attribute_no_amount_key()
    {
        $actualData = json_decode(
            '[{"planned_disbursement_type":"1","period_start":[{"iso_date":"2022-07-19"}],"period_end":[{"iso_date":"2022-07-27"}],"value":[{"currency":"AOA","value_date":"2022-07-30"}],"provider_org":[{"ref":"provider-org-ref","provider_activity_id":"123123123","type":"11","narrative":[{"narrative":"asdasdasdads","language":"ab"}]}],"receiver_org":[{"ref":"receiver-org-ref","provider_activity_id":"5555","type":"23","narrative":[{"narrative":"asdasdadasdasd","language":"af"}]}]}]',
            true
        );

        $this->test_level_two_multi_dimensional_element_incomplete($this->element, $actualData);
    }

    public function test_planned_disbursement_sub_element_value_attribute_no_currency_key()
    {
        $actualData = json_decode(
            '[{"planned_disbursement_type":"1","period_start":[{"iso_date":"2022-07-19"}],"period_end":[{"iso_date":"2022-07-27"}],"value":[{"amount":"1111","value_date":"2022-07-30"}],"provider_org":[{"ref":"provider-org-ref","provider_activity_id":"123123123","type":"11","narrative":[{"narrative":"asdasdasdads","language":"ab"}]}],"receiver_org":[{"ref":"receiver-org-ref","provider_activity_id":"5555","type":"23","narrative":[{"narrative":"asdasdadasdasd","language":"af"}]}]}]',
            true
        );

        $this->test_level_two_multi_dimensional_element_incomplete($this->element, $actualData);
    }

    public function test_planned_disbursement_sub_element_value_attribute_no_value_date_key()
    {
        $actualData = json_decode(
            '[{"planned_disbursement_type":"1","period_start":[{"iso_date":"2022-07-19"}],"period_end":[{"iso_date":"2022-07-27"}],"value":[{"amount":"1111","currency":"AOA"}],"provider_org":[{"ref":"provider-org-ref","provider_activity_id":"123123123","type":"11","narrative":[{"narrative":"asdasdasdads","language":"ab"}]}],"receiver_org":[{"ref":"receiver-org-ref","provider_activity_id":"5555","type":"23","narrative":[{"narrative":"asdasdadasdasd","language":"af"}]}]}]',
            true
        );

        $this->test_level_two_multi_dimensional_element_incomplete($this->element, $actualData);
    }

    /*public function test_planned_disbursement_sub_element_empty_provider_org()
    {
        $actualData = json_decode(
            '[{"planned_disbursement_type":"1","period_start":[{"iso_date":"2022-07-19"}],"period_end":[{"iso_date":"2022-07-27"}],"value":[{"amount":"1111","currency":"AOA","value_date":"2022-07-30"}],"provider_org":"","receiver_org":[{"ref":"receiver-org-ref","provider_activity_id":"5555","type":"23","narrative":[{"narrative":"asdasdadasdasd","language":"af"}]}]}]',
            true
        );

        $this->test_level_two_multi_dimensional_element_incomplete($this->element, $actualData);
    }

    public function test_planned_disbursement_sub_element_empty_provider_org_array()
    {
        $actualData = json_decode(
            '[{"planned_disbursement_type":"1","period_start":[{"iso_date":"2022-07-19"}],"period_end":[{"iso_date":"2022-07-27"}],"value":[{"amount":"1111","currency":"AOA","value_date":"2022-07-30"}],"provider_org":[],"receiver_org":[{"ref":"receiver-org-ref","provider_activity_id":"5555","type":"23","narrative":[{"narrative":"asdasdadasdasd","language":"af"}]}]}]',
            true
        );

        $this->test_level_two_multi_dimensional_element_incomplete($this->element, $actualData);
    }

    public function test_planned_disbursement_sub_element_empty_provider_org_json_array()
    {
        $actualData = json_decode(
            '[{"planned_disbursement_type":"1","period_start":[{"iso_date":"2022-07-19"}],"period_end":[{"iso_date":"2022-07-27"}],"value":[{"amount":"1111","currency":"AOA","value_date":"2022-07-30"}],"provider_org":[{}],"receiver_org":[{"ref":"receiver-org-ref","provider_activity_id":"5555","type":"23","narrative":[{"narrative":"asdasdadasdasd","language":"af"}]}]}]',
            true
        );

        $this->test_level_two_multi_dimensional_element_incomplete($this->element, $actualData);
    }

    public function test_planned_disbursement_sub_element_provider_org_attribute_empty_ref()
    {
        $actualData = json_decode(
            '[{"planned_disbursement_type":"1","period_start":[{"iso_date":"2022-07-19"}],"period_end":[{"iso_date":"2022-07-27"}],"value":[{"amount":"1111","currency":"AOA","value_date":"2022-07-30"}],"provider_org":[{"ref":"","provider_activity_id":"123123123","type":"11","narrative":[{"narrative":"asdasdasdads","language":"ab"}]}],"receiver_org":[{"ref":"receiver-org-ref","provider_activity_id":"5555","type":"23","narrative":[{"narrative":"asdasdadasdasd","language":"af"}]}]}]',
            true
        );

        $this->test_level_two_multi_dimensional_element_incomplete($this->element, $actualData);
    }

    public function test_planned_disbursement_sub_element_provider_org_attribute_no_ref_key()
    {
        $actualData = json_decode(
            '[{"planned_disbursement_type":"1","period_start":[{"iso_date":"2022-07-19"}],"period_end":[{"iso_date":"2022-07-27"}],"value":[{"amount":"1111","currency":"AOA","value_date":"2022-07-30"}],"provider_org":[{"provider_activity_id":"123123123","type":"11","narrative":[{"narrative":"asdasdasdads","language":"ab"}]}],"receiver_org":[{"ref":"receiver-org-ref","provider_activity_id":"5555","type":"23","narrative":[{"narrative":"asdasdadasdasd","language":"af"}]}]}]',
            true
        );

        $this->test_level_two_multi_dimensional_element_incomplete($this->element, $actualData);
    }

    public function test_planned_disbursement_sub_element_provider_org_attribute_empty_provider_activity_id()
    {
        $actualData = json_decode(
            '[{"planned_disbursement_type":"1","period_start":[{"iso_date":"2022-07-19"}],"period_end":[{"iso_date":"2022-07-27"}],"value":[{"amount":"1111","currency":"AOA","value_date":"2022-07-30"}],"provider_org":[{"ref":"provider-org-ref","provider_activity_id":"","type":"11","narrative":[{"narrative":"asdasdasdads","language":"ab"}]}],"receiver_org":[{"ref":"receiver-org-ref","provider_activity_id":"5555","type":"23","narrative":[{"narrative":"asdasdadasdasd","language":"af"}]}]}]',
            true
        );

        $this->test_level_two_multi_dimensional_element_incomplete($this->element, $actualData);
    }

    public function test_planned_disbursement_sub_element_provider_org_attribute_no_provider_activity_id_key()
    {
        $actualData = json_decode(
            '[{"planned_disbursement_type":"1","period_start":[{"iso_date":"2022-07-19"}],"period_end":[{"iso_date":"2022-07-27"}],"value":[{"amount":"1111","currency":"AOA","value_date":"2022-07-30"}],"provider_org":[{"ref":"provider-org-ref","type":"11","narrative":[{"narrative":"asdasdasdads","language":"ab"}]}],"receiver_org":[{"ref":"receiver-org-ref","provider_activity_id":"5555","type":"23","narrative":[{"narrative":"asdasdadasdasd","language":"af"}]}]}]',
            true
        );

        $this->test_level_two_multi_dimensional_element_incomplete($this->element, $actualData);
    }

    public function test_planned_disbursement_sub_element_provider_org_attribute_empty_type()
    {
        $actualData = json_decode(
            '[{"planned_disbursement_type":"1","period_start":[{"iso_date":"2022-07-19"}],"period_end":[{"iso_date":"2022-07-27"}],"value":[{"amount":"1111","currency":"AOA","value_date":"2022-07-30"}],"provider_org":[{"ref":"provider-org-ref","provider_activity_id":"12312","type":"","narrative":[{"narrative":"asdasdasdads","language":"ab"}]}],"receiver_org":[{"ref":"receiver-org-ref","provider_activity_id":"5555","type":"23","narrative":[{"narrative":"asdasdadasdasd","language":"af"}]}]}]',
            true
        );

        $this->test_level_two_multi_dimensional_element_incomplete($this->element, $actualData);
    }

    public function test_planned_disbursement_sub_element_provider_org_attribute_no_type_key()
    {
        $actualData = json_decode(
            '[{"planned_disbursement_type":"1","period_start":[{"iso_date":"2022-07-19"}],"period_end":[{"iso_date":"2022-07-27"}],"value":[{"amount":"1111","currency":"AOA","value_date":"2022-07-30"}],"provider_org":[{"ref":"provider-org-ref","provider_activity_id":"12312","narrative":[{"narrative":"asdasdasdads","language":"ab"}]}],"receiver_org":[{"ref":"receiver-org-ref","provider_activity_id":"5555","type":"23","narrative":[{"narrative":"asdasdadasdasd","language":"af"}]}]}]',
            true
        );

        $this->test_level_two_multi_dimensional_element_incomplete($this->element, $actualData);
    }

    public function test_planned_disbursement_sub_element_provider_org_attribute_empty_narrative()
    {
        $actualData = json_decode(
            '[{"planned_disbursement_type":"1","period_start":[{"iso_date":"2022-07-19"}],"period_end":[{"iso_date":"2022-07-27"}],"value":[{"amount":"1111","currency":"AOA","value_date":"2022-07-30"}],"provider_org":[{"ref":"provider-org-ref","provider_activity_id":"123123123","type":"11","narrative":""}],"receiver_org":[{"ref":"receiver-org-ref","provider_activity_id":"5555","type":"23","narrative":[{"narrative":"asdasdadasdasd","language":"af"}]}]}]',
            true
        );

        $this->test_level_two_multi_dimensional_element_incomplete($this->element, $actualData);
    }

    public function test_planned_disbursement_sub_element_provider_org_attribute_no_narrative_key()
    {
        $actualData = json_decode(
            '[{"planned_disbursement_type":"1","period_start":[{"iso_date":"2022-07-19"}],"period_end":[{"iso_date":"2022-07-27"}],"value":[{"amount":"1111","currency":"AOA","value_date":"2022-07-30"}],"provider_org":[{"ref":"provider-org-ref","provider_activity_id":"123123123","type":"11"}],"receiver_org":[{"ref":"receiver-org-ref","provider_activity_id":"5555","type":"23","narrative":[{"narrative":"asdasdadasdasd","language":"af"}]}]}]',
            true
        );

        $this->test_level_two_multi_dimensional_element_incomplete($this->element, $actualData);
    }

    public function test_planned_disbursement_sub_element_provider_org_sub_element_narrative_attribute_empty_narrative()
    {
        $actualData = json_decode(
            '[{"planned_disbursement_type":"1","period_start":[{"iso_date":"2022-07-19"}],"period_end":[{"iso_date":"2022-07-27"}],"value":[{"amount":"1111","currency":"AOA","value_date":"2022-07-30"}],"provider_org":[{"ref":"provider-org-ref","provider_activity_id":"123123123","type":"11","narrative":[{"narrative":"","language":"ab"}]}],"receiver_org":[{"ref":"receiver-org-ref","provider_activity_id":"5555","type":"23","narrative":[{"narrative":"asdasdadasdasd","language":"af"}]}]}]',
            true
        );

        $this->test_level_two_multi_dimensional_element_incomplete($this->element, $actualData);
    }

    public function test_planned_disbursement_sub_element_provider_org_sub_element_narrative_attribute_no_narrative_key()
    {
        $actualData = json_decode(
            '[{"planned_disbursement_type":"1","period_start":[{"iso_date":"2022-07-19"}],"period_end":[{"iso_date":"2022-07-27"}],"value":[{"amount":"1111","currency":"AOA","value_date":"2022-07-30"}],"provider_org":[{"ref":"provider-org-ref","provider_activity_id":"123123123","type":"11","narrative":[{"language":"ab"}]}],"receiver_org":[{"ref":"receiver-org-ref","provider_activity_id":"5555","type":"23","narrative":[{"narrative":"asdasdadasdasd","language":"af"}]}]}]',
            true
        );

        $this->test_level_two_multi_dimensional_element_incomplete($this->element, $actualData);
    }

    public function test_planned_disbursement_sub_element_empty_receiver_org()
    {
        $actualData = json_decode(
            '[{"planned_disbursement_type":"1","period_start":[{"iso_date":"2022-07-19"}],"period_end":[{"iso_date":"2022-07-27"}],"value":[{"amount":"1111","currency":"AOA","value_date":"2022-07-30"}],"provider_org":[{"ref":"provider-org-ref","provider_activity_id":"123123123","type":"11","narrative":[{"narrative":"asdasdasdads","language":"ab"}]}],"receiver_org":""}]',
            true
        );

        $this->test_level_two_multi_dimensional_element_incomplete($this->element, $actualData);
    }

    public function test_planned_disbursement_sub_element_empty_receiver_org_array()
    {
        $actualData = json_decode(
            '[{"planned_disbursement_type":"1","period_start":[{"iso_date":"2022-07-19"}],"period_end":[{"iso_date":"2022-07-27"}],"value":[{"amount":"1111","currency":"AOA","value_date":"2022-07-30"}],"provider_org":[{"ref":"provider-org-ref","provider_activity_id":"123123123","type":"11","narrative":[{"narrative":"asdasdasdads","language":"ab"}]}],"receiver_org":[]}]',
            true
        );

        $this->test_level_two_multi_dimensional_element_incomplete($this->element, $actualData);
    }

    public function test_planned_disbursement_sub_element_empty_receiver_org_json_array()
    {
        $actualData = json_decode(
            '[{"planned_disbursement_type":"1","period_start":[{"iso_date":"2022-07-19"}],"period_end":[{"iso_date":"2022-07-27"}],"value":[{"amount":"1111","currency":"AOA","value_date":"2022-07-30"}],"provider_org":[{"ref":"provider-org-ref","provider_activity_id":"123123123","type":"11","narrative":[{"narrative":"asdasdasdads","language":"ab"}]}],"receiver_org":[{}]}]',
            true
        );

        $this->test_level_two_multi_dimensional_element_incomplete($this->element, $actualData);
    }

    public function test_planned_disbursement_sub_element_receiver_org_attribute_empty_ref()
    {
        $actualData = json_decode(
            '[{"planned_disbursement_type":"1","period_start":[{"iso_date":"2022-07-19"}],"period_end":[{"iso_date":"2022-07-27"}],"value":[{"amount":"1111","currency":"AOA","value_date":"2022-07-30"}],"provider_org":[{"ref":"provider-org-ref","provider_activity_id":"123123123","type":"11","narrative":[{"narrative":"asdasdasdads","language":"ab"}]}],"receiver_org":[{"ref":"","provider_activity_id":"5555","type":"23","narrative":[{"narrative":"asdasdadasdasd","language":"af"}]}]}]',
            true
        );

        $this->test_level_two_multi_dimensional_element_incomplete($this->element, $actualData);
    }

    public function test_planned_disbursement_sub_element_receiver_org_attribute_no_ref_key()
    {
        $actualData = json_decode(
            '[{"planned_disbursement_type":"1","period_start":[{"iso_date":"2022-07-19"}],"period_end":[{"iso_date":"2022-07-27"}],"value":[{"amount":"1111","currency":"AOA","value_date":"2022-07-30"}],"provider_org":[{"ref":"provider-org-ref","provider_activity_id":"123123123","type":"11","narrative":[{"narrative":"asdasdasdads","language":"ab"}]}],"receiver_org":[{"provider_activity_id":"5555","type":"23","narrative":[{"narrative":"asdasdadasdasd","language":"af"}]}]}]',
            true
        );

        $this->test_level_two_multi_dimensional_element_incomplete($this->element, $actualData);
    }

    public function test_planned_disbursement_sub_element_receiver_org_attribute_empty_provider_activity_id()
    {
        $actualData = json_decode(
            '[{"planned_disbursement_type":"1","period_start":[{"iso_date":"2022-07-19"}],"period_end":[{"iso_date":"2022-07-27"}],"value":[{"amount":"1111","currency":"AOA","value_date":"2022-07-30"}],"provider_org":[{"ref":"provider-org-ref","provider_activity_id":"123123123","type":"11","narrative":[{"narrative":"asdasdasdads","language":"ab"}]}],"receiver_org":[{"ref":"123","provider_activity_id":"","type":"23","narrative":[{"narrative":"asdasdadasdasd","language":"af"}]}]}]',
            true
        );

        $this->test_level_two_multi_dimensional_element_incomplete($this->element, $actualData);
    }

    public function test_planned_disbursement_sub_element_receiver_org_attribute_no_provider_activity_id_key()
    {
        $actualData = json_decode(
            '[{"planned_disbursement_type":"1","period_start":[{"iso_date":"2022-07-19"}],"period_end":[{"iso_date":"2022-07-27"}],"value":[{"amount":"1111","currency":"AOA","value_date":"2022-07-30"}],"provider_org":[{"ref":"provider-org-ref","provider_activity_id":"123123123","type":"11","narrative":[{"narrative":"asdasdasdads","language":"ab"}]}],"receiver_org":[{"ref":"123","type":"23","narrative":[{"narrative":"asdasdadasdasd","language":"af"}]}]}]',
            true
        );

        $this->test_level_two_multi_dimensional_element_incomplete($this->element, $actualData);
    }

    public function test_planned_disbursement_sub_element_receiver_org_attribute_empty_type()
    {
        $actualData = json_decode(
            '[{"planned_disbursement_type":"1","period_start":[{"iso_date":"2022-07-19"}],"period_end":[{"iso_date":"2022-07-27"}],"value":[{"amount":"1111","currency":"AOA","value_date":"2022-07-30"}],"provider_org":[{"ref":"provider-org-ref","provider_activity_id":"123123123","type":"11","narrative":[{"narrative":"asdasdasdads","language":"ab"}]}],"receiver_org":[{"ref":"123","provider_activity_id":"123","type":"","narrative":[{"narrative":"asdasdadasdasd","language":"af"}]}]}]',
            true
        );

        $this->test_level_two_multi_dimensional_element_incomplete($this->element, $actualData);
    }

    public function test_planned_disbursement_sub_element_receiver_org_attribute_no_type_key()
    {
        $actualData = json_decode(
            '[{"planned_disbursement_type":"1","period_start":[{"iso_date":"2022-07-19"}],"period_end":[{"iso_date":"2022-07-27"}],"value":[{"amount":"1111","currency":"AOA","value_date":"2022-07-30"}],"provider_org":[{"ref":"provider-org-ref","provider_activity_id":"123123123","type":"11","narrative":[{"narrative":"asdasdasdads","language":"ab"}]}],"receiver_org":[{"ref":"123","provider_activity_id":"123","narrative":[{"narrative":"asdasdadasdasd","language":"af"}]}]}]',
            true
        );

        $this->test_level_two_multi_dimensional_element_incomplete($this->element, $actualData);
    }

    public function test_planned_disbursement_sub_element_receiver_org_attribute_empty_narrative()
    {
        $actualData = json_decode(
            '[{"planned_disbursement_type":"1","period_start":[{"iso_date":"2022-07-19"}],"period_end":[{"iso_date":"2022-07-27"}],"value":[{"amount":"1111","currency":"AOA","value_date":"2022-07-30"}],"provider_org":[{"ref":"provider-org-ref","provider_activity_id":"123123123","type":"11","narrative":[{"narrative":"asdasdasdads","language":"ab"}]}],"receiver_org":[{"ref":"receiver-org-ref","provider_activity_id":"5555","type":"23","narrative":""}]}]',
            true
        );

        $this->test_level_two_multi_dimensional_element_incomplete($this->element, $actualData);
    }

    public function test_planned_disbursement_sub_element_receiver_org_sub_element_empty_narrative_array()
    {
        $actualData = json_decode(
            '[{"planned_disbursement_type":"1","period_start":[{"iso_date":"2022-07-19"}],"period_end":[{"iso_date":"2022-07-27"}],"value":[{"amount":"1111","currency":"AOA","value_date":"2022-07-30"}],"provider_org":[{"ref":"provider-org-ref","provider_activity_id":"123123123","type":"11","narrative":[{"narrative":"asdasdasdads","language":"ab"}]}],"receiver_org":[{"ref":"receiver-org-ref","provider_activity_id":"5555","type":"23","narrative":[]}]}]',
            true
        );

        $this->test_level_two_multi_dimensional_element_incomplete($this->element, $actualData);
    }

    public function test_planned_disbursement_sub_element_receiver_org_sub_element_empty_narrative_json_array()
    {
        $actualData = json_decode(
            '[{"planned_disbursement_type":"1","period_start":[{"iso_date":"2022-07-19"}],"period_end":[{"iso_date":"2022-07-27"}],"value":[{"amount":"1111","currency":"AOA","value_date":"2022-07-30"}],"provider_org":[{"ref":"provider-org-ref","provider_activity_id":"123123123","type":"11","narrative":[{"narrative":"asdasdasdads","language":"ab"}]}],"receiver_org":[{"ref":"receiver-org-ref","provider_activity_id":"5555","type":"23","narrative":[{}]}]}]',
            true
        );

        $this->test_level_two_multi_dimensional_element_incomplete($this->element, $actualData);
    }

    public function test_planned_disbursement_sub_element_receiver_org_sub_element_no_narrative_key()
    {
        $actualData = json_decode(
            '[{"planned_disbursement_type":"1","period_start":[{"iso_date":"2022-07-19"}],"period_end":[{"iso_date":"2022-07-27"}],"value":[{"amount":"1111","currency":"AOA","value_date":"2022-07-30"}],"provider_org":[{"ref":"provider-org-ref","provider_activity_id":"123123123","type":"11","narrative":[{"narrative":"asdasdasdads","language":"ab"}]}],"receiver_org":[{"ref":"receiver-org-ref","provider_activity_id":"5555","type":"23"}]}]',
            true
        );

        $this->test_level_two_multi_dimensional_element_incomplete($this->element, $actualData);
    }

    public function test_planned_disbursement_sub_element_receiver_org_sub_element_narrative_attribute_empty_narrative()
    {
        $actualData = json_decode(
            '[{"planned_disbursement_type":"1","period_start":[{"iso_date":"2022-07-19"}],"period_end":[{"iso_date":"2022-07-27"}],"value":[{"amount":"1111","currency":"AOA","value_date":"2022-07-30"}],"provider_org":[{"ref":"provider-org-ref","provider_activity_id":"123123123","type":"11","narrative":[{"narrative":"asdasdasdads","language":"ab"}]}],"receiver_org":[{"ref":"receiver-org-ref","provider_activity_id":"5555","type":"23","narrative":[{"narrative":"","language":"af"}]}]}]',
            true
        );

        $this->test_level_two_multi_dimensional_element_incomplete($this->element, $actualData);
    }

    public function test_planned_disbursement_sub_element_receiver_org_sub_element_narrative_attribute_no_narrative_key()
    {
        $actualData = json_decode(
            '[{"planned_disbursement_type":"1","period_start":[{"iso_date":"2022-07-19"}],"period_end":[{"iso_date":"2022-07-27"}],"value":[{"amount":"1111","currency":"AOA","value_date":"2022-07-30"}],"provider_org":[{"ref":"provider-org-ref","provider_activity_id":"123123123","type":"11","narrative":[{"narrative":"asdasdasdads","language":"ab"}]}],"receiver_org":[{"ref":"receiver-org-ref","provider_activity_id":"5555","type":"23","narrative":[{"language":"af"}]}]}]',
            true
        );

        $this->test_level_two_multi_dimensional_element_incomplete($this->element, $actualData);
    }*/

    public function test_planned_disbursement_element_complete()
    {
        $actualData = json_decode(
            '[{"planned_disbursement_type":"1","period_start":[{"iso_date":"2022-07-19"}],"period_end":[{"iso_date":"2022-07-27"}],"value":[{"amount":"1111","currency":"AOA","value_date":"2022-07-30"}],"provider_org":[{"ref":"provider-org-ref","provider_activity_id":"123123123","type":"11","narrative":[{"narrative":"asdasdasdads","language":"ab"}]}],"receiver_org":[{"ref":"receiver-org-ref","provider_activity_id":"5555","type":"23","narrative":[{"narrative":"asdasdadasdasd","language":"af"}]}]}]',
            true
        );

        $this->test_level_two_multi_dimensional_element_complete($this->element, $actualData);
    }
}
