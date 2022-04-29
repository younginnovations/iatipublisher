<?php

namespace App\IATI\Requests;

use App\IATI\Services\Activity\ActivityService;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

/**
 * Class ActivityCreateRequest.
 */
class ActivityCreateRequest extends FormRequest
{
    /**
     * @var ActivityService
     */
    protected $activityService;

    /**
     * ActivityCreateRequest constructor.
     * @param ActivityService $activityService
     */
    public function __construct(ActivityService $activityService)
    {
        parent::__construct();
        $this->activityService = $activityService;
    }

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $activityIdentifiers = [];
        $organizationActivityIdentifiers = $this->activityService->getActivityIdentifiersForOrganization(auth()->user()->organization->id);

        if (count($organizationActivityIdentifiers)) {
            foreach ($organizationActivityIdentifiers as $identifier) {
                $activityIdentifiers[] = $identifier->identifier['activity_identifier'];
            }
        }

        return [
            'narrative'             => ['required'],
            'language'              => ['required'],
            'activity_identifier'   => ['required', Rule::notIn($activityIdentifiers)],
            'iati_identifier_text'  => ['required'],
        ];
    }
}
