<?php

declare(strict_types=1);

namespace App\XlsImporter\Foundation\XlsValidator\Validators;

use App\Http\Requests\Activity\Indicator\IndicatorRequest;
use App\XlsImporter\Foundation\Factory\Validation;
use App\XlsImporter\Foundation\XlsValidator\ValidatorInterface;

/**
 * Class IndicatorValidator.
 */
class IndicatorValidator implements ValidatorInterface
{
    /**
     * @var array
     */
    protected $indicator;

    /**
     * @var Validation
     */
    protected $factory;

    /**
     * @param Validation $factory
     */
    public function __construct(Validation $factory)
    {
        $this->factory = $factory;
    }

    /**
     * Returns warnings for xml uploaded indicator.
     *
     * @return array
     */
    public function rules(): array
    {
        $rules = (new IndicatorRequest())->getWarningForIndicator($this->indicator);

        return $rules;
    }

    /**
     * Returns error rules for xml uploaded indicator.
     *
     * @return array
     */
    public function errorRules(): array
    {
        $rules = (new IndicatorRequest())->getErrorsForIndicator($this->indicator);

        return $rules;
    }

    /**
     * Returns critical rules for xml uploaded indicator.
     * @return array
     */
    public function criticalRules(): array
    {
        return [];
    }

    /**
     * Returns the required messages for the failed validation rules of indicator.
     *
     * @return array
     */
    public function messages(): array
    {
        return (new IndicatorRequest())->getMessagesForIndicator($this->indicator);
    }

    /**
     * Initialize indicator for the class.
     */
    public function init($indicator): static
    {
        $this->indicator = $indicator;

        return $this;
    }

    /**
     * Validate data and create rules.
     *
     * @return array
     */
    public function validateData(): array
    {
        $errors = [
            // 'critical' => $this->factory->initialize($this->indicator, $this->criticalRules(), $this->messages())
            //     ->passes()
            //     ->withErrors(),
            'error' => $this->factory->initialize($this->indicator, $this->errorRules(), $this->messages())
                ->passes()
                ->withErrors(),
            // 'warning' => $this->factory->initialize($this->indicator, $this->rules(), $this->messages())
            //     ->passes()
            //     ->withErrors(),
        ];

        return $errors;
    }

    /**
     * Create base rule for multilevel elements.
     *
     * @param $baseRules
     * @param $element
     * @param $data
     * @param $indexRequired
     *
     * @return array
     */
    public function getBaseRules($baseRules, $element, $data, $indexRequired = true): array
    {
        $rules = [];

        if (!empty($data)) {
            foreach ($data as $idx => $value) {
                foreach ($baseRules as $elementName => $baseRule) {
                    $fieldName = $indexRequired ? $element . '.' . $idx . '.' . $elementName : $element . '.' . $elementName;
                    $rules[$fieldName] = $baseRule;
                }
            }
        }

        return $rules;
    }

    /**
     * Create base messages for multilevel elements.
     *
     * @param $baseRules
     * @param $element
     * @param $data
     * @param $indexRequired
     *
     * @return array
     */
    public function getBaseMessages($baseMessages, $element, $data, $indexRequired = true): array
    {
        $messages = [];

        if (is_array($data)) {
            foreach ($data as $idx => $value) {
                foreach ($baseMessages as $elementName => $baseMessage) {
                    $fieldName = $indexRequired ? $element . '.' . $idx . '.' . $elementName : $element . '.' . $elementName;
                    $messages[$fieldName] = $baseMessage;
                }
            }
        } else {
            foreach ($baseMessages as $elementName => $baseMessage) {
                $messages[$element . '.' . $elementName] = $baseMessage;
            }
        }

        return $messages;
    }
}
