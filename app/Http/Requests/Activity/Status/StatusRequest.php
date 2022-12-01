<?php

declare(strict_types=1);

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
     * @param $status
     *
     * @return array
     */
    public function rules($status = null): array
    {
        if ($status && is_array($status)) {
            return [
                'activity_status' => 'nullable|size:1',
            ];
        }

        return [
          'activity_status' => sprintf('nullable|in:%s|size:1', implode(',', array_keys(getCodeList('ActivityStatus', 'Activity', false)))),
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
            'in'        => 'The activity status does not exist.',
            'size'      => 'The default flow type cannot have more than one value.',
        ];
    }
}
