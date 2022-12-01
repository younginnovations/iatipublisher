<?php

declare(strict_types=1);

namespace App\Http\Requests\Activity\DefaultAidType;

use App\Http\Requests\Activity\ActivityBaseRequest;

/**
 * Class DefaultAidTypeRequest.
 */
class DefaultAidTypeRequest extends ActivityBaseRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return $this->getRulesForDefaultAidType($this->get('default_aid_type'));
    }

    /**
     * Get the error message as required.
     *
     * @return array
     */
    public function messages(): array
    {
        return $this->getMessagesForDefaultAidType($this->get('default_aid_type'));
    }

    /**
     * Returns rules for related activity.
     *
     * @param array $formFields
     *
     * @return array
     */
    public function getRulesForDefaultAidType(array $formFields): array
    {
        return [];
    }

    /**
     * Returns messages for related activity validations.
     *
     * @param array $formFields
     *
     * @return array
     */
    public function getMessagesForDefaultAidType(array $formFields): array
    {
        return [];
    }
}
