<?php

namespace App\Http\Requests\Activity\Status;

use App\Http\Requests\Activity\ActivityBaseRequest;

/**
 * Class StatusRequest.
 */
class StatusRequest extends ActivityBaseRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
          'activity_status' => ['nullable', 'in:1,2,3,4,5,6'],
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
