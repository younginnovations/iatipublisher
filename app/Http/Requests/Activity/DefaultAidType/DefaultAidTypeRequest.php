<?php

declare(strict_types=1);

namespace App\Http\Requests\Activity\DefaultAidType;

use App\Http\Requests\Activity\ActivityBaseRequest;
use Illuminate\Support\Arr;

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
     * @param array $formFields
     * @return array
     */
    protected function getRulesForDefaultAidType(array $formFields): array
    {
        $rules = [];

//        foreach ($formFields as $aidtypeIndex => $aidtype) {
//            $aidtypeForm = sprintf('default_aid_type.%s', $aidtypeIndex);
//
//            $rules[sprintf('%s.default_aidtype_vocabulary', $aidtypeForm)] = 'required';
//            $vocabulary = Arr::get($aidtype, 'default_aidtype_vocabulary', 1);
//
//            if ($vocabulary == 1) {
//                $rules[sprintf('%s.default_aid_type', $aidtypeForm)]
//                    = 'required_with:' . $aidtypeForm . '.default_aidtype_vocabulary';
//            } elseif ($vocabulary == 2) {
//                $rules[sprintf('%s.earmarking_category', $aidtypeForm)]
//                    = 'required_with:' . $aidtypeForm . '.default_aidtype_vocabulary';
//            } elseif ($vocabulary == 3) {
//                $rules[sprintf('%s.earmarking_modality', $aidtypeForm)]
//                    = 'required_with:' . $aidtypeForm . '.default_aidtype_vocabulary';
//            } elseif ($vocabulary == 4) {
//                $rules[sprintf('%s.cash_and_voucher_modalities', $aidtypeForm)]
//                    = 'required_with:' . $aidtypeForm . '.default_aidtype_vocabulary';
//            }
//        }

        return $rules;
    }

    /**
     * Returns messages for related activity validations.
     * @param array $formFields
     * @return array
     */
    protected function getMessagesForDefaultAidType(array $formFields): array
    {
        $messages = [];

//        foreach ($formFields as $aidtypeIndex => $aidtype) {
//            $aidtypeForm = sprintf('default_aid_type.%s', $aidtypeIndex);
//            $messages[sprintf('%s.default_aidtype_vocabulary.required', $aidtypeForm)] = 'The @vocabulary field is required.';
//            $vocabulary = Arr::get($aidtype, 'default_aidtype_vocabulary', 1);
//
//            if ($vocabulary == 1) {
//                $messages[sprintf('%s.default_aid_type.%s', $aidtypeForm, 'required_with')] = 'The @code field is required with @vocabulary field';
//            } elseif ($vocabulary == 2) {
//                $messages[sprintf('%s.earmarking_category.%s', $aidtypeForm, 'required_with')] = 'The @code field is required with @vocabulary field';
//            } elseif ($vocabulary == 3) {
//                $messages[sprintf('%s.earmarking_modality.%s', $aidtypeForm, 'required_with')] = 'The @code field is required with @vocabulary field';
//            } elseif ($vocabulary == 4) {
//                $messages[sprintf('%s.cash_and_voucher_modalities.%s', $aidtypeForm, 'required_with')] = 'The @code field is required with @vocabulary field';
//            }
//        }

        return $messages;
    }
}
