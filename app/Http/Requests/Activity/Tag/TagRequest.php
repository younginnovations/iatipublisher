<?php

declare(strict_types=1);

namespace App\Http\Requests\Activity\Tag;

use App\Http\Requests\Activity\ActivityBaseRequest;

/**
 * Class TagRequest.
 */
class TagRequest extends ActivityBaseRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return $this->getRulesForTag($this->get('tag'));
    }

    /**
     * Get the error message as required.
     *
     * @return array
     */
    public function messages(): array
    {
        return $this->getMessagesForTag($this->get('tag'));
    }

    /**
     * Returns rules for related activity.
     *
     * @param array $formFields
     *
     * @return array
     */
    protected function getRulesForTag(array $formFields): array
    {
        $rules = [];

        foreach ($formFields as $tagIndex => $tag) {
            $tagForm = sprintf('tag.%s', $tagIndex);
            $rules[sprintf('%s.vocabulary_uri', $tagForm)] = 'nullable|url';

            $rules = array_merge($rules, $this->getRulesForNarrative($tag['narrative'], $tagForm));
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
    protected function getMessagesForTag(array $formFields): array
    {
        $messages = [];

        foreach ($formFields as $tagIndex => $tag) {
            $tagForm = sprintf('tag.%s', $tagIndex);
            $messages[sprintf('%s.vocabulary_uri.url', $tagForm)] = 'The @vocabulary-uri field must be a valid url.';
            $messages = array_merge($messages, $this->getMessagesForNarrative($tag['narrative'], $tagForm));
        }

        return $messages;
    }
}
