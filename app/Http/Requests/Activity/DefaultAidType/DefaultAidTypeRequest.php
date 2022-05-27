<?php

namespace App\Http\Requests\Activity\DefaultAidType;

use App\Http\Requests\Activity\ActivityBaseRequest;

class DefaultAidTypeRequest extends ActivityBaseRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'default_aid_type' => ['required', 'in:10,20,21,22,30,35,36,37,40,50'],
        ];
    }

    /**
     * Get the error message as required.
     *
     * @return array
     */
    public function messages(): array
    {
        return [
            'required'  => 'The Code is required.',
            'in'        => 'The selected code does not exist.',
        ];
    }
}
