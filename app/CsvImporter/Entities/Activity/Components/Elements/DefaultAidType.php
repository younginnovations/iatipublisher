<?php

declare(strict_types=1);

namespace App\CsvImporter\Entities\Activity\Components\Elements;

use App\CsvImporter\Entities\Activity\Components\Elements\Foundation\Iati\Element;
use App\CsvImporter\Entities\Activity\Components\Factory\Validation;
use Illuminate\Support\Arr;

/**
 * Class DefaultAidType.
 */
class DefaultAidType extends Element
{
    /**
     * Csv Header for DefaultAidType element.
     * @var array
     */
    private array $_csvHeaders
        = [
            'default_aid_type_vocabulary',
            'default_aid_type_code',
        ];

    /**
     * Index under which the data is stored within the object.
     *
     * @var string
     */
    protected string $index = 'default_aid_type';

    /**
     * DefaultAidType constructor.
     *
     * @param            $fields
     * @param Validation $factory
     */
    public function __construct($fields, Validation $factory)
    {
        $this->prepare($fields);
        $this->factory = $factory;
    }

    /**
     * Prepare DefaultAidType element.
     *
     * @param $fields
     *
     * @return void
     */
    public function prepare($fields): void
    {
        foreach ($fields as $key => $values) {
            if (!is_null($values) && array_key_exists($key, array_flip($this->_csvHeaders))) {
                foreach ($values as $index => $value) {
                    $this->map($key, $index, $value);
                }
            }
        }
    }

    /**
     * Map data from CSV file into DefaultAidType data format.
     *
     * @param $key
     * @param $index
     * @param $value
     *
     * @return void
     */
    public function map($key, $index, $value): void
    {
        if (!(is_null($value) || $value === '')) {
            $this->setDefaultAidTypeVocabulary($key, $value, $index);
            $this->setDefaultAidTypeCode($key, $value, $index);
        }
    }

    /**
     * Maps DefaultAidType Vocabulary.
     *
     * @param $key
     * @param $value
     * @param $index
     *
     * @return void
     */
    protected function setDefaultAidTypeVocabulary($key, $value, $index): void
    {
        if ($key === $this->_csvHeaders[0]) {
            $value = (!$value) ? '' : trim($value);

            $validDefaultAidTypeVocab = $this->loadCodeList('AidTypeVocabulary');

            if ($value) {
                foreach ($validDefaultAidTypeVocab as $code => $name) {
                    if (strcasecmp(trim($value), $name) === 0) {
                        $value = strval($code);
                        break;
                    }
                }
            }

            $this->data['default_aid_type'][$index]['default_aid_type_vocabulary'] = $value;
        }
    }

    /**
     * Maps DefaultAidType Code.
     *
     * @param $key
     * @param $value
     * @param $index
     *
     * @return void
     */
    protected function setDefaultAidTypeCode($key, $value, $index): void
    {
        if ($key === $this->_csvHeaders[1]) {
            $defaultAidTypeVocabulary = $this->data['default_aid_type'][$index]['default_aid_type_vocabulary'] ?? '';
            $defaultAidTypeVocabulary = empty($defaultAidTypeVocabulary) ?: (int) $defaultAidTypeVocabulary;
            $value = (!$value) ? '' : trim($value);

            switch ($defaultAidTypeVocabulary) {
                case '2':
                    $validDefaultAidTypeCode = $this->loadCodeList('EarmarkingCategory');
                    $variable = 'earmarking_category';
                    break;

                case '3':
                    $validDefaultAidTypeCode = $this->loadCodeList('EarmarkingModality');
                    $variable = 'earmarking_modality';
                    break;

                case '4':
                    $validDefaultAidTypeCode = $this->loadCodeList('CashandVoucherModalities');
                    $variable = 'cash_and_voucher_modalities';
                    break;

                default:
                    $validDefaultAidTypeCode = $this->loadCodeList('AidType');
                    $variable = 'default_aid_type';
            }

            if ($value) {
                foreach ($validDefaultAidTypeCode as $code => $name) {
                    if (strcasecmp(trim($value), $name) === 0) {
                        $value = strval($code);
                        break;
                    }
                }
            }

            $this->data['default_aid_type'][$index][$variable] = strtoupper($value);
        }
    }

