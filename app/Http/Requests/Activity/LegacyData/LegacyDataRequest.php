<?php

declare(strict_types=1);

namespace App\Http\Requests\Activity\LegacyData;

use App\Http\Requests\Activity\ActivityBaseRequest;

/**
 * Class LegacyDataRequest.
 */
class LegacyDataRequest extends ActivityBaseRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        $totalRules = [$this->getCriticalRulesForLegacyData(), $this->getRulesForActivityLegacyData()];

        return mergeRules($totalRules);
    }

    /**
     * Get the error message as required.
     *
     * @return array
     */
    public function messages(): array
    {
        return $this->getMessagesForActivityLegacyData($this->get('legacy_data'));
    }

    /**
     * Returns rules for related activity.
     *
     * @return array
     */
    public function getCriticalRulesForLegacyData(): array
    {
        return [];
    }

    /**
     * Returns rules for related activity.
     *
     * @return array
     */
    public function getRulesForActivityLegacyData(): array
    {
        return [];
    }

    /**
     * Returns messages for related activity validations.
     *
     * @return array
     */
    public function getMessagesForActivityLegacyData(): array
    {
        return [];
    }
}
