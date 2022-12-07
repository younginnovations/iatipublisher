<?php

declare(strict_types=1);

namespace App\Http\Requests\Activity\Sector;

use App\Http\Requests\Activity\ActivityBaseRequest;
use App\IATI\Services\Activity\ActivityService;
use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Support\Facades\Validator;

/**
 * Class SectorRequest.
 */
class SectorRequest extends ActivityBaseRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     * @throws BindingResolutionException
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
     * Returns grouped sector.
     *
     * @param $formFields
     *
     * @return array
     */
    public function groupSector($formFields): array
    {
        $groupedSector = [];

        foreach ($formFields as $formField) {
            if (array_key_exists($formField['sector_vocabulary'], $groupedSector)) {
                $groupedSector[$formField['sector_vocabulary']]['count'] += 1;
                $groupedSector[$formField['sector_vocabulary']]['total'] += (float) $formField['percentage'];
            } else {
                $groupedSector[$formField['sector_vocabulary']] = ['count' => 1, 'total' => (float) $formField['percentage']];
            }
        }

        return $groupedSector;
    }

    /**
     * returns rules for sector.
     *
     * @param $formFields
     * @param bool $fileUpload
     *
     * @return array
     * @throws BindingResolutionException
     */
    public function getSectorsRules($formFields, bool $fileUpload = false): array
    {
        if (empty($formFields)) {
            return [];
        }

        if (!$fileUpload) {
            $params = $this->route()->parameters();
            $activityService = app()->make(ActivityService::class);

            if ($activityService->hasSectorDefinedInTransactions($params['id'])) {
                Validator::extend('already_in_transactions', function () {
                    return false;
                });

                return ['sector' => 'already_in_transactions'];
            }
        }

        Validator::extend('sector_total_percent', function () {
            return false;
        });
        Validator::extend('sector_has_five_digit_oced_vocab', function () {
            return false;
        });
        $rules = [];
        $groupedPercentSector = $this->groupSector($formFields);
        $hasFiveDigitOecd = false;

        foreach ($formFields as $sectorIndex => $sector) {
            $sectorForm = sprintf('sector.%s', $sectorIndex);
            $rules[sprintf('%s.sector_vocabulary', $sectorForm)] = 'nullable|in:' . implode(',', array_keys(getCodeList('SectorVocabulary', 'Activity', false)));
            $rules[sprintf('%s.code', $sectorForm)] = 'nullable|in:' . implode(',', array_keys(getCodeList('SectorCode', 'Activity', false)));
            $rules[sprintf('%s.category_code', $sectorForm)] = 'nullable|in:' . implode(',', array_keys(getCodeList('SectorCategory', 'Activity', false)));
            $rules[sprintf('%s.sdg_goal', $sectorForm)] = 'nullable|in:' . implode(',', array_keys(getCodeList('UNSDG-Goals', 'Activity', false)));
            $rules[sprintf('%s.sdg_target', $sectorForm)] = 'nullable|in:' . implode(',', array_keys(getCodeList('UNSDG-Targets', 'Activity', false)));

            if (isset($sector['sector_vocabulary']) && ($sector['sector_vocabulary'] === '99' || $sector['sector_vocabulary'] === '98')) {
                $rules[sprintf('%s.vocabulary_uri', $sectorForm)] = 'nullable|url';
            }

            $rules[sprintf('%s.percentage', $sectorForm)] = 'nullable|numeric|min:0';

            $narrativeRules = $this->getRulesForNarrative($sector['narrative'], $sectorForm);

            foreach ($narrativeRules as $key => $item) {
                $rules[$key] = $item;
            }

            if ($sector['sector_vocabulary'] === '1') {
                $hasFiveDigitOecd = true;
            }

            if ($groupedPercentSector[$sector['sector_vocabulary']]['count'] > 1) {
                if ($groupedPercentSector[$sector['sector_vocabulary']]['total'] !== 100.0) {
                    $rules[$sectorForm . '.percentage'] .= '|sector_total_percent';
                }
            } else {
                $rules[$sectorForm . '.percentage'] .= '|in:' . 100.0;
            }
        }

        if (!$hasFiveDigitOecd) {
            foreach ($formFields as $sectorIndex => $sector) {
                $sectorForm = sprintf('sector.%s', $sectorIndex);
                $rules[$sectorForm . '.sector_vocabulary'] = 'sector_has_five_digit_oced_vocab';
            }
        }

        return $rules;
    }

    /**
     * returns messages for sector.
     *
     * @param $formFields
     *
     * @return array
     */
    public function getSectorsMessages($formFields): array
    {
        $messages = ['sector.already_in_transactions' => 'Sector already defined in Transactions'];

        foreach ($formFields as $sectorIndex => $sector) {
            $sectorForm = sprintf('sector.%s', $sectorIndex);
            $messages[sprintf('%s.sector_vocabulary.in', $sectorForm)] = 'The sector vocabulary is invalid.';
            $messages[sprintf('%s.code.in', $sectorForm)] = 'The sector code is invalid.';
            $messages[sprintf('%s.category_code.in', $sectorForm)] = 'The sector code is invalid.';
            $messages[sprintf('%s.sdg_goal.in', $sectorForm)] = 'The sector code is invalid.';
            $messages[sprintf('%s.sdg_target.in', $sectorForm)] = 'The sector code is invalid.';
            $messages[sprintf('%s.vocabulary_uri.url', $sectorForm)] = 'The sector vocabulary-uri field must be a valid url.';
            $messages[sprintf('%s.percentage.numeric', $sectorForm)] = 'The sector percentage field must be a number.';
            $messages[sprintf('%s.percentage.in', $sectorForm)] = 'The sector percentage for single sector must be either omitted or be 100.';
            $messages[sprintf('%s.percentage.sector_total_percent', $sectorForm)] = 'The total percentage within a vocabulary must be 100.';
            $messages[sprintf('%s.sector_vocabulary.sector_has_five_digit_oced_vocab', $sectorForm)] = 'The sector vocabulary must have 5 digit OCED';

            $messageNarratives = $this->getMessagesForNarrative($sector['narrative'], $sectorForm);

            foreach ($messageNarratives as $key => $item) {
                $messages[$key] = $item;
            }
        }

        return $messages;
    }
}
