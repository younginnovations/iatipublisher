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
            'default_currency' => 'sometimes',
            'default_language' => 'sometimes',
            'hierarchy' => 'sometimes|nullable|integer|min:1|lte:4',
            'linked_data_url' => 'sometimes',
            'humanitarian' => 'sometimes',
        ];
    }
}
