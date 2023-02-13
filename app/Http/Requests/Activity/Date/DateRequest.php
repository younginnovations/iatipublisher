<?php

declare(strict_types=1);

namespace App\Http\Requests\Activity\Date;

use App\Http\Requests\Activity\ActivityBaseRequest;
use Illuminate\Support\Facades\Validator;

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
        $data = $this->get('activity_date');
        $totalRules = [$this->getErrorsForActivityDate($data), $this->getWarningForActivityDate($data)];

        return mergeRules($totalRules);
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
    public function getWarningForActivityDate(array $formFields): array
    {
        $rules = [];

        foreach ($formFields as $activityDateIndex => $activityDate) {
            $activityDateForm = sprintf('activity_date.%s', $activityDateIndex);

            foreach ($this->getWarningForNarrative($activityDate['narrative'], $activityDateForm) as $narrativeIndex => $narrativeRules) {
                $rules[$narrativeIndex] = $narrativeRules;
            }
        }

        return $this->validateDataRules($formFields, $rules);
    }

    /**
     * Returns critical rules for date.
     *
     * @param array $formFields
     *
     * @return
     */
    public function getErrorsForActivityDate(array $formFields): array
    {
        $rules = [];

        foreach ($formFields as $activityDateIndex => $activityDate) {
            $activityDateForm = sprintf('activity_date.%s', $activityDateIndex);
            $rules[sprintf('%s.date', $activityDateForm)] = 'nullable|date';
            $rules[sprintf('%s.type', $activityDateForm)] = sprintf('nullable|in:%s', implode(',', array_keys(getCodeList('ActivityDateType', 'Activity'))));
            $rules[sprintf('%s.narrative', $activityDateForm)] = $this->getErrorsForNarrative($activityDate['narrative'], $activityDateForm)[sprintf('%s.narrative', $activityDateForm)];
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
    public function getMessagesForDate(array $formFields): array
    {
        $messages = [];

        foreach ($formFields as $activityDateIndex => $activityDate) {
            $activityDateForm = sprintf('activity_date.%s', $activityDateIndex);
            $messages[sprintf('%s.date.date', $activityDateForm)] = 'Date is invalid.';
            $messages[sprintf('%s.date.before', $activityDateForm)] = 'Actual start and end dates may not be in the future.';
            $messages[sprintf('%s.date.end_later_than_start', $activityDateForm)] = 'End date must be later than the start date.';
            $messages += $this->getMessagesForNarrative($activityDate['narrative'], $activityDateForm);
        }

        return $messages;
    }

    /**
     * Validate activity date data based on Activity Date and Activity Date Type.
     *
     * @param array $activityDates
     * @param array $rules
     *
     * @return array
     */
    private function validateDataRules(array $activityDates, array $rules): array
    {
        Validator::extend('end_later_than_start', function () {
            return false;
        });

        foreach ($activityDates as $activityDateIndex => $activityDate) {
            $activityDateForm = sprintf('activity_date.%s', $activityDateIndex);
            $date = $activityDate['date'];
            $type = $activityDate['type'];

            if (isset($date, $type)) {
                if (($type === '2' || $type === '4')) {
                    (dateStrToTime($date) <= dateStrToTime(date('Y-m-d'))) ?: $rules[sprintf('%s.date', $activityDateForm)] .= '|before:' . now();
                }

                if ($type === '4') {
                    $actualStartDate = array_column(
                        array_filter($activityDates, function ($date) {
                            return $date['type'] === '2';
                        }),
                        'date'
                    );

                    if (count($actualStartDate)) {
                        foreach ($actualStartDate as $startDate) {
                            dateStrToTime($date) > dateStrToTime($startDate) ?: $rules[sprintf('%s.date', $activityDateForm)] .= '|end_later_than_start';
                        }
                    }
                }

                if ($type === '3') {
                    $plannedStartDate = array_column(
                        array_filter($activityDates, function ($date) {
                            return $date['type'] === '1';
                        }),
                        'date'
                    );

                    if (count($plannedStartDate)) {
                        foreach ($plannedStartDate as $startDate) {
                            dateStrToTime($date) > dateStrToTime($startDate) ?: $rules[sprintf('%s.date', $activityDateForm)] .= '|end_later_than_start';
                        }
                    }
                }
            }
        }

        return $rules;
    }
}
