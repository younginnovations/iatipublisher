<?php

declare(strict_types=1);

namespace Tests\Feature\Element;

use Illuminate\Support\Arr;
use Tests\Traits\FilterMandatoryItemsTrait;
use Tests\Traits\TestDataTrait;

/**
 * Class TransactionCompleteTest.
 */
class TransactionCompleteTest extends ElementCompleteTest
{
    use FilterMandatoryItemsTrait;
    use TestDataTrait;

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
}
