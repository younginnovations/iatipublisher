<?php

declare(strict_types=1);

namespace App\IATI\Repositories\Activity;

use App\IATI\Models\Activity\Activity;
use App\IATI\Models\Setting\Setting;
use App\IATI\Repositories\Repository;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Arr;

/**
 * Class ActivityRepository.
 */
class ActivityRepository extends Repository
{
    /**
     * Returns activity model.
     *
     * @return string
     */
    public function getModel(): string
    {
        return Activity::class;
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
        return $this->model->where('org_id', $organizationId)->get(['iati_identifier']);
    }

    /**
     * Returns activity identifiers used by an organization.
     *
     * @param       $organizationId
     * @param array $queryParams
     * @param int   $page
     *
     * @return Collection|LengthAwarePaginator
     */
    public function getActivityForOrganization($organizationId, array $queryParams = [], int $page = 1): Collection|LengthAwarePaginator
    {
        $whereSql = '1=1';
        $bindParams = [];

        if (!empty($organizationId)) {
            $whereSql .= " AND org_id=$organizationId";
        }

        if (array_key_exists('query', $queryParams) && (!empty($queryParams['query']) || $queryParams['query'] === '0')) {
            $query = $queryParams['query'];
            $innerSql = 'select id, json_array_elements(title) title_array from activities';

            if (!empty($organizationId)) {
                $innerSql . " org_id=$organizationId";
            }

            $whereSql .= " AND ((iati_identifier->>'activity_identifier')::text ilike ? or id in (select x1.id from ($innerSql)x1 where (x1.title_array->>'narrative')::text ilike ?))";
            $bindParams[] = "%$query%";
            $bindParams[] = "%$query%";
        }

        $orderBy = 'created_at';
        $direction = 'desc';

        if (array_key_exists('orderBy', $queryParams) && !empty($queryParams['orderBy'])) {
            $orderBy = $queryParams['orderBy'];

            if (array_key_exists('direction', $queryParams) && !empty($queryParams['direction'])) {
                $direction = $queryParams['direction'];
            }
        }

        return $this->model->whereRaw($whereSql, $bindParams)
            ->orderBy($orderBy, $direction)
            ->paginate(10, ['*'], 'activity', $page);
    }

    /**
     * Updates status column of activity row.
     *
     * @param $activity
     * @param $status
     * @param $linkedToIati
     *
     * @return bool
     */
    public function updatePublishedStatus($activity, $status, $linkedToIati): bool
    {
        return (bool) $this->model->where('id', $activity->id)->update([
            'status'            => $status,
            'linked_to_iati'    => $linkedToIati,
        ]);
    }

    /**
     * Deletes desired activity.
     *
     * @param Activity $activity
     *
     * @return bool
     */
    public function deleteActivity(Activity $activity): bool
    {
        return $activity->delete();
    }

    /**
     * Sets activity status to draft.
     *
     * @param $activity_id
     *
     * @return void
     */
    public function resetActivityWorkflow($activity_id): void
    {
        $this->model->whereId($activity_id)->update(['status' => 'draft']);
    }

    /**
     * Returns activities having given ids.
     *
     * @param $activityIds
     *
     * @return object
     */
    public function getActivitiesHavingIds($activityIds): object
    {
        return $this->model->whereIn('id', $activityIds)->where('org_id', auth()->user()->organization->id)->where('status', 'draft')->get();
    }

    /**
     * Provides activity identifiers.
     *
     * @param $orgId
     *
     * @return Collection|array
     */
    public function getActivityIdentifiers($orgId): Collection|array
    {
        return $this->model->where('org_id', $orgId)->get('iati_identifier->activity_identifier');
    }

    /**
     * Provides activity identifiers.
     *
     * @param $orgId
     *
     * @return Collection|array
     */
    public function getActivities($orgId): Collection|array
    {
        return $this->model->where('org_id', $orgId)->get();
    }

