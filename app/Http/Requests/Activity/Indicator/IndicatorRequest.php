<?php

declare(strict_types=1);

namespace App\Http\Requests\Activity\Indicator;

use App\Http\Requests\Activity\ActivityBaseRequest;
use App\IATI\Services\Activity\ResultService;
use Illuminate\Contracts\Container\BindingResolutionException;
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
     * @throws NotFoundExceptionInterface
     *
     * @throws ContainerExceptionInterface
     */
    public function rules(): array
    {
        $data = request()->except(['_token']);
        $totalRules = [
            $this->getWarningForIndicator($data),
            $this->getErrorsForIndicator($data),
        ];

        return mergeRules($totalRules);
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
     * @param bool $fileUpload
     * @param array $result
     * @param $resultId
     *
     * @return array
     * @throws NotFoundExceptionInterface
     *
     * @throws ContainerExceptionInterface
     */
    public function getWarningForIndicator(array $formFields, bool $fileUpload = false, array $result = [], $resultId = null): array
    {
        $rules = [];

        if (!$fileUpload) {
            $resultId = (int) (Arr::get($this->route()->parameters(), 'id'));
        }

        $tempRules = [
            $this->getWarningForNarrative(Arr::get($formFields, 'title', []), 'title.0'),
            $this->getWarningForNarrative(Arr::get($formFields, 'description', []), 'description.0'),
            $this->getWarningForDocumentLink(Arr::get($formFields, 'document_link', [])),
            $this->getWarningForReference(Arr::get($formFields, 'reference', []), $fileUpload, $result, $resultId),
            $this->getWarningForBaseline(Arr::get($formFields, 'baseline', [])),
        ];

        foreach ($tempRules as $index => $tempRule) {
            foreach ($tempRule as $idx => $rule) {
                $rules[$idx] = $rule;
            }
        }

        return $rules;
    }

    /**
     * Returns rules for result indicator.
     *
     * @param array $formFields
     * @param bool $fileUpload
     * @param array $result
     *
     * @return array
     * @throws NotFoundExceptionInterface
     *
     * @throws ContainerExceptionInterface
     */
    public function getErrorsForIndicator(array $formFields, bool $fileUpload = false, array $result = []): array
    {
        $rules = [];
        $rules['measure'] = sprintf('nullable|in:%s', implode(',', array_keys(
            $this->getCodeListForRequestFiles('IndicatorMeasure', 'Activity', false)
        )));
        $rules['ascending'] = sprintf('nullable|in:0,1');
        $rules['aggregation_status'] = sprintf('nullable|in:0,1');

        $tempRules = [
            $this->getErrorsForNarrative(Arr::get($formFields, 'title', []), 'title.0'),
            $this->getErrorsForNarrative(Arr::get($formFields, 'description', []), 'description.0'),
            $this->getErrorsForDocumentLink(Arr::get($formFields, 'document_link', [])),
            $this->getErrorsForReference(Arr::get($formFields, 'reference', []), $fileUpload),
            $this->getErrorsForBaseline(Arr::get($formFields, 'baseline', [])),
        ];

        foreach ($tempRules as $index => $tempRule) {
            foreach ($tempRule as $idx => $rule) {
                $rules[$idx] = $rule;
            }
        }

        return $rules;
    }

    /**
     * Returns messages for result indicator validations.
     *
     * @param array $formFields
     *
     * @return array
     */
    public function getMessagesForIndicator(array $formFields): array
    {
        $messages = [];
        $messages['measure.in'] = 'The indicator measure is invalid.';
        $messages['aggregation_status.in'] = 'The indicator aggregation status is invalid.';
        $messages['ascending.in'] = 'The indicator ascending is invalid.';

        $tempMessages = [
            $this->getMessagesForNarrative(Arr::get($formFields, 'title', []), 'title.0'),
            $this->getMessagesForNarrative(Arr::get($formFields, 'description', []), 'description.0'),
            $this->getMessagesForDocumentLink(Arr::get($formFields, 'document_link', [])),
            $this->getMessagesForReference(Arr::get($formFields, 'reference', [])),
            $this->getMessagesForBaseline(Arr::get($formFields, 'baseline', [])),
        ];

        foreach ($tempMessages as $index => $tempMessage) {
            foreach ($tempMessage as $idx => $message) {
                $messages[$idx] = $message;
            }
        }

        return $messages;
    }

    /**
     * returns rules for reference.
     *
     * @param $formFields
     * @param $fileUpload
     * @param array $result
     * @param $resultId
     *
     * @return array
     *
     * @throws BindingResolutionException
     */
    protected function getWarningForReference($formFields, bool $fileUpload, array $result, $resultId): array
    {
        $resultService = app()->make(ResultService::class);
        $rules = [];

        Validator::extendImplicit(
            'result_ref_code_present',
            function () {
                return false;
            }
        );

        Validator::extendImplicit(
            'result_ref_vocabulary_present',
            function () {
                return false;
            }
        );

        foreach ($formFields as $referenceIndex => $reference) {
            $referenceForm = sprintf('reference.%s', $referenceIndex);

            if (!is_array_value_empty($reference)) {
                if ($fileUpload) {
                    $hasCode = false;
                    $hasVocabulary = false;

                    foreach ((Arr::get($result, 'reference', [])) as $ref) {
                        if (Arr::get($ref, 'code', false)) {
                            $hasCode = true;
                            break;
                        }

                        if (Arr::get($ref, 'vocabulary', false)) {
                            $hasVocabulary = true;
                            break;
                        }
                    }

                    $codePresent = $resultId ? $resultService->resultHasRefCode($resultId) : $hasCode;
                    $vocabularyPresent = $resultId ? $resultService->resultHasRefVocabulary($resultId) : $hasVocabulary;

                    $rules[sprintf('%s.code', $referenceForm)][] = $codePresent ? 'result_ref_code_present' : false;
                    $rules[sprintf('%s.vocabulary', $referenceForm)][] = $vocabularyPresent ? 'result_ref_vocabulary_present' : false;
                } else {
                    $rules[sprintf('%s.code', $referenceForm)][] = $resultService->resultHasRefCode($resultId) ? 'result_ref_code_present' : false;
                    $rules[sprintf('%s.vocabulary', $referenceForm)][] = $resultService->resultHasRefVocabulary($resultId) ? 'result_ref_vocabulary_present' : false;
                }
            }
        }

        return $rules;
    }

    /**
     * returns rules for reference.
     *
     * @param $formFields
     * @param $fileUpload
     *
     * @return array
     *
     * @throws \JsonException
     */
    protected function getErrorsForReference($formFields, bool $fileUpload): array
    {
        $rules = [];

        foreach ($formFields as $referenceIndex => $reference) {
            $referenceForm = sprintf('reference.%s', $referenceIndex);
            $rules[sprintf('%s.indicator_uri', $referenceForm)] = 'nullable|url';
            $rules[sprintf('%s.vocabulary', $referenceForm)] = sprintf('nullable|in:%s', implode(',', array_keys(
                $this->getCodeListForRequestFiles('IndicatorVocabulary', 'Activity', false)
            )));
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
                $messages[sprintf('%s.code.result_ref_code_present', $referenceForm)] = 'The code is already defined in its result';
            }

            if (!empty($reference['vocabulary'])) {
                $messages[sprintf('%s.vocabulary.result_ref_vocabulary_present', $referenceForm)] = 'The vocabulary is already defined in its result';
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
     * @throws NotFoundExceptionInterface
     *
     * @throws ContainerExceptionInterface
     */
    protected function getWarningForBaseline($formFields): array
    {
        $rules = [];

        foreach ($formFields as $baselineIndex => $baseline) {
            $baselineForm = sprintf('baseline.%s', $baselineIndex);
            $rules[sprintf('%s.value', $baselineForm)] = 'nullable|numeric|gte:0';

            if ((request()->get('measure') == 2) && Arr::get($baseline, 'value', null)) {
                $rules[sprintf('%s.value', $baselineForm)] = 'nullable|numeric|gte:0';
            } elseif ((request()->get('measure') == 1) && Arr::get($baseline, 'value', null)) {
                $rules[sprintf('%s.value', $baselineForm)] = 'nullable|numeric';
            }

            $narrativeRules = $this->getWarningForNarrative($baseline['comment'][0]['narrative'], sprintf('%s.comment.0', $baselineForm));

            foreach ($narrativeRules as $key => $item) {
                $rules[$key] = $item;
            }

            $dcoLinkRules = $this->getWarningForDocumentLink(Arr::get($baseline, 'document_link', []), $baselineForm);

            foreach ($dcoLinkRules as $key => $item) {
                $rules[$key] = $item;
            }
        }

        return $rules;
    }

    /**
     * returns rules for baseline.
     *
     * @param $formFields
     *
     * @return array
     * @throws NotFoundExceptionInterface
     *
     * @throws ContainerExceptionInterface
     */
    protected function getErrorsForBaseline($formFields): array
    {
        $rules = [];

        foreach ($formFields as $baselineIndex => $baseline) {
            $baselineForm = sprintf('baseline.%s', $baselineIndex);
            $baselineYearRule = 'nullable|date_format:Y|digits:4';

            if (!empty($baseline['date']) && dateStrToTime(($baseline['date']))) {
                $baselineYearRule = sprintf('%s|in:%s', $baselineYearRule, date('Y', dateStrToTime($baseline['date'])));
            }

            $rules[sprintf('%s.year', $baselineForm)] = $baselineYearRule;

            $narrativeRules = $this->getErrorsForNarrative($baseline['comment'][0]['narrative'], sprintf('%s.comment.0', $baselineForm));

            foreach ($narrativeRules as $key => $item) {
                $rules[$key] = $item;
            }

            $dcoLinkRules = $this->getErrorsForDocumentLink(Arr::get($baseline, 'document_link', []), $baselineForm);

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

            $docLinkMessages = $this->getMessagesForDocumentLink(Arr::get($baseline, 'document_link', []), $baselineForm);

            foreach ($docLinkMessages as $key => $item) {
                $messages[$key] = $item;
            }
        }

        return $messages;
    }
}
