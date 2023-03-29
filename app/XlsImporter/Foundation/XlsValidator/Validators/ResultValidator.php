<?php

declare(strict_types=1);

namespace App\XmlImporter\Foundation\Support\Factory;

use App\Http\Requests\Activity\Result\ResultRequest;
use App\XlsImporter\Foundation\XlsValidator\ValidatorInterface;

/**
 * Class XmlValidator.
 */
class ResultValidator implements ValidatorInterface
{
    /**
     * @var
     */
    protected $result;

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
     * Returns warnings for xml uploaded activity.
     *
     * @return array
     */
    public function rules(): array
    {
        $rules = (new ResultRequest())->getWarningForResult($this->result);

        // foreach ($this->result as $periodIndex => $period) {
        // $periodBase = sprintf('period.%s', $periodIndex);
        // $tempRules = (new PeriodRequest())->getWarningForPeriod($this->result, true, []);

        // foreach ($tempRules as $idx => $rule) {
            //     $rules[$periodBase . '.' . $idx] = $rule;
        // }
        // }

        return $rules;
    }

    /**
     * Returns error rules for xml uploaded activity.
     *
     * @return array
     */
    public function errorRules(): array
    {
        $rules = (new ResultRequest())->getErrorsForResult($this->result);

        return $rules;
        // return [];
    }

    /**
     * Returns critical rules for xml uploaded activity.
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
        return (new ResultRequest())->getMessagesForResult($this->result);
    }

    public function init($result): void
    {
        $this->result = $result;
    }

    /**
     * @param bool $isDuplicate
     * @param bool $isIdentifierValid
     *
     * @return array
     */
    public function validateData(bool $isDuplicate, bool $isIdentifierValid): array
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
