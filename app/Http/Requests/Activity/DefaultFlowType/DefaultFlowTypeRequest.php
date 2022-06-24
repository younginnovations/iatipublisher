<?php

namespace App\Http\Requests\Activity\DefaultFlowType;

use App\Http\Requests\Activity\ActivityBaseRequest;

/**
 * Class DefaultFlowTypeRequest.
 */
class DefaultFlowTypeRequest extends ActivityBaseRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'default_flow_type' => ['nullable', 'in:10,20,21,22,30,35,36,37,40,50'],
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
