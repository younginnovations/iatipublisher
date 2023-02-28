<?php

declare(strict_types=1);

namespace App\CsvImporter\Entities\Activity\Components\Elements;

use App\CsvImporter\Entities\Activity\Components\Elements\Foundation\Iati\Element;
use App\CsvImporter\Entities\Activity\Components\Factory\Validation;
use App\Http\Requests\Activity\Date\DateRequest;
use App\IATI\Traits\DataSanitizeTrait;

/**
 * Class ActivityDate.
 */
class ActivityDate extends Element
{
    use DataSanitizeTrait;

    /**
     * Csv Headers for the ActivityDate element.
     *
     * @var array
     */
    private array $_csvHeaders = ['actual_start_date' => '2', 'actual_end_date' => '4', 'planned_start_date' => '1', 'planned_end_date' => '3'];

    /**
     * Index under which the data is stored within the object.
     *
     * @var string
     */
    protected string $index = 'activity_date';

    /**
     * @var array
     */
    protected array $types = [];

    /**
     * @var
     */
    protected $narratives;

    /**
     * @var
     */
    protected $dates;

    /**
     * @var array
     */
    protected array $actualDates = [];

    /**
     * @var array
     */
    protected array $plannedDates = [];

    /**
     * @var array
     */
    protected array $activityDate = [];

    /**
     * @var DateRequest
     */
    private DateRequest $request;

    /**
     * ActivityDate constructor.
     *
     * @param            $fields
     * @param Validation $factory
     */
    public function __construct($fields, Validation $factory)
    {
        $this->prepare($fields);
        $this->factory = $factory;
        $this->request = new DateRequest();
    }

    /**
     * Prepare ActivityDate element.
     *
     * @param $fields
     *
     * @return void
     */
    public function prepare($fields): void
    {
        $index = 0;

        foreach ($fields as $key => $values) {
            if (!is_null($values) && array_key_exists($key, $this->_csvHeaders)) {
                foreach ($values as $value) {
                    $this->map($key, $value, $index);
                    $index++;
                }
            }
        }

        $fields = is_array($fields) ? $this->sanitizeData($fields) : $fields;
    }

    /**
     * Map data from CSV file into the ActivityDate data format.
     *
     * @param $key
     * @param $value
     * @param $index
     *
     * @return void
     */
    public function map($key, $value, &$index):  void
    {
        if (!(is_null($value) || $value === '')) {
            $type = $this->setType($key);
            $this->data['activity_date'][$index]['date'] = $this->setDate($value);
            $this->data['activity_date'][$index]['type'] = $type;
            $this->data['activity_date'][$index]['narrative'][] = $this->setNarrative();
        }
    }

    /**
     * Set the type for ActivityDate element.
     *
     * @param $key
     *
     * @return mixed
     */
    public function setType($key): mixed
    {
        $this->types[] = $key;
        $this->types = array_unique($this->types);

        return $this->_csvHeaders[$key];
    }

    /**
     * Set the Date for the ActivityDate element.
     *
     * @param $value
     *
     * @return bool|string
     */
    public function setDate($value): bool|string
    {
        $this->dates[] = dateFormat('Y-m-d', $value);

        return dateFormat('Y-m-d', $value);
    }

    /**
     * Set the Narrative for the ActivityDate element.
     *
     *
     * @return array
     */
    public function setNarrative(): array
    {
        $narrative = ['narrative' => '', 'language' => ''];
        $this->narratives[] = $narrative;

        return $narrative;
    }

    /**
     * Provides the rules for the IATI Element validation.
     *
     * @return array
     */
    public function rules(): array
    {
        return $this->request->getWarningForActivityDate($this->data('activity_date'));
    }

    /**
     * Provides the rules for the IATI Element validation.
     *
     * @return array
     */
    public function errorRules(): array
    {
        return $this->request->getErrorsForActivityDate($this->data('activity_date'));
    }

    /**
     * Provides custom messages used for IATI Element Validation.
     *
     * @return array
     */
    public function messages(): array
    {
        return $this->request->getMessagesForDate($this->data('activity_date'));
    }

    /**
     * Validate data for IATI Element.
     *
     * @return $this
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
}
