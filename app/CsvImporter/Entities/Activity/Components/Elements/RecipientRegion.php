<?php

declare(strict_types=1);

namespace App\CsvImporter\Entities\Activity\Components\Elements;

use App\CsvImporter\Entities\Activity\Components\ActivityRow;
use App\CsvImporter\Entities\Activity\Components\Elements\Foundation\Iati\Element;
use App\CsvImporter\Entities\Activity\Components\Factory\Validation;
use App\Http\Requests\Activity\RecipientRegion\RecipientRegionRequest;
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
     * @var RecipientRegionRequest
     */
    private RecipientRegionRequest $request;

    /**
     * @var ActivityRow
     */
    protected ActivityRow $activityRow;

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
        $this->request = new RecipientRegionRequest();
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
                        $value = (string) $code;
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
        if (!isset($this->data['recipient_region'][$index]['vocabulary_uri'])) {
            $this->data['recipient_region'][$index]['vocabulary_uri'] = '';
        }

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
        if (!isset($this->data['recipient_region'][$index]['region_vocabulary'])) {
            $this->data['recipient_region'][$index]['region_vocabulary'] = '';
        }

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
     * @throws BindingResolutionException
     */
    public function rules(): array
    {
        return $this->request->getRulesForRecipientRegion($this->data('recipient_region'), true, Arr::get($this->recipientCountry->data, 'recipient_country', []));
    }

    /**
     * Provides custom messages used for IATI Element Validation.
     *
     * @return array
     */
    public function messages(): array
    {
        return $this->request->getMessagesForRecipientRegion($this->data('recipient_region'));
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
