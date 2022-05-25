<?php

declare(strict_types=1);

namespace App\Http\Requests\Activity\Title;

use App\Http\Requests\Activity\ActivityBaseRequest;

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
        $messages['narrative.*.narrative.required'] = 'Narrative Required';
        $messages['narrative.unique_lang'] = 'Narrative Unique';

        return $messages;
    }
}
