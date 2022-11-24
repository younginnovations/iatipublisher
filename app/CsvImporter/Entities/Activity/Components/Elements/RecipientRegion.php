<?php

declare(strict_types=1);

namespace App\CsvImporter\Entities\Activity\Components\Elements;

use App\CsvImporter\Entities\Activity\Components\Elements\Foundation\Iati\Element;
use App\CsvImporter\Entities\Activity\Components\Factory\Validation;
use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Support\Arr;

/**
 * Class RecipientRegion.
 */
class RecipientRegion extends Element
{
    /**
     * CSV Header of Description with their code.
     */
    private array $_csvHeaders = ['recipient_region_code', 'recipient_region_percentage', 'recipient_region_vocabulary_uri', 'recipient_region_narrative'];

    /**
     * Index under which the data is stored within the object.
     * @var string
     */
    protected string $index = 'recipient_region';

    /**
     * @var array
     */
    protected array $regions = [];

    /**
     * @var array
     */
    protected array $percentage = [];

    /**
     * @var array
     */
    protected array $template = [['region_code' => '', 'region_vocabulary' => '', 'vocabulary_uri' => '', 'percentage' => '', 'narrative' => ['narrative' => '', 'language' => '']]];

    /**
     * @var
     */
    protected $recipientCountry;

    /**
     * @var int
     */
    protected float $totalPercentage = 0;

    /**
     * @var
     */
    protected $fields;

    /**
     * Description constructor.
     *
     * @param            $fields
     * @param Validation $factory
     *
     * @throws BindingResolutionException
     */
    public function __construct($fields, Validation $factory)
    {
        $this->prepare($fields);
        $this->factory = $factory;
        $this->fields = $fields;
        $this->getRecipientCountry($fields);
    }

    /**
     * Prepare RecipientRegion Element.
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
                    $this->map($key, $value, $index);
                }
            }
        }
    }

    /**
     * Map data from CSV into RecipientRegion data format.
     *
     * @param $key
     * @param $value
     * @param $index
     *
     * @return void
     * @throws \JsonException
     */
    public function map($key, $value, $index): void
    {
        if (!(is_null($value) || $value === '')) {
            $this->setRegion($key, $value, $index);
            $this->setRegionVocabulary($index);
            $this->setVocabularyUri($key, $value, $index);
            $this->setPercentage($key, $value, $index);
            $this->setNarrative($key, $value, $index);
        }
    }

    /**
     * Set Region of RecipientRegion.
     *
     * @param $key
     * @param $value
     * @param $index
     *
     * @return void
     */
    protected function setRegion($key, $value, $index): void
    {
        if (!isset($this->data['recipient_region'][$index]['region_code'])) {
            $this->data['recipient_region'][$index]['region_code'] = '';
            $this->data['recipient_region'][$index]['custom_code'] = '';
        }

        if ($key === $this->_csvHeaders[0] && (!is_null($value))) {
            $this->regions[] = $value;
            $this->regions = array_unique($this->regions);
            $validRegionCode = $this->loadCodeList('Region');
            $value = $value ? trim($value) : '';

            if ($value) {
                foreach ($validRegionCode as $code => $name) {
                    if (strcasecmp($value, $name) === 0) {
                        $value = strval($code);
                        break;
                    }
                }
            }

            if ($value === '1') {
                $this->data['recipient_region'][$index]['region_code'] = $value;
            } else {
                $this->data['recipient_region'][$index]['custom_code'] = $value;
            }
        }
    }

    /**
     * Set Percentage of RecipientRegion.
     *
     * @param $key
     * @param $value
     * @param $index
     *
     * @return void
     */
    protected function setPercentage($key, $value, $index): void
    {
        if (!isset($this->data['recipient_region'][$index]['percentage'])) {
            $this->data['recipient_region'][$index]['percentage'] = '';
        }

        if ($key === $this->_csvHeaders[1] && (!is_null($value))) {
            $this->percentage[] = $value;

            $this->data['recipient_region'][$index]['percentage'] = $value;
        }
    }

