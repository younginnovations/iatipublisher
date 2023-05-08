<?php

declare(strict_types=1);

namespace App\Http\Requests\Activity\Result;

use App\Http\Requests\Activity\ActivityBaseRequest;
use App\IATI\Services\Activity\ResultService;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Validator;

/**
 * Class ResultRequest.
 */
class ResultRequest extends ActivityBaseRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        $data = request()->except(['_token']);

        $totalRules = [
            $this->getWarningForResult($data),
            $this->getErrorsForResult($data),
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
        return $this->getMessagesForResult(request()->except(['_token']));
    }

    /**
     * Returns rules for result.
     *
     * @param array $formFields
     * @param bool $fileUpload
     * @param array $indicator
     *
     * @return array
     */
    public function getWarningForResult(array $formFields, bool $fileUpload = false, array $indicators = [], $resultId = null): array
    {
        $rules = [];

        $tempRules = [
            $this->getWarningForNarrative($formFields['title'][0]['narrative'], 'title.0'),
            $this->getWarningForNarrative($formFields['description'][0]['narrative'], 'description.0'),
            $this->getWarningForDocumentLink($formFields['document_link']),
            // $this->getWarningForReferences($formFields['reference'], $fileUpload, $indicators, $resultId),
        ];

        foreach ($tempRules as $key => $tempRule) {
            foreach ($tempRule as $idx => $rule) {
                $rules[$idx] = $rule;
            }
        }

        return $rules;
    }

    /**
     * Returns critical rules for result.
     *
     * @param array $formFields
     * @param bool $fileUpload
     * @param array $indicators
     *
     * @return array
     */
    public function getErrorsForResult(array $formFields, bool $fileUpload = false, array $indicators = []): array
    {
        $rules = [];
        $rules['type'] = sprintf('nullable|in:%s', implode(',', array_keys(getCodeList('ResultType', 'Activity', false))));
        $rules['aggregation_status'] = sprintf('nullable|in:0,1');

        $tempRules = [
            $this->getErrorsForNarrative(Arr::get($formFields, 'title.0.narrative', []), 'title.0'),
            $this->getErrorsForNarrative(Arr::get($formFields, 'description.0.narrative', []), 'description.0'),
            $this->getErrorsForDocumentLink(Arr::get($formFields, 'document_link')),
            $this->getErrorsForReferences(Arr::get($formFields, 'reference', []), $fileUpload, $indicators),
        ];

        foreach ($tempRules as $key => $tempRule) {
            foreach ($tempRule as $idx => $rule) {
                $rules[$idx] = $rule;
            }
        }

        return $rules;
    }

    /**
     * Returns messages for transaction validations.
     *
     * @param array $formFields
     *
     * @return array
     */
    public function getMessagesForResult(array $formFields, bool $fileUpload = false, $resultId = null): array
    {
        $messages = [];

        $tempMessages = [
            $this->getMessagesForNarrative(Arr::get($formFields, 'title.0.narrative', []), 'title.0'),
            $this->getMessagesForNarrative(Arr::get($formFields, 'description.0.narrative', []), 'description.0'),
            $this->getMessagesForDocumentLink(Arr::get($formFields, 'document_link', [])),
            $this->getMessagesForReferences(Arr::get($formFields, 'reference', []), $fileUpload, $resultId),
        ];

        foreach ($tempMessages as $key => $tempMessage) {
            foreach ($tempMessage as $idx => $message) {
                $messages[$idx] = $message;
            }
        }

        return $messages;
    }

    /**
     * returns rules for Reference.
     *
     * @param $formFields
     *
     * @return array
     */
    protected function getWarningForReferences($formFields, $fileUpload = false, array $indicators = [], int $resultId = null): array
    {
        Validator::extendImplicit(
            'indicator_ref_code_present',
            function () use ($resultId) {
                $resultId = Arr::get($this->route()->parameters(), 'resultId');

                return !app()->make(ResultService::class)->indicatorHasRefCode($resultId);
            }
        );

        $rules = [];

        if ($fileUpload) {
            $hasResultId = (bool) $resultId;
        } else {
            $params = $this->route()->parameters();
            $hasResultId = array_key_exists('resultId', $params);
        }

        foreach ($formFields as $referenceIndex => $reference) {
            $referenceForm = sprintf('reference.%s', $referenceIndex);

            if (!empty($reference['code']) && $reference['code'] !== '' && $hasResultId) {
                if ($fileUpload) {
                    $hasCode = false;

                    foreach ((Arr::get($indicators, 'reference', [])) as $ref) {
                        if (Arr::get($ref, 'code') && !empty($ref['code'])) {
                            $hasCode = true;
                            break;
                        }
                    }

                    $rules[sprintf('%s.code', $referenceForm)][] = 'indicator_ref_code_present:' . $resultId ? !app()->make(ResultService::class)->indicatorHasRefCode($resultId) : !$hasCode;
                } else {
                    $rules[sprintf('%s.code', $referenceForm)][] = 'indicator_ref_code_present';
                }
            }
        }

        return $rules;
    }

    /**
     * returns critical rules for Reference.
     *
     * @param $formFields
     *
     * @return array
     */
    protected function getErrorsForReferences($formFields, $fileUpload = false, array $indicators = []): array
    {
        $rules = [];

        foreach ($formFields as $referenceIndex => $reference) {
            $referenceForm = sprintf('reference.%s', $referenceIndex);
            $rules[sprintf('%s.vocabulary_uri', $referenceForm)] = 'nullable|url';
            $rules[sprintf('%s.vocabulary', $referenceForm)] = sprintf('nullable|in:%s', implode(',', array_keys(getCodeList('ResultVocabulary', 'Activity'))));
        }

        return $rules;
    }

    /**
     * returns messages for Reference.
     *
     * @param $formFields
     *
     * @return array
     */
    protected function getMessagesForReferences($formFields, $fileUpload = false, $resultId = null): array
    {
        $messages = [];

        if ($fileUpload) {
            $hasResultId = (bool) $resultId;
        } else {
            $params = $this->route()->parameters();
            $hasResultId = array_key_exists('resultId', $params);
        }

        foreach ($formFields as $referenceIndex => $reference) {
            $referenceForm = sprintf('reference.%s', $referenceIndex);
            $messages[sprintf('%s.vocabulary_uri.url', $referenceForm)] = 'The @vocabulary-uri field must be a valid url.';

            if (!empty($reference['code']) && $hasResultId) {
                $messages[sprintf('%s.code.indicator_ref_code_present', $referenceForm)] = 'The code is already defined in its indicators';
            }
        }

        return $messages;
    }
}
