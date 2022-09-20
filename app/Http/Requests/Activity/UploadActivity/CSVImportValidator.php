<?php

declare(strict_types=1);

namespace App\Http\Requests\Activity\UploadActivity;

use DateTime;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Facades\Excel;

/**
 * Class CsvImportValidator.
 */
class CSVImportValidator
{
    public const REQUIRED_NONEMPTY_FIELD = 1;
    public const IDENTICAL_INTERNAL_REFERENCE = 1;

    public function __construct()
    {
        Validator::extend(
            'multiple_value_in',
            static function ($attribute, $value, $parameters) {
                $inputs = explode(';', $value);
                foreach ($inputs as $input) {
                    if (!in_array($input, $parameters, true)) {
                        return false;
                    }
                }

                return true;
            }
        );

        Validator::extendImplicit(
            'required_any',
            function ($attribute, $value, $parameters) {
                $maxParams = count($parameters);

                for ($i = 1; $i < $maxParams; $i += 2) {
                    $values = $parameters[$i];

                    if (!empty($values)) {
                        return true;
                    }
                }

                return false;
            }
        );

        Validator::extendImplicit(
            'required_only_one',
            function ($attribute, $value, $parameters) {
                $counter = 0;

                foreach ($parameters as $parameterIndex => $parameter) {
                    if (($parameterIndex % 2 !== 0) && (!empty($parameter))) {
                        $counter++;
                    }
                }

                if ($counter === self::REQUIRED_NONEMPTY_FIELD) {
                    return true;
                }

                return false;
            }
        );

        Validator::extendImplicit(
            'unique_validation',
            function ($attribute, $value, $parameters) {
                $csvData = Excel::load($parameters[2])->get()->toArray();
                $counter = 0;
                $csvFiled = $parameters[3];

                foreach ($csvData as $csvDatum) {
                    if ($csvDatum[$csvFiled] === $parameters[1]) {
                        $counter++;
                    }
                }

                return $counter === self::IDENTICAL_INTERNAL_REFERENCE;
            }
        );
    }

    /**
     * check if date is valid or not.
     *
     * @param $date
     *
     * @return bool
     */
    public function validateDate($date): bool
    {
        $dateFormat = DateTime::createFromFormat('Y-m-d', $date);
        $checkDate = checkdate($date->format('m'), $date->format('d'), $date->format('Y'));

        return $dateFormat && $checkDate;
    }