    /**
     * Set Narrative of RecipientRegion.
     *
     * @param $key
     * @param $value
     * @param $index
     *
     * @return void
     */
    protected function setNarrative($key, $value, $index): void
    {
        if (!isset($this->data['recipient_region'][$index]['narrative'][0]['narrative'])) {
            $this->data['recipient_region'][$index]['narrative'][0] = [
                'narrative' => '',
                'language'  => '',
            ];
        }

        if ($key === $this->_csvHeaders[3]) {
            $value = $value ?: '';
            $narrative = [
                'narrative' => $value,
                'language'  => '',
            ];

            $this->data['recipient_region'][$index]['narrative'][0] = $narrative;
        }
    }

    /**
     * Set VocabularyUri of RecipientRegion.
     *
     * @param $key
     * @param $value
     * @param $index
     * @return void
     */
    protected function setVocabularyUri($key, $value, $index): void
    {
        if ($key === $this->_csvHeaders[2]) {
            $value = (!$value) ? '' : trim($value);
            $this->data['recipient_region'][$index]['vocabulary_uri'] = $value;
            $this->data['recipient_region'][$index]['region_vocabulary'] = '99';
        }
    }

    /**
     * Set Region Vocabulary of RecipientRegion.
     *
     * @param $index
     *
     * @return void
     * @throws \JsonException
     */
    protected function setRegionVocabulary($index): void
    {
        $regionCode = $this->data['recipient_region'][$index]['region_code'];
        $validRegions = array_flip(explode(',', $this->validRecipientRegion()));
        $this->data['recipient_region'][$index]['region_vocabulary'] = '';

        if (isset($validRegions[$regionCode])) {
            $this->data['recipient_region'][$index]['region_vocabulary'] = '1';
        } elseif (isset($this->data['recipient_region'][$index]['vocabulary_uri']) && !empty($this->data['recipient_region'][$index]['vocabulary_uri'])) {
            $this->data['recipient_region'][$index]['region_vocabulary'] = '99';
        } else {
            $this->data['recipient_region'][$index]['region_vocabulary'] = '2';
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
        $recipientCountry = $this->recipientCountry->data;

        $this->totalPercentage = $this->totalPercentage() + $this->recipientCountry->totalPercentage();
        $this->data['recipient_country'] = (empty($recipientCountry)) ? '' : $recipientCountry;
        $this->data['recipient_region_total_percentage'] = Arr::get($this->data, 'recipient_region', []);
        $this->data['total_percentage'] = $this->totalPercentage;
        $this->validator = $this->factory->sign($this->data())
                                         ->with($this->rules(), $this->messages())
                                         ->getValidatorInstance();
        $this->setValidity();
        unset($this->data['recipient_region_total_percentage'], $this->data['recipient_country']);

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
        return $this->getBaseRules($this->request->rules($this->data('recipient_region')));

//        $codes = $this->validRecipientRegion();
//        $rules = [];
//
//        if (count($this->fields) === 20) {
//            $rules = [
//                'recipient_region' => sprintf('required_if:recipient_country,%s', ''),
//            ];
//        }
//        ($this->data['recipient_country'] !== '' && (array_key_exists('recipient_region', $this->data)))
//            ? $rules['total_percentage'] = 'recipient_country_region_percentage_sum' : null;
//
//        ($this->data['recipient_country'] === '' && array_key_exists('recipient_region', $this->data))
//            ? $rules['recipient_region_total_percentage'] = 'percentage_sum' : null;
//
//        foreach (Arr::get($this->data(), 'recipient_region', []) as $key => $value) {
//            if (Arr::get($value, 'region_vocabulary', 1) === '1') {
//                $rules['recipient_region.' . $key . '.region_code'] = sprintf('nullable|required_with:recipient_region.%s.percentage|in:%s', $key, $codes);
//            } elseif (Arr::get($value, 'region_vocabulary', 1) === '2') {
//                $rules['recipient_region.' . $key . '.custom_code'] = sprintf('nullable|required_with:recipient_region.%s.percentage', $key);
//            } else {
//                $rules['recipient_region.' . $key . '.custom_code'] = sprintf('nullable|required_with:recipient_region.%s.percentage, recipient_region.%s.vocabulary_uri', $key, $key);
//                $rules['recipient_region.' . $key . '.vocabulary_uri'] = sprintf('url|required_with:recipient_region.%s.custom_code, recipient_region.%s.percentage', $key, $key);
//            }
//            $rules['recipient_region.' . $key . '.percentage'] = 'nullable|numeric|max:100|min:0';
//        }
//
//        return $rules;
    }

    /**
     * Provides custom messages used for IATI Element Validation.
     *
     * @return array
     */
    public function messages(): array
    {

        return $this->getBaseMessages($this->request->messages($this->data('recipient_region')));

//        $messages = [
//            'recipient_region.required_if'                             => trans(
//                'validation.required_without',
//                ['attribute' => trans('element.recipient_region'), 'values' => trans('element.recipient_country')]
//            ),
//            'recipient_region_total_percentage.percentage_sum'         => trans('validation.sum_of_percentage', ['attribute' => trans('element.recipient_region')]),
//            'total_percentage.recipient_country_region_percentage_sum' => trans('validation.recipient_country_region_percentage_sum'),
//        ];
//
//        foreach (Arr::get($this->data(), 'recipient_region', []) as $key => $value) {
//            $messages['recipient_region.' . $key . '.region_code.required_with'] = trans(
//                'validation.required_with',
//                ['attribute' => trans('elementForm.recipient_country_code'), 'values' => trans('elementForm.percentage')]
//            );
//            $messages['recipient_region.' . $key . '.region_code.in'] = trans('validation.code_list', ['attribute' => trans('elementForm.recipient_region_code')]);
//            $messages['recipient_region.' . $key . '.percentage.numeric'] = trans('validation.numeric', ['attribute' => trans('elementForm.percentage')]);
//            $messages['recipient_region.' . $key . '.percentage.max'] = trans('validation.max.numeric', ['attribute' => trans('elementForm.percentage'), 'max' => 100]);
//            $messages['recipient_region.' . $key . '.percentage.min'] = trans('validation.min.numeric', ['attribute' => trans('elementForm.percentage'), 'min' => 0]);
//            $messages['recipient_region.' . $key . '.custom_code.required_with'] = trans('validation.required_with', ['attribute' => 'percentage or vocabulary uri']);
//            $messages['recipient_region.' . $key . '.vocabulary_uri.required_with'] = trans('validation.required_with', ['attribute' => 'percentage or code']);
//            $messages['recipient_region.' . $key . '.vocabulary_uri.url'] = trans('validation.url', ['attribute' => trans('elementForm.recipient_region_vocabulary_uri')]);
//        }
//
//        return $messages;
    }

    /**
     * Return Valid Recipient Region Codes.
     *
     * @return string
     * @throws \JsonException
     */
    protected function validRecipientRegion(): string
    {
        $recipientRegionCodeList = $this->loadCodeList('Region');
        $codes = array_keys($recipientRegionCodeList);

        return implode(',', $codes);
    }

    /**
     * Store Recipient Country Object.
     *
     * @param $fields
     *
     * @return void
     * @throws BindingResolutionException
     */
    protected function getRecipientCountry($fields): void
    {
        $this->recipientCountry = app()->makeWith(RecipientCountry::class, ['fields' => $fields]);
    }

    /**
     * Calculate Total Percentage of Recipient Region.
     *
     * @return float|int|string
     */
    public function totalPercentage(): float|int|string
    {
        foreach ($this->percentage as $percentage) {
            if (is_numeric($percentage)) {
                $this->totalPercentage = (float) $this->totalPercentage + (float) $percentage;
            }
        }

        return $this->totalPercentage;
    }
}
