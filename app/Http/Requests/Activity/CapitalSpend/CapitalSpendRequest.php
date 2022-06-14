<?php

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
    public function rules(): array
    {
        return [
            'capital_spend' => ['required', 'numeric', 'between:0, 100'],
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
            'required'  => 'The Percentage is required.',
        ];
    }
}
