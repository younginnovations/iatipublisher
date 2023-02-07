<?php

declare(strict_types=1);

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
     * @param $scope
     *
     * @return array
     */
    public function rules($scope = null): array
    {
        $totalRules = [$this->getErrorsForActivityScope($scope), $this->getWarningForActivityScope()];

        return mergeRules($totalRules);
    }

    /**
     * Return general rules for scope.
     */
    public function getWarningForActivityScope(): array
    {
        return [];
    }

    /**
     * Returns critical error for scope.
     *
     * @param $scope
     *
     * @return array
     */
    public function getErrorsForActivityScope($scope = null): array
    {
        if ($scope && is_array($scope)) {
            return [
                'activity_scope' => 'nullable|size:1',
            ];
        }

        return [
            'activity_scope' => sprintf('nullable|in:%s', implode(',', array_keys(getCodeList('ActivityScope', 'Activity', false)))),
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
            'in'        => 'The activity scope does not exist.',
            'size'      => 'The activity scope cannot have more than one value.',
        ];
    }
}