    /**
     * check if the csv file data is valid or not.
     *
     * @param $file
     *
     * @return \Illuminate\Contracts\Validation\Validator|\Illuminate\Validation\Validator|null
     * @throws \JsonException
     */
    public function getDetailedCsvValidator($file): \Illuminate\Contracts\Validation\Validator|\Illuminate\Validation\Validator|null
    {
        $transactions = Excel::load($file)->get()->toArray();
        $transactionHeader = Excel::load($file)->get()->first()->keys()->toArray();
        $templateHeader = Excel::load(app_path('Core/V201/Template/Csv/iati_transaction_template_detailed.csv'))->get()->first()->keys()->toArray();

        if (count(array_intersect($transactionHeader, $templateHeader)) !== count($templateHeader)) {
            return null;
        }

        $transactionTypeCodes = implode(',', array_keys(getCodeList('TransactionType', 'Activity', false)));
        $disbursementChannelCodes = implode(',', array_keys(getCodeList('DisbursementChannel', 'Activity', false)));
        $sectorVocabularyCodes = implode(',', array_keys(getCodeList('SectorVocabulary', 'Activity', false)));
        $recipientCountryCodes = implode(',', array_keys(getCodeList('Country', 'Organization', false)));
        $recipientRegionCodes = implode(',', array_keys(getCodeList('Region', 'Activity', false)));
        $recipientRegionVocabularyCodes = implode(',', array_keys(getCodeList('RegionVocabulary', 'Activity', false)));
        $flowTypeCodes = implode(',', array_keys(getCodeList('FlowType', 'Activity', false)));
        $financeTypeCodes = implode(',', array_keys(getCodeList('FinanceType', 'Activity', false)));
        $aidTypeCodes = implode(',', array_keys(getCodeList('AidType', 'Activity', false)));
        $tiedStatusCodes = implode(',', array_keys(getCodeList('TiedStatus', 'Activity', false)));

        $rules = [];
        $messages = [];

        foreach ($transactions as $transactionIndex => $transactionRow) {
            $rules["$transactionIndex.transaction_ref"] = sprintf(
                'required|unique_validation:%s.transaction_ref,%s,%s,transaction_ref',
                $transactionIndex,
                trimInput($transactionRow['transaction_ref']),
                $file
            );
            $rules["$transactionIndex.transactiontype_code"] = 'in:' . $transactionTypeCodes;
            $rules["$transactionIndex.transactiondate_iso_date"] = 'date';
            $rules["$transactionIndex.transactionvalue_value_date"] = 'date';
            $rules["$transactionIndex.transactionvalue_text"] = 'numeric';
            $rules["$transactionIndex.description_text"] = '';
            $rules["$transactionIndex.disbursementchannel_code"] = 'in:' . $disbursementChannelCodes;
            $rules["$transactionIndex.sector_vocabulary"] = 'in:' . $sectorVocabularyCodes;
            $rules["$transactionIndex.recipientcountry_code"] = 'in:' . $recipientCountryCodes;
            $rules["$transactionIndex.recipientregion_code"] = 'in:' . $recipientRegionCodes;
            $rules["$transactionIndex.recipientregion_vocabulary"] = 'in:' . $recipientRegionVocabularyCodes;
            $rules["$transactionIndex.flowtype_code"] = 'in:' . $flowTypeCodes;
            $rules["$transactionIndex.financetype_code"] = 'in:' . $financeTypeCodes;
            $rules["$transactionIndex.aidtype_code"] = 'in:' . $aidTypeCodes;
            $rules["$transactionIndex.tiedstatus_code"] = 'in:' . $tiedStatusCodes;

            $messages["$transactionIndex.transaction_ref.required"] = trans(
                'validation.csv_required',
                ['number' => $transactionIndex + 1, 'attribute' => trans('element.transaction') . '-' . trans('elementForm.ref')]
            );
            $messages["$transactionIndex.transaction_ref.unique_validation"] = trans(
                'validation.csv_unique',
                ['number' => $transactionIndex + 1, 'attribute' => trans('element.transaction') . '-' . trans('elementForm.ref')]
            );
            $messages["$transactionIndex.transactiontype_code.required"] = trans(
                'validation.csv_required',
                ['number' => $transactionIndex + 1, 'attribute' => trans('elementForm.transaction_type') . '-' . trans('elementForm.code')]
            );
            $messages["$transactionIndex.transactiontype_code.in"] = trans(
                'validation.csv_invalid',
                ['number' => $transactionIndex + 1, 'attribute' => trans('elementForm.transaction_type') . '-' . trans('elementForm.code')]
            );
            $messages["$transactionIndex.transactiondate_iso_date.required"] = trans(
                'validation.csv_required',
                ['number' => $transactionIndex + 1, 'attribute' => trans('elementForm.transaction_date') . '-' . trans('elementForm.iso_date')]
            );
            $messages["$transactionIndex.transactiondate_iso_date.date"] = trans(
                'validation.csv_invalid',
                ['number' => $transactionIndex + 1, 'attribute' => trans('elementForm.transaction_value') . '-' . trans('elementForm.value_date')]
            );
            $messages["$transactionIndex.transactionvalue_value_date.required"] = trans(
                'validation.csv_required',
                ['number' => $transactionIndex + 1, 'attribute' => trans('elementForm.transaction_value') . '-' . trans('elementForm.value_date')]
            );
            $messages["$transactionIndex.transactionvalue_value_date.date"] = trans(
                'validation.csv_invalid',
                ['number' => $transactionIndex + 1, 'attribute' => trans('elementForm.transaction_value') . '-' . trans('elementForm.value_date')]
            );
            $messages["$transactionIndex.transactionvalue_text.required"] = trans(
                'validation.csv_required',
                ['number' => $transactionIndex + 1, 'attribute' => trans('elementForm.transaction_value') . '-' . trans('elementForm.text')]
            );
            $messages["$transactionIndex.transactionvalue_text.numeric"] = trans(
                'validation.csv_numeric',
                ['number' => $transactionIndex + 1, 'attribute' => trans('elementForm.transaction_value') . '-' . trans('elementForm.text')]
            );
            $messages["$transactionIndex.description_text.required"] = trans(
                'validation.csv_required',
                ['number' => $transactionIndex + 1, 'attribute' => trans('element.description') . '-' . trans('elementForm.text')]
            );
            $messages["$transactionIndex.disbursementchannel_code.in"] = trans(
                'validation.csv_invalid',
                ['number' => $transactionIndex + 1, 'attribute' => trans('elementForm.disbursement_channel') . '-' . trans('elementForm.code')]
            );
            $messages["$transactionIndex.sector_vocabulary.in"] = trans(
                'validation.csv_invalid',
                ['number' => $transactionIndex + 1, 'attribute' => trans('element.sector') . '-' . trans('elementForm.vocabulary')]
            );
            $messages["$transactionIndex.recipientcountry_code.in"] = trans(
                'validation.csv_invalid',
                ['number' => $transactionIndex + 1, 'attribute' => trans('element.recipient_country') . '-' . trans('elementForm.code')]
            );
            $messages["$transactionIndex.recipientregion_code.in"] = trans(
                'validation.csv_invalid',
                ['number' => $transactionIndex + 1, 'attribute' => trans('element.recipient_region') . '-' . trans('elementForm.code')]
            );
            $messages["$transactionIndex.recipientregion_vocabulary.in"] = trans(
                'validation.csv_invalid',
                ['number' => $transactionIndex + 1, 'attribute' => trans('element.recipient_region') . '-' . trans('elementForm.vocabulary')]
            );
            $messages["$transactionIndex.flowtype_code.in"] = trans(
                'validation.csv_invalid',
                ['number' => $transactionIndex + 1, 'attribute' => trans('elementForm.flow_type') . '-' . trans('elementForm.code')]
            );
            $messages["$transactionIndex.financetype_code.in"] = trans(
                'validation.csv_invalid',
                ['number' => $transactionIndex + 1, 'attribute' => trans('elementForm.finance_type') . '-' . trans('elementForm.code')]
            );
            $messages["$transactionIndex.aidtype_code.in"] = trans(
                'validation.csv_invalid',
                ['number' => $transactionIndex + 1, 'attribute' => trans('elementForm.aid_type') . '-' . trans('elementForm.code')]
            );
            $messages["$transactionIndex.tiedstatus_code.in"] = trans(
                'validation.csv_invalid',
                ['number' => $transactionIndex + 1, 'attribute' => trans('elementForm.tied_status') . '-' . trans('elementForm.code')]
            );

            $sectorVocabulary = $transactionRow['sector_vocabulary'];

            if ($sectorVocabulary === 1) {
                $sectorCodes = implode(',', $this->getCodes('SectorCode', 'Activity'));
                $rules["$transactionIndex.sector_code"] = 'in:' . $sectorCodes;
                $messages["$transactionIndex.sector_code.in"] = trans(
                    'validation.csv_invalid',
                    ['number' => $transactionIndex + 1, 'attribute' => trans('element.sector') . '-' . trans('elementForm.code')]
                );
            } elseif ($sectorVocabulary === 2) {
                $sectorCodes = implode(',', $this->getCodes('SectorCategory', 'Activity'));
                $rules["$transactionIndex.sector_code"] = 'in:' . $sectorCodes;
                $messages["$transactionIndex.sector_code.in"] = trans(
                    'validation.csv_invalid',
                    ['number' => $transactionIndex + 1, 'attribute' => trans('element.sector') . '-' . trans('elementForm.code')]
                );
            }
        }

        return Validator::make($transactions, $rules, $messages);
    }

