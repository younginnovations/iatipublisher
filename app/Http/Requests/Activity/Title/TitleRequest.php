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
    public function rules(): array
    {
        $rules['narrative.*.narrative'] = 'required';
        $rules['narrative'] = 'unique_lang|unique_default_lang';

        return $rules;
    }

    /**
     * Get the error message as required.
     *
     * @return array
     */
    public function messages(): array
    {
        $messages['narrative.*.narrative.required'] = 'The text field is required.';
        $messages['narrative.unique_lang'] = 'The @xml:lang field must be unique.';
        $messages['narrative.unique_default_lang'] = 'The @xml:lang field must be unique.';

        return $messages;
    }
}
