<?php

declare(strict_types=1);

namespace App\Http\Requests\Activity\Status;

use App\Http\Requests\Activity\ActivityBaseRequest;
use JsonException;

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
        $totalRules = [$this->getErrorsForActivityStatus($status), $this->getWarningForActivityStatus($status)];

        return mergeRules($totalRules);
    }

    /**
     * Get critical rules for status request.
     *
     * @param $status
     *
     * @return array
     */
    public function getWarningForActivityStatus($status): array
    {
        return [];
    }

    /**
     * Get critical rules for status request.
     *
     * @param $status
     *
     * @return array
     *
     * @throws JsonException
     */
    public function getErrorsForActivityStatus($status): array
    {
        if ($status && is_array($status)) {
            return [
                'activity_status' => 'nullable|size:1',
            ];
        }

        return [
            'activity_status' => sprintf('nullable|in:%s', implode(',', array_keys(getCodeList('ActivityStatus', 'Activity', false)))),
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
            'in'        => translateRequestMessage('the_activity_status', 'doesnt_exist'),
            'size'      => translateRequestMessage('the_activity_status', 'cannot_have_more_than_one'),
        ];
    }
}
