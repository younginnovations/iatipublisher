<?php

declare(strict_types=1);

namespace App\Http\Requests\Activity\Identifier;

use App\IATI\Services\Activity\ActivityService;
use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

/**
 * Class IdentifierRequest.
 */
class IdentifierRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @param bool $fileUpload
     *
     * @return array
     *
     * @throws BindingResolutionException
     */
    public function rules(bool $fileUpload = false): array
    {
        $totalRules = [$this->getWarningForIdentifier(), $this->getErrorsForIdentifier()];

        return mergeRules($totalRules);
    }

    /**
     * Return critical rules for identifier.
     *
     * @param bool $fileUpload
     * @param string $elementName
     *
     * @return array
     *
     * @throws BindingResolutionException
     */
    public function getErrorsForIdentifier(bool $fileUpload = false, string $elementName = ''): array
    {
        if (!$fileUpload) {
            $activityIdentifiers = [];
            $activityService = app()->make(ActivityService::class);
            $organizationActivityIdentifiers = $activityService->getActivityIdentifiersForOrganization(auth()->user()->organization->id);
            $activity = $activityService->getActivity(request()->segment(2));

            if (count($organizationActivityIdentifiers)) {
                foreach ($organizationActivityIdentifiers as $identifier) {
                    if ($identifier->iati_identifier['activity_identifier'] != $activity->iati_identifier['activity_identifier']) {
                        $activityIdentifiers[] = $identifier->iati_identifier['activity_identifier'];
                    }
                }
            }

            return [
                'activity_identifier' => ['required', Rule::notIn($activityIdentifiers), 'not_regex:/(&|!|\/|\||\?)/'],
            ];
        }

        return [
            empty($elementName) ? 'activity_identifier' : "$elementName.activity_identifier" => ['required', 'not_regex:/(&|!|\/|\||\?)/'],
        ];
    }

    /**
     * Return rules for identifier.
     *
     * @return array
     */
    public function getWarningForIdentifier(): array
    {
        return [
            'iati_identifier_text' => 'sometimes',
        ];
    }

    /**
     * Get the error message as required.
     *
     * @return array
     */
    public function messages(): array
    {
        return [
            'activity_identifier.not_in' => translateRequestMessage('the_activity', 'identifier_already_exists'),
        ];
    }
}
