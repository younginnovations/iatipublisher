<?php

namespace App\Http\Requests\Activity\DefaultFinanceType;

use App\Http\Requests\Activity\ActivityBaseRequest;

class DefaultFinanceTypeRequest extends ActivityBaseRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'default_finance_type' => ['required', 'in:110,111,210,211,310,311,410,411,412,413,414,421,422,423,424,425,431,432,433'],
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
            'required'  => 'The Code is required.',
            'in'        => 'The selected code does not exist.',
        ];
    }
}
