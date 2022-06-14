<?php

declare(strict_types=1);

namespace App\Http\Requests\Activity;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Validator;

/**
 * Class ActivityBaseRequest.
 */
class ActivityBaseRequest extends FormRequest
{
    /**
     * ActivityBaseRequest constructor.
     */
    public function __construct()
    {
        Validator::extendImplicit(
            'unique_lang',
            function ($attribute, $value) {
                $languages = [];
                foreach ($value as $narrative) {
                    $language = $narrative['language'];
                    if (in_array($language, $languages)) {
                        return false;
                    }
                    $languages[] = $language;
                }

                return true;
            }
        );

        Validator::extendImplicit(
            'unique_default_lang',
            function ($attribute, $value, $parameters, $validator) {
                $languages = [];
                $defaultLanguage = 'en';

                $validator->addReplacer(
                    'unique_default_lang',
                    function ($message) use ($validator, $defaultLanguage) {
                        return str_replace(':language', getCodeListArray('Languages', 'ActivityArray')[$defaultLanguage], $message);
                    }
                );

                $check = true;
                foreach ($value as $narrative) {
                    $languages[] = $narrative['language'];
                }

                if (count($languages) === count(array_unique($languages))) {
                    if (in_array('', $languages) && in_array($defaultLanguage, $languages)) {
                        $check = false;
                    }
                }

                return $check;
            }
        );
    }
}
