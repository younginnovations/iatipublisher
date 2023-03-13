<?php

declare(strict_types=1);

namespace App\CsvImporter\Entities\Activity\Components\Elements;

use App\CsvImporter\Entities\Activity\Components\ActivityRow;
use App\CsvImporter\Entities\Activity\Components\Elements\Foundation\Iati\Element;
use App\CsvImporter\Entities\Activity\Components\Elements\Transaction\PreparesTransactionData;
use App\CsvImporter\Entities\Activity\Components\Factory\Validation;
use App\Http\Requests\Activity\Transaction\TransactionRequest;
use App\IATI\Traits\DataSanitizeTrait;
use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Support\Arr;

/**
 * Class Transaction.
 */
class Transaction extends Element
{
    use PreparesTransactionData;
    use DataSanitizeTrait;

    /**
     * @var array
     */
    protected array $data = [];

    /**
     * Index under which the data is stored within the object.
     * @var string
     */
    protected string $index = 'transaction';

    /**
     * @var array
     */
    protected array $_csvHeaders = [
        'transaction_internal_reference',
        'transaction_type',
        'transaction_date',
        'transaction_value',
        'transaction_value_date',
        'transaction_description',
        'transaction_provider_organisation_identifier',
        'transaction_provider_organisation_activity_identifier',
        'transaction_provider_organisation_type',
        'transaction_provider_organisation_description',
        'transaction_receiver_organisation_identifier',
        'transaction_receiver_organisation_activity_identifier',
        'transaction_receiver_organisation_type',
        'transaction_receiver_organisation_description',
        'transaction_sector_vocabulary',
        'transaction_sector_vocabulary_uri',
        'transaction_sector_code',
        'transaction_sector_narrative',
        'transaction_recipient_country_code',
        'transaction_recipient_region_code',
        'transaction_recipient_region_vocabulary_uri',
    ];

    /**
     * @var array
     */
    protected array $template = [
        'reference'             => '',
        'humanitarian'          => '',
        'transaction_type'      => ['transaction_type_code' => ''],
        'transaction_date'      => ['date' => ''],
        'value'                 => ['amount' => '', 'date' => '', 'currency' => ''],
        'description'           => ['narrative' => ['narrative' => '', 'language' => '']],
        'provider_organization' => ['organization_identifier_code' => '', 'provider_activity_id' => '', 'type' => '', 'narrative' => ['narrative' => '', 'language' => '']],
        'receiver_organization' => ['organization_identifier_code' => '', 'receiver_activity_id' => '', 'type' => '', 'narrative' => ['narrative' => '', 'language' => '']],
        'disbursement_channel'  => ['disbursement_channel_code' => ''],
        'sector'                => [
            'sector_vocabulary'    => '',
            'vocabulary_uri'       => '',
            'code'          => '',
            'category_code' => '',
            'text'          => '',
            'narrative'            => ['narrative' => '', 'language' => ''],
        ],
        'recipient_country'     => ['country_code' => '', 'narrative' => ['narrative' => '', 'language' => '']],
        'recipient_region'      => ['region_code' => '', 'region_vocabulary' => '', 'vocabulary_uri' => '', 'narrative' => ['narrative' => '', 'language' => '']],
        'flow_type'             => ['flow_type' => ''],
        'finance_type'          => ['finance_type' => ''],
        'aid_type'              => ['aid_type' => ''],
        'tied_status'           => ['tied_status_code' => ''],
    ];

    /**
     * @var ActivityRow
     */
    protected ActivityRow $activityRow;

    /**
     * @var TransactionRequest
     */
    private TransactionRequest $request;

    /**
     * @var
     */
    private mixed $transactionRow;

    /**
     * @var array
     */
    protected array $multipleTransaction;

