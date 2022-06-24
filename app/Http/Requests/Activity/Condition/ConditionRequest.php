<?php

declare(strict_types=1);

namespace App\Http\Requests\Activity\Condition;

use App\Http\Requests\Activity\ActivityBaseRequest;

/**
 * Class ConditionRequest.
 */
class ConditionRequest extends ActivityBaseRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return $this->getRulesForCondition($this->get('condition'));
    }

    /**
     * Get the error message as required.
     *
     * @return array
     */
    public function messages(): array
    {
        return $this->getMessagesForCondition($this->get('condition'));
    }

    /**
     * Returns rules for related activity.
     *
     * @param array $formFields
     *
     * @return array
     */
    protected function getRulesForCondition(array $formFields): array
    {
        $rules = [];

        foreach ($formFields as $conditionIndex => $condition) {
            $conditionForm = sprintf('condition.%s', $conditionIndex);
            $rules[sprintf('%s.condition_type', $conditionForm)] = 'required_if:condition_attached,1';
            $rules = array_merge(
                $rules,
                $this->getRulesForNarrative($condition['narrative'], $conditionForm)
            );

            foreach ($condition['narrative'] as $narrativeIndex => $narrative) {
                $rules[sprintf('%s.narrative.%s.narrative', $conditionForm, $narrativeIndex)][] = 'required_if:condition_attached,1';
            }
        }

        return $rules;
    }

    /**
     * Returns messages for related activity validations.
     *
     * @param array $formFields
     *
     * @return array
     */
    protected function getMessagesForCondition(array $formFields): array
    {
        $messages = [];

        foreach ($formFields as $conditionIndex => $condition) {
            $conditionForm = sprintf('condition.%s', $conditionIndex);
            $messages[sprintf('%s.condition_type.required_if', $conditionForm)] = 'The @type field is required when @attached field is true.';
            $messages = array_merge(
                $messages,
                $this->getMessagesForNarrative($condition['narrative'], $conditionForm)
            );

            foreach ($condition['narrative'] as $narrativeIndex => $narrative) {
                $messages[sprintf('%s.narrative.%s.narrative.required_if', $conditionForm, $narrativeIndex)] = 'Narrative is required if @attached is true.';
            }
        }

        return $messages;
    }
}
