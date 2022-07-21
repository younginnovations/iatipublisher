<?php

namespace Tests\Feature\Element;

class TransactionCompleteTest extends ElementCompleteTest
{
    private string $element = 'transactions';

    public function __construct(?string $name = null, array $data = [], $dataName = '')
    {
        parent::__construct($name, $data, $dataName);

        $this->activityObj->element = $this->element;
    }

    public function test_transaction_mandatory_attributes()
    {
        $this->test_mandatory_attributes($this->element, []);
    }

    public function test_transaction_mandatory_sub_elements()
    {
        $this->test_mandatory_sub_elements($this->element, [
            'transaction_type' => ['transaction_type_code'],
            'transaction_date' => ['date'],
            'value'            => ['amount', 'date', 'currency'],
            'recipient_region' => ['region_code', 'custom_code'],
            'aid_type'         => ['aid_type_code', 'earmarking_category', 'earmarking_modality', 'cash_and_voucher_modalities'],
        ]);
    }

    public function test_transaction_element_complete()
    {
        $elementSchema = $this->elementSchema($this->element);
        $actualData = json_decode(
            '{"reference":"ref test","humanitarian":"1","transaction_type":[{"transaction_type_code":"1"}],"transaction_date":[{"date":"2022-07-08"}],"value":[{"amount":"5000","date":"2022-07-08","currency":"AED"}],"description":[{"narrative":[{"narrative":"test description","language":"ab"},{"narrative":"description 2","language":"af"}]}],"provider_organization":[{"organization_identifier_code":"provider ref","provider_activity_id":"15","type":"15","narrative":[{"narrative":"narative 1","language":"ae"},{"narrative":"narrative 2","language":"am"}]}],"receiver_organization":[{"organization_identifier_code":"receiver org","receiver_activity_id":"16","type":"15","narrative":[{"narrative":"receiver narrative 1","language":"ab"},{"narrative":"receiver narrative 2","language":"ak"}]}],"disbursement_channel":[{"disbursement_channel_code":"123"}],"sector":[{"sector_vocabulary":"2","vocabulary_uri":null,"code":null,"text":null,"category_code":"112","sdg_goal":null,"sdg_target":null,"narrative":[{"narrative":"test narrative","language":"ab"},{"narrative":"test narrative 2","language":"am"}]},{"sector_vocabulary":"4","vocabulary_uri":null,"code":null,"text":"5638","category_code":null,"sdg_goal":null,"sdg_target":null,"narrative":[{"narrative":"narrative 22","language":"af"},{"narrative":"narrative 23","language":"am"}]}],"recipient_country":[{"country_code":"AL","narrative":[{"narrative":"test narrative","language":"ab"},{"narrative":"test narrative recipient","language":"am"}]}],"recipient_region":[{"region_vocabulary":"99","region_code":"123","custom_code":"test code","vocabulary_uri":"https:\/\/github.com\/younginnovations\/iatipublisher\/runs\/6980821807?check_suite_focus=true","narrative":[{"narrative":"narrative region 1","language":"aa"},{"narrative":"narrative region 2","language":"am"}]}],"flow_type":[{"flow_type":"10"}],"finance_type":[{"finance_type":"210"}],"aid_type":[{"aid_type_vocabulary":"1","aid_type_code":"A02","earmarking_category":"asdasd","earmarking_modality":"asd","cash_and_voucher_modalities":"asdasd"},{"aid_type_vocabulary":"4","aid_type_code":"asdsad","earmarking_category":"asdasd","earmarking_modality":"asdsad","cash_and_voucher_modalities":"1"}],"tied_status":[{"tied_status_code":"3"}]}',
            true
        );

        $this->test_transaction_data_complete($elementSchema['sub_elements'], $actualData);
    }
}
