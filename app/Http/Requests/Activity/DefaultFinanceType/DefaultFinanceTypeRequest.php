<?php

declare(strict_types=1);

namespace App\Http\Requests\Activity\DefaultFinanceType;

use App\Http\Requests\Activity\ActivityBaseRequest;

/**
 * Class DefaultFinanceTypeRequest.
 */
class DefaultFinanceTypeRequest extends ActivityBaseRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        $financeTypeKeys = implode(',', array_keys(getCodeList('FinanceType', 'Activity')));

        return [
            'default_finance_type' => ['nullable', 'in:' . $financeTypeKeys],
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
