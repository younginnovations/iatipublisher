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
        $totalRules = [$this->getCriticalRulesForActivityStatus($status), $this->getRulesForActivityStatus($status)];

        return mergeRules($totalRules);
    }

    /**
     * Get critical rules for status request.
     *
     * @param $status
     *
     * @return array
     */
    public function getRulesForActivityStatus($status): array
    {
        if ($status && is_array($status)) {
            return [
                'activity_status' => 'nullable|size:1',
            ];
        }

        return [];
    }

    /**
     * Get critical rules for status request.
     *
     * @param $status
     *
     * @return array
     */
    public function getCriticalRulesForActivityStatus($status): array
    {
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
            'in'        => 'The activity status does not exist.',
            'size'      => 'The activity status cannot have more than one value.',
        ];
    }
}