    /**
     * Check if the activities in csv are valid or not.
     *
     * @param $file
     * @param $identifiers
     *
     * @return false|\Illuminate\Contracts\Validation\Validator|\Illuminate\Validation\Validator|void
     */
    public function isValidActivityCsv($file, $identifiers)
    {
        try {
            $activities = Excel::load($file)->get()->toArray();
            $activityStatus = implode(',', $this->getCodes('ActivityStatus', 'Activity'));
            $sectorCategory = implode(',', $this->getCodes('SectorCode', 'Activity'));
            $recipientCountryCodes = implode(',', $this->getCodes('Country', 'Organization'));
            $recipientRegionCodes = implode(',', $this->getCodes('Region', 'Activity'));
            $rules = [];
            $messages = [];
            $identifiers = implode(',', $identifiers);

            foreach ($activities as $activityIndex => $activityRow) {
                $rules["$activityIndex.activity_identifier"] = sprintf('sometimes|unique_validation:%s.activity_identifier,%s,%s,activity_identifier|not_in:%s', $activityIndex, trimInput($activityRow['activity_identifier']), $file, $identifiers);
                $rules["$activityIndex.actual_start_date"] = 'date';
                $rules["$activityIndex.actual_end_date"] = 'date';
                $rules["$activityIndex.planned_start_date"] = 'date';
                $rules["$activityIndex.planned_end_date"] = 'date';
                $rules["$activityIndex.activity_status"] = 'in:' . $activityStatus;
                $rules["$activityIndex.sector_dac_5digit"] = 'multiple_value_in:' . $sectorCategory;
                $rules["$activityIndex.recipient_country"] = 'sometimes|multiple_value_in:' . $recipientCountryCodes;
                $rules["$activityIndex.recipient_region"] = 'sometimes|multiple_value_in:' . $recipientRegionCodes;

                $messages["$activityIndex.sector_dac_5digit.multiple_value_in"] = trans('validation.csv_invalid', ['number' => $activityIndex + 1, 'attribute' => trans('elementForm.sector_5_digit') . '-' . trans('elementForm.category_code')]);
                $messages["$activityIndex.sector_dac_5digit.required"] = trans('validation.csv_required', ['number' => $activityIndex + 1, 'attribute' => trans('elementForm.sector_5_digit') . '-' . trans('elementForm.category_code')]);
                $messages["$activityIndex.recipient_country.multiple_value_in"] = trans('validation.csv_invalid', ['number' => $activityIndex + 1, 'attribute' => trans('elementForm.recipient_country')]);
                $messages["$activityIndex.recipient_country.required_without"] = trans('validation.csv_required', ['number'    => $activityIndex + 1, 'attribute' => trans('global.either') . ' ' . trans('elementForm.recipient_country') . ' ' . trans('global.or') . ' ' . trans('elementForm.recipientRegion')]);
                $messages["$activityIndex.recipient_region.multiple_value_in"] = trans('validation.csv_invalid', ['number' => $activityIndex + 1, 'attribute' => trans('elementForm.recipient_region')]);
                $messages["$activityIndex.recipient_region.required_without"] = trans('validation.csv_required', ['number'    => $activityIndex + 1, 'attribute' => trans('global.either') . ' ' . trans('elementForm.recipient_country') . ' ' . trans('global.or') . ' ' . trans('elementForm.recipientRegion')]);
                $messages["$activityIndex.activity_status.in"] = trans(
                    'validation.csv_invalid',
                    ['number' => $activityIndex + 1, 'attribute' => trans('element.activity_status')]
                );
                $messages["$activityIndex.activity_status.required"] = trans(
                    'validation.csv_required',
                    ['number' => $activityIndex + 1, 'attribute' => trans('elementForm.activity_status')]
                );
                $messages["$activityIndex.activity_identifier.required"] = trans(
                    'validation.csv_required',
                    ['number' => $activityIndex + 1, 'attribute' => trans('elementForm.activity_identifier')]
                );
                $messages["$activityIndex.activity_identifier.not_in"] = trans(
                    'validation.csv_unique',
                    ['number' => $activityIndex + 1, 'attribute' => trans('elementForm.activity_identifier')]
                );
                $messages["$activityIndex.activity_identifier.unique_validation"] = trans(
                    'validation.csv_unique_validation',
                    ['number' => $activityIndex + 1, 'attribute' => trans('elementForm.activity_identifier')]
                );
                $messages["$activityIndex.activity_title.required"] = trans(
                    'validation.csv_required',
                    ['number' => $activityIndex + 1, 'attribute' => trans('element.title')]
                );
                $messages["$activityIndex.actual_start_date.date"] = trans(
                    'validation.csv_invalid',
                    ['number' => $activityIndex + 1, 'attribute' => trans('elementForm.actual_start_date')]
                );
                $messages["$activityIndex.actual_end_date.date"] = trans(
                    'validation.csv_invalid',
                    ['number' => $activityIndex + 1, 'attribute' => trans('elementForm.actual_end_date')]
                );
                $messages["$activityIndex.planned_start_date.date"] = trans(
                    'validation.csv_invalid',
                    ['number' => $activityIndex + 1, 'attribute' => trans('elementForm.planned_start_date')]
                );
                $messages["$activityIndex.planned_end_date.date"] = trans(
                    'validation.csv_invalid',
                    ['number' => $activityIndex + 1, 'attribute' => trans('elementForm.planned_end_date')]
                );
                $messages["$activityIndex.actual_start_date.required_any"] = trans(
                    'validation.csv_required',
                    [
                        'number'    => $activityIndex + 1,
                        'attribute' => trans('global.among') . ' ' . trans('elementForm.actual_start_date') . '/' . trans('elementForm.actual_end_date') . '/' . trans(
                            'elementForm.planned_start_date'
                        ) . '/' . trans(
                            'elementForm.planned_end_date'
                        ),
                    ]
                );
                $messages["$activityIndex.description_general.required_any"] = trans(
                    'validation.csv_among',
                    [
                        'number'    => $activityIndex + 1,
                        'type'      => trans('elementForm.type'),
                        'attribute' => trans('elementForm.description_general') . '/' . trans('elementForm.description_objectives') . '/' . trans('elementForm.description_target_group'),
                    ]
                );
                $messages["$activityIndex.funding_participating_organization.required_any"] = trans(
                    'validation.csv_among',
                    [
                        'number'    => $activityIndex + 1,
                        'type'      => trans('element.participating_organisation'),
                        'attribute' => trans('elementForm.funding') . '/' . trans('elementForm.implementing'),
                    ]
                );
            }

            return Validator::make($activities, $rules, $messages);
        } catch (\Exception $e) {
            if (str_starts_with($e->getMessage(), 'Undefined index:')) {
                return false;
            }
        }
    }

