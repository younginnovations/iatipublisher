<?php

declare(strict_types=1);

namespace App\CsvImporter\Entities\Activity\Components\Elements;

use App\CsvImporter\Entities\Activity\Components\Elements\Foundation\Iati\Element;
use App\CsvImporter\Entities\Activity\Components\Factory\Validation;
use App\Http\Requests\Activity\DefaultAidType\DefaultAidTypeRequest;

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
     * @var DefaultAidTypeRequest
     */
    private DefaultAidTypeRequest $request;

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
        $this->request = new DefaultAidTypeRequest();
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
        if (!isset($this->data['default_aid_type'][$index]['default_aid_type_vocabulary'])) {
            $this->data['default_aid_type'][$index]['default_aid_type_vocabulary'] = '';
        }

        if ($key === $this->_csvHeaders[0]) {
            $value = is_null($value) ? '' : trim($value);

            $validDefaultAidTypeVocab = $this->loadCodeList('AidTypeVocabulary');

            if ($value) {
                foreach ($validDefaultAidTypeVocab as $code => $name) {
                    if (strcasecmp($value, $name) === 0) {
                        $value = (string) $code;
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
        if (!isset($this->data['default_aid_type'][$index]['default_aid_type'])) {
            $this->data['default_aid_type'][$index]['default_aid_type'] = '';
        }

        if ($key === $this->_csvHeaders[1]) {
            $defaultAidTypeVocabulary = $this->data['default_aid_type'][$index]['default_aid_type_vocabulary'] ?? '';
            $defaultAidTypeVocabulary = empty($defaultAidTypeVocabulary) ?: (int) $defaultAidTypeVocabulary;
            $value = is_null($value) ? '' : trim($value);

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
                    if (strcasecmp($value, $name) === 0) {
                        $value = (string) $code;
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
        return $this->request->getRulesForDefaultAidType($this->data('default_aid_type'));
    }

    /**
     * Provides the critical rules for the IATI Element validation.
     *
     * @return array
     * @throws \JsonException
     */
    public function criticalRules(): array
    {
        return $this->request->getCriticalRulesForDefaultAidType($this->data('default_aid_type'));
    }

    /**
     * Provides custom messages used for IATI Element Validation.
     *
     * @return array
     */
    public function messages(): array
    {
        return $this->request->getMessagesForDefaultAidType($this->data('default_aid_type'));
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
        $this->criticalValidator = $this->factory->sign($this->data())
                                         ->with($this->criticalRules(), $this->messages())
                                         ->getValidatorInstance();
        $this->setValidity();

        return $this;
    }
}