    /**
     * Transaction constructor.
     *
     * @param            $transactionRow
     * @param            $activityRow
     * @param Validation $factory
     *
     * @throws \JsonException
     */
    public function __construct($transactionRow, $activityRow, Validation $factory)
    {
        $this->transactionRow = $transactionRow;
        $this->activityRow = $activityRow;
        $this->prepare($transactionRow);
        $this->factory = $factory;
        $this->request = new TransactionRequest();
    }

    /**
     * Prepare the IATI Element.
     *
     * @param $fields
     *
     * @return void
     * @throws \JsonException
     */
    protected function prepare($fields): void
    {
        foreach ($fields as $key => $value) {
            $value = (!is_null($value)) ? $value : '';
            $this->setInternalReference($key, $value);
            $this->setHumanitarian();
            $this->setTransactionType($key, $value);
            $this->setTransactionDate($key, $value);
            $this->setTransactionValue($key, $value);
            $this->setTransactionValueDate($key, $value);
            $this->setTransactionDescription($key, $value);
            $this->setProviderOrganization($key, $value);
            $this->setReceiverOrganization($key, $value);
            $this->setDisbursementChannel();
            $this->setSector($key, $value);
            $this->setRecipientCountry($key, $value);
            $this->setRecipientRegion($key, $value);
            $this->setFlowType();
            $this->setFinanceType();
            $this->setAidType();
            $this->setTiedStatus();
        }

        $fields = is_array($fields) ? $this->sanitizeData($fields) : $fields;
    }

    /**
     * Validate data for IATI Element.
     * @param array $multipleTransaction
     * @return $this
     * @throw \JsonException
     */
    public function validate(array $multipleTransaction = []): static
    {
        $this->multipleTransaction = $multipleTransaction;

        $this->validator = $this->factory->sign($this->data())
            ->with($this->rules(), $this->messages())
            ->getValidatorInstance();
        $this->errorValidator = $this->factory->sign($this->data())
            ->with($this->errorRules(), $this->messages())
            ->getValidatorInstance();

        $this->setValidity();

        return $this;
    }

    /**
     * Provides the rules for the IATI Element validation.
     *
     * @return array
     * @throws BindingResolutionException
     * @throws \JsonException
     */
    public function rules(): array
    {
        return $this->getBaseRules($this->request->getWarningForTransaction(Arr::get($this->data, 'transaction', []), true, $this->getActivityData(), $this->multipleTransaction), false);
    }

    /**
     * Provides the rules for the IATI Element validation.
     *
     * @return array
     * @throw \JsonException
     */
    public function errorRules(): array
    {
        return $this->getBaseRules($this->request->getErrorsForTransaction(Arr::get($this->data, 'transaction', []), true, $this->getActivityData()), false);
    }

    /**
     * Provides custom messages used for IATI Element Validation.
     *
     * @return array
     */
    public function messages(): array
    {
        return $this->getBaseMessages($this->request->getMessagesForTransaction(Arr::get($this->data, 'transaction', [])), false);
    }

    /**
     * Returns activity sector, recipient country and region data.
     *
     * @return array
     */
    protected function getActivityData(): array
    {
        return [
          'sector' =>  Arr::get($this->activityLevelSector(), 'sector', []),
          'recipient_country' =>  Arr::get($this->activityLevelRecipientCountry(), 'recipient_country', []),
          'recipient_region' =>  Arr::get($this->activityLevelRecipientRegion(), 'recipient_region', []),
        ];
    }

    /**
     * Get the Sector for the Activity Level.
     *
     * @return mixed
     */
    protected function activityLevelSector(): mixed
    {
        return $this->activityRow->sector->data;
    }

    /**
     * Get the Recipient Country for the Activity Level.
     *
     * @return mixed
     */
    public function activityLevelRecipientCountry(): mixed
    {
        return $this->activityRow->recipientCountry->data;
    }

    /**
     * Get the Recipient Region for the Activity Level.
     *
     * @return mixed
     */
    public function activityLevelRecipientRegion(): mixed
    {
        return $this->activityRow->recipientRegion->data;
    }
}
