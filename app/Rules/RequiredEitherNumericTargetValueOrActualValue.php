<?php

declare(strict_types=1);

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use Illuminate\Support\Arr;

/**
 * @class RequiredEitherNumericTargetValueOrActualValue
 *
 * Change source: https://github.com/younginnovations/iatipublisher/issues/1492
 */
class RequiredEitherNumericTargetValueOrActualValue implements Rule
{
    /**
     * @var string
     */
    public string $errorType = '';

    /**
     * Create a new rule instance.
     *
     * @param string $field
     * @param string $otherField
     * @param array $formFields
     */
    public function __construct(protected string $field, protected string $otherField, protected array $formFields)
    {
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value): bool
    {
        if ($this->bothTargetAnDActualHaveEmptyValues()) {
            return false;
        }

        /**
         * I'm doing this because $value can be null or N empty spaces.
         * Null during creation/untouched value field.
         * Empty spaces when value filed data is edited/cleared.
         * strlen > 0 because I'm allowing ''.
         */
        $value = trim($value ?? '');

        if ($this->otherFieldHasAtleastOneNonEmptyValue() && strlen($value) > 0 && !is_numeric($value)) {
            $this->errorType = 'numeric';

            return false;
        }

        return true;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message(): string
    {
        if ($this->errorType === 'numeric') {
            return 'The @value field must be numeric.';
        }

        return sprintf('%s value is required if %s value is not provided.', ucfirst($this->field), $this->otherField);
    }

    /**
     * Check if both target and actual fields have empty value field.
     *
     * @return bool
     */
    private function bothTargetAndActualHaveEmptyValues(): bool
    {
        $targetValues = Arr::get($this->formFields, 'target', []);
        $actualValues = Arr::get($this->formFields, 'actual', []);

        $targetAllNonEmpty = !collect($targetValues)->every(function ($item) {
            return !empty(trim($item['value'] ?? ''));
        });

        $actualAllNonEmpty = !collect($actualValues)->every(function ($item) {
            return !empty(trim($item['value'] ?? ''));
        });

        return $targetAllNonEmpty && $actualAllNonEmpty;
    }

    /**
     * Check if the other field (target or actual) has at least one non-empty value field.
     *
     * @return bool
     */
    private function otherFieldHasAtleastOneNonEmptyValue(): bool
    {
        foreach ($this->formFields[$this->otherField] as $item) {
            $item = trim($item['value'] ?? '');
            if ($item !== '') {
                return true;
            }
        }

        return false;
    }
}