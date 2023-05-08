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
     * @var
     */
    protected $resultId;

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
     * Initialize indicator for the class.
     */
    public function init($indicator): static
    {
        $this->indicator = $indicator['indicator'];
        $this->resultId = $indicator['resultId'];

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
            'critical' => $this->factory->initialize($this->indicator, $this->criticalRules(), $this->messages())
                ->passes()
                ->withErrors(),
            'error' => $this->factory->initialize($this->indicator, $this->errorRules(), $this->messages())
                ->passes()
                ->withErrors(),
            'warning' => $this->factory->initialize($this->indicator, $this->rules(), $this->messages())
                ->passes()
                ->withErrors(),
        ];

        return $errors;
    }

    /**
     * Returns warnings for xml uploaded indicator.
     *
     * @return array
     */
    public function rules(): array
    {
        $rules = (new IndicatorRequest())->getWarningForIndicator($this->indicator, true, [], $this->resultId);

        return $rules;
    }

    /**
     * Returns error rules for xml uploaded indicator.
     *
     * @return array
     */
    public function errorRules(): array
    {
        $rules = (new IndicatorRequest())->getErrorsForIndicator($this->indicator, true);

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
}
