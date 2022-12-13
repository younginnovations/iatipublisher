<?php

declare(strict_types=1);

namespace App\Http\Requests\Activity\Identifier;

use App\IATI\Services\Activity\ActivityService;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

/**
 * Class IdentifierRequest.
 */
class IdentifierRequest extends FormRequest
{
    /**
     * @var ActivityService
     */
    protected $activityService;

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(bool $fileUpload = false): array
    {
        $activityIdentifiers = [];

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
        }

        return [
            'activity_identifier'   => ['required', Rule::notIn($activityIdentifiers), 'not_regex:/(&|!|\/|\||\?)/'],
            'iati_identifier_text'  => ['sometimes'],
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
            'activity_identifier.not_in' => 'The activity identifier already exists.',
        ];
    }
}
