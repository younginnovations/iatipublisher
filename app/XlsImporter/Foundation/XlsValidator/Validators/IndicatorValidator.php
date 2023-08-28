<?php

declare(strict_types=1);

namespace App\XlsImporter\Foundation\XlsValidator\Validators;

use App\Http\Requests\Activity\Indicator\IndicatorRequest;
use App\XlsImporter\Foundation\Factory\Validation;
use App\XlsImporter\Foundation\XlsValidator\ValidatorInterface;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;

/**
 * Class IndicatorValidator.
 */
class IndicatorValidator implements ValidatorInterface
{
    /**
     * array containing indicator and its subelements.
     *
     * @var array
     */
    protected $indicator;

    /**
     * parent result id to the indicator being validated.
     *
     * @var int|null
     */
    protected $resultId;

    /**
     * @var Validation
     */
    protected $factory;

    /**
     * Constructor.
     *
     * @param Validation $factory
     */
    public function __construct(Validation $factory)
    {
        $this->factory = $factory;
    }

    /**
     * Initialize indicator for the class.
     *
     * @param $indicator
     *
     * @return static
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
     *
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    public function rules(): array
    {
        return (new IndicatorRequest())->getWarningForIndicator($this->indicator, true, [], $this->resultId);
    }

    /**
     * Returns error rules for xml uploaded indicator.
     *
     * @return array
     */
    public function errorRules(): array
    {
        return (new IndicatorRequest())->getErrorsForIndicator($this->indicator, true);
    }

    /**
     * Returns critical rules for xml uploaded indicator.
     *
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
