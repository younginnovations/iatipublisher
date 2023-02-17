<?php

declare(strict_types=1);

namespace App\CsvImporter\Entities\Activity\Components\Elements\Foundation\Iati;

use Illuminate\Support\Arr;
use Str;

/**
 * Class Element.
 */
abstract class Element
{
    /**
     * LIst of warnings.
     *
     * @var array
     */
    public array $warnings = [];

    /**
     * List of errors.
     *
     * @var array
     */
    public array $errors = [];

    /**
     * List of critical errors.
     *
     * @var array
     */
    public array $criticals = [];

    /**
     * Index under which the data is stored within the object.
     * @var string
     */
    protected string $index;

    /**
     * @var array
     */
    protected array $data = [];

    /**
     * @var array
     */
    protected array $template = [];

    /**
     * @var
     */
    public $validator;

    /**
     * @var
     */
    public $errorValidator;

    /**
     * @var mixed
     */
    public $criticalValidator;

    /**
     * @var
     */
    protected $isValid;

    /**
     * @var
     */
    protected $factory;

    /**
     * Prepare the IATI Element.
     * @param $fields
     */
    abstract protected function prepare($fields);

    /**
     * Provides the rules for the IATI Element validation.
     * @return array
     */
    abstract public function rules(): array;

    /**
     * Provides custom messages used for IATI Element Validation.
     * @return array
     */
    abstract public function messages(): array;

    /**
     * Validate data for IATI Element.
     */
    abstract public function validate();

    /**
     * Set the validity for the IATI Element data.
     *
     * @return void
     */
    protected function setValidity(): void
    {
        if ($this->criticalValidator) {
            $this->isValid = $this->validator->passes() && $this->errorValidator->passes() && $this->criticalValidator->passes();
        } else {
            $this->isValid = $this->validator->passes() && $this->errorValidator->passes();
        }
    }

    /**
     * @param null|string $popIndex
     *
     * @return array|int|string|float
     */
    public function data($popIndex = null): array |int|string|float
    {
        if (!$this->data) {
            $this->data = [];
        }

        if (!$popIndex) {
            return $this->data;
        }

        if (array_key_exists($popIndex, $this->data)) {
            return $this->data[$popIndex];
        }

        return [];
    }

    /**
     * Get the template for the IATI Element.
     *
     * @return array
     */
    public function template(): array
    {
        return $this->template;
    }

    /**
     * Load the provided Activity CodeList.
     *
     * @param        $codeList
     * @param string $directory
     *
     * @return array
     * @throws \JsonException
     */
    protected function loadCodeList($codeList, string $directory = 'Activity'): array
    {
        return getCodeList($codeList, $directory, false);
    }

    /**
     * Check the validity of an Element.
     *
     * @return mixed
     */
    public function isElementValid(): mixed
    {
        return $this->isValid;
    }

    /**
     * Get the index under which the data is stored within the object.
     *
     * @return string
     */
    public function pluckIndex(): string
    {
        return $this->index;
    }

    /**
     * Record all errors within the Element classes.
     *
     * @param $transactionIndex
     *
     * @return void
     */
    public function withErrors($transactionIndex = null): void
    {
        foreach ($this->validator->errors()->getMessages() as $element => $errors) {
            $this->warnings[$this->addIndexToTransactionErrors($element, $transactionIndex)] = implode(' ', $errors);
        }

        foreach ($this->errorValidator->errors()->getMessages() as $element => $errors) {
            $this->errors[$this->addIndexToTransactionErrors($element, $transactionIndex)] = implode(' ', $errors);
        }

        if ($this->criticalValidator) {
            foreach ($this->criticalValidator->errors()->getMessages() as $element => $errors) {
                $this->criticals[$this->addIndexToTransactionErrors($element, $transactionIndex)] = implode(' ', $errors);
            }
        }
    }

    /**
     * Adds transaction index to.
     *
     * @param string $element
     * @param $transactionIndex
     *
     * @return string
     */
    public function addIndexToTransactionErrors($element, $transactionIndex): string
    {
        if (is_null($transactionIndex)) {
            return $element;
        }

        return Str::replaceFirst('transaction', "transaction.$transactionIndex", $element);
    }

    /**
     * Returns warnings.
     *
     * @return array
     */
    public function warnings(): array
    {
        return $this->warnings;
    }

    /**
     * Returns errors.
     *
     * @return array
     */
    public function errors(): array
    {
        return $this->errors;
    }

    /**
     * Returns critical error.
     *
     * @return array
     */
    public function criticals(): array
    {
        return $this->criticals;
    }

    /**
     * Returns updated base rules.
     *
     * @param $baseRules
     * @param bool $hasIdx
     *
     * @return array
     */
    public function getBaseRules($baseRules, bool $hasIdx = true): array
    {
        $rules = [];

        foreach (Arr::get($this->data(), $this->index, []) as $idx => $value) {
            foreach ($baseRules as $elementName => $baseRule) {
                if ($hasIdx) {
                    $rules[$this->index . '.' . $idx . '.' . $elementName] = $baseRule;
                } else {
                    $rules[$this->index . '.' . $elementName] = $baseRule;
                }
            }
        }

        return $rules;
    }

    /**
     * Returns updated base messages.
     *
     * @param $baseMessages
     * @param bool $hasIdx
     *
     * @return array
     */
    public function getBaseMessages($baseMessages, bool $hasIdx = true): array
    {
        $messages = [];

        foreach (Arr::get($this->data(), $this->index, []) as $idx => $value) {
            foreach ($baseMessages as $elementName => $baseMessage) {
                if ($hasIdx) {
                    $messages[$this->index . '.' . $idx . '.' . $elementName] = $baseMessage;
                } else {
                    $messages[$this->index . '.' . $elementName] = $baseMessage;
                }
            }
        }

        return $messages;
    }
}
