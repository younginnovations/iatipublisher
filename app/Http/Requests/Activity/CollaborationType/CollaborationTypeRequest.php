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
        $totalRules = [$this->getWarningForCollaborationType($collaboration), $this->getErrorsForCollaborationType($collaboration)];

        return mergeRules($totalRules);
    }

    /**
     * returns critical rule for capital spend.
     *
     * @param $collaboration
     *
     * @return array
     */
    public function getErrorsForCollaborationType($collaboration = null): array
    {
        if ($collaboration && is_array($collaboration)) {
            return [
                'collaboration_type' => 'nullable|size:1',
            ];
        }

        return [
            'collaboration_type' => sprintf('nullable|in:%s', implode(',', array_keys(getCodeList('CollaborationType', 'Activity', false)))),
        ];
    }

    /**
     * returns critical rule for capital spend.
     *
     * @param $collaboration
     *
     * @return array
     */
    public function getWarningForCollaborationType($collaboration = null): array
    {
        return [];
    }

    /**
     * Get the error message as required.
     *
     * @return array
     */
    public function messages(): array
    {
        return [
            'in'        => trans('requests.collaboration_type', ['suffix'=>trans('requests.suffix.doesnt_exist')]),
            'size'      => trans('requests.collaboration_type', ['suffix'=>trans('requests.suffix.cannot_have_more_than_one')]),
        ];
    }
}
