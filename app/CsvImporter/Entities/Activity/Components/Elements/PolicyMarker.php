<?php

declare(strict_types=1);

namespace App\CsvImporter\Entities\Activity\Components\Elements;

use App\CsvImporter\Entities\Activity\Components\Elements\Foundation\Iati\Element;
use App\CsvImporter\Entities\Activity\Components\Factory\Validation;
use App\Http\Requests\Activity\PolicyMarker\PolicyMarkerRequest;
use App\IATI\Traits\DataSanitizeTrait;
use Illuminate\Support\Arr;

/**
 * Class PolicyMarker.
 */
class PolicyMarker extends Element
{
    use DataSanitizeTrait;

    /**
     * Csv Header for PolicyMarker element.
     * @var array
     */
    protected array $_csvHeaders = ['policy_marker_vocabulary', 'policy_marker_code', 'policy_marker_significance', 'policy_marker_vocabulary_uri', 'policy_marker_narrative'];

    /**
     * Index under which the data is stored within the object.
     * @var string
     */
    protected string $index = 'policy_marker';

    /**
     * @var PolicyMarkerRequest
     */
    private PolicyMarkerRequest $request;

    /**
     * PolicyMarker constructor.
     * @param            $fields
     * @param Validation $factory
     */
    public function __construct($fields, Validation $factory)
    {
        $this->prepare($fields);
        $this->factory = $factory;
        $this->request = new PolicyMarkerRequest();
    }

    /**
     * Prepare the IATI Element.
     *
     * @param $fields
     *
     * @return void
     */
    protected function prepare($fields): void
    {
        foreach ($fields as $key => $values) {
            if (!is_null($values) && array_key_exists($key, array_flip($this->_csvHeaders))) {
                foreach ($values as $index => $value) {
                    $this->map($key, $value, $index);
                }
            }
        }

        $fields = is_array($fields) ? $this->sanitizeData($fields) : $fields;
    }

    /**
     * Map data from CSV file into Policy Marker data format.
     *
     * @param $key
     * @param $value
     * @param $index
     *
     * @return void
     */
    protected function map($key, $value, $index): void
    {
        if (!(is_null($value) || $value === '')) {
            $this->setVocabulary($key, $value, $index);
            $this->setVocabularyUri($key, $value, $index);
            $this->setSignificance($key, $value, $index);
            $this->setPolicyMarker($key, $value, $index);
            $this->setNarrative($key, $value, $index);
        }
    }

    /**
     * Set Vocabulary for PolicyMarker element.
     *
     * @param $key
     * @param $value
     * @param $index
     *
     * @return void
     */
    protected function setVocabulary($key, $value, $index): void
    {
        if (!isset($this->data['policy_marker'][$index]['policy_marker_vocabulary'])) {
            $this->data['policy_marker'][$index]['policy_marker_vocabulary'] = '';
        }

        if ($key === $this->_csvHeaders[0]) {
            $validVocabulary = $this->loadCodeList('PolicyMarkerVocabulary');
            $value = $value ? trim($value) : $value;

            if ($value) {
                foreach ($validVocabulary as $code => $name) {
                    if (strcasecmp($value, $name) === 0) {
                        $value = (string) $code;
                        break;
                    }
                }
            }
            $this->data['policy_marker'][$index]['policy_marker_vocabulary'] = $value;
        }
    }

    /**
     * Set VocabularyUri for PolicyMarker element.
     *
     * @param $key
     * @param $value
     * @param $index
     *
     * @return void
     */
    protected function setVocabularyUri($key, $value, $index): void
    {
        if ($key === $this->_csvHeaders[3] && Arr::get($this->data(), 'policy_marker.' . $index . '.policy_marker_vocabulary') === '99') {
            $this->data['policy_marker'][$index]['vocabulary_uri'] = $value;
        }
    }

