<?php

declare(strict_types=1);

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

/**
 * @class ValidPhoneNumber
 *
 * Adds validation rules for the phone number.
 *
 * Change source: https://github.com/IATI/iatipublisher/issues/1733
 */
class ValidPhoneNumber implements Rule
{
    /**
     * @param $attribute
     * @param $value
     *
     * @return bool
     */
    public function passes($attribute, $value): bool
    {
        if (!preg_match('/^\+?(\(\d{1,3}\)|\d{1,4})?[-.\s]?\(?\d{1,20}\)?[-.\s]?\d{1,20}[-.\s]?\d{1,20}$/', $value)) {
            return false;
        }

        $balance = 0;

        for ($i = 0, $len = strlen($value); $i < $len; $i++) {
            if ($value[$i] === '(') {
                $balance++;
            } elseif ($value[$i] === ')') {
                $balance--;
            }

            if ($balance < 0) {
                return false;
            }
        }

        return $balance === 0;
    }

    /**
     * @return string
     */
    public function message() :string
    {
        return 'The contact info telephone number is invalid.';
    }
}
