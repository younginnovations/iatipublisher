<?php

declare(strict_types=1);

namespace App\Http\Requests\Activity\Result;

use App\Http\Requests\Activity\ActivityBaseRequest;
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
    protected function getRulesForResult(array $formFields): array
    {
        $rules = [];

        return array_merge(
            $rules,
            $this->getRulesForNarrative($formFields['title'][0]['narrative'], 'title.0'),
            $this->getRulesForNarrative($formFields['description'][0]['narrative'], 'description.0'),
            $this->getRulesForDocumentLink($formFields['document_link']),
            $this->getRulesForReferences($formFields['reference'])
        );
    }

    /**
     * Returns messages for transaction validations.
     *
     * @param array $formFields
     *
     * @return array
     */
    protected function getMessagesForResult(array $formFields): array
    {
        $messages = [];

        return array_merge(
            $messages,
            $this->getMessagesForNarrative($formFields['title'][0]['narrative'], 'title.0'),
            $this->getMessagesForNarrative($formFields['description'][0]['narrative'], 'description.0'),
            $this->getMessagesForDocumentLink($formFields['document_link']),
            $this->getMessagesForReferences($formFields['reference'])
        );
    }

    /**
     * returns rules for Reference.
     *
     * @param $formFields
     *
     * @return array
     */
    protected function getRulesForReferences($formFields): array
    {
        Validator::extendImplicit(
            'indicator_ref_code_present',
            function () {
                $params = $this->route()->parameters();

                return !$this->resultService->indicatorHasRefCode($params['resultId']);
            }
        );

        $rules = [];

        foreach ($formFields as $referenceIndex => $reference) {
            $referenceForm = sprintf('reference.%s', $referenceIndex);
            $rules[sprintf('%s.vocabulary_uri', $referenceForm)] = 'nullable|url';

            if (!empty($reference['code'])) {
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
    protected function getMessagesForReferences($formFields): array
    {
        $messages = [];

        foreach ($formFields as $referenceIndex => $reference) {
            $referenceForm = sprintf('reference.%s', $referenceIndex);
            $messages[sprintf('%s.vocabulary_uri.url', $referenceForm)] = 'The @vocabulary-uri field must be a valid url.';

            if (!empty($reference['code'])) {
                $messages[sprintf('%s.code.indicator_ref_code_present', $referenceForm)] = 'The @code is already defined in its indicators';
            }
        }

        return $messages;
    }
}