    /**
     * @param       $activity_id
     * @param array $mappedActivity
     *
     * @return mixed
     * @throws \JsonException
     */
    public function importXmlActivities($activity_id, array $mappedActivity): mixed
    {
        $defaultFieldValues = $this->setDefaultFieldValues($mappedActivity['default_field_values'], $mappedActivity['org_id']);
        $mappedActivity = json_decode(json_encode($mappedActivity, JSON_THROW_ON_ERROR | 512), true, 512, JSON_THROW_ON_ERROR);

        $data = [
            'iati_identifier'      => $mappedActivity['identifier'],
            'title'                => $this->getActivityElement($mappedActivity, 'title'),
            'description'          => $this->getActivityElement($mappedActivity, 'description'),
            'activity_status'      => $mappedActivity['activity_status'] ?? null,
            'activity_date'        => $this->getActivityElement($mappedActivity, 'activity_date'),
            'participating_org'    => $this->getActivityElement($mappedActivity, 'participating_organization'),
            'recipient_country'    => $this->getActivityElement($mappedActivity, 'recipient_country'),
            'recipient_region'     => $this->getActivityElement($mappedActivity, 'recipient_region'),
            'sector'               => $this->getActivityElement($mappedActivity, 'sector'),
            'location'             => $this->getActivityElement($mappedActivity, 'location'),
            'conditions'           => $this->getActivityElement($mappedActivity, 'conditions', false),
            'document_link'        => $this->getActivityElement($mappedActivity, 'document_link'),
            'country_budget_items' => Arr::get($this->getActivityElement($mappedActivity, 'country_budget_items'), '0', null),
            'planned_disbursement' => $this->getActivityElement($mappedActivity, 'planned_disbursement'),
            'humanitarian_scope'   => $this->getActivityElement($mappedActivity, 'humanitarian_scope'),
            'other_identifier'     => $this->getActivityElement($mappedActivity, 'other_identifier'),
            'legacy_data'          => $this->getActivityElement($mappedActivity, 'legacy_data'),
            'tag'                  => $this->getActivityElement($mappedActivity, 'tag'),
            'org_id'               => $mappedActivity['org_id'],
            'policy_marker'        => $this->getActivityElement($mappedActivity, 'policy_marker'),
            'budget'               => $this->getActivityElement($mappedActivity, 'budget'),
            'activity_scope'       => Arr::get($this->getActivityElement($mappedActivity, 'activity_scope'), '0', null),
            'collaboration_type'   => Arr::get($mappedActivity, 'collaboration_type', null),
            'capital_spend'        => Arr::get($mappedActivity, 'capital_spend', null),
            'default_flow_type'    => Arr::get($mappedActivity, 'default_flow_type', null),
            'default_finance_type' => Arr::get($mappedActivity, 'default_finance_type', null),
            'default_aid_type'     => $this->getActivityElement($mappedActivity, 'default_aid_type'),
            'default_tied_status'  => Arr::get($mappedActivity, 'default_tied_status', null),
            'contact_info'         => $this->getActivityElement($mappedActivity, 'contact_info'),
            'related_activity'     => $this->getActivityElement($mappedActivity, 'related_activity'),
            'default_field_values' => $defaultFieldValues[0],
        ];

        if ($activity_id) {
            return $this->model->where('id', $activity_id)->update($data);
        }

        return $this->model->create($data);
    }

    /**
     * Returns activity element.
     *
     * @param      $activity
     * @param      $type
     * @param bool $get_values
     *
     * @return array|null
     */
    public function getActivityElement($activity, $type, bool $get_values = true): ?array
    {
        if (isset($activity[$type]) && !empty($activity[$type])) {
            return $get_values ? array_values((array) $activity[$type]) : (array) $activity[$type];
        }

        return null;
    }

