<?php

declare(strict_types=1);

namespace App\IATI\Services;

use Illuminate\Support\Arr;

/**
 * Class ElementCompleteService.
 */
class OrganizationElementCompleteService
{
    /**
     * Public variable element.
     *
     * @var string
     */
    public string $element = '';

    /**
     * @var string
     */
    public string $tempNarrative = '';

    /**
     * @var string
     */
    public string $tempAmount = '';


    /**
     * Sets default values of language and currency where required for organization.
     *
     * @param $data
     * @param $organization
     *
     * @return mixed
     * @throws \JsonException
     */
    public function setOrganizationDefaultValues(&$data, $organization): mixed
    {
        if (is_string($data) && $this->isJson($data)) {
            $data = json_decode($data, true, 512, JSON_THROW_ON_ERROR);
        }

        if (!is_string($data)) {
            foreach ($data as $key => &$datum) {
                if (is_array($datum)) {
                    $this->setOrganizationDefaultValues($datum, $organization);
                }

                if ($key === 'narrative') {
                    $this->tempNarrative = $datum;
                }

                if ($key === 'amount') {
                    $this->tempAmount = $datum;
                }

                if ($organization->settings) {
                    if ($key === 'language' && empty($datum) && !empty($this->tempNarrative)) {
                        $data['language'] = Arr::get($organization->settings->default_values, 'default_language', null);
                    }

                    if ($key === 'currency' && empty($datum) && !empty($this->tempAmount)) {
                        $data['currency'] = Arr::get($organization->settings->default_values, 'default_currency', null);
                    }
                }
            }
        }

        return $data;
    }

    /**
     * Checks if the string is json
     *
     * @param $string
     *
     * @return bool
     * @throws \JsonException
     */
    public function isJson($string): bool
    {
        json_decode($string, false, 512, JSON_THROW_ON_ERROR);

        return json_last_error() === JSON_ERROR_NONE;
    }
}
