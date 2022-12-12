<?php

declare(strict_types=1);

namespace App\Http\Requests\Activity\Result;

use App\Http\Requests\Activity\ActivityBaseRequest;
use App\IATI\Services\Activity\ResultService;
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
        return $this->getRulesForResult(request()->except(['_token']));
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
     * Returns rules for transaction.
     *
     * @param array $formFields
     *
     * @return array
     */
    public function getRulesForResult(array $formFields, bool $fileUpload = false, array $indicators = []): array
    {
        $rules = [];

        $rules['type'] = sprintf('nullable|in:%s', implode(',', array_keys(getCodeList('ResultType', 'Activity', false))));
        $rules['aggregation_status'] = sprintf('nullable|in:0,1');

        $tempRules = [
            $this->getRulesForNarrative($formFields['title'][0]['narrative'], 'title.0'),
            $this->getRulesForNarrative($formFields['description'][0]['narrative'], 'description.0'),
            $this->getRulesForDocumentLink($formFields['document_link']),
            $this->getRulesForReferences($formFields['reference'], $fileUpload, $indicators),
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
    public function getMessagesForResult(array $formFields, bool $fileUpload = false): array
    {
        $messages = [];

        $tempMessages = [
            $this->getMessagesForNarrative($formFields['title'][0]['narrative'], 'title.0'),
            $this->getMessagesForNarrative($formFields['description'][0]['narrative'], 'description.0'),
            $this->getMessagesForDocumentLink($formFields['document_link']),
            $this->getMessagesForReferences($formFields['reference'], $fileUpload),
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
    protected function getRulesForReferences($formFields, $fileUpload, $indicators): array
    {
        Validator::extendImplicit(
            'indicator_ref_code_present',
            function ($fileUpload, $indicators) {
                if ($fileUpload) {
                    foreach ($indicators as $indicator) {
                        $refs = $indicator['reference'];

                        if (!empty($refs)) {
                            foreach ($refs as $ref) {
                                if (array_key_exists('code', $ref) && $ref['code'] && !empty($ref['code'])) {
                                    return false;
                                }
                            }
                        }
                    }

                    return true;
                } else {
                    $params = $this->route()->parameters();

                    return !app()->make(ResultService::class)->indicatorHasRefCode($params['resultId']);
                }
            }
        );

        $rules = [];

        if ($fileUpload) {
            $hasResultId = false;
        } else {
            $params = $this->route()->parameters();
            $hasResultId = array_key_exists('resultId', $params);
        }

        foreach ($formFields as $referenceIndex => $reference) {
            $referenceForm = sprintf('reference.%s', $referenceIndex);
            $rules[sprintf('%s.vocabulary_uri', $referenceForm)] = 'nullable|url';

            if (!empty($reference['code']) && $hasResultId) {
                $rules[sprintf('%s.code', $referenceForm)] = 'indicator_ref_code_present';
            }
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
    protected function getMessagesForReferences($formFields, $fileUpload): array
    {
        $messages = [];

        if ($fileUpload) {
            $hasResultId = true;
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
