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
     * @param $collaboration
     *
     * @return array
     */
    public function rules($collaboration = null): array
    {
        if ($collaboration && is_array($collaboration)) {
            return [
                'collaboration_type' => 'nullable|size:1',
            ];
        }

        return [
            'collaboration_type' => sprintf('nullable|in:%s', implode(',', array_keys(getCodeList('ActivityStatus', 'Activity', false)))),
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
            'in'        => 'The collaboration type does not exist.',
            'size'      => 'The collaboration type cannot have more than one value.',
        ];
    }
}
