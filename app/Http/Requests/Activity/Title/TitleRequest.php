<?php

declare(strict_types=1);

namespace App\Http\Requests\Activity\Title;

use App\Http\Requests\Activity\ActivityBaseRequest;
use Illuminate\Support\Arr;
use JsonException;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;

/**
 * Class TitleRequest.
 */
class TitleRequest extends ActivityBaseRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @param string $name
     * @param array $data
     *
     * @return array
     *
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     * @throws JsonException
     */
    public function rules(string $name = 'narrative', array $data = []): array
    {
        if ($name === 'title') {
            $titles = $data;
        } else {
            $titles = request()->get('narrative');
        }

        $totalRules = [$this->getCriticalErrorsForTitle($name, $titles), $this->getErrorsForTitle($name, $titles), $this->getWarningForTitle($name, $titles)];

        return mergeRules($totalRules);
    }

    /**
     * Return critical rules for title.
     *
     * @param $name
     * @param array $titles
     *
     * @return array
     */
    public function getCriticalErrorsForTitle($name, array $titles = []): array
    {
        $firstTitleKey = array_key_first($titles) ?? '0';
        $rules = [];

        if (empty(Arr::get($titles, sprintf('%s.narrative', $firstTitleKey), null))) {
            $rules[sprintf('%s.%s.narrative', $name, $firstTitleKey)] = 'required';
        }

        return $rules;
    }

    /**
     * Return errors for title.
     *
     * @param $name
     * @param array $titles
     *
     * @return array
     *
     * @throws JsonException
     */
    public function getErrorsForTitle($name, array $titles = []): array
    {
        $rules = [];
        $validLanguages = implode(',', array_keys(getCodeList('Language', 'Activity', false)));

        if (is_array($titles) && count($titles)) {
            foreach ($titles as $key => $title) {
                $rules[sprintf('%s.%s.language', $name, $key)][] = 'nullable';
                $rules[sprintf('%s.%s.language', $name, $key)][] = sprintf('in:%s', $validLanguages);
            }
        }

        return $rules;
    }

    /**
     * Return rules for title.
     *
     * @param $name
     * @param array $titles
     *
     * @return array
     */
    public function getWarningForTitle($name, array $titles = []): array
    {
        $rules[$name] = 'unique_lang|unique_default_lang';

        if (is_array($titles) && count($titles)) {
            foreach ($titles as $key => $title) {
                if ($key !== 0 && !empty(Arr::get($title, 'language', ''))) {
                    $rules[sprintf('%s.%s.narrative', $name, $key)] = 'required_with_language:' . Arr::get($title, 'narrative', '');
                }
            }
        }

        return $rules;
    }

    /**
     * Get the error message as required.
     *
     * @param string $name
     * @param array $data
     *
     * @return array
     *
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    public function messages(string $name = 'narrative', array $data = []): array
    {
        if ($name === 'title') {
            $titles = $data;
        } else {
            $titles = request()->get('narrative');
        }

        $messages[sprintf('%s.unique_lang', $name)] = translateRequestMessage('title_language_field', 'must_be_unique');
        $messages[sprintf('%s.unique_default_lang', $name)] = translateRequestMessage('title_language_field', 'must_be_unique');
        $messages[sprintf('%s.0.narrative.required', $name)] = translateRequestMessage('first_title', 'is_required');

        if (is_array($titles) && count($titles)) {
            foreach ($titles as $key => $title) {
                if ($key !== 0) {
                    $messages[sprintf('%s.%s.narrative.required_with_language', $name, $key)] = translateRequestMessage('narrative', 'required_when_language');
                }
            }
        }

        return $messages;
    }
}
