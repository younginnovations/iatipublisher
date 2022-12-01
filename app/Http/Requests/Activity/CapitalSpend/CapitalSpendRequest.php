<?php

declare(strict_types=1);

namespace App\Http\Requests\Activity\CapitalSpend;

use App\Http\Requests\Activity\ActivityBaseRequest;

/**
 * Class CapitalSpendRequest.
 */
class CapitalSpendRequest extends ActivityBaseRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules($capital_spend = null): array
    {
        if ($capital_spend && is_array($capital_spend)) {
            return [
                'capital_spend' => 'nullable|size:1',
            ];
        }

        return [
            'capital_spend' => ['nullable', 'numeric', 'between:0, 100'],
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
            'numeric'   => 'The capital spend must be a number',
            'between'   => 'The capital spend must be a number between 0 and 100',
            'size'      => 'The capital spend cannot have more than one value.',
        ];
    }
}
