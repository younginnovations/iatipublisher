<?php

namespace App\Http\Requests\Activity\CollaborationType;

use App\Http\Requests\Activity\ActivityBaseRequest;

class CollaborationTypeRequest extends ActivityBaseRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'collaboration_type' => ['required', 'in:1,2,3,4,5,6,7,8'],
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
