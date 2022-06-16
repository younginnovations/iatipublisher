<?php

namespace App\Http\Requests\Activity\DefaultTiedStatus;

use App\Http\Requests\Activity\ActivityBaseRequest;

/**
 * Class DefaultTiedStatusRequest.
 */
class DefaultTiedStatusRequest extends ActivityBaseRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'default_tied_status' => ['nullable', 'in:3,4,5'],
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
            'required'  => 'The @code field is required.',
            'in'        => 'The selected code does not exist.',
        ];
    }
}