    /**
     * Set Default values for the imported csv activities.
     *
     * @param $defaultFieldValues
     * @param $organizationId
     *
     * @return mixed
     */
    protected function setDefaultFieldValues($defaultFieldValues, $organizationId): mixed
    {
        $settings = Setting::where('organization_id', $organizationId)->first();
        $settingsDefaultFieldValues = $settings ? $settings->default_values + $settings->activity_default_values : [];

        foreach ($defaultFieldValues as $index => $value) {
            $settingsDefaultFieldValues[0]['default_currency'] = ((Arr::get((array) $value, 'default_currency')) === '')
                ? Arr::get($settingsDefaultFieldValues, '0.default_currency', null) : (Arr::get((array) $value, 'default_currency', null));
            $settingsDefaultFieldValues[0]['default_language'] = ((Arr::get((array) $value, 'default_language')) === '')
                ? Arr::get($settingsDefaultFieldValues, '0.default_language', null) : Arr::get((array) $value, 'default_language', null);
            $settingsDefaultFieldValues[0]['hierarchy'] = ((Arr::get((array) $value, 'hierarchy')) === '')
                ? Arr::get($settingsDefaultFieldValues, '0.hierarchy', null) : (Arr::get((array) $value, 'hierarchy', null));
            $settingsDefaultFieldValues[0]['humanitarian'] = ((Arr::get((array) $value, 'humanitarian')) === '')
                ? Arr::get($settingsDefaultFieldValues, '0.humanitarian', null) : Arr::get((array) $value, 'humanitarian', null);
            $settingsDefaultFieldValues[0]['budget_not_provided'] = ((Arr::get((array) $value, 'budget_not_provided')) === '')
                ? Arr::get($settingsDefaultFieldValues, '0.budget_not_provided', null) : (Arr::get((array) $value, 'budget_not_provided', null));
        }

        return $settingsDefaultFieldValues;
    }

    /**
     * Create Activity from the csv data.
     *
     * @param $activityData
     *
     * @return Activity
     */
    public function createActivity($activityData): Activity
    {
        $defaultFieldValues = $this->setDefaultFieldValues($activityData['default_field_values'], $activityData['organization_id']);

        return $this->model->create(
            [
                'iati_identifier'      => $activityData['identifier'],
                'title'                => $this->getActivityElement($activityData, 'title'),
                'description'          => $this->getActivityElement($activityData, 'description'),
                'activity_status'      => Arr::get($this->getActivityElement($activityData, 'activity_status'), '0', null),
                'activity_date'        => $this->getActivityElement($activityData, 'activity_date'),
                'participating_org'    => $this->getActivityElement($activityData, 'participating_organization'),
                'recipient_country'    => $this->getActivityElement($activityData, 'recipient_country'),
                'recipient_region'     => $this->getActivityElement($activityData, 'recipient_region'),
                'sector'               => $this->getActivityElement($activityData, 'sector'),
                'org_id'               => $activityData['organization_id'],
                'policy_marker'        => $this->getActivityElement($activityData, 'policy_marker'),
                'budget'               => $this->getActivityElement($activityData, 'budget'),
                'activity_scope'       => Arr::get($this->getActivityElement($activityData, 'activity_scope'), '0', null),
                'default_field_values' => $defaultFieldValues[0],
                'contact_info'         => $this->getActivityElement($activityData, 'contact_info'),
                'related_activity'     => $this->getActivityElement($activityData, 'related_activity'),
                'other_identifier'     => $this->getActivityElement($activityData, 'other_identifier'),
                'tag'                  => $this->getActivityElement($activityData, 'tag'),
                'collaboration_type'   => Arr::get($this->getActivityElement($activityData, 'collaboration_type'), '0', null),
                'default_flow_type'    => Arr::get($this->getActivityElement($activityData, 'default_flow_type'), '0', null),
                'default_finance_type' => Arr::get($this->getActivityElement($activityData, 'default_finance_type'), '0', null),
                'default_tied_status'  => Arr::get($this->getActivityElement($activityData, 'default_tied_status'), '0', null),
                'default_aid_type'     => $this->getActivityElement($activityData, 'default_aid_type'),
                'country_budget_items' => Arr::get($activityData, 'country_budget_item', null),
                'humanitarian_scope'   => $this->getActivityElement($activityData, 'humanitarian_scope'),
                'capital_spend'        => Arr::get($this->getActivityElement($activityData, 'capital_spend'), '0', null),
                'conditions'           => Arr::get($activityData, 'condition', null),
                'legacy_data'          => $this->getActivityElement($activityData, 'legacy_data'),
                'document_link'        => $this->getActivityElement($activityData, 'document_link'),
                'location'             => $this->getActivityElement($activityData, 'location'),
                'planned_disbursement' => $this->getActivityElement($activityData, 'planned_disbursement'),
            ]
        );
    }

