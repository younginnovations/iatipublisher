<?php

declare(strict_types=1);

namespace App\Http\Requests\Activity\Indicator;

use App\Http\Requests\Activity\ActivityBaseRequest;
use App\IATI\Services\Activity\ResultService;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Validator;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;

/**
 * Class IndicatorRequest.
 */
class IndicatorRequest extends ActivityBaseRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    public function rules(): array
    {
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
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    protected function getRulesForIndicator(array $formFields): array
    {
        $rules = [];

        return array_merge(
            $rules,
            $this->getRulesForNarrative($formFields['title'], 'title.0'),
            $this->getRulesForNarrative($formFields['description'], 'description.0'),
            $this->getRulesForDocumentLink($formFields['document_link']),
            $this->getRulesForReference($formFields['reference']),
            $this->getRulesForBaseline($formFields['baseline']),
        );
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

        return array_merge(
            $messages,
            $this->getMessagesForNarrative($formFields['title'], 'title.0'),
            $this->getMessagesForNarrative($formFields['description'], 'description.0'),
            $this->getMessagesForDocumentLink($formFields['document_link']),
            $this->getMessagesForReference($formFields['reference']),
            $this->getMessagesForBaseline($formFields['baseline']),
        );
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

        Validator::extendImplicit(
            'result_ref_code_present',
            function () {
                $params = $this->route()->parameters();

                return !app()->make(ResultService::class)->resultHasRefCode((int) $params['id']);
            }
        );

        foreach ($formFields as $referenceIndex => $reference) {
            $referenceForm = sprintf('reference.%s', $referenceIndex);
            $rules[sprintf('%s.indicator_uri', $referenceForm)] = 'nullable|url';

            if (!empty($reference['code'])) {
                $rules[sprintf('%s.code', $referenceForm)] = 'result_ref_code_present';
            }
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
            $messages[sprintf('%s.indicator_uri.url', $referenceForm)] = 'The @indicator-uri field must be a valid url.';

            if (!empty($reference['code'])) {
                $messages[sprintf('%s.code.result_ref_code_present', $referenceForm)] = 'The @code is already defined in its result';
            }
        }

        return $messages;
    }

    /**
     * returns rules for baseline.
     *
     * @param $formFields
     *
     * @return array
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    protected function getRulesForBaseline($formFields): array
    {
        $rules = [];

        foreach ($formFields as $baselineIndex => $baseline) {
            $baselineForm = sprintf('baseline.%s', $baselineIndex);
            $baselineYearRule = 'nullable|date_format:Y|digits:4';

            if (!empty($baseline['date'])) {
                $baselineYearRule = sprintf('%s|in:%s', $baselineYearRule, date('Y', strtotime($baseline['date'])));
            }
            $rules[sprintf('%s.year', $baselineForm)] = $baselineYearRule;
            $rules[sprintf('%s.value', $baselineForm)] = 'nullable|numeric|gte:0';

            if ((request()->get('measure') === 2) && Arr::get($baseline, 'value', null)) {
                $rules[sprintf('%s.value', $baselineForm)] = 'nullable|numeric|gte:0';
            } elseif ((request()->get('measure') === 1) && Arr::get($baseline, 'value', null)) {
                $rules[sprintf('%s.value', $baselineForm)] = 'nullable|numeric';
            }

            $narrativeRules = $this->getRulesForNarrative($baseline['comment'][0]['narrative'], sprintf('%s.comment.0', $baselineForm));

            foreach ($narrativeRules as $key => $item) {
                $rules[$key] = $item;
            }

            $dcoLinkRules = $this->getRulesForDocumentLink($baseline['document_link'], $baselineForm);

            foreach ($dcoLinkRules as $key => $item) {
                $rules[$key] = $item;
            }
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
            $messages[sprintf('%s.year.in', $baselineForm)] = 'The @year field should be the year of baseline date';
            $messages[sprintf('%s.year.digits', $baselineForm)] = 'The @year field must have 4 digits.';

            $messages[sprintf('%s.value.numeric', $baselineForm)] = 'The @value field must be a number.';
            $messages[sprintf('%s.value.gte', $baselineForm)] = 'The @value field must be greater or equal to 0.';

            $narrativeMessages = $this->getMessagesForNarrative($baseline['comment'][0]['narrative'], sprintf('%s.comment.0', $baselineForm));

            foreach ($narrativeMessages as $key => $item) {
                $messages[$key] = $item;
            }

            $docLinkMessages = $this->getMessagesForDocumentLink($baseline['document_link'], $baselineForm);

            foreach ($docLinkMessages as $key => $item) {
                $messages[$key] = $item;
            }
        }

        return $messages;
    }
}
