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
     * @param array $formFields
     * @return array
     */
    protected function getRulesForTag(array $formFields): array
    {
        $rules = [];

        foreach ($formFields as $tagIndex => $tag) {
            $tagForm = sprintf('tag.%s', $tagIndex);
            $rules[sprintf('%s.tag_vocabulary', $tagForm)] = 'required';
            $rules[sprintf('%s.vocabulary_uri', $tagForm)] = 'nullable|url';

            if ($tag['tag_vocabulary'] == 1) {
                $rules[sprintf('%s.tag_code', $tagForm)] = 'required';
            } elseif ($tag['tag_vocabulary'] == 2) {
                $rules[sprintf('%s.goals_tag_code', $tagForm)] = 'required';
            } elseif ($tag['tag_vocabulary'] == 3) {
                $rules[sprintf('%s.targets_tag_code', $tagForm)] = 'required';
            } elseif ($tag['tag_vocabulary'] == 99) {
                $rules[sprintf('%s.tag_text', $tagForm)] = 'required';
                $rules[sprintf('%s.vocabulary_uri', $tagForm)] = 'url|required_with:' . $tagForm . '.tag_vocabulary';
            }

            $rules = array_merge($rules, $this->getRulesForNarrative($tag['narrative'], $tagForm));
        }

        return $rules;
    }

    /**
     * Returns messages for related activity validations.
     * @param array $formFields
     * @return array
     */
    protected function getMessagesForTag(array $formFields): array
    {
        $messages = [];

        foreach ($formFields as $tagIndex => $tag) {
            $tagForm = sprintf('tag.%s', $tagIndex);
            $messages[sprintf('%s.tag_vocabulary.required', $tagForm)] = 'The @vocabulary field is required.';

            if ($tag['tag_vocabulary'] == 1) {
                $messages[sprintf('%s.tag_code.required', $tagForm)] = 'The @code field is required.';
            } elseif ($tag['tag_vocabulary'] == 2) {
                $messages[sprintf('%s.goals_tag_code.required', $tagForm)] = trans(
                    'validation.required',
                    ['attribute' => trans('elementForm.tag_code')]
                );
            } elseif ($tag['tag_vocabulary'] == 3) {
                $messages[sprintf('%s.targets_tag_code.required', $tagForm)] = 'The @code field is required.';
            } elseif ($tag['tag_vocabulary'] == 99) {
                $messages[sprintf('%s.tag_text.required', $tagForm)] = 'The @code field is required.';
                $messages[sprintf('%s.vocabulary_uri.url', $tagForm)] = 'The @vocabulary-uri field must be a valid url.';
                $messages[sprintf('%s.vocabulary_uri.%s', $tagForm, 'required_with')] = 'The @vocabulary-uri field is required when @vocabulary field is 99.';
            }

            $messages = array_merge($messages, $this->getMessagesForNarrative($tag['narrative'], $tagForm));
        }

        return $messages;
    }
}
