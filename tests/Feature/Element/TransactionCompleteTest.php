<?php

declare(strict_types=1);

namespace Tests\Feature\Element;

/**
 * Class TransactionCompleteTest.
 */
class TransactionCompleteTest extends ElementCompleteTest
{
    /**
     * Element transactions.
     *
     * @var string
     */
    private string $element = 'transactions';

    /**
     * Mandatory attribute test.
     *
     * @return void
     * @throws \JsonException
     */
    public function test_transaction_mandatory_attributes(): void
    {
        $this->test_mandatory_attributes($this->element, []);
    }

    /**
     * Mandatory sub element test.
     *
     * @return void
     * @throws \JsonException
     */
    public function test_transaction_mandatory_sub_elements(): void
    {
        $this->test_mandatory_sub_elements($this->element, [
            'transaction_type' => ['transaction_type_code'],
            'transaction_date' => ['date'],
            'value'            => ['amount', 'date', 'currency'],
            'recipient_region' => ['region_code', 'custom_code'],
            'aid_type'         => ['aid_type_code', 'earmarking_category', 'earmarking_modality', 'cash_and_voucher_modalities'],
        ]);
    }

    /**
     * Transaction element complete test.
     *
     * @return void
     * @throws \JsonException
     */
    public function test_transaction_element_complete(): void
    {
        $elementSchema = getElementSchema($this->element);
        $actualData = json_decode(
            '{"reference":"ref test1","humanitarian":"1","transaction_type":[{"transaction_type_code":"1"}],"transaction_date":[{"date":"2022-07-08"}],"value":[{"amount":"5000","date":"2022-07-08","currency":"AED"}],"description":[{"narrative":[{"narrative":"test description","language":"ab"},{"narrative":"description 2","language":"af"}]}],"provider_organization":[{"organization_identifier_code":"provider ref","provider_activity_id":"15","type":"15","narrative":[{"narrative":"narative 1","language":"ae"},{"narrative":"narrative 2","language":"am"}]}],"receiver_organization":[{"organization_identifier_code":"receiver org","receiver_activity_id":"16","type":"15","narrative":[{"narrative":"receiver narrative 1","language":"ab"},{"narrative":"receiver narrative 2","language":"ak"}]}],"disbursement_channel":[{"disbursement_channel_code":null}],"sector":[{"sector_vocabulary":"2","category_code":"112","narrative":[{"narrative":"test narrative","language":"ab"},{"narrative":"test narrative 2","language":"am"}]},{"sector_vocabulary":"4","text":"5638","narrative":[{"narrative":"narrative 22","language":"af"},{"narrative":"narrative 23","language":"am"}]}],"recipient_country":[{"country_code":"AL","narrative":[{"narrative":"test narrative","language":"ab"},{"narrative":"test narrative recipient","language":"am"}]}],"recipient_region":[{"region_vocabulary":"99","custom_code":"test code","vocabulary_uri":"https:\/\/github.com\/younginnovations\/iatipublisher\/runs\/6980821807?check_suite_focus=true","narrative":[{"narrative":"narrative region 1","language":"aa"},{"narrative":"narrative region 2","language":"am"}]}],"flow_type":[{"flow_type":"10"}],"finance_type":[{"finance_type":"210"}],"aid_type":[{"aid_type_vocabulary":"1","aid_type_code":"A02"},{"aid_type_vocabulary":"4","cash_and_voucher_modalities":"1"}],"tied_status":[{"tied_status_code":"3"}]}',
            true,
            512,
            JSON_THROW_ON_ERROR
        );

        $this->test_transaction_data_complete($elementSchema['sub_elements'], $actualData);
    }
}
