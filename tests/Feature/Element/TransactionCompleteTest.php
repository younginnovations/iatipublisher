<?php

declare(strict_types=1);

namespace Tests\Feature\Element;

use App\IATI\Models\Activity\Activity;
use App\IATI\Models\Activity\Transaction;
use Database\Factories\IATI\Models\Organization\OrganizationFactory;
use Illuminate\Support\Arr;
use Tests\Traits\FilterMandatoryItemsTrait;

/**
 * Class TransactionCompleteTest.
 */
class TransactionCompleteTest extends ElementCompleteTest
{
    use FilterMandatoryItemsTrait;

    protected array $mandatorySubelements = [
        'sub_elements.transaction_type.attributes.transaction_type_code.criteria' => 'mandatory',
        'sub_elements.transaction_date.attributes.date.criteria'                  => 'mandatory',
        'sub_elements.value.attributes.amount.criteria'                           => 'mandatory',
        'sub_elements.value.attributes.date.criteria'                             => 'mandatory',
        'sub_elements.value.attributes.currency.criteria'                         => 'mandatory',
    ];

    protected array $mandatoryAttributes = [];

    /**
     * Element transactions.
     *
     * @var string
     */
    private string  $element = 'transactions';

    /**
     * Test for ensuring mandatory attributes have not changed since the time of writing this test.
     *
     * @return void
     *
     * @throws \JsonException
     */
    public function test_contact_info_mandatory_attributes_have_not_changed(): void
    {
        $transactionSchema = Arr::get(readElementJsonSchema(), $this->element, []);
        $transactionFlattened = flattenArrayWithKeys($transactionSchema);
        $transactionFlattened = getItemsWhereKeyContains($transactionFlattened, '.criteria');
        $mandatoryItemsInSchema = array_filter(
            $transactionFlattened,
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
        $transactionSchema = Arr::get(readElementJsonSchema(), $this->element, []);
        $transactionFlattened = flattenArrayWithKeys($transactionSchema);
        $transactionFlattened = getItemsWhereKeyContains($transactionFlattened, '.criteria');
        $mandatoryItemsInSchema = array_filter(
            $transactionFlattened,
            fn ($item) => !empty($item) && $item == 'mandatory'
        );

        $this->unsetMandatoryAttributes($mandatoryItemsInSchema);

        $this->assertEquals($mandatoryItemsInSchema, $this->mandatorySubelements);
    }

    public function test_transaction_incomplete_when_doesnt_exist()
    {
        $activity = $this->createDummyActivity();

        $this->assertFalse($this->elementCompleteService->isTransactionsElementCompleted($activity));
    }

    public function test_transaction_incomplete_when_all_transactions_value_is_null()
    {
        $actualData = [$this->getEmptyTransactionData()];

        $activity = $this->createDummyActivity();
        $activity = $this->setTransactionValue($activity, $actualData);

        $this->assertFalse($this->elementCompleteService->isTransactionsElementCompleted($activity));
    }

    public function test_transaction_complete_when_all_transactions_value_is_filled()
    {
        $actualData = [$this->getCompleteTransactionData()];

        $activity = $this->createDummyActivity();
        $activity = $this->setTransactionValue($activity, $actualData);

        $this->assertTrue($this->elementCompleteService->isTransactionsElementCompleted($activity));
    }

    public function test_transaction_incomplete_when_transaction_type_is_null()
    {
        $actualData = [$this->getCompleteTransactionData()];
        $actualData[0]['transaction_type'] = null;

        $activity = $this->createDummyActivity();
        $activity = $this->setTransactionValue($activity, $actualData);

        $this->assertFalse($this->elementCompleteService->isTransactionsElementCompleted($activity));
    }

    public function test_transaction_incomplete_when_transaction_type_transaction_type_code_is_null()
    {
        $actualData = [$this->getCompleteTransactionData()];
        $actualData[0]['transaction_type'][0]['transaction_type_code'] = null;

        $activity = $this->createDummyActivity();
        $activity = $this->setTransactionValue($activity, $actualData);

        $this->assertFalse($this->elementCompleteService->isTransactionsElementCompleted($activity));
    }

    public function test_transaction_incomplete_when_transaction_date_is_null()
    {
        $actualData = [$this->getCompleteTransactionData()];
        $actualData[0]['transaction_date'] = null;

        $activity = $this->createDummyActivity();
        $activity = $this->setTransactionValue($activity, $actualData);

        $this->assertFalse($this->elementCompleteService->isTransactionsElementCompleted($activity));
    }

    public function test_transaction_incomplete_when_transaction_date_date_is_null()
    {
        $actualData = [$this->getCompleteTransactionData()];
        $actualData[0]['transaction_date'][0]['date'] = null;

        $activity = $this->createDummyActivity();
        $activity = $this->setTransactionValue($activity, $actualData);

        $this->assertFalse($this->elementCompleteService->isTransactionsElementCompleted($activity));
    }

    public function test_transaction_incomplete_when_transaction_value_is_null()
    {
        $actualData = [$this->getCompleteTransactionData()];
        $actualData[0]['value'] = null;

        $activity = $this->createDummyActivity();
        $activity = $this->setTransactionValue($activity, $actualData);

        $this->assertFalse($this->elementCompleteService->isTransactionsElementCompleted($activity));
    }

    public function test_transaction_incomplete_when_transaction_value_amount_is_null()
    {
        $actualData = [$this->getCompleteTransactionData()];
        $actualData[0]['value'][0]['amount'] = null;

        $activity = $this->createDummyActivity();
        $activity = $this->setTransactionValue($activity, $actualData);

        $this->assertFalse($this->elementCompleteService->isTransactionsElementCompleted($activity));
    }

    public function test_transaction_incomplete_when_transaction_value_date_is_null()
    {
        $actualData = [$this->getCompleteTransactionData()];
        $actualData[0]['value'][0]['date'] = null;

        $activity = $this->createDummyActivity();
        $activity = $this->setTransactionValue($activity, $actualData);

        $this->assertFalse($this->elementCompleteService->isTransactionsElementCompleted($activity));
    }

    public function test_transaction_incomplete_when_transaction_value_currency_is_null()
    {
        $actualData = [$this->getCompleteTransactionData()];
        $actualData[0]['value'][0]['currency'] = null;

        $activity = $this->createDummyActivity();
        $activity = $this->setTransactionValue($activity, $actualData);

        $this->assertFalse($this->elementCompleteService->isTransactionsElementCompleted($activity));
    }

    public function test_activity_RR_and_RC_incomplete_when_transaction_RR_is_not_filled()
    {
        $actualData = [$this->getCompleteTransactionData()];

        $activity = $this->createDummyActivity();
        $activity = $this->setTransactionValue($activity, $actualData);

        $elementStatus = $activity->element_status;

        $this->assertTrue($elementStatus['transactions'], 'Transactions is incomplete.');
        $this->assertFalse($elementStatus['recipient_country'], 'Recipient country is complete. It should be incomplete.');
        $this->assertFalse($elementStatus['recipient_region'], 'Recipient region is complete. It should be incomplete.');
    }

    public function test_activity_RR_and_RC_complete_when_transaction_RR_is_filled()
    {
        $actualData = [$this->getCompleteTransactionData(withRR: true)];

        $activity = $this->createDummyActivity();
        $activity = $this->setTransactionValue($activity, $actualData);

        $elementStatus = $activity->element_status;

        $this->assertTrue($elementStatus['transactions'], 'Transactions is incomplete.');
        $this->assertTrue($elementStatus['recipient_country'], 'Recipient country is incomplete. It should be complete.');
        $this->assertTrue($elementStatus['recipient_region'], 'Recipient region is incomplete. It should be complete.');
    }

    public function test_activity_RR_and_RC_incomplete_when_transaction_RC_is_not_filled()
    {
        $actualData = [$this->getCompleteTransactionData()];

        $activity = $this->createDummyActivity();
        $activity = $this->setTransactionValue($activity, $actualData);

        $elementStatus = $activity->element_status;

        $this->assertTrue($elementStatus['transactions'], 'Transactions is incomplete.');
        $this->assertFalse($elementStatus['recipient_country'], 'Recipient country is complete. It should be incomplete.');
        $this->assertFalse($elementStatus['recipient_region'], 'Recipient region is complete. It should be incomplete.');
    }

    public function test_activity_RR_and_RC_complete_when_transaction_RC_is_filled()
    {
        $actualData = [$this->getCompleteTransactionData(withRC: true)];

        $activity = $this->createDummyActivity();
        $activity = $this->setTransactionValue($activity, $actualData);

        $elementStatus = $activity->element_status;

        $this->assertTrue($elementStatus['transactions'], 'Transactions is incomplete.');
        $this->assertTrue($elementStatus['recipient_country'], 'Recipient country is incomplete. It should be complete.');
        $this->assertTrue($elementStatus['recipient_region'], 'Recipient region is incomplete. It should be complete.');
    }

    public function test_activity_sector_incomplete_when_transaction_sector_is_not_filled()
    {
        $actualData = [$this->getCompleteTransactionData()];

        $activity = $this->createDummyActivity();
        $activity = $this->setTransactionValue($activity, $actualData);

        $elementStatus = $activity->element_status;

        $this->assertTrue($elementStatus['transactions'], 'Transactions is incomplete.');
        $this->assertFalse($elementStatus['recipient_country'], 'Recipient country is complete. It should be incomplete.');
        $this->assertFalse($elementStatus['recipient_region'], 'Recipient region is complete. It should be incomplete.');
    }

    public function test_activity_sector_complete_when_transaction_sector_is_filled()
    {
        $actualData = [$this->getCompleteTransactionData(withRC: true)];

        $activity = $this->createDummyActivity();
        $activity = $this->setTransactionValue($activity, $actualData);

        $elementStatus = $activity->element_status;

        $this->assertTrue($elementStatus['transactions'], 'Transactions is incomplete.');
        $this->assertTrue($elementStatus['recipient_country'], 'Recipient country is incomplete. It should be complete.');
        $this->assertTrue($elementStatus['recipient_region'], 'Recipient region is incomplete. It should be complete.');
    }

    /** Utility methods */
    private function createDummyActivity(): Activity
    {
        $orgId = (OrganizationFactory::new()->create())->id;

        $emptyActivityData = [
            'iati_identifier'         => [
                'activity_identifier'             => 'TAN',
                'iati_identifier_text'            => 'NP-SWC-0987-TAN',
                'present_organization_identifier' => 'NP-SWC-0987',
            ],
            'other_identifier'        => null,
            'title'                   => [
                [
                    'narrative' => 'test activity narrative',
                    'language'  => 'ng',
                ],
            ],
            'description'             => null,
            'activity_status'         => null,
            'status'                  => 'draft',
            'activity_date'           => null,
            'contact_info'            => null,
            'activity_scope'          => null,
            'participating_org'       => null,
            'recipient_country'       => null,
            'recipient_region'        => null,
            'location'                => null,
            'sector'                  => null,
            'country_budget_items'    => null,
            'humanitarian_scope'      => null,
            'policy_marker'           => null,
            'collaboration_type'      => null,
            'default_flow_type'       => null,
            'default_finance_type'    => null,
            'default_aid_type'        => null,
            'default_tied_status'     => null,
            'budget'                  => null,
            'planned_disbursement'    => null,
            'capital_spend'           => null,
            'document_link'           => null,
            'related_activity'        => null,
            'legacy_data'             => null,
            'conditions'              => null,
            'org_id'                  => $orgId,
            'default_field_values'    => [
                'default_currency'           => 'AOA',
                'default_language'           => 'ng',
                'hierarchy'                  => '1',
                'budget_not_provided'        => '',
                'humanitarian'               => '',
                'linked_data_uri'            => '',
                'default_collaboration_type' => '',
                'default_flow_type'          => '',
                'default_finance_type'       => '',
                'default_aid_type'           => '',
                'default_tied_status'        => '',
            ],
            'already_published'       => false,
            'linked_to_iati'          => false,
            'tag'                     => null,
            'element_status'          => [
                'iati_identifier'      => true,
                'title'                => true,
                'description'          => false,
                'activity_status'      => false,
                'activity_date'        => false,
                'activity_scope'       => false,
                'recipient_country'    => false,
                'recipient_region'     => false,
                'collaboration_type'   => false,
                'default_flow_type'    => false,
                'default_finance_type' => false,
                'default_aid_type'     => false,
                'default_tied_status'  => false,
                'capital_spend'        => false,
                'related_activity'     => false,
                'conditions'           => false,
                'sector'               => false,
                'humanitarian_scope'   => false,
                'legacy_data'          => false,
                'tag'                  => false,
                'policy_marker'        => false,
                'other_identifier'     => false,
                'country_budget_items' => false,
                'budget'               => false,
                'participating_org'    => false,
                'document_link'        => false,
                'contact_info'         => false,
                'location'             => false,
                'planned_disbursement' => false,
                'transactions'         => false,
                'result'               => false,
                'reporting_org'        => true,
            ],
            'created_at'              => '2024-12-18T03:45:50.000000Z',
            'updated_at'              => '2024-12-18T03:45:50.000000Z',
            'reporting_org'           => [
                [
                    'ref'                => 'NP-SWC-0987',
                    'type'               => '15',
                    'secondary_reporter' => '1',
                    'narrative'          => [
                        [
                            'narrative' => 'dsadas',
                            'language'  => 'ab',
                        ],
                    ],
                ],
            ],
            'upload_medium'           => 'manual',
            'migrated_from_aidstream' => false,
            'complete_percentage'     => 18.75,
            'has_ever_been_published' => false,
            'deprecation_status_map'  => [
                'iati_identifier'      => [],
                'other_identifier'     => [],
                'title'                => [],
                'description'          => [],
                'activity_status'      => [],
                'activity_date'        => [],
                'contact_info'         => [],
                'activity_scope'       => [],
                'participating_org'    => [],
                'recipient_country'    => [],
                'recipient_region'     => [],
                'location'             => [],
                'sector'               => [],
                'country_budget_items' => [],
                'humanitarian_scope'   => [],
                'policy_marker'        => [],
                'collaboration_type'   => [],
                'default_flow_type'    => [],
                'default_finance_type' => [],
                'default_aid_type'     => [],
                'default_tied_status'  => [],
                'budget'               => [],
                'planned_disbursement' => [],
                'capital_spend'        => [],
                'document_link'        => [],
                'related_activity'     => [],
                'legacy_data'          => [],
                'conditions'           => [],
                'tag'                  => [],
                'reporting_org'        => [],
            ],
        ];

        $emptyTransactionData = [];
        $emptyResultData = [];

        $activity = Activity::create($emptyActivityData);
        $activity->transactions()->createMany($emptyTransactionData);
        $activity->results()->createMany($emptyResultData);

        return $activity;
    }

    private function setTransactionValue(Activity $activity, array $actualData): Activity
    {
        $transactionSchema = [
            'activity_id'=>$activity->id,
            'transaction' => [],
            'created_at'=> now(),
            'updated_at'=> now(),
        ];

        foreach ($actualData as $transactionData) {
            $transactionSchema['transaction'] = $transactionData;

            Transaction::create($transactionSchema);
        }

        return $activity->refresh();
    }

    public function getEmptyTransactionData()
    {
        return json_decode('{"reference":null,"humanitarian":null,"transaction_type":[{"transaction_type_code":null}],"transaction_date":[{"date":null}],"value":[{"amount":null,"date":null,"currency":null}],"description":[{"narrative":[{"narrative":null,"language":null}]}],"provider_organization":[{"organization_identifier_code":null,"provider_activity_id":null,"type":null,"narrative":[{"narrative":null,"language":null}]}],"receiver_organization":[{"organization_identifier_code":null,"receiver_activity_id":null,"type":null,"narrative":[{"narrative":null,"language":null}]}],"disbursement_channel":[{"disbursement_channel_code":null}],"sector":[{"sector_vocabulary":null,"text":null,"narrative":[{"narrative":null,"language":null}]}],"recipient_country":[{"country_code":null,"narrative":[{"narrative":null,"language":null}]}],"recipient_region":[{"region_vocabulary":null,"custom_code":null,"narrative":[{"narrative":null,"language":null}]}],"flow_type":[{"flow_type":null}],"finance_type":[{"finance_type":null}],"aid_type":[{"aid_type_vocabulary":null,"aid_type_code":null}],"tied_status":[{"tied_status_code":null}]}', true);
    }

    public function getCompleteTransactionData(bool $withRR = false, bool $withRC = false, bool $withSector = false)
    {
        if ($withRR) {
            return json_decode('{"reference":"Reference","humanitarian":"0","transaction_type":[{"transaction_type_code":"1"}],"transaction_date":[{"date":"2024-12-18"}],"value":[{"amount":"10000000","date":"2024-12-17","currency":"AOA"}],"description":[{"narrative":[{"narrative":"Description data","language":"ng"}]}],"provider_organization":[{"organization_identifier_code":"provide-org-reference","provider_activity_id":"provide-org-activity-id","type":"10","narrative":[{"narrative":"provide-org-narrative","language":"ng"}]}],"receiver_organization":[{"organization_identifier_code":"receiver-org-reference","receiver_activity_id":"receiver-org-activity-id","type":"10","narrative":[{"narrative":"receiver-org-narrative","language":"ng"}]}],"disbursement_channel":[{"disbursement_channel_code":"1"}],"sector":[{"sector_vocabulary":null,"code":null,"narrative":[{"narrative":null,"language":null}]}],"recipient_country":[{"country_code":null,"narrative":[{"narrative":null,"language":null}]}],"recipient_region":[{"region_vocabulary":"1","region_code":"88","narrative":[{"narrative":"RR-narrative","language":"ng"}]}],"flow_type":[{"flow_type":"21"}],"finance_type":[{"finance_type":"1"}],"aid_type":[{"aid_type_vocabulary":"1","aid_type_code":"A01"}],"tied_status":[{"tied_status_code":"3"}]}', true);
        }

        if ($withRC) {
            return json_decode('{"reference":"Reference","humanitarian":"0","transaction_type":[{"transaction_type_code":"1"}],"transaction_date":[{"date":"2024-12-18"}],"value":[{"amount":"10000000","date":"2024-12-17","currency":"AOA"}],"description":[{"narrative":[{"narrative":"Description data","language":"ng"}]}],"provider_organization":[{"organization_identifier_code":"provide-org-reference","provider_activity_id":"provide-org-activity-id","type":"10","narrative":[{"narrative":"provide-org-narrative","language":"ng"}]}],"receiver_organization":[{"organization_identifier_code":"receiver-org-reference","receiver_activity_id":"receiver-org-activity-id","type":"10","narrative":[{"narrative":"receiver-org-narrative","language":"ng"}]}],"disbursement_channel":[{"disbursement_channel_code":"1"}],"sector":[{"sector_vocabulary":null,"code":null,"narrative":[{"narrative":null,"language":null}]}],"recipient_country":[{"country_code":"NP","narrative":[{"narrative":"RC narr","language":"AF"}]}],"recipient_region":[{"region_vocabulary":null,"region_code":null,"narrative":[{"narrative":null,"language":null}]}],"flow_type":[{"flow_type":"21"}],"finance_type":[{"finance_type":"1"}],"aid_type":[{"aid_type_vocabulary":"1","aid_type_code":"A01"}],"tied_status":[{"tied_status_code":"3"}]}', true);
        }

        if ($withSector) {
            return json_decode('{"reference":"Reference","humanitarian":"0","transaction_type":[{"transaction_type_code":"1"}],"transaction_date":[{"date":"2024-12-18"}],"value":[{"amount":"10000000","date":"2024-12-17","currency":"AOA"}],"description":[{"narrative":[{"narrative":"Description data","language":"ng"}]}],"provider_organization":[{"organization_identifier_code":"provide-org-reference","provider_activity_id":"provide-org-activity-id","type":"10","narrative":[{"narrative":"provide-org-narrative","language":"ng"}]}],"receiver_organization":[{"organization_identifier_code":"receiver-org-reference","receiver_activity_id":"receiver-org-activity-id","type":"10","narrative":[{"narrative":"receiver-org-narrative","language":"ng"}]}],"disbursement_channel":[{"disbursement_channel_code":"1"}],"sector":[{"sector_vocabulary":"1","code":"11110","narrative":[{"narrative":"sector-narrative","language":"ng"}]}],"recipient_country":[{"country_code":null,"narrative":[{"narrative":null,"language":null}]}],"recipient_region":[{"region_vocabulary":null,"region_code":null,"narrative":[{"narrative":null,"language":null}]}],"flow_type":[{"flow_type":"21"}],"finance_type":[{"finance_type":"1"}],"aid_type":[{"aid_type_vocabulary":"1","aid_type_code":"A01"}],"tied_status":[{"tied_status_code":"3"}]}', true);
        }

        return json_decode('{"reference":"Reference","humanitarian":"0","transaction_type":[{"transaction_type_code":"1"}],"transaction_date":[{"date":"2024-12-18"}],"value":[{"amount":"10000000","date":"2024-12-17","currency":"AOA"}],"description":[{"narrative":[{"narrative":"Description data","language":"ng"}]}],"provider_organization":[{"organization_identifier_code":"provide-org-reference","provider_activity_id":"provide-org-activity-id","type":"10","narrative":[{"narrative":"provide-org-narrative","language":"ng"}]}],"receiver_organization":[{"organization_identifier_code":"receiver-org-reference","receiver_activity_id":"receiver-org-activity-id","type":"10","narrative":[{"narrative":"receiver-org-narrative","language":"ng"}]}],"disbursement_channel":[{"disbursement_channel_code":"1"}],"sector":[{"sector_vocabulary":null,"code":null,"narrative":[{"narrative":null,"language":null}]}],"recipient_country":[{"country_code":null,"narrative":[{"narrative":null,"language":null}]}],"recipient_region":[{"region_vocabulary":null,"region_code":null,"narrative":[{"narrative":null,"language":null}]}],"flow_type":[{"flow_type":"21"}],"finance_type":[{"finance_type":"1"}],"aid_type":[{"aid_type_vocabulary":"1","aid_type_code":"A01"}],"tied_status":[{"tied_status_code":"3"}]}', true);
    }
}
