<?php

declare(strict_types=1);

namespace App\Http\Requests\Setting;

use Illuminate\Foundation\Http\FormRequest;

/**
 * Class PublisherFormRequest.
 */
class PublisherFormRequest extends FormRequest
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
            'publisher_id' => 'sometimes',
            'api_token' => 'sometimes',
        ];
    }
}
