<?php

declare(strict_types=1);

namespace App\CsvImporter\Entities\Activity\Components\Elements;

use App\CsvImporter\Entities\Activity\Components\Elements\Foundation\Iati\Element;
use App\CsvImporter\Entities\Activity\Components\Factory\Validation;
use App\Http\Requests\Activity\Title\TitleRequest;

/**
 * Class Title.
 */
class Title extends Element
{
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
        return $this->getBaseRules($this->request->rules());
    }

    /**
     * Provides custom messages used for IATI Element Validation.
     *
     * @return array
     */
    public function messages(): array
    {
        return $this->getBaseMessages($this->request->messages());
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

        $this->setValidity();

        return $this;
    }
}
