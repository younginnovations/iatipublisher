<?php

declare(strict_types=1);

namespace App\CsvImporter\Entities\Activity\Components\Elements;

use App\CsvImporter\Entities\Activity\Components\Elements\Foundation\Iati\Element;
use App\CsvImporter\Entities\Activity\Components\Factory\Validation;

/**
 * Class Identifier.
 */
class Identifier extends Element
{
    /**
     * @var
     */
    protected $organizationId;

    /**
     * @var
     */
    protected $activityIdentifiers;

    /**
     * CSV Header of Description with their code.
     */
    private array $_csvHeader = ['activity_identifier'];

    /**
     * @var array
     */
    protected array $template = [['activity_identifier' => '']];

    /**
     * Description constructor.
     * @param                   $fields
     * @param Validation        $factory
     */
    public function __construct($fields, Validation $factory)
    {
        $this->prepare($fields);
        $this->factory = $factory;
    }

    /**
     * Prepare the Identifier element.
     *
     * @param $fields
     *
     * @return void
     */
    protected function prepare($fields): void
    {
        foreach ($fields as $key => $values) {
            if (!is_null($values) && array_key_exists($key, array_flip($this->_csvHeader))) {
                foreach ($values as $value) {
                    $this->map($value);
                }
            }
        }
    }

    /**
     * Map data from CSV file into Identifier data format.
     *
     * @param $value
     *
     * @return void
     */
    public function map($value): void
    {
        if (!is_null($value)) {
            $this->data[end($this->_csvHeader)] = $value;
        }
    }

    /**
     * Validate data for Identifier.
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

    /**
     * Provides the rules for the Identifier validation.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'activity_identifier' => 'required',
            'activity_identifier' => sprintf('nullable|not_in:%s', implode(',', $this->activityIdentifiers ?? [])),
        ];
    }

    /**
     * Provides custom messages used for Identifier Validation.
     *
     * @return array
     */
    public function messages(): array
    {
        return [
            'activity_identifier.required' => trans('validation.required', ['attribute' => trans('elementForm.activity_identifier')]),
            'activity_identifier.not_in'   => trans('validation.unique', ['attribute' => trans('elementForm.activity_identifier')]),
        ];
    }

    /**
     * Set the organizationId for the current Organization.
     *
     * @param $organizationId
     *
     * @return void
     */
    public function setOrganization($organizationId): void
    {
        $this->organizationId = $organizationId;
    }

    /**
     * Set activity identifiers.
     *
     * @param array $activityIdentifiers
     *
     * @return void
     */
    public function setActivityIdentifier(array $activityIdentifiers): void
    {
        $this->activityIdentifiers = $activityIdentifiers;
    }
}
