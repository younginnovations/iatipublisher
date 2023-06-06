<?php

declare(strict_types=1);

namespace App\XlsImporter\Foundation\XlsValidator\Validators;

use App\Http\Requests\Activity\Result\ResultRequest;
use App\XlsImporter\Foundation\Factory\Validation;
use App\XlsImporter\Foundation\XlsValidator\ValidatorInterface;

/**
 * Class XlsValidator.
 */
class ResultValidator implements ValidatorInterface
{
    /**
     * result to be validated.
     *
     * @var array
     */
    protected $result;

    /**
     * id of result being validated if it already exists in the system.
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
     * Initialization of data for result validation.
     *
     * @param $result
     *
     * @return static
     */
    public function init($result): static
    {
        $this->result = $result['result'];
        $this->resultId = $result['resultId'];

        return $this;
    }

    /**
     * Validation of result.
     *
     * @return array
     */
    public function validateData(): array
    {
        $errors = [
            'critical' => $this->factory->initialize($this->result, $this->criticalRules(), $this->messages())
                ->passes()
                ->withErrors(),
            'error' => $this->factory->initialize($this->result, $this->errorRules(), $this->messages())
                ->passes()
                ->withErrors(),
            'warning' => $this->factory->initialize($this->result, $this->rules(), $this->messages())
                ->passes()
                ->withErrors(),
        ];

        return $errors;
    }

    /**
     * Returns warnings for xls uploaded activity.
     *
     * @return array
     */
    public function rules(): array
    {
        return (new ResultRequest())->getWarningForResult($this->result, true, [], $this->resultId);
    }

    /**
     * Returns error rules for xls uploaded activity.
     *
     * @return array
     */
    public function errorRules(): array
    {
        return (new ResultRequest())->getErrorsForResult($this->result, true);
    }

    /**
     * Returns critical rules for xls uploaded activity.
     *
     * @return array
     */
    public function criticalRules(): array
    {
        return [];
    }

    /**
     * Returns the required messages for the failed validation rules.
     *
     * @return array
     */
    public function messages(): array
    {
        return (new ResultRequest())->getMessagesForResult($this->result, true, $this->resultId);
    }
}
