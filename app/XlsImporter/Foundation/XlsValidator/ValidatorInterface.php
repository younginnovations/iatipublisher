<?php

declare(strict_types=1);

namespace App\XlsImporter\Foundation\XlsValidator;

/**
 * Class Repository.
 */
interface ValidatorInterface
{
    /**
     * Initializes data on which validation is to be done\.
     *
     * @param $data
     *
     * @return void
     */
    public function init($data): void;

    /**
     * Returns warnings for the xls data.
     *
     * @return array
     */
    public function rules(): array;

    /**
     * Returns error rules for the xls data.
     *
     * @return array
     */
    public function errorRules(): array;

    /**
     * Returns critical rules for the xls data.
     *
     * @return array
     */
    public function criticalRules(): array;

    /**
     * Returns validation messages for xls data.
     *
     * @return array
     */
    public function messages(): array;

    /**
     * Returns errors after validation.
     *
     * @return array
     */
    public function validateData(): array;
}
