<?php

declare(strict_types=1);

namespace App\Http\Requests\Document;

use Illuminate\Foundation\Http\FormRequest;

/**
 * Class DocumentRequest.
 */
class DocumentRequest extends FormRequest
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

        ];
    }
}
