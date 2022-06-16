<?php

declare(strict_types=1);

namespace App\Http\Requests\Activity\Sector;

use App\Http\Requests\Activity\ActivityBaseRequest;

/**
 * Class SectorRequest.
 */
class SectorRequest extends ActivityBaseRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return $this->getSectorsRules($this->get('sector'));
    }

    /**
     * returns rules for sector.
     * @param $formFields
     * @return array|mixed
     */
    public function getSectorsRules($formFields)
    {
        $rules = [];
        foreach ($formFields as $sectorIndex => $sector) {
            $sectorForm = sprintf('sector.%s', $sectorIndex);
            $rules[sprintf('%s.vocabulary', $sectorForm)] = 'required';
            // dd($sector);
            $vocabulary = $sector['vocabulary'];
            // $vocabulary                                          = getCodeL$sector, ['sector_vocabulary']);
            // $customVocab                                         = getVal($sector, ['use_my_custom_vocab']);

            switch ($vocabulary) {
                case '1':
                    $rules[sprintf('%s.code', $sectorForm)] = 'required';
                    break;
                case '2':
                    $rules[sprintf('%s.category_code', $sectorForm)] = 'required';
                    break;
                case '7':
                    $rules[sprintf('%s.sdg_goal', $sectorForm)] = 'required';
                    break;
                case '8':
                    $rules[sprintf('%s.sdg_target', $sectorForm)] = 'required';
                    break;
                case '98':
                case '99':
                    $rules[sprintf('%s.text', $sectorForm)] = 'required';
                    $rules[sprintf('%s.vocabulary_uri', $sectorForm)] = 'sometimes|required';

                    foreach ($sector['narrative'] as $narrativeKey => $narrative) {
                        $rules[sprintf('%s.narrative.%s.narrative', $sectorForm, $narrativeKey)] = 'required|required_with_language';
                    }
                    break;
                default:
                    $rules[sprintf('%s.text', $sectorForm)] = 'required';
                    break;
            }

            if (!$vocabulary) {
                $rules[sprintf('%s.code', $sectorForm)] = 'required';
            }

            $rules[sprintf('%s.percentage', $sectorForm)] = 'nullable|numeric|max:100';
            if (count($formFields) > 1) {
                $rules[sprintf('%s.percentage', $sectorForm)] = 'required|numeric|max:100';
            }
            $rules = array_merge($this->getRulesForNarrative($sector['narrative'], $sectorForm), $rules);
        }

        $totalPercentage = $this->getRulesForPercentage($this->get('sector'));

        $indexes = [];

        foreach ($totalPercentage as $index => $value) {
            if (is_numeric($index) && $value != 100) {
                $indexes[] = $index;
            }
        }

        $fields = [];

        foreach ($totalPercentage as $i => $percentage) {
            foreach ($indexes as $index) {
                if ($index == $percentage) {
                    $fields[] = $i;
                }
            }
        }

        foreach ($fields as $field) {
            $rules[$field] = 'required|sum|numeric|max:100';
        }

        return $rules;
    }

    /**
     * returns messages for sector.
     * @param $formFields
     * @return array|mixed
     */
    public function getSectorsMessages($formFields)
    {
        $messages = [];

        foreach ($formFields as $sectorIndex => $sector) {
            $sectorForm = sprintf('sector.%s', $sectorIndex);
            $messages[sprintf('%s.vocabulary_uri.url', $sectorForm)] = trans('validation.url');
            $messages[sprintf('%s.vocabulary.required', $sectorForm)] = trans('validation.required', ['attribute' => trans('elementForm.sector_vocabulary')]);

            $vocabulary = $sector['vocabulary'];
            // $customVocab = getVal($sector, ['use_my_custom_vocab']);

            switch ($vocabulary) {
                case '1':
                    $messages[sprintf('%s.code.%s', $sectorForm, 'required')] = trans('validation.required', ['attribute' => trans('elementForm.sector_code')]);
                    break;
                case '2':
                    $messages[sprintf('%s.category_code.%s', $sectorForm, 'required')] = trans('validation.required', ['attribute' => trans('elementForm.sector_code')]);
                    break;
                case '7':
                    $messages[sprintf('%s.sdg_goal.%s', $sectorForm, 'required')] = trans('validation.required', ['attribute' => trans('elementForm.sector_code')]);

                    break;
                case '8':
                    $messages[sprintf('%s.sdg_target.%s', $sectorForm, 'required')] = trans('validation.required', ['attribute' => trans('elementForm.sector_code')]);
                    break;
                case '98':
                case '99':
                    $messages[sprintf('%s.text.%s', $sectorForm, 'required')] = trans('validation.required', ['attribute' => trans('elementForm.sector_code')]);
                    $messages[sprintf('%s.vocabulary_uri.%s', $sectorForm, 'required')] = trans('validation.required', ['attribute' => trans('elementForm.vocabulary_uri')]);

                    foreach ($sector['narrative'] as $narrativeKey => $narrative) {
                        $messages[sprintf('%s.narrative.%s.narrative.%s', $sectorForm, $narrativeKey, 'required')] = trans('validation.required', ['attribute' => trans('elementForm.narrative')]);
                        $messages[sprintf(
                            '%s.narrative.%s.narrative.required_with_language',
                            $sectorForm,
                            $narrativeKey
                        )] = trans('validation.required_with', ['attribute' => trans('elementForm.narrative'), 'values' => trans('elementForm.languages')]);
                    }
                    break;
                default:
                    $messages[sprintf('%s.text.%s', $sectorForm, 'required')] = trans('validation.required', ['attribute' => trans('elementForm.sector_code')]);
                    break;
            }

            if (!$vocabulary) {
                $messages[sprintf('%s.code.%s', $sectorForm, 'required')] = trans('validation.required', ['attribute' => trans('elementForm.sector_code')]);
            }

            $messages[sprintf('%s.percentage.numeric', $sectorForm)] = trans('validation.numeric', ['attribute' => trans('elementForm.percentage')]);
            $messages[sprintf('%s.percentage.max', $sectorForm)] = trans('validation.max.numeric', ['attribute' => trans('elementForm.percentage'), 'max' => 100]);
            $messages[sprintf('%s.percentage.required', $sectorForm)] = trans('validation.required', ['attribute' => trans('elementForm.percentage')]);
            $messages[sprintf('%s.percentage.sum', $sectorForm)] = trans('validation.sum', ['attribute' => trans('elementForm.percentage')]);
            $messages = array_merge($this->getMessagesForNarrative($sector['narrative'], $sectorForm), $messages);
        }

        return $messages;
    }

    /**
     * write brief description.
     *
     * @param $sectors
     *
     * @return array
     */
    protected function getRulesForPercentage($sectors)
    {
        $array = [];
        $totalPercentage = 0;

        if (count($sectors) > 1) {
            foreach ($sectors as $sectorIndex => $sector) {
                $sectorForm = sprintf('sector.%s', $sectorIndex);
                $percentage = $sector['percentage'];
                $sectorVocabulary = $sector['vocabulary'];

                if (array_key_exists($sectorVocabulary, $array)) {
                    $totalPercentage = $array[$sectorVocabulary] + (float) $percentage;
                    $array[$sectorVocabulary] = $totalPercentage;
                    $array[sprintf('%s.percentage', $sectorForm)] = $sectorVocabulary;
                } else {
                    $array[$sectorVocabulary] = $percentage;

                    $array[sprintf('%s.percentage', $sectorForm)] = $sectorVocabulary;
                }
            }
        }

        return $array;
    }
}
