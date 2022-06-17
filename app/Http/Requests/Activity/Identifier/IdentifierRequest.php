<?php

namespace App\Http\Requests\Activity\Identifier;

use App\Http\Requests\Activity\ActivityBaseRequest;
use App\IATI\Services\Activity\ActivityService;
use Illuminate\Validation\Rule;

/**
 * Class IdentifierRequest.
 */
class IdentifierRequest extends ActivityBaseRequest
{
    /**
     * @var ActivityService
     */
    protected $activityService;

    /**
     * ActivityCreateRequest constructor.
     *
     * @param ActivityService $activityService
     */
    public function __construct(ActivityService $activityService)
    {
        parent::__construct();
        $this->activityService = $activityService;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        $activityIdentifiers = [];
        $organizationActivityIdentifiers = $this->activityService->getActivityIdentifiersForOrganization(auth()->user()->organization->id);

        if (count($organizationActivityIdentifiers)) {
            foreach ($organizationActivityIdentifiers as $identifier) {
                $activityIdentifiers[] = $identifier->identifier['activity_identifier'];
            }
        }

        return [
            'activity_identifier'   => ['required', Rule::notIn($activityIdentifiers)],
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