    /**
     * Set Significance for PolicyMarker element.
     *
     * @param $key
     * @param $value
     * @param $index
     *
     * @return void
     */
    protected function setSignificance($key, $value, $index): void
    {
        if (!isset($this->data['policy_marker'][$index]['significance'])) {
            $this->data['policy_marker'][$index]['significance'] = '';
        }

        if ($key === $this->_csvHeaders[2]) {
            $validSignificance = $this->loadCodeList('PolicySignificance');
            $value = is_string($value) ? trim($value) : '';

            if ($value) {
                foreach ($validSignificance as $code => $name) {
                    if (strcasecmp($value, $name) === 0) {
                        $value = (string) $code;
                        break;
                    }
                }
            }

            $this->data['policy_marker'][$index]['significance'] = $value;
        }
    }

    /**
     * Set policy marker code for PolicyMarker element.
     *
     * @param $key
     * @param $value
     * @param $index
     *
     * @return void
     */
    protected function setPolicyMarker($key, $value, $index): void
    {
        if (!isset($this->data['policy_marker'][$index]['policy_marker'])) {
            $this->data['policy_marker'][$index]['policy_marker'] = '';
        }

        if (!isset($this->data['policy_marker'][$index]['policy_marker_text'])) {
            $this->data['policy_marker'][$index]['policy_marker_text'] = '';
        }

        if ($key === $this->_csvHeaders[1]) {
            $vocabulary = $this->data['policy_marker'][$index]['policy_marker_vocabulary'];
            switch ($vocabulary) {
                case '1':
                    $validMarker = $this->loadCodeList('PolicyMarker');
                    $value = $value ? trim($value) : $value;

                    if ($value) {
                        foreach ($validMarker as $code => $name) {
                            if (strcasecmp($value, $name) === 0) {
                                $value = (string) $code;
                                break;
                            }
                        }
                    }

                    $this->data['policy_marker'][$index]['policy_marker'] = $value;
                    break;
                case '99':
                    $this->data['policy_marker'][$index]['policy_marker_text'] = $value;
                    break;
                default:
                    $this->data['policy_marker'][$index]['policy_marker_text'] = '';
                    $this->data['policy_marker'][$index]['policy_marker'] = $value ?: '';
                    break;
            }
        }
    }

    /**
     * Set Narrative for PolicyMarker element.
     *
     * @param $key
     * @param $value
     * @param $index
     *
     * @return void
     */
    protected function setNarrative($key, $value, $index): void
    {
        if (!isset($this->data['policy_marker'][$index]['narrative'][0]['narrative'])) {
            $this->data['policy_marker'][$index]['narrative'][0] = [
                'narrative' => '',
                'language'  => '',
            ];
        }

        if ($key === $this->_csvHeaders[4]) {
            $value = $value ?: '';
            $narrative = [
                'narrative' => $value,
                'language'  => '',
            ];

            $this->data['policy_marker'][$index]['narrative'][0] = $narrative;
        }
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
     * @throws \JsonException
     */
    public function rules(): array
    {
        return $this->request->getWarningForPolicyMarker(Arr::get($this->data, 'policy_marker', []));
    }

    /**
     * Provides the critical rules for the IATI Element validation.
     *
     * @return array
     * @throws \JsonException
     */
    public function errorRules(): array
    {
        return $this->request->getErrorsForPolicyMarker(Arr::get($this->data, 'policy_marker', []));
    }

    /**
     * Provides custom messages used for IATI Element Validation.
     *
     * @return array
     */
    public function messages(): array
    {
        return $this->request->getMessagesForPolicyMarker(Arr::get($this->data, 'policy_marker', []));
    }

    /**
     * Get the valid PolicyMaker Codes from the PolicyMarker code list as a string.
     *
     * @param $codeList
     *
     * @return string
     * @throws \JsonException
     */
    protected function policyMarkerCodeList($codeList): string
    {
        [$policyMarkerCodeList] = [$this->loadCodeList($codeList), []];
        $codes = array_keys($policyMarkerCodeList);

        return implode(',', array_keys(array_flip($codes)));
    }
}
