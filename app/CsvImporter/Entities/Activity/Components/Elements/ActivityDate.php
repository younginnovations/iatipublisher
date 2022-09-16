<?php

declare(strict_types=1);

namespace App\CsvImporter\Entities\Activity\Components\Elements;

use App\CsvImporter\Entities\Activity\Components\Elements\Foundation\Iati\Element;
use App\CsvImporter\Entities\Activity\Components\Factory\Validation;
use Illuminate\Support\Arr;

/**
 * Class ActivityDate.
 */
class ActivityDate extends Element
{
    /**
     * Csv Headers for the ActivityDate element.
     *
     * @var array
     */
    private array $_csvHeaders = ['actual_start_date' => 2, 'actual_end_date' => 4, 'planned_start_date' => 1, 'planned_end_date' => 3];

    /**
     * Index under which the data is stored within the object.
     *
     * @var string
     */
    protected string $index = 'activity_date';

    /**
     * Template for the ActivityDate element.
     *
     * @var array
     */
    protected array $template = ['type' => '', 'date' => '', 'narrative' => ['narrative' => '', 'language' => '']];

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
     * ActivityDate constructor.
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
            $this->data['activity_date'][$index]['narrative'][] = $this->setNarrative($value);
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
     * @param $value
     *
     * @return array
     */
    public function setNarrative($value): array
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
        $rules = [
            'activity_date' => 'nullable|multiple_activity_date|start_date_required|start_end_date',
        ];

        foreach ($this->actualDates as $index => $date) {
            foreach ($date as $key => $value) {
                $rules['activity_date.' . $index] = 'actual_date';
                $rules['activity_date.' . $index . '.' . $key . '.date'] = 'date_format:Y-m-d|actual_date';
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
        $messages = [
            'activity_date.required'               => 'Activity date field is required.',
            'activity_date.multiple_activity_date' => 'Activity date field is required.',
            'activity_date.start_date_required'    => 'Activity start date is required.',
            'activity_date.start_end_date'         => 'Activity end date must be after activity start date.',
        ];

        foreach ($this->actualDates as $index => $date) {
            foreach ($date as $key => $value) {
                $messages['activity_date.' . $index . '.actual_date'] = 'Activity date must be date.';
                $messages['activity_date.' . $index . '.' . $key . '.date.date_format'] = 'Activity date must be in Y-M-d format.';
            }
        }

        return $messages;
    }

    /**
     * Validate data for IATI Element.
     *
     * @return $this
     */
    public function validate(): static
    {
        $this->activityDateRules();

        $this->validator = $this->factory->sign($this->activityDate)
                                         ->with($this->rules(), $this->messages())
                                         ->getValidatorInstance();

        $this->setValidity();

        return $this;
    }

    /**
     * Append additional rules for Activity Date.
     *
     * @return void
     */
    protected function activityDateRules(): void
    {
        $this->sortByType();
        $this->activityDate['activity_date'] = array_merge($this->actualDates, $this->plannedDates);
    }

    /**
     * Sort ActivityDate by their type.
     *
     * @return void
     */
    protected function sortByType(): void
    {
        $dates = array_flip($this->_csvHeaders);

        foreach (Arr::get($this->data(), 'activity_date', []) as $key => $value) {
            $type = Arr::get($dates, Arr::get($value, 'type', ''), '');

            if ($type === $dates[2] || $type === $dates[4]) {
                $this->actualDates[$dates[$this->_csvHeaders[$type]]][] = $value;
            } else {
                $this->plannedDates[$dates[$this->_csvHeaders[$type]]][] = $value;
            }
        }
    }
}
