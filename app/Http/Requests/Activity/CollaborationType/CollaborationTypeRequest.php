<?php

declare(strict_types=1);

namespace App\Http\Requests\Activity\CollaborationType;

use App\Http\Requests\Activity\ActivityBaseRequest;

/**
 * Class CollaborationTypeRequest.
 */
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
            'collaboration_type' => ['nullable', 'in:1,2,3,4,5,6,7,8'],
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
