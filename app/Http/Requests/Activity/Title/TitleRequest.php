<?php

declare(strict_types=1);

namespace App\Http\Requests\Activity\Title;

use App\Http\Requests\Activity\ActivityBaseRequest;
use Illuminate\Support\Arr;

/**
 * Class TitleRequest.
 */
class TitleRequest extends ActivityBaseRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules($name = 'narrative', $data = []): array
    {
        if ($name === 'title') {
            $titles = $data;
        } else {
            $titles = request()->get('narrative');
        }

        $totalRules = [$this->getErrorsForTitle($name), $this->getWarningForTitle($name, $titles)];

        return mergeRules($totalRules);
    }

    /**
     * Return critical rules for title.
     *
     * @param $name
     *
     * @return array
     */
    public function getErrorsForTitle($name, $titles = []): array
    {
        $firstTitleKey = array_key_first($titles) ?? '0';
        $rules[sprintf('%s.%s.narrative', $name, $firstTitleKey)] = 'required';

        return [sprintf('%s.0.narrative', $name) => 'required'];
    }

    /**
     * Return rules for title.
     *
     * @param $name
     * @param $titles
     *
     * @return array
     */
    public function getWarningForTitle($name, $titles = []): array
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
     * @return array
     */
    public function messages($name = 'narrative', $data = []): array
    {
        if ($name === 'title') {
            $titles = $data;
        } else {
            $titles = request()->get('narrative');
        }

        $messages[sprintf('%s.unique_lang', $name)] = 'The title language field must be unique.';
        $messages[sprintf('%s.unique_default_lang', $name)] = 'The title language field must be unique.';
        $messages[sprintf('%s.0.narrative.required', $name)] = 'The first title is required.';

        if (is_array($titles) && count($titles)) {
            foreach ($titles as $key => $title) {
                if ($key !== 0) {
                    $messages[sprintf('%s.%s.narrative.required_with_language', $name, $key)] = 'The narrative is required when language is specified.';
                }
            }
        }

        return $messages;
    }
}
