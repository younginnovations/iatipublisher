<?php

declare(strict_types=1);

namespace App\Http\Requests\Activity\Otheridentifier;

use App\Http\Requests\Activity\ActivityBaseRequest;
use Illuminate\Http\Request;

/**
 * Class OtheridentifierRequest.
 */
class OtherIdentifierRequest extends ActivityBaseRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return $this->getRulesForOtherIdentifier($this->get('owner_org'));
    }

    /**
     * @return array
     */
    public function messages()
    {
        return $this->getMessagesForOtherIdentifier($this->get('owner_org'));
    }

    /**
     * @param array $formFields
     * @return array
     */
    public function getRulesForOtherIdentifier(array $formFields)
    {
        $rules = [];
//        $rules['reference'] = 'required';
//        $rules['reference_type'] = 'required';

        foreach ($formFields as $ownerOrgIndex => $ownerOrg) {
            $ownerOrgForm = sprintf('owner_org.%s', $ownerOrgIndex);
            $rules = array_merge(
                $rules,
                $this->getRulesForNarrative($ownerOrg['narrative'], $ownerOrgForm)
            );
        }

        return $rules;
    }

    /**
     * @param array $formFields
     * @return array
     */
    public function getMessagesForOtherIdentifier(array $formFields)
    {
        $messages = [];

        foreach ($formFields as $ownerOrgIndex => $ownerOrg) {
            $ownerOrgForm = sprintf('owner_org.%s', $ownerOrgIndex);
            $messages = array_merge(
                $messages,
                $this->getMessagesForNarrative($ownerOrg['narrative'], $ownerOrgForm)
            );
        }

        return $messages;
    }
}
