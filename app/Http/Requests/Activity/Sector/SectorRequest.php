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
     * Get the error message as required.
     *
     * @return array
     */
    public function messages(): array
    {
        return $this->getSectorsMessages($this->get('sector'));
    }

    /**
     * returns rules for sector.
     *
     * @param $formFields
     *
     * @return array|mixed
     */
    public function getSectorsRules($formFields): array
    {
        $rules = [];
        foreach ($formFields as $sectorIndex => $sector) {
            $sectorForm = sprintf('sector.%s', $sectorIndex);

            if (isset($sector['vocabulary']) && $sector['vocabulary'] === '99') {
                $rules[sprintf('%s.vocabulary_uri', $sectorForm)] = 'nullable|url';
            }

            $rules[sprintf('%s.percentage', $sectorForm)] = 'nullable|numeric|max:100|digits_between:0,3';

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
            $rules[$field] = 'nullable|sum|numeric|max:100';
        }

        return $rules;
    }

    /**
     * returns messages for sector.
     *
     * @param $formFields
     *
     * @return array|mixed
     */
    public function getSectorsMessages($formFields): array
    {
        $messages = [];

        foreach ($formFields as $sectorIndex => $sector) {
            $sectorForm = sprintf('sector.%s', $sectorIndex);
            $messages[sprintf('%s.vocabulary_uri.url', $sectorForm)] = 'The @vocabulary-uri field must be a valid url.';
            $messages[sprintf('%s.percentage.numeric', $sectorForm)] = 'The @percentage field must be a number.';
            $messages[sprintf('%s.percentage.max', $sectorForm)] = 'The @percentage field cannot be greater than 100.';
            $messages[sprintf('%s.percentage.digits_between', $sectorForm)] = 'The @percentage field cannot be greater than 3 digits.';
            $messages[sprintf('%s.percentage.sum', $sectorForm)] = 'The sum of @percentage within a vocabulary must add upto 100.';
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
    protected function getRulesForPercentage($sectors): array
    {
        $array = [];
        $totalPercentage = 0;

        if (count($sectors) > 1) {
            foreach ($sectors as $sectorIndex => $sector) {
                $sectorForm = sprintf('sector.%s', $sectorIndex);
                $percentage = $sector['percentage'] ?: 0;
                $sectorVocabulary = $sector['sector_vocabulary'] ?: 'Not Specified';

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
