<?php

namespace App\Http\Requests\Setting;

use Illuminate\Foundation\Http\FormRequest;

/**
 * Class DefaultFormRequest.
 */
class DefaultFormRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    /**
     * Get all of the input and files for the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'default_currency' => 'sometimes',
            'default_language' => 'sometimes',
            'hierarchy' => 'sometimes|nullable|integer|min:0|lte:4',
            'linked_data_url' => 'sometimes',
            'humanitarian' => 'sometimes',
        ];
    }
}
