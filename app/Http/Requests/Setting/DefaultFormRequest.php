<?php

declare(strict_types=1);

namespace App\Http\Requests\Setting;

use Illuminate\Foundation\Http\FormRequest;

/**
 * Class DefaultFormRequest.
 */
class DefaultFormRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get all of the input and files for the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'default_currency'      => sprintf('nullable|in:%s', implode(',', array_keys(getCodeList('Currency', 'Activity', false)))),
            'default_language'      => sprintf('nullable|in:%s', implode(',', array_keys(getCodeList('Language', 'Activity', false)))),
            'hierarchy'             => 'sometimes|nullable|integer|min:1|lte:4',
            'budget_not_provided'   => sprintf('nullable|in:%s', implode(',', array_keys(getCodeList('BudgetNotProvided', 'Activity', false)))),
            'humanitarian'          => sprintf('nullable|in:0,1'),
        ];
    }
}
