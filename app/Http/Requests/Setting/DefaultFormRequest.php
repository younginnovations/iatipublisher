<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

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
          'default_currency' => 'required',
          'default_language' => 'required',
          'default_hierarchy' => 'required',
          'linked_data_url' => 'required',
          'humanitarian' => 'required',
        ];
    }
}
