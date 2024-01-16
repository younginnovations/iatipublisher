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
        $totalRules = [$this->getErrorsForDefaultAidType($this->get('default_aid_type')), $this->getWarningForDefaultAidType()];

        return mergeRules($totalRules);
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
    public function getErrorsForDefaultAidType(array $formFields): array
    {
        $rules = [];

        foreach ($formFields as $index => $formField) {
            $baseForm = sprintf('default_aid_type.%s', $index);
            $rules[sprintf('%s.default_aid_type_vocabulary', $baseForm)] = 'nullable|in:' . implode(',', array_keys(getCodeList('AidTypeVocabulary', 'Activity', false)));
            $rules[sprintf('%s.default_aid_type', $baseForm)] = 'nullable|in:' . implode(',', array_keys(getCodeList('AidType', 'Activity', false)));
            $rules[sprintf('%s.earmarking_category', $baseForm)] = 'nullable|in:' . implode(',', array_keys(getCodeList('EarmarkingCategory', 'Activity', false)));
            $rules[sprintf('%s.earmarking_modality', $baseForm)] = 'nullable|in:' . implode(',', array_keys(getCodeList('EarmarkingModality', 'Activity', false)));
            $rules[sprintf('%s.cash_and_voucher_modalities', $baseForm)] = 'nullable|in:' . implode(',', array_keys(getCodeList('CashandVoucherModalities', 'Activity', false)));
        }

        return $rules;
    }

    /**
     * Returns rules for related activity.
     *
     * @return array
     */
    public function getWarningForDefaultAidType(): array
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
        $messages = [];

        foreach ($formFields as $index => $formField) {
            $baseForm = sprintf('default_aid_type.%s', $index);
            $messages[sprintf('%s.default_aid_type_vocabulary.in', $baseForm)] = translateRequestMessage('default_aid_type', 'vocabulary_is_invalid');
            $messages[sprintf('%s.default_aid_type.in', $baseForm)] = translateRequestMessage('default_aid_type', 'is_invalid');
            $messages[sprintf('%s.earmarking_category.in', $baseForm)] = translateRequestMessage('default_aid_type', 'earmarking_category_is_invalid');
            $messages[sprintf('%s.earmarking_modality.in', $baseForm)] = translateRequestMessage('default_aid_type', 'earmarking_modality_is_invalid');
            $messages[sprintf('%s.cash_and_voucher_modalities.in', $baseForm)] = translateRequestMessage('default_aid_type', 'cash_and_voucher_is_invalid');
        }

        return $messages;
    }
}
