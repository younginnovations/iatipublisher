<?php

declare(strict_types=1);

namespace App\Http\Requests\Activity\Tag;

use App\Http\Requests\Activity\ActivityBaseRequest;
use JsonException;

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
        $data = $this->get('tag');
        $totalRules = [$this->getErrorsForTag($data), $this->getWarningForTag($data)];

        return mergeRules($totalRules);
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
    public function getWarningForTag(array $formFields): array
    {
        $rules = [];

        foreach ($formFields as $tagIndex => $tag) {
            $tagForm = sprintf('tag.%s', $tagIndex);

            foreach ($this->getWarningForNarrative($tag['narrative'], $tagForm) as $tagNarrativeIndex => $narrativeRules) {
                $rules[$tagNarrativeIndex] = $narrativeRules;
            }
        }

        return $rules;
    }

    /**
     * Returns critical rules for related activity.
     *
     * @param array $formFields
     *
     * @return array
     * @throws JsonException
     */
    public function getErrorsForTag(array $formFields): array
    {
        $rules = [];

        foreach ($formFields as $tagIndex => $tag) {
            $tagForm = sprintf('tag.%s', $tagIndex);
            $rules[sprintf('%s.tag_vocabulary', $tagForm)] = 'nullable|in:' . implode(',', array_keys(getCodeList('TagVocabulary', 'Activity', false)));
            $rules[sprintf('%s.goals_tag_code', $tagForm)] = 'nullable|in:' . implode(',', array_keys(getCodeList('UNSDG-Goals', 'Activity', false)));
            $rules[sprintf('%s.targets_tag_code', $tagForm)] = 'nullable|in:' . implode(',', array_keys(getCodeList('UNSDG-Targets', 'Activity', false)));
            $rules[sprintf('%s.vocabulary_uri', $tagForm)] = 'nullable|url';

            foreach ($this->getErrorsForNarrative($tag['narrative'], $tagForm) as $tagNarrativeIndex => $narrativeRules) {
                $rules[$tagNarrativeIndex] = $narrativeRules;
            }
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
    public function getMessagesForTag(array $formFields): array
    {
        $messages = [];

        foreach ($formFields as $tagIndex => $tag) {
            $tagForm = sprintf('tag.%s', $tagIndex);
            $messages[sprintf('%s.tag_vocabulary.in', $tagForm)] = translateRequestMessage('tag', 'vocabulary_is_invalid');
            $messages[sprintf('%s.goals_tag_code.in', $tagForm)] = translateRequestMessage('sdg', 'code_is_invalid');
            $messages[sprintf('%s.targets_tag_code.in', $tagForm)] = translateRequestMessage('sdg_targets', 'code_is_invalid');
            $messages[sprintf('%s.vocabulary_uri.url', $tagForm)] = translateRequestMessage('vocab_url_field_symbol', 'must_be_valid_url');

            foreach ($this->getMessagesForNarrative($tag['narrative'], $tagForm) as $tagNarrativeIndex => $narrativeMessages) {
                $messages[$tagNarrativeIndex] = $narrativeMessages;
            }
        }

        return $messages;
    }
}
