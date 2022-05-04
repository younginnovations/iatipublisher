<?php

namespace App\Http\Requests\Setting;

use Illuminate\Foundation\Http\FormRequest;

/**
 * Class PublisherFormRequest.
 */
class PublisherFormRequest extends FormRequest
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
          'publisher_id' => 'required',
          'api_token' => 'required',
        ];
    }
}
