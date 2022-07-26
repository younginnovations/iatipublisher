<?php

declare(strict_types=1);

namespace App\IATI\Services\Activity;

use App\IATI\Models\Activity\Activity;
use App\IATI\Repositories\Activity\ActivityRepository;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

/**
 * Class ActivityService.
 */
class ActivityService
{
    /**
     * @var ActivityRepository
     */
    protected ActivityRepository $activityRepository;

    /**
     * ActivityService constructor.
     *
     * @param ActivityRepository $activityRepository
     */
    public function __construct(ActivityRepository $activityRepository)
    {
        $this->activityRepository = $activityRepository;
    }

    /**
     * Returns all activities present in database.
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getAllActivities(): Collection
    {
        return $this->activityRepository->getActivityForOrganization(Auth::user()->organization_id);
    }

    /**
     * Returns all activities present in database.
     *
     * @param int $page
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getPaginatedActivities(int $page = 1): Collection | \Illuminate\Pagination\LengthAwarePaginator
    {
        return $this->activityRepository->getActivityForOrganization(Auth::user()->organization_id, $page);
    }

    /**
     * Stores activity in activity table.
     *
     * @param $input
     *
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function store($input): \Illuminate\Database\Eloquent\Model
    {
        $activity_identifier = [
            'activity_identifier' => $input['activity_identifier'],
            'iati_identifier_text' => Auth::user()->organization->identifier . '-' . $input['activity_identifier'],
        ];

        $activity_title = [
            [
                'narrative' => $input['narrative'],
                'language'  => $input['language'],
            ],
        ];

        return $this->activityRepository->store([
            'iati_identifier'    => $activity_identifier,
            'title'         => $activity_title,
            'org_id'        => Auth::user()->organization_id,
        ]);
    }

    /**
     * Returns activity identifiers used by an organization.
     *
     * @param $organizationId
     *
     * @return Collection
     */
    public function getActivityIdentifiersForOrganization($organizationId): Collection
    {
        return $this->activityRepository->getActivityIdentifiersForOrganization($organizationId);
    }

    /**
     * Returns activity identifiers used by an organization.
     *
     * @param $id
     *
     * @return Activity
     */
    public function getActivity($id): Activity
    {
        return $this->activityRepository->find($id);
    }

    /**
     * Generates toast array.
     *
     * @return array
     */
    public function generateToastData(): array
    {
        $toast['message'] = Session::exists('error') ? Session::get('error') : (Session::exists('success') ? Session::get('success') : '');
        $toast['type'] = Session::exists('error') ? false : 'success';
        Session::forget('success');
        Session::forget('error');

        return $toast;
    }

    /**
     * Returns array containing activity detail status.
     *
     * @param Activity $activity
     *
     * @return array
     */
    public function activityDetailStatus(Activity $activity): array
    {
        return [
            'identifier'           => $activity->identifier_element_completed,
            'title'                => $activity->title_element_completed,
            'description'          => $activity->description_element_completed,
            'activity_status'      => $activity->activity_status_element_completed,
            'activity_date'        => $activity->activity_date_element_completed,
            'activity_scope'       => $activity->activity_scope_element_completed,
            'recipient_country'    => $activity->recipient_country_element_completed,
            'recipient_region'     => $activity->recipient_region_element_completed,
            'collaboration_type'   => $activity->collaboration_type_element_completed,
            'default_flow_type'    => $activity->default_flow_type_element_completed,
            'default_finance_type' => $activity->default_finance_type_element_completed,
            'default_aid_type'     => $activity->default_aid_type_element_completed,
            'default_tied_status'  => $activity->default_tied_status_element_completed,
            'capital_spend'        => $activity->capital_spend_element_completed,
            'related_activity'     => $activity->related_activity_element_completed,
            'conditions'           => $activity->conditions_element_completed,
            'sector'               => $activity->sector_element_completed,
            'humanitarian_scope'   => $activity->humanitarian_scope_element_completed,
            'legacy_data'          => $activity->legacy_data_element_completed,
            'tag'                  => $activity->tag_element_completed,
            'policy_marker'        => $activity->policy_marker_element_completed,
            'other_identifier'     => $activity->other_identifier_element_completed,
            'country_budget_items' => $activity->country_budget_items_element_completed,
            'budget'               => $activity->budget_element_completed,
            'participating_org'    => $activity->participating_org_element_completed,
            'reporting_org'        => false,
            'document_link'        => $activity->document_link_element_completed,
            'contact_info'         => $activity->contact_info_element_completed,
            'location'             => $activity->location_element_completed,
            'planned_disbursement' => $activity->planned_disbursement_element_completed,
            'transactions'         => $activity->transactions_element_completed,
            'result'               => $activity->result_element_completed,
        ];
    }

    /**
     * Return activity publishing progress in percentage.
     *
     * @param $elements_status
     *
     * @return float|int
     */
    public function activityPublishingProgress($elements_status): float|int
    {
        $core_elements = [
            'title',
            'description',
            'budget',
            'transactions',
            'sector',
            'participating_org',
            'activity_status',
            'activity_date',
            'recipient_country',
            'recipient_region',
            'collaboration_type',
            'default_flow_type',
            'default_finance_type',
            'default_aid_type',
        ];
        $completed_core_element_count = 0;

        foreach ($core_elements as $core_element) {
            if (array_key_exists($core_element, $elements_status) && $elements_status[$core_element]) {
                $completed_core_element_count++;
            }
        }

        return ($completed_core_element_count / count($core_elements)) * 100;
    }
}
