<?php

declare(strict_types=1);

namespace App\Http\Requests\Activity\Period;

use App\Http\Requests\Activity\ActivityBaseRequest;

/**
 * Class PeriodRequest.
 */
class PeriodRequest extends ActivityBaseRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return $this->getRulesForPeriod(request()->except(['_token']));
    }

    /**
     * Get the error message as required.
     *
     * @return array
     */
    public function messages(): array
    {
        return $this->getMessagesForPeriod(request()->except(['_token']));
    }

    /**
     * Returns rules for result indicator.
     *
     * @param array $formFields
     *
     * @return array
     */
    protected function getRulesForPeriod(array $formFields): array
    {
        $rules = [];

        return $rules;
    }

    /**
     * Returns messages for result indicator validations.
     *
     * @param array $formFields
     *
     * @return array
     */
    protected function getMessagesForPeriod(array $formFields): array
    {
        $messages = [];

        return $messages;
    }
}
