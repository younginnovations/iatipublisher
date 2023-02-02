<?php

declare(strict_types=1);

namespace App\CsvImporter\Entities;

use Illuminate\Contracts\Container\BindingResolutionException;

/**
 * Class Row.
 */
abstract class Row
{
    /**
     * Elements for a Row.
     * @var array
     */
    protected array $elements = [];

    /**
     * Fields in the Row.
     * @var
     */
    protected $fields;

    /**
     * @var bool
     */
    protected bool $isValid = false;

    /**
     * Data in the row.
     * @var array
     */
    protected array $data = [];

    /**
     * @var array
     */
    protected array $errors = [];

    /**
     * @var array
     */
    protected array $criticalErrors = [];

    /**
     * Initialize the Row object.
     *
     * @return void
     */
    abstract public function init(): void;

    /**
     * Process the Row.
     *
     * @return mixed
     */
    abstract public function process(): mixed;

    /**
     * Validate the Row.
     *
     * @return mixed
     */
    abstract public function validate(): mixed;

    /**
     * Store the Row in a temporary JSON File for further usage.
     *
     * @return void
     */
    abstract public function keep(): void;

    /**
     * Initialize the objects for the all the elements in the Row.
     *
     * @param $classNamespace
     * @param $fields
     * @param $data
     *
     * @return mixed
     * @throws BindingResolutionException
     */
    protected function make($classNamespace, $fields, $data = null): mixed
    {
        if ($data) {
            return app()->makeWith($classNamespace, ['fields' => $fields, 'orgId' => $data]);
        }

        return app()->makeWith($classNamespace, ['fields' => $fields]);
    }

    /**
     * Get the Fields of the Row.
     *
     * @return mixed
     */
    public function getFields(): mixed
    {
        return $this->fields;
    }

    /**
     * Get the value of a Field in a Row with specific fieldName.
     *
     * @param $fieldName
     *
     * @return mixed
     */
    public function field($fieldName): mixed
    {
        if (array_key_exists($fieldName, $this->fields)) {
            return $this->fields[$fieldName];
        }

        return false;
    }

    /**
     * Get all elements of a Row.
     *
     * @return array
     */
    protected function elements(): array
    {
        return $this->elements;
    }

    /**
     * Get the namespace for the element class.
     *
     * @param $element
     * @param $baseNamespace
     *
     * @return string
     */
    protected function getNamespace($element, $baseNamespace): string
    {
        return sprintf('%s\%s', $baseNamespace, ucfirst($element));
    }
}