    /**
     * Only updates data provided in activity csv.
     *
     * @param       $id
     * @param array $activityData
     *
     * @return int
     */
    public function updateActivity($id, array $activityData): int
    {
        $defaultFieldValues = $this->setDefaultFieldValues($activityData['default_field_values'], $activityData['organization_id']);

        return $this->model->where('id', $id)->update(
            [
                'iati_identifier'      => $activityData['identifier'],
                'title'                => $this->getActivityElement($activityData, 'title'),
                'description'          => $this->getActivityElement($activityData, 'description'),
                'activity_status'      => Arr::get($this->getActivityElement($activityData, 'activity_status'), '0', null),
                'activity_date'        => $this->getActivityElement($activityData, 'activity_date'),
                'participating_org'    => $this->getActivityElement($activityData, 'participating_organization'),
                'recipient_country'    => $this->getActivityElement($activityData, 'recipient_country'),
                'recipient_region'     => $this->getActivityElement($activityData, 'recipient_region'),
                'sector'               => $this->getActivityElement($activityData, 'sector'),
                'org_id'               => $activityData['organization_id'],
                'policy_marker'        => $this->getActivityElement($activityData, 'policy_marker'),
                'budget'               => $this->getActivityElement($activityData, 'budget'),
                'activity_scope'       => Arr::get($this->getActivityElement($activityData, 'activity_scope'), '0', null),
                'default_field_values' => $defaultFieldValues[0],
                'contact_info'         => $this->getActivityElement($activityData, 'contact_info'),
                'related_activity'     => $this->getActivityElement($activityData, 'related_activity'),
                'other_identifier'     => $this->getActivityElement($activityData, 'other_identifier'),
                'tag'                  => $this->getActivityElement($activityData, 'tag'),
                'collaboration_type'   => $this->getActivityElement($activityData, 'collaboration_type'),
                'default_flow_type'    => Arr::get($this->getActivityElement($activityData, 'default_flow_type'), '0', null),
                'default_finance_type' => Arr::get($this->getActivityElement($activityData, 'default_finance_type'), '0', null),
                'default_tied_status'  => Arr::get($this->getActivityElement($activityData, 'default_tied_status'), '0', null),
                'default_aid_type'     => $this->getActivityElement($activityData, 'default_aid_type'),
                'country_budget_items' => Arr::get($activityData, 'country_budget_item', null),
                'humanitarian_scope'   => $this->getActivityElement($activityData, 'humanitarian_scope'),
                'capital_spend'        => Arr::get($this->getActivityElement($activityData, 'capital_spend'), '0', null),
                'conditions'           => Arr::get($activityData, 'condition', null),
                'legacy_data'          => $this->getActivityElement($activityData, 'legacy_data'),
                'document_link'        => $this->getActivityElement($activityData, 'document_link'),
                'location'             => $this->getActivityElement($activityData, 'location'),
                'planned_disbursement' => $this->getActivityElement($activityData, 'planned_disbursement'),
            ]
        );
    }

    /**
     * Returns activity.
     *
     * @param $org_id
     * @param $identifier
     *
     * @return mixed
     */
    public function getActivityWithIdentifier($org_id, $identifier): mixed
    {
        return $this->model->where('org_id', $org_id)->whereJsonContains('iati_identifier->activity_identifier', $identifier['activity_identifier'])->first();
    }
}
