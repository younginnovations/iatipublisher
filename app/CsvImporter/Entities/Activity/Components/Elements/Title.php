<?php

declare(strict_types=1);

namespace App\CsvImporter\Entities\Activity\Components\Elements;

use App\CsvImporter\Entities\Activity\Components\Elements\Foundation\Iati\Element;
use App\CsvImporter\Entities\Activity\Components\Factory\Validation;
use App\Http\Requests\Activity\Title\TitleRequest;
use App\IATI\Traits\DataSanitizeTrait;

/**
 * Class Title.
 */
class Title extends Element
{
    use DataSanitizeTrait;

    /**
     * Csv Header for Title element.
     * @var array
     */
    private array $_csvHeader = ['activity_title'];

    /**
     * Index under which the data is stored within the object.
     * @var string
     */
    protected string $index = 'activity_title';

    /**
     * @var
     */
    protected $narratives;

    /**
     * @var
     */
    protected $languages;

    /**
     * @var TitleRequest
     */
    protected TitleRequest $request;

    /**
     * Template for Title element.
     * @var array
     */
    protected array $template = [['narrative' => '', 'language' => '']];

    /**
     * Title constructor.
     * @param            $fields
     * @param Validation $factory
     */
    public function __construct($fields, Validation $factory)
    {
        $this->prepare($fields);
        $this->factory = $factory;
        $this->request = new TitleRequest();
    }

    /**
     * Prepare Title element.
     *
     * @param $fields
     *
     * @return void
     */
    public function prepare($fields): void
    {
        foreach ($fields as $key => $values) {
            if (!is_null($values) && array_key_exists($key, array_flip($this->_csvHeader))) {
                foreach ($values as $value) {
                    $this->map($value);
                }
            }

            if ($key === $this->index && empty($this->data)) {
                $this->data[end($this->_csvHeader)][] = ['narrative' => null, 'language' => null];
            }
        }

        $fields = is_array($fields) ? $this->sanitizeData($fields) : $fields;
    }

    /**
     * Map data from CSV file into Title data format.
     *
     * @param $value
     *
     * @return void
     */
    public function map($value): void
    {
        if (!(is_null($value) || $value === '')) {
            $this->data[end($this->_csvHeader)][] = $this->setNarrative($value);
        }
    }

    /**
     * Set the Narrative for the Title element.
     *
     * @param $value
     *
     * @return array
     */
    public function setNarrative($value): array
    {
        $narrative = ['narrative' => $value, 'language' => ''];
        $this->narratives[] = $narrative;

        return $narrative;
    }

    /**
     * Get the languages for the Title element.
     *
     * @return mixed
     */
    public function language(): mixed
    {
        return $this->languages;
    }

    /**
     * Provides the rules for the IATI Element validation.
     *
     * @return array
     */
    public function rules(): array
    {
        return [];
    }

    /**
     * Provides the critical rules for the IATI Element validation.
     *
     * @return array
     */
    public function errors(): array
    {
        return  [];
    }

    /**
     * Provides the critical rules for the IATI Element validation.
     *
     * @return array
     */
    public function criticalErrors(): array
    {
        $rules['activity_title.0.narrative'] = 'required';
        $rules['activity_title'] = 'size:1';

        return $rules;
    }

    /**
     * Provides custom messages used for IATI Element Validation.
     *
     * @return array
     */
    public function messages(): array
    {
        $messages['activity_title.0.narrative.required'] = trans('common.error.activity_title_is_required');
        $messages['activity_title'] = trans('common.error.there_should_be_only_one');

        return $messages;
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
            ->with($this->errors(), $this->messages())
            ->getValidatorInstance();
        $this->criticalValidator = $this->factory->sign($this->data())
            ->with($this->criticalErrors(), $this->messages())
            ->getValidatorInstance();

        $this->setValidity();

        return $this;
    }
}
