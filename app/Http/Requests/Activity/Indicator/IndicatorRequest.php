<?php

declare(strict_types=1);

namespace App\Http\Requests\Activity\Indicator;

use App\Http\Requests\Activity\ActivityBaseRequest;
use Illuminate\Support\Arr;

/**
 * Class IndicatorRequest.
 */
class IndicatorRequest extends ActivityBaseRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        dump(request()->except(['_token']));

        return $this->getRulesForIndicator(request()->except(['_token']));
    }

    /**
     * Get the error message as required.
     *
     * @return array
     */
    public function messages(): array
    {
        return $this->getMessagesForIndicator(request()->except(['_token']));
    }

    /**
     * Returns rules for result indicator.
     *
     * @param array $formFields
     *
     * @return array
     */
    protected function getRulesForIndicator(array $formFields): array
    {
        $rules = [];

        $rules = array_merge(
            $rules,
            $this->getRulesForNarrative($formFields['title'], 'title.0'),
            $this->getRulesForNarrative($formFields['description'], 'description.0'),
            $this->getRulesForDocumentLink($formFields['document_link']),
            $this->getRulesForReference($formFields['reference']),
            $this->getRulesForBaseline($formFields['baseline']),
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
    protected function getMessagesForIndicator(array $formFields): array
    {
        $messages = [];

        $messages = array_merge(
            $messages,
            $this->getMessagesForNarrative($formFields['title'], 'title.0'),
            $this->getMessagesForNarrative($formFields['description'], 'description.0'),
            $this->getMessagesForDocumentLink($formFields['document_link']),
            $this->getMessagesForReference($formFields['reference']),
            $this->getMessagesForBaseline($formFields['baseline']),
        );

        return $messages;
    }

    /**
     * returns rules for reference.
     *
     * @param $formFields
     *
     * @return array
     */
    protected function getRulesForReference($formFields): array
    {
        $rules = [];

        foreach ($formFields as $referenceIndex => $reference) {
            $referenceForm = sprintf('reference.%s', $referenceIndex);
            $rules[sprintf('%s.indicator_uri', $referenceForm)] = 'nullable|url';
        }

        return $rules;
    }

    /**
     * returns messages for reference.
     *
     * @param $formFields
     *
     * @return array
     */
    protected function getMessagesForReference($formFields): array
    {
        $messages = [];

        foreach ($formFields as $referenceIndex => $reference) {
            $referenceForm = sprintf('reference.%s', $referenceIndex);
            $messages[sprintf('%s.indicator_uri.url', $referenceForm)]
                = 'The @indicator-uri field must be a valid url.';
        }

        return $messages;
    }

    /**
     * returns rules for baseline.
     *
     * @param $formFields
     *
     * @return array
     */
    protected function getRulesForBaseline($formFields): array
    {
        $rules = [];

        foreach ($formFields as $baselineIndex => $baseline) {
            $baselineForm = sprintf('baseline.%s', $baselineIndex);

            $rules[sprintf('%s.year', $baselineForm)] = 'nullable|date_format:Y|digits:4';
            $rules[sprintf('%s.value', $baselineForm)] = 'nullable|numeric|gte:0';

            if ((request()->get('measure') == 2) &&
                (Arr::get($baseline, 'value', null))) {
                $rules[sprintf('%s.value', $baselineForm)] = 'nullable|numeric|gte:0';
            } elseif ((request()->get('measure') == 1) &&
                (Arr::get($baseline, 'value', null))) {
                $rules[sprintf('%s.value', $baselineForm)] = 'nullable|numeric';
            }

            $rules = array_merge(
                $rules,
                $this->getRulesForNarrative(
                    $baseline['comment'][0]['narrative'],
                    sprintf('%s.comment.0', $baselineForm)
                ),
                $this->getRulesForDocumentLink($baseline['document_link'], $baselineForm),
            );
        }

        return $rules;
    }

    /**
     * returns messages for baseline.
     *
     * @param $formFields
     *
     * @return array
     */
    protected function getMessagesForBaseline($formFields): array
    {
        $messages = [];

        foreach ($formFields as $baselineIndex => $baseline) {
            $baselineForm = sprintf('baseline.%s', $baselineIndex);
            $messages[sprintf('%s.year.date_format', $baselineForm)] = 'The @year field is not valid.';
            $messages[sprintf('%s.year.digits', $baselineForm)] = 'The @year field must have 4 digits.';

            $messages[sprintf('%s.value.numeric', $baselineForm)] = 'The @value field must be a number.';
            $messages[sprintf('%s.value.gte', $baselineForm)] = 'The @value field must be greater or equal to 0.';

            $messages = array_merge(
                $messages,
                $this->getMessagesForNarrative(
                    $baseline['comment'][0]['narrative'],
                    sprintf('%s.comment.0', $baselineForm)
                ),
                $this->getMessagesForDocumentLink($baseline['document_link'], $baselineForm),
            );
        }

        return $messages;
    }
}