    /**
     * @param $file
     *
     * @return \Illuminate\Contracts\Validation\Validator|\Illuminate\Validation\Validator|null
     */
    public function getSimpleCsvValidator($file): \Illuminate\Contracts\Validation\Validator|\Illuminate\Validation\Validator|null
    {
        $transactions = Excel::load($file)->get()->toArray();
        $transactionHeader = Excel::load($file)->get()->first()->keys()->toArray();
        $templateHeader = Excel::load(app_path('Core/V201/Template/Csv/iati_transaction_template_simple.csv'))->get()->first()->keys()->toArray();

        if (count(array_intersect($transactionHeader, $templateHeader)) !== count($templateHeader)) {
            return null;
        }

        $transactionCurrency = implode(',', $this->getCodes('Currency', 'Organization'));

        $rules = [];
        $messages = [];

        foreach ($transactions as $transactionIndex => $transactionRow) {
            $requiredOnlyOneRule = sprintf(
                'required_only_one:%s.incoming_fund,%s,%s.expenditure,%s,%s.commitment,%s,%s.disbursement,%s',
                $transactionIndex,
                trimInput($transactionRow['incoming_fund']),
                $transactionIndex,
                trimInput($transactionRow['expenditure']),
                $transactionIndex,
                trimInput($transactionRow['commitment']),
                $transactionIndex,
                trimInput($transactionRow['disbursement'])
            );

            $rules["$transactionIndex.internal_reference"] = sprintf('unique_validation:%s.internal_reference,%s,%s,internal_reference', $transactionIndex, trimInput($transactionRow['internal_reference']), $file);
            $rules["$transactionIndex.incoming_fund"] = (trimInput($transactionRow['incoming_fund'])) ? ($requiredOnlyOneRule . '|numeric') : $requiredOnlyOneRule;
            $rules["$transactionIndex.expenditure"] = (trimInput($transactionRow['expenditure'])) ? 'numeric' : '';
            $rules["$transactionIndex.disbursement"] = (trimInput($transactionRow['disbursement'])) ? 'numeric' : '';
            $rules["$transactionIndex.commitment"] = (trimInput($transactionRow['commitment'])) ? 'numeric' : '';
            $rules["$transactionIndex.transaction_date"] = 'sometimes|date';
            $rules["$transactionIndex.transaction_currency"] = 'in:' . $transactionCurrency;

            $messages["$transactionIndex.internal_reference.required"] = trans(
                'validation.csv_required',
                [
                    'number'    => $transactionIndex + 1,
                    'attribute' => trans('elementForm.internal_reference'),
                ]
            );
            $messages["$transactionIndex.internal_reference.unique_validation"] = trans(
                'validation.csv_unique',
                [
                    'number'    => $transactionIndex + 1,
                    'attribute' => trans('elementForm.internal_reference'),
                ]
            );
            $messages["$transactionIndex.incoming_fund.numeric"] = trans(
                'validation.csv_numeric',
                [
                    'number'    => $transactionIndex + 1,
                    'attribute' => trans('elementForm.incoming_fund'),
                ]
            );
            $messages["$transactionIndex.incoming_fund.required_only_one"] = trans(
                'validation.csv_only_one',
                [
                    'number'    => $transactionIndex + 1,
                    'attribute' => trans('elementForm.incoming_fund') . ', ' . trans('elementForm.expenditure') . ', ' . trans('elementForm.disbursement') . ', ' . trans(
                        'elementForm.commitment'
                    ),
                ]
            );
            $messages["$transactionIndex.expenditure.numeric"] = trans(
                'validation.csv_numeric',
                [
                    'number'    => $transactionIndex + 1,
                    'attribute' => trans('elementForm.expenditure'),
                ]
            );
            $messages["$transactionIndex.disbursement.numeric"] = trans(
                'validation.csv_numeric',
                [
                    'number'    => $transactionIndex + 1,
                    'attribute' => trans('elementForm.disbursement'),
                ]
            );
            $messages["$transactionIndex.commitment.numeric"] = trans(
                'validation.csv_numeric',
                [
                    'number'    => $transactionIndex + 1,
                    'attribute' => trans('elementForm.commitment'),
                ]
            );
            $messages["$transactionIndex.transaction_date.required"] = trans(
                'validation.csv_required',
                [
                    'number'    => $transactionIndex + 1,
                    'attribute' => trans('elementForm.transaction_date'),
                ]
            );
            $messages["$transactionIndex.transaction_date.date"] = trans(
                'validation.csv_invalid',
                [
                    'number'    => $transactionIndex + 1,
                    'attribute' => trans('elementForm.transaction_date'),
                ]
            );
            $messages["$transactionIndex.transaction_currency.in"] = trans(
                'validation.csv_invalid',
                [
                    'number'    => $transactionIndex + 1,
                    'attribute' => trans('elementForm.transaction_currency'),
                ]
            );
            $messages["$transactionIndex.description.required"] = trans(
                'validation.csv_required',
                [
                    'number'    => $transactionIndex + 1,
                    'attribute' => trans('element.description'),
                ]
            );
        }

        return Validator::make($transactions, $rules, $messages);
    }
}
