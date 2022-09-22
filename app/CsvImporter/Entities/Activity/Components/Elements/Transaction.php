<?php

declare(strict_types=1);

namespace App\CsvImporter\Entities\Activity\Components\Elements;

use App\CsvImporter\Entities\Activity\Components\ActivityRow;
use App\CsvImporter\Entities\Activity\Components\Elements\Foundation\Iati\Element;
use App\CsvImporter\Entities\Activity\Components\Elements\Transaction\PreparesTransactionData;
use App\CsvImporter\Entities\Activity\Components\Factory\Validation;
use Illuminate\Support\Arr;

/**
 * Class Transaction.
 */
class Transaction extends Element
{
    use PreparesTransactionData;

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
            'sector_code'          => '',
            'sector_category_code' => '',
            'sector_text'          => '',
            'narrative'            => ['narrative' => '', 'language' => ''],
        ],
        'recipient_country'     => ['country_code' => '', 'narrative' => ['narrative' => '', 'language' => '']],
        'recipient_region'      => ['region_code' => '', 'vocabulary' => '', 'vocabulary_uri' => '', 'narrative' => ['narrative' => '', 'language' => '']],
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
        $this->activityRow = $activityRow;
        $this->prepare($transactionRow);
        $this->factory = $factory;
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
    }

    /**
     * Validate data for IATI Element.
     *
     * @return $this
     * @throw \JsonException
     */
    public function validate(): static
    {
        $activitySector = Arr::get($this->activityLevelSector(), 'sector', []);
        $this->data['transaction']['sector'][0]['activitySector'] = (empty($activitySector) ? '' : $activitySector);

        $recipientRegion = Arr::get($this->activityLevelRecipientRegion(), 'recipient_region', []);
        $this->data['transaction']['activityRecipientRegion'] = (empty($recipientRegion) ? '' : $recipientRegion);

        $recipientCountry = Arr::get($this->activityLevelRecipientCountry(), 'recipient_country', []);
        $this->data['transaction']['activityRecipientCountry'] = (empty($recipientCountry) ? '' : $recipientCountry);

        $this->validator = $this->factory->sign($this->data())
            ->with($this->rules(), $this->messages())
            ->getValidatorInstance();

        $this->setValidity();

        unset($this->data['transaction']['sector'][0]['activitySector']);
        unset($this->data['transaction']['activityRecipientRegion']);
        unset($this->data['transaction']['activityRecipientCountry']);

        return $this;
    }

    /**
     * Provides the rules for the IATI Element validation.
     *
     * @return array
     * @throw \JsonException
     */
    public function rules(): array
    {
        $sector = Arr::get($this->data(), 'transaction.sector', []);
        $sectorVocabularyCodeList = $this->validCodeList('SectorVocabulary');
        $sectorCodeList = $this->validCodeList('SectorCode');
        $sectorCategoryCodeList = $this->validCodeList('SectorCategory');
        $sectorSdgGoalsCodeList = $this->validCodeList('UNSDG-Goals');
        $sectorSdgTargetsCodeList = $this->validCodeList('UNSDG-Targets');
        $regionCode = $this->validCodeList('Region');
        $countryCode = $this->validCodeList('Country', 'Organization');

        $rules = [
            'transaction'                                          => 'check_recipient_region_country',
            'transaction.transaction_type.*.transaction_type_code' => sprintf('required|in:%s', $this->validCodeOrName('TransactionType')),
            'transaction.transaction_date.*.date'                  => 'required|date_format:Y-m-d',
            'transaction.value.*.amount'                           => 'required|numeric',
            'transaction.value.*.date'                             => 'required|date_format:Y-m-d',
            'transaction.provider_organization.*.type'             => sprintf('in:%s', $this->validCodeOrName('OrganizationType', 'Organization')),
            'transaction.provider_organization'                    => 'only_one_among',
            'transaction.receiver_organization.*.type'             => sprintf('in:%s', $this->validCodeOrName('OrganizationType', 'Organization')),
            'transaction.receiver_organization'                    => 'only_one_among',
            'transaction.sector'                                   => 'check_sector',
            'transaction.recipient_country.0.country_code'         => sprintf('in:%s', $countryCode),
            'transaction.recipient_region.0.region_code'           => sprintf('in:%s', $regionCode),
        ];

        /* Rules for sector */
        foreach ($sector as $sectorValue) {
            $sectorForm = 'transaction.sector.*';

            $vocabulary = Arr::get($sectorValue, 'sector_vocabulary', '');
            if ($vocabulary) {
                $rules[sprintf('%s.vocabulary_uri', $sectorForm)] = 'nullable|url';
                $rules[sprintf('%s.sector_vocabulary', $sectorForm)] = sprintf('in:%s', $sectorVocabularyCodeList);

                switch ($vocabulary) {
                    case '1':
                        $rules[sprintf('%s.sector_code', $sectorForm)] = sprintf('required|in:%s', $sectorCodeList);
                        break;
                    case '2':
                        $rules[sprintf('%s.sector_category_code', $sectorForm)] = sprintf('required|in:%s', $sectorCategoryCodeList);
                        break;
                    case '7':
                        $rules[sprintf('%s.sector_sdg_goal', $sectorForm)] = sprintf('required|in:%s', $sectorSdgGoalsCodeList);
                        break;
                    case '8':
                        $rules[sprintf('%s.sector_sdg_target', $sectorForm)] = sprintf('required|in:%s', $sectorSdgTargetsCodeList);
                        break;
                    case '98':
                    case '99':
                        $rules[sprintf('%s.sector_text', $sectorForm)] = 'required';
                        $rules[sprintf('%s.vocabulary_uri', $sectorForm)] = 'required_with:' . $sectorForm . '.sector_vocabulary';
                        $rules[sprintf('%s.narrative.0.narrative', $sectorForm)] = 'required';
                        break;
                    default:
                        $rules[sprintf('%s.sector_text', $sectorForm)] = 'required';
                        break;
                }
            }
        }

        return $rules;
    }

    /**
     * Provides custom messages used for IATI Element Validation.
     *
     * @return array
     */
    public function messages(): array
    {
        $sector = Arr::get($this->data(), 'transaction.sector', []);
        $message = [
            'transaction.check_recipient_region_country'                    => trans('validation.sector_in_activity_and_transaction'),
            'transaction.transaction_type.*.transaction_type_code.required' => trans('validation.required', ['attribute' => trans('elementForm.transaction_type')]),
            'transaction.transaction_type.*.transaction_type_code.in'       => trans('validation.code_list', ['attribute' => trans('elementForm.transaction_type')]),
            'transaction.transaction_date.*.date.required'                  => trans('validation.required', ['attribute' => trans('elementForm.transaction_date')]),
            'transaction.transaction_date.*.date.date_format'               => trans('validation.csv_date', ['attribute' => trans('elementForm.transaction_date')]),
            'transaction.value.*.amount.required'                           => trans('validation.required', ['attribute' => trans('elementForm.transaction_value')]),
            'transaction.value.*.amount.numeric'                            => trans('validation.numeric', ['attribute' => trans('elementForm.transaction_value')]),
            'transaction.value.*.amount.min'                                => trans('validation.negative', ['attribute' => trans('elementForm.transaction_value')]),
            'transaction.value.*.date.required'                             => trans('validation.required', ['attribute' => trans('elementForm.transaction_value_date')]),
            'transaction.value.*.date.date_format'                          => trans('validation.csv_date', ['attribute' => trans('elementForm.transaction_value_date')]),
            'transaction.provider_organization.*.type.in'                   => trans('validation.invalid_in_transaction', ['attribute' => trans('elementForm.provider_organisation_type')]),
            'transaction.provider_organization.only_one_among'              => trans(
                'validation.required_if',
                [
                    'attribute' => trans('elementForm.provider_organisation_identifier'),
                    'values'    => trans('elementForm.organisation_name'),
                    'value'     => 'absent',
                ]
            ),
            'transaction.receiver_organization.*.type.in'                   => trans('validation.invalid_in_transaction', ['attribute' => trans('elementForm.receiver_organisation_type')]),
            'transaction.receiver_organization.only_one_among'              => trans(
                'validation.required_if_in_transaction',
                [
                    'attribute' => trans('elementForm.receiver_organisation_identifier'),
                    'values'    => trans('elementForm.organisation_name'),
                ]
            ),
            'transaction.sector.check_sector'                               => trans('validation.sector_validation'),
            'transaction.recipient_country.*.country_code.in'               => trans('validation.invalid_in_transaction', ['attribute' => trans('elementForm.recipient_country_code')]),
            'transaction.recipient_region.*.region_code.in'                 => trans('validation.invalid_in_transaction', ['attribute' => trans('elementForm.recipient_region_code')]),
        ];

        /* Messages for transaction sector */
        foreach ($sector as $sectorValue) {
            $sectorForm = 'transaction.sector.*';
            $vocabulary = Arr::get($sectorValue, 'sector_vocabulary', '');

            if ($vocabulary) {
                $message[sprintf('%s.vocabulary_uri.%s', $sectorForm, 'url')] = trans('validation.active_url', ['attribute' => trans('elementForm.sector_vocabulary_uri')]);
                $message[sprintf('%s.sector_vocabulary.%s', $sectorForm, 'in')] = trans('validation.invalid_in_transaction', ['attribute' => trans('elementForm.sector_vocabulary')]);

                switch ($vocabulary) {
                    case '1':
                        $message[sprintf('%s.sector_code.%s', $sectorForm, 'required')] = trans('validation.required', ['attribute' => trans('elementForm.sector_code')]);
                        $message[sprintf('%s.sector_code.%s', $sectorForm, 'in')] = trans('validation.invalid_in_transaction', ['attribute' => trans('elementForm.sector_code')]);
                        break;
                    case '2':
                        $message[sprintf('%s.sector_category_code.%s', $sectorForm, 'required')] = trans('validation.required', ['attribute' => trans('elementForm.sector_code')]);
                        $message[sprintf('%s.sector_category_code.%s', $sectorForm, 'in')] = trans('validation.invalid_in_transaction', ['attribute' => trans('elementForm.sector_code')]);
                        break;
                    case '7':
                        $message[sprintf('%s.sector_sdg_goal.%s', $sectorForm, 'required')] = trans('validation.required', ['attribute' => trans('elementForm.sector_code')]);
                        $message[sprintf('%s.sector_sdg_goal.%s', $sectorForm, 'in')] = trans('validation.invalid_in_transaction', ['attribute' => trans('elementForm.sector_code')]);
                        break;
                    case '8':
                        $message[sprintf('%s.sector_sdg_target.%s', $sectorForm, 'required')] = trans('validation.required', ['attribute' => trans('elementForm.sector_code')]);
                        $message[sprintf('%s.sector_sdg_target.%s', $sectorForm, 'in')] = trans('validation.invalid_in_transaction', ['attribute' => trans('elementForm.sector_code')]);
                        break;
                    case '98':
                    case '99':
                        $message[sprintf('%s.sector_text.%s', $sectorForm, 'required')] = trans('validation.required', ['attribute' => trans('elementForm.sector_code')]);
                        $message[sprintf('%s.vocabulary_uri.%s', $sectorForm, 'required_with')] = trans(
                            'validation.required_with',
                            [
                                'attribute' => trans('elementForm.vocabulary_uri'),
                                'values'    => trans('elementForm.sector_code'),
                            ]
                        );
                        $messages[sprintf('%s.narrative.0.narrative.%s', $sectorForm, 'required')] = trans('validation.required', ['attribute' => trans('elementForm.transaction_sector_narrative')]);
                        break;
                    default:
                        $message[sprintf('%s.sector_text.%s', $sectorForm, 'required')] = trans('validation.required', ['attribute' => trans('elementForm.sector_code')]);
                        break;
                }
            }
        }

        return $message;
    }

    /**
     * Get the valid codes/names from the respective code list.
     *
     * @param        $name
     * @param string $directory
     *
     * @return string
     * @throws \JsonException
     */
    protected function validCodeOrName($name, $directory = 'Activity'): string
    {
        list($validCodes, $codes) = [$this->loadCodeList($name, $directory), []];

        $codes = array_keys($validCodes) + array_values($validCodes);

        return implode(',', array_keys(array_flip($codes)));
    }

    /**
     * Get the valid codes from the respective code list.
     *
     * @param $name
     * @param string $directory
     *
     * @return string
     * @throws \JsonException
     */
    protected function validCodeList($name, $directory = 'Activity'): string
    {
        $codeList = $this->loadCodeList($name, $directory);
        $codes = array_keys($codeList);

        return implode(',', $codes);
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
    protected function activityLevelRecipientCountry(): mixed
    {
        return $this->activityRow->recipientCountry->data;
    }

    /**
     * Get the Recipient Region for the Activity Level.
     *
     * @return mixed
     */
    protected function activityLevelRecipientRegion(): mixed
    {
        return $this->activityRow->recipientRegion->data;
    }
}
