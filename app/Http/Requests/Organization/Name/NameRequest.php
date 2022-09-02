<?php

declare(strict_types=1);

namespace App\Http\Requests\Organization\Name;

use App\Http\Requests\Organization\OrganizationBaseRequest;

/**
 * Class NameRequest.
 */
class NameRequest extends OrganizationBaseRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        $rules['narrative'] = 'unique_lang|unique_default_lang';

        return $rules;
    }

    /**
     * Get the error message as required.
     *
     * @return array
     */
    public function messages(): array
    {
        $messages['narrative.unique_lang'] = 'The @xml:lang field must be unique.';
        $messages['narrative.unique_default_lang'] = 'The @xml:lang field must be unique.';

        return $messages;
    }
}
