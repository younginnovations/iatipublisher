<?php

namespace App\Http\Requests\Activity\Scope;

use App\Http\Requests\Activity\ActivityBaseRequest;

/**
 * Class ScopeRequest.
 */
class ScopeRequest extends ActivityBaseRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'activity_scope' => ['nullable', 'in:1,2,3,4,5,6,7,8'],
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
            'in'        => 'The selected code does not exist.',
        ];
    }
}
