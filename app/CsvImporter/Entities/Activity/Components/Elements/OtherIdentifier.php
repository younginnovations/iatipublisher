<?php

declare(strict_types=1);

namespace App\CsvImporter\Entities\Activity\Components\Elements;

use App\CsvImporter\Entities\Activity\Components\Elements\Foundation\Iati\Element;
use App\CsvImporter\Entities\Activity\Components\Factory\Validation;
use App\Http\Requests\Activity\OtherIdentifier\OtherIdentifierRequest;
use Illuminate\Support\Arr;

/**
 * Class OtherIdentifier.
 */
class OtherIdentifier extends Element
{
    /**
     * Csv Header for OtherIdentifier element.
     * @var array
     */
    private array $_csvHeaders = [
        'other_identifier_reference',
        'other_identifier_type',
        'owner_org_reference',
        'owner_org_narrative',
    ];

    /**
     * Index under which the data is stored within the object.
     *
     * @var string
     */
    protected string $index = 'other_identifier';
    private OtherIdentifierRequest $request;

    /**
     * OtherIdentifier constructor.
     *
     * @param            $fields
     * @param Validation $factory
     */
    public function __construct($fields, Validation $factory)
    {
        $this->prepare($fields);
        $this->factory = $factory;
        $this->request = new OtherIdentifierRequest();
    }

    /**
     * Prepare OtherIdentifier element.
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
     * Map data from CSV file into OtherIdentifier data format.
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
            $this->setOtherIdentifierReference($key, $value, $index);
            $this->setOtherIdentifierType($key, $value, $index);
            $this->setOwnerOrgReference($key, $value, $index);
            $this->setOwnerOrgNarrative($key, $value, $index);
        }
    }

    /**
     * Maps OtherIdentifier Reference.
     *
     * @param $key
     * @param $value
     * @param $index
     *
     * @return void
     */
    protected function setOtherIdentifierReference($key, $value, $index): void
    {
        if (!isset($this->data['other_identifier'][$index]['reference'])) {
            $this->data['other_identifier'][$index]['reference'] = '';
        }

        if ($key === $this->_csvHeaders[0]) {
            $this->data['other_identifier'][$index]['reference'] = $value;
        }
    }

    /**
     * Maps OtherIdentifier Type.
     *
     * @param $key
     * @param $value
     * @param $index
     *
     * @return void
     */
    protected function setOtherIdentifierType($key, $value, $index): void
    {
        if (!isset($this->data['other_identifier'][$index]['reference_type'])) {
            $this->data['other_identifier'][$index]['reference_type'] = '';
        }

        if ($key === $this->_csvHeaders[1]) {
            $value = (!$value) ? '' : trim($value);

            $validOtherIdentifierType = $this->loadCodeList('OtherIdentifierType');

            if ($value) {
                foreach ($validOtherIdentifierType as $code => $name) {
                    if (strcasecmp($value, $name) === 0) {
                        $value = strval($code);
                        break;
                    }
                }
            }

            $this->data['other_identifier'][$index]['reference_type'] = strtoupper($value);
        }
    }

    /**
     * Maps Owner Org Reference.
     *
     * @param $key
     * @param $value
     * @param $index
     *
     * @return void
     */
    protected function setOwnerOrgReference($key, $value, $index): void
    {
        if (!isset($this->data['other_identifier'][$index]['owner_org'][0]['ref'])) {
            $this->data['other_identifier'][$index]['owner_org'][0]['ref'] = '';
        }

        if ($key === $this->_csvHeaders[2]) {
            $this->data['other_identifier'][$index]['owner_org'][0]['ref'] = $value;
        }
    }

    /**
     * Maps Owner Org Narrative.
     *
     * @param $key
     * @param $value
     * @param $index
     *
     * @return void
     */
    protected function setOwnerOrgNarrative($key, $value, $index): void
    {
        if ($key === $this->_csvHeaders[3]) {
            $value = $value ?: '';
            $narrative = [
                'narrative' => $value,
                'language'  => '',
            ];

            $this->data['other_identifier'][$index]['owner_org'][0]['narrative'][] = $narrative;
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
        return $this->getBaseRules($this->request->rules());

//        $otherIdentifierTypeList = implode(',', $this->validOtherIdentifierCodeList('OtherIdentifierType'));
//        $rules = [];
//
//        foreach (Arr::get($this->data(), 'other_identifier', []) as $key => $value) {
//            $rules['other_identifier.' . $key . '.reference'][] = sprintf(
//                'required_with: %s,%s,%s',
//                'other_identifier.' . $key . '.reference_type',
//                'other_identifier.' . $key . '.owner_org.0.ref',
//                'other_identifier.' . $key . '.owner_org.0.narrative.0.narrative'
//            );
//            $rules['other_identifier.' . $key . '.reference'][] = 'not_regex:/(&|!|\/|\||\?)/';
//            $rules['other_identifier.' . $key . '.reference_type'] = sprintf(
//                'in:%s|required_with: %s,%s,%s',
//                $otherIdentifierTypeList,
//                'other_identifier.' . $key . '.reference',
//                'other_identifier.' . $key . '.owner_org.0.ref',
//                'other_identifier.' . $key . '.owner_org.0.narrative.0.narrative'
//            );
//            $rules['other_identifier.' . $key . '.owner_org.0.ref'] = 'not_regex:/(&|!|\/|\||\?)/';
//        }
//
//        return $rules;
    }

    /**
     * Return Valid OtherIdentifier Type.
     *
     * @param $name
     *
     * @return array
     * @throws \JsonException
     */
    protected function validOtherIdentifierCodeList($name): array
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
        return $this->getBaseMessages($this->request->messages());

//        $messages = [];
//
//        foreach (Arr::get($this->data(), 'other_identifier', []) as $key => $value) {
//            $messages['other_identifier.' . $key . '.reference_type.in'] = trans('validation.code_list', ['attribute' => trans('element.other_identifier_type')]);
//            $messages['other_identifier.' . $key . '.reference_type.required_with'] = trans('validation.required_with', ['attribute' => 'Other Identifier Reference Type', 'values' => 'Reference, narrative']);
//            $messages['other_identifier.' . $key . '.reference.not_regex'] = trans('validation.not_regex', ['attribute' => trans('element.other_identifier_reference')]);
//            $messages['other_identifier.' . $key . '.reference.required_with'] = trans('validation.required_with', ['attribute' => 'Other Identifier Reference', 'values' => 'Reference type, reference, narrative']);
//            $messages['other_identifier.' . $key . '.owner_org.0.ref.not_regex'] = trans('validation.not_regex', ['attribute' => trans('element.owner_org_ref')]);
//        }
//
//        return $messages;
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