    /**
     * Provides the rules for the IATI Element validation.
     *
     * @return array
     * @throws \JsonException
     */
    public function rules(): array
    {
        $rules = [];

        foreach (Arr::get($this->data(), 'default_aid_type', []) as $key => $value) {
            $defaultAidTypeForm = sprintf('default_aid_type.%s', $key);
            $rules[sprintf('%s.default_aid_type_vocabulary', $defaultAidTypeForm)] = sprintf(
                'in:1,2,3,4|required_with: %s,%s,%s,%s',
                sprintf('%s.default_aid_type', $defaultAidTypeForm),
                sprintf('%s.earmarking_category', $defaultAidTypeForm),
                sprintf('%s.earmarking_modality', $defaultAidTypeForm),
                sprintf('%s.cash_and_voucher_modalities', $defaultAidTypeForm),
            );
            $vocabulary = Arr::get($value, 'default_aid_type_vocabulary');

            if ($vocabulary) {
                switch ($vocabulary) {
                    case '2':
                        $validAidTypeCode = implode(',', $this->validDefaultAidTypeCodeList('EarmarkingCategory'));
                        $rules[sprintf('%s.earmarking_category', $defaultAidTypeForm)] = sprintf(
                            'in:%s|required_with: %s,%s,%s,%s',
                            $validAidTypeCode,
                            sprintf('%s.default_aid_type', $defaultAidTypeForm),
                            sprintf('%s.earmarking_modality', $defaultAidTypeForm),
                            sprintf('%s.cash_and_voucher_modalities', $defaultAidTypeForm),
                            sprintf('%s.default_aid_type_vocabulary', $defaultAidTypeForm),
                        );
                        break;
                    case '3':
                        $validAidTypeCode = implode(',', $this->validDefaultAidTypeCodeList('EarmarkingModality'));
                        $rules[sprintf('%s.earmarking_modality', $defaultAidTypeForm)] = sprintf(
                            'in:%s|required_with: %s,%s,%s,%s',
                            $validAidTypeCode,
                            sprintf('%s.default_aid_type', $defaultAidTypeForm),
                            sprintf('%s.earmarking_category', $defaultAidTypeForm),
                            sprintf('%s.cash_and_voucher_modalities', $defaultAidTypeForm),
                            sprintf('%s.default_aid_type_vocabulary', $defaultAidTypeForm),
                        );
                        break;
                    case '4':
                        $validAidTypeCode = implode(
                            ',',
                            $this->validDefaultAidTypeCodeList('CashandVoucherModalities')
                        );
                        $rules[sprintf('%s.cash_and_voucher_modalities', $defaultAidTypeForm)] = sprintf(
                            'in:%s|required_with: %s,%s,%s,%s',
                            $validAidTypeCode,
                            sprintf('%s.default_aid_type', $defaultAidTypeForm),
                            sprintf('%s.earmarking_category', $defaultAidTypeForm),
                            sprintf('%s.earmarking_modality', $defaultAidTypeForm),
                            sprintf('%s.default_aid_type_vocabulary', $defaultAidTypeForm),
                        );
                        break;
                    default:
                        $validAidTypeCode = implode(',', $this->validDefaultAidTypeCodeList('AidType'));
                        $rules[sprintf('%s.default_aid_type', $defaultAidTypeForm)] = sprintf(
                            'in:%s|required_with: %s,%s,%s,%s',
                            $validAidTypeCode,
                            sprintf('%s.earmarking_category', $defaultAidTypeForm),
                            sprintf('%s.earmarking_modality', $defaultAidTypeForm),
                            sprintf('%s.cash_and_voucher_modalities', $defaultAidTypeForm),
                            sprintf('%s.default_aid_type_vocabulary', $defaultAidTypeForm),
                        );
                }
            }
        }

        return $rules;
    }

    /**
     * Return Valid DefaultAidType Type.
     *
     * @param $name
     *
     * @return array
     * @throws \JsonException
     */
    protected function validDefaultAidTypeCodeList($name): array
    {
        return array_keys($this->loadCodeList($name));
    }

    /**
     * Provides custom messages used for IATI Element Validation.
     *
     * @return array
     */
    public function messages(): array
    {
        $messages = [];

        foreach (Arr::get($this->data(), 'default_aid_type', []) as $key => $value) {
            $defaultAidTypeForm = sprintf('default_aid_type.%s', $key);
            $messages[sprintf(
                '%s.default_aid_type_vocabulary.%s',
                $defaultAidTypeForm,
                'required_with'
            )]
                = trans(
                    'validation.required_with',
                    [
                        'attribute' => trans('elementForm.default_aid_type_vocabulary'),
                        'values'    => 'default aid type code',
                    ]
                );
            $messages[sprintf(
                '%s.default_aid_type_vocabulary.%s',
                $defaultAidTypeForm,
                'in'
            )]
                = trans(
                    'validation.code_list',
                    [
                        'attribute' => trans('elementForm.default_aid_type_vocabulary'),
                    ]
                );
            $vocabulary = Arr::get($value, 'default_aid_type_vocabulary');

            if ($vocabulary) {
                switch ($vocabulary) {
                    case '2':
                        $variable = 'earmarking_category';
                        break;

                    case '3':
                        $variable = 'earmarking_modality';
                        break;

                    case '4':
                        $variable = 'cash_and_voucher_modalities';
                        break;

                    default:
                        $variable = 'default_aid_type';
                }

                $messages[sprintf(
                    '%s.%s.%s',
                    $defaultAidTypeForm,
                    $variable,
                    'required_with'
                )]
                    = trans(
                        'validation.required_with',
                        [
                            'attribute' => trans('elementForm.default_aid_type_code'),
                            'values'    => 'default aid type vocabulary',
                        ]
                    );

                $messages[sprintf(
                    '%s.%s.%s',
                    $defaultAidTypeForm,
                    $variable,
                    'in'
                )] = trans('validation.code_list', ['attribute' => 'default aid type code']);
            }
        }

        return $messages;
    }

    /**
     * Validate data for IATI Element.
     *
     * @return $this
     * @throws \JsonException
     */
    public function validate(): static
    {
        $this->validator = $this->factory->sign($this->data())
                                         ->with($this->rules(), $this->messages())
                                         ->getValidatorInstance();
        $this->setValidity();

        return $this;
    }
}
