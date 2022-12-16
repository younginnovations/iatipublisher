<?php

declare(strict_types=1);

namespace App\Http\Requests\Activity\Title;

use App\Http\Requests\Activity\ActivityBaseRequest;

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

        $rules[$name] = 'unique_lang|unique_default_lang';
        $rules[sprintf('%s.0.narrative', $name)] = 'required';

        if (is_array($titles) && count($titles)) {
            foreach ($titles as $key => $title) {
                if ($key !== 0) {
                    $rules[sprintf('%s.%s.narrative', $name, $key)] = 'required_with_language';
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
