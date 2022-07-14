<?php

declare(strict_types=1);

namespace App\Http\Requests\Activity\Period;

use App\Http\Requests\Activity\ActivityBaseRequest;

/**
 * Class PeriodRequest.
 */
class PeriodRequest extends ActivityBaseRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return $this->getRulesForPeriod(request()->except(['_token']));
    }

    /**
     * Get the error message as required.
     *
     * @return array
     */
    public function messages(): array
    {
        return $this->getMessagesForPeriod(request()->except(['_token']));
    }

    /**
     * Returns rules for result indicator.
     *
     * @param array $formFields
     *
     * @return array
     */
    protected function getRulesForPeriod(array $formFields): array
    {
        $rules = [];

        $rules = array_merge(
            $rules,
            $this->getRulesForResultPeriod($formFields['period_start'], 'period_start'),
            $this->getRulesForResultPeriod($formFields['period_end'], 'period_end'),
            $this->getRulesForTarget($formFields['target'], 'target'),
            $this->getRulesForTarget($formFields['actual'], 'actual')
        );

        return $rules;
    }

    /**
     * Returns messages for result indicator validations.
     *
     * @param array $formFields
     *
     * @return array
     */
    protected function getMessagesForPeriod(array $formFields): array
    {
        $messages = [];

        $messages = array_merge(
            $messages,
            $this->getMessagesForResultPeriod($formFields['period_start'], 'period_start'),
            $this->getMessagesForResultPeriod($formFields['period_end'], 'period_end'),
            $this->getMessagesForTarget($formFields['target'], 'target'),
            $this->getMessagesForTarget($formFields['actual'], 'actual')
        );

        return $messages;
    }

    /**
     * returns rules for period start and period end.
     *
     * @param $formFields
     * @param $periodType
     *
     * @return array
     */
    protected function getRulesForResultPeriod($formFields, $periodType): array
    {
        $rules = [];

        foreach ($formFields as $periodStartKey => $periodStartVal) {
            $rules[sprintf('%s.%s.date', $periodType, $periodStartKey)] = 'nullable|date|date_greater_than:1900';
        }

        return $rules;
    }

    /**
     * returns messages for period start and period end.
     *
     * @param $formFields
     * @param $periodType
     *
     * @return array
     */
    protected function getMessagesForResultPeriod($formFields, $periodType): array
    {
        $messages = [];

        foreach ($formFields as $periodStartKey => $periodStartVal) {
            $messages[sprintf('%s.%s.date.date', $periodType, $periodStartKey)] = 'The @date field must be a proper date.';
            $messages[sprintf('%s.%s.date.date_greater_than', $periodType, $periodStartKey)] = 'The @date field must date after year 1900.';
        }

        return $messages;
    }

    /**
     * returns rules for Target.
     *
     * @param $formFields
     * @param $valueType
     *
     * @return array
     */
    protected function getRulesForTarget($formFields, $valueType): array
    {
        $rules = [];

        foreach ($formFields as $targetIndex => $target) {
            $targetForm = sprintf('%s.%s', $valueType, $targetIndex);

            $rules = array_merge(
                $rules,
                $this->getRulesForNarrative($target['comment'][0]['narrative'], sprintf('%s.comment.0', $targetForm)),
                $this->getRulesForDocumentLink($target['document_link'], $targetForm),
            );
        }

        return $rules;
    }

    /**
     * returns messages for target.
     *
     * @param $formFields
     * @param $valueType
     *
     * @return array
     */
    protected function getMessagesForTarget($formFields, $valueType): array
    {
        $messages = [];

        foreach ($formFields as $targetIndex => $target) {
            $targetForm = sprintf('%s.%s', $valueType, $targetIndex);

            $messages = array_merge(
                $messages,
                $this->getMessagesForNarrative($target['comment'][0]['narrative'], sprintf('%s.comment.0', $targetForm)),
                $this->getMessagesForDocumentLink($target['document_link'], $targetForm),
            );
        }

        return $messages;
    }
}
