<?php

declare(strict_types=1);

namespace App\Http\Requests\Activity\LegacyData;

use App\Http\Requests\Activity\ActivityBaseRequest;

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
     * @param array $formFields
     * @return array
     */
    protected function getRulesForActivityLegacyData(array $formFields): array
    {
        $rules = [];

        foreach ($formFields as $legacyDataIndex => $legacyData) {
            $legacyDataForm = sprintf('legacy_data.%s', $legacyDataIndex);
            $rules[sprintf('%s.name', $legacyDataForm)] = 'required';
            $rules[sprintf('%s.value', $legacyDataForm)] = 'required';
        }

        return $rules;
    }

    /**
     * Returns messages for related activity validations.
     * @param array $formFields
     * @return array
     */
    protected function getMessagesForActivityLegacyData(array $formFields): array
    {
        $messages = [];

        foreach ($formFields as $legacyDataIndex => $legacyData) {
            $legacyDataForm = sprintf('legacy_data.%s', $legacyDataIndex);
            $messages[sprintf('%s.name.required', $legacyDataForm)] = 'The Name field is required';
            $messages[sprintf('%s.value.required', $legacyDataForm)] = 'The Value field is required';
        }

        return $messages;
    }
}
