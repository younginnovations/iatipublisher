<?php

declare(strict_types=1);

namespace App\Http\Requests\Activity\LegacyData;

use App\Http\Requests\Activity\ActivityBaseRequest;

/**
 * Class LegacyDataRequest.
 */
class LegacyDataRequest extends ActivityBaseRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return $this->getRulesForActivityLegacyData($this->get('legacy_data'));
    }

    /**
     * Get the error message as required.
     *
     * @return array
     */
    public function messages(): array
    {
        return $this->getMessagesForActivityLegacyData($this->get('legacy_data'));
    }

    /**
     * Returns rules for related activity.
     *
     * @param array $formFields
     *
     * @return array
     */
    public function getRulesForActivityLegacyData(array $formFields): array
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
    public function getMessagesForActivityLegacyData(array $formFields): array
    {
        return [];
    }
}
