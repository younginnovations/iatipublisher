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
        return $this->getRulesForSector($this->get('sector'));
    }

    /**
     * Get the error message as required.
     *
     * @return array
     */
    public function messages(): array
    {
        return $this->getMessagesForSector($this->get('sector'));
    }

    /**
     * Returns rules for related activity.
     * @param array $formFields
     * @return array
     */
    protected function getRulesForSector(array $formFields): array
    {
        $rules = [];

        foreach ($formFields as $sectorIndex => $sector) {
            $sectorForm = sprintf('sector.%s', $sectorIndex);
            $rules[sprintf('%s.type', $sectorForm)] = 'required';
            $rules = array_merge(
                $rules,
                $this->getRulesForRequiredNarrative($sector['narrative'], $sectorForm)
            );
        }

        return $rules;
    }

    /**
     * Returns messages for related activity validations.
     * @param array $formFields
     * @return array
     */
    protected function getMessagesForSector(array $formFields): array
    {
        $messages = [];

        foreach ($formFields as $sectorIndex => $d) {
            $dForm = sprintf('sector.%s', $sectorIndex);
            $messages[sprintf('%s.type.required', $dForm)] = 'Type is required.';
            $messages = array_merge(
                $messages,
                $this->getMessagesForRequiredNarrative($d['narrative'], $dForm)
            );
        }

        return $messages;
    }
}
