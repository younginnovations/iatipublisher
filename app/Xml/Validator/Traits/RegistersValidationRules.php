<?php

declare(strict_types=1);

namespace App\Xml\Validator\Traits;

use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Request;

/**
 * Class RegistersValidationRules.
 */
trait RegistersValidationRules
{
    /**
     * Register the required validation rules.
     */
    protected function registerValidationRules(): void
    {
        $this->extendImplicit(
            'unique_lang',
            function ($attribute, $value) {
                $languages = [];
                foreach ((array) $value as $narrative) {
                    $language = $narrative['language'];
                    if (in_array($language, $languages, true)) {
                        return false;
                    }
                    $languages[] = $language;
                }

                return true;
            }
        );

        $this->extendImplicit(
            'unique_default_lang',
            function ($attribute, $value) {
                $languages = [];
                // $defaultLanguage = getDefaultLanguage();
                $defaultLanguage = 'en';

                $check = true;
                foreach ((array) $value as $narrative) {
                    $languages[] = $narrative['language'];
                }

                if (count($languages) === count(array_unique($languages))) {
                    if (in_array('', $languages, true) && in_array($defaultLanguage, $languages, true)) {
                        $check = false;
                    }
                }

                return $check;
            }
        );

        $this->extendImplicit(
            'sum',
            function () {
                return false;
            }
        );

        $this->extendImplicit('total', function ($attribute, $value) {
            if ($value === 100) {
                return true;
            }

            return false;
        });

        $this->extendImplicit(
            'required_with_language',
            function ($attribute) {
                $language = preg_replace('/([^~]+).narrative/', '$1.language', (string) $attribute);

                return !(Request::get($language) && !Request::get($attribute));
            }
        );

        $this->extend(
            'exclude_operators',
            function ($attribute, $value) {
                return !preg_match('/[\&\|\?|]+/', $value);
            }
        );

        $this->extend(
            'start_end_date',
            function ($attribute, $dates) {
                $actual_start_date = '';
                $actual_end_date = '';
                $planned_start_date = '';
                $planned_end_date = '';

                foreach ($dates as $date) {
                    $actual_start_date = (Arr::get($date, 'type') === 2) ? Arr::get($date, 'date') : $actual_start_date;
                    $actual_end_date = (Arr::get($date, 'type') === 4) ? Arr::get($date, 'date') : $actual_end_date;
                    $planned_start_date = (Arr::get($date, 'type') === 1) ? Arr::get($date, 'date') : $planned_start_date;
                    $planned_end_date = (Arr::get($date, 'type') === 3) ? Arr::get($date, 'date') : $planned_end_date;
                }

                if (($actual_start_date > $actual_end_date) && ($actual_start_date !== '' && $actual_end_date !== '')) {
                    return false;
                }

                if (($planned_start_date > $planned_end_date) && ($planned_start_date !== '' && $planned_end_date !== '')) {
                    return false;
                }

                if (($actual_start_date > $planned_end_date) && ($actual_start_date !== '' && $planned_end_date !== '')
                    && ($actual_end_date === '' && $planned_start_date === '')) {
                    return false;
                }

                if (($planned_start_date > $actual_end_date) && ($planned_start_date !== '' && $actual_end_date !== '')
                    && ($planned_end_date === '' && $actual_start_date === '')) {
                    return false;
                }

                return true;
            }
        );

        $this->extend(
            'actual_date',
            function ($attribute, $date) {
                $dateType = (!is_array($date)) ?: Arr::get($date, '0.type');

                if ($dateType === 2 || $dateType === 4) {
                    $actual_date = (!is_array($date)) ?: Arr::get($date, '0.date');
                    if ($actual_date > date('Y-m-d')) {
                        return false;
                    }
                }

                return true;
            }
        );

        $this->extend(
            'start_date_required',
            function ($attribute, $dates) {
                $dateTypes = [];
                foreach ($dates as $date) {
                    $dateTypes[] = $date['type'];
                }
                if (array_key_exists('1', array_flip($dateTypes))
                    || array_key_exists('2', array_flip($dateTypes))
                ) {
                    return true;
                }

                return false;
            }
        );

        $this->extendImplicit(
            'year_value_narrative_validation',
            function ($attribute, $value) {
                $narratives = $value['comment'][0]['narrative'];
                $hasNarrative = false;
                foreach ($narratives as $narrative) {
                    if ($narrative['narrative']) {
                        $hasNarrative = true;
                        break;
                    }
                }

                if (!$hasNarrative) {
                    return true;
                }

                isset($value['year']) ?: $value['year'] = null;
                isset($value['value']) ?: $value['value'] = null;

                return $value['year'] || $value['value'];
            }
        );
    }
}
