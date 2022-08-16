<?php

declare(strict_types=1);

namespace App\Http\Requests\Activity\Date;

use App\Http\Requests\Activity\ActivityBaseRequest;

/**
 * Class DateRequest.
 */
class DateRequest extends ActivityBaseRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return $this->getRulesForDate($this->get('activity_date'));
    }

    /**
     * Get the error message as required.
     *
     * @return array
     */
    public function messages(): array
    {
        return $this->getMessagesForDate($this->get('activity_date'));
    }

    /**
     * Returns rules for related activity.
     *
     * @param array $formFields
     *
     * @return array
     */
    protected function getRulesForDate(array $formFields): array
    {
        $rules = [];

        foreach ($formFields as $activityDateIndex => $activityDate) {
            $activityDateForm = sprintf('activity_date.%s', $activityDateIndex);
            $rules[sprintf('%s.date', $activityDateForm)] = 'nullable|date';
            $rules[sprintf('%s.type', $activityDateForm)] = 'nullable';
            $rules[sprintf('%s.narrative', $activityDateForm)] = $this->getRulesForNarrative($activityDate['narrative'], $activityDateForm)[sprintf('%s.narrative', $activityDateForm)];
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
    protected function getMessagesForDate(array $formFields): array
    {
        $messages = [];

        foreach ($formFields as $activityDateIndex => $activityDate) {
            $activityDateForm = sprintf('activity_date.%s', $activityDateIndex);
            $messages[sprintf('%s.date.date', $activityDateForm)] = 'Date is invalid.';
            $messages = $messages + $this->getMessagesForNarrative($activityDate['narrative'], $activityDateForm);
        }

        return $messages;
    }
}
