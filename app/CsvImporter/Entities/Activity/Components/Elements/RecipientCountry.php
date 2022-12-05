<?php

declare(strict_types=1);

namespace App\CsvImporter\Entities\Activity\Components\Elements;

use App\CsvImporter\Entities\Activity\Components\Elements\Foundation\Iati\Element;
use App\CsvImporter\Entities\Activity\Components\Factory\Validation;
use App\Http\Requests\Activity\RecipientCountry\RecipientCountryRequest;
use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Support\Arr;

/**
 * Class RecipientCountry.
 */
class RecipientCountry extends Element
{
    /**
     * CSV Header of Description with their code.
     */
    private array $_csvHeaders = ['recipient_country_code', 'recipient_country_percentage', 'recipient_country_narrative'];

    /**
     * Index under which the data is stored within the object.
     * @var string
     */
    protected string $index = 'recipient_country';

    /**
     * @var array
     */
    protected array $countries = [];

    /**
     * @var array
     */
    protected array $percentage = [];

    /**
     * @var int
     */
    protected int $totalPercentage = 0;

    /**
     * @var
     */
    protected $recipientRegion;

    /**
     * @var
     */
    protected $fields;

    /**
     * @var array
     */
    protected array $template = [['country_code' => '', 'percentage' => '', 'narrative' => ['narrative' => '', 'language' => '']]];

    /**
     * @var RecipientCountryRequest
     */
    private RecipientCountryRequest $request;

    /**
     * Description constructor.
     * @param            $fields
     * @param Validation $factory
     */
    public function __construct($fields, Validation $factory)
    {
        $this->prepare($fields);
        $this->factory = $factory;
        $this->fields = $fields;
        $this->request = new RecipientCountryRequest();
    }

    /**
     * Prepare RecipientCountry Element.
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
     * Map data from CSV file into RecipientCountry data format.
     *
     * @param $key
     * @param $value
     * @param $index
     *
     * @return void
     */
    public function map($key, $value, $index): void
    {
        if (!(is_null($value) || $value === '')) {
            $this->setCountry($key, $value, $index);
            $this->setPercentage($key, $value, $index);
            $this->setNarrative($key, $value, $index);
        }
    }

    /**
     * Set Country for RecipientCountry.
     *
     * @param $key
     * @param $value
     * @param $index
     *
     * @return void
     */
    protected function setCountry($key, $value, $index): void
    {
        if (!isset($this->data['recipient_country'][$index]['country_code'])) {
            $this->data['recipient_country'][$index]['country_code'] = '';
        }

        if ($key === $this->_csvHeaders[0] && (!is_null($value))) {
            $this->countries[] = $value;
            $this->countries = array_unique($this->countries);
            $validCountry = $this->loadCodeList('Country');
            $value = $value ? trim($value) : '';

            if ($value) {
                foreach ($validCountry as $code => $name) {
                    if (strcasecmp($value, $name) === 0) {
                        $value = (string) $code;
                        break;
                    }
                }
            }

            $this->data['recipient_country'][$index]['country_code'] = strtoupper($value);
        }
    }

    /**
     * Set Percentage for RecipientCountry Element.
     *
     * @param $key
     * @param $value
     * @param $index
     *
     * @return void
     */
    protected function setPercentage($key, $value, $index): void
    {
        if (!isset($this->data['recipient_country'][$index]['percentage'])) {
            $this->data['recipient_country'][$index]['percentage'] = '';
        }

        if ($key === $this->_csvHeaders[1] && (!is_null($value))) {
            $this->percentage[] = $value;
            $this->data['recipient_country'][$index]['percentage'] = $value;
        }
    }

    /**
     * Set Narrative for RecipientCountry Element.
     *
     * @param $key
     * @param $value
     * @param $index
     *
     * @return void
     */
    protected function setNarrative($key, $value, $index): void
    {
        if (!isset($this->data['recipient_country'][$index]['narrative'][0]['narrative'])) {
            $this->data['recipient_country'][$index]['narrative'][0] = [
                'narrative' => '',
                'language'  => '',
            ];
        }

        if ($key === $this->_csvHeaders[2]) {
            $value = $value ?: '';
            $narrative = [
                'narrative' => $value,
                'language'  => '',
            ];

            $this->data['recipient_country'][$index]['narrative'][0] = $narrative;
        }
    }

    /**
     * Validate data for IATI Element.
     *
     * @return $this
     * @throws BindingResolutionException
     * @throws \JsonException
     */
    public function validate(): static
    {
        $this->getRecipientRegion($this->fields);

        $recipientRegion = $this->recipientRegion->data;
        $this->data['recipient_region'] = (empty($recipientRegion)) ? '' : $recipientRegion;
        $this->data['recipient_country_total_percentage'] = Arr::get($this->data, 'recipient_country', []);
        $this->validator = $this->factory->sign($this->data())
                                         ->with($this->rules(), $this->messages())
                                         ->getValidatorInstance();
        $this->setValidity();

        unset($this->data['recipient_country_total_percentage'], $this->data['recipient_region']);

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
        return $this->request->getRulesForRecipientCountry($this->data('recipient_country'), true);
    }

    /**
     * Provides custom messages used for IATI Element Validation.
     *
     * @return array
     */
    public function messages(): array
    {
        return $this->request->getMessagesForRecipientCountry($this->data('recipient_country'));
    }

    /**
     * Return valid Recipient Country.
     *
     * @return string
     * @throws \JsonException
     */
    protected function validRecipientCountry(): string
    {
        $recipientCountryCodeList = $this->loadCodeList('Country', 'Organization');
        $codes = array_keys($recipientCountryCodeList);

        return implode(',', $codes);
    }

    /**
     * Store Recipient Region object.
     *
     * @param $fields
     *
     * @return void
     * @throws BindingResolutionException
     */
    protected function getRecipientRegion($fields): void
    {
        $this->recipientRegion = app()->makeWith(RecipientRegion::class, ['fields' => $fields]);
    }

    /**
     * Calculate total Percentage of Recipient Country.
     *
     * @return int
     */
    public function totalPercentage(): int
    {
        foreach ($this->percentage as $percentage) {
            if (is_numeric($percentage)) {
                $this->totalPercentage += $percentage;
            }
        }

        return $this->totalPercentage;
    }
}
