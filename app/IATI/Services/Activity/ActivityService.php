<?php

declare(strict_types=1);

namespace App\IATI\Services\Activity;

use App\IATI\Models\Activity\Activity;
use App\IATI\Repositories\Activity\ActivityRepository;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;

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
     * @var array
     */
    protected array $sectorFields = [
        'sector_vocabulary',
        'code',
        'category_code',
        'text',
        'sdg_goal',
        'sdg_target',
        'vocabulary_uri',
        'percentage',
    ];

    /**
     * @var array
     */
    protected array $recipientCountryFields = [
        'country_code',
        'percentage',
    ];

    /**
     * @var array
     */
    protected array $recipientRegionFields = [
        'region_vocabulary',
        'region_code',
        'custom_code',
        'vocabulary_uri',
        'percentage',
    ];

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
     * @param int $page
     * @param array $queryParams
     *
     * @return Collection|LengthAwarePaginator
     */
    public function getPaginatedActivities(int $page, array $queryParams): Collection|LengthAwarePaginator
    {
        $activities = $this->activityRepository->getActivityForOrganization(
            Auth::user()->organization_id,
            $queryParams,
            $page
        );

        foreach ($activities as $idx => $activity) {
            $activities[$idx]['default_title_narrative'] = $activity->default_title_narrative;
            $activity->setAttribute(
                'coreCompleted',
                isCoreElementCompleted(
                    array_merge(
                        ['reporting_org' => $activity->organization->reporting_org_element_completed],
                        $activity->element_status
                    )
                )
            );
        }

        return $activities;
    }

    /**
     * Stores activity in activity table.
     *
     * @param $input
     *
     * @return Model
     */
    public function store($input): Model
    {
        $activity_identifier = [
            'activity_identifier' => $input['activity_identifier'],
        ];

        $activity_title = [
            [
                'narrative' => $input['narrative'],
                'language' => $input['language'],
            ],
        ];

        $defaultElementStatus = getDefaultElementStatus();
        $budgetNotProvided = Auth::user()->organization->settings->activity_default_values['budget_not_provided'] ?? '';
        $defaultElementStatus['budget'] = $budgetNotProvided === '1' || $defaultElementStatus['budget'];

        return $this->activityRepository->store([
            'iati_identifier' => $activity_identifier,
            'title' => $activity_title,
            'org_id' => Auth::user()->organization_id,
            'element_status' => $defaultElementStatus,
            'default_field_values' => $this->getDefaultValues(),
            'reporting_org' => Auth::user()->organization->reporting_org,
        ]);
    }

    /**
     * @param $id
     * @param $element
     *
     * @return bool
     */
    public function deleteElement($id, $element): bool
    {
        return $this->activityRepository->update($id, [$element => null]);
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
     * @return object|null
     */
    public function getActivity($id): ?object
    {
        return $this->activityRepository->find($id);
    }

    /**
     * Returns required service file.
     *
     * @param $serviceName
     *
     * @return mixed
     */
    public function getService($serviceName): mixed
    {
        return app(sprintf("App\IATI\Services\Activity\%s", $serviceName));
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
        return $this->activityRepository->updatePublishedStatus($activity, $status, $linkedToIati);
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
        return $this->activityRepository->deleteActivity($activity);
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
        $this->activityRepository->resetActivityWorkflow($activity_id);
    }

    /**
     * Return activity publishing progress in percentage.
     *
     * @param $activity
     *
     * @return float|int
     */
    public function activityPublishingProgress($activity): float|int
    {
        $core_elements = getCoreElements();
        $completed_core_element_count = 0;

        foreach ($core_elements as $core_element) {
            if (
                array_key_exists(
                    $core_element,
                    $activity->element_status
                ) && $activity->element_status[$core_element]
            ) {
                $completed_core_element_count++;
            }
        }

        return ($completed_core_element_count / count($core_elements)) * 100;
    }

    /**
     * Returns default values for activity.
     *
     * @return array|null
     */
    public function getDefaultValues(): ?array
    {
        $organizationSettings = Auth::user()->organization->settings;

        if (!empty($organizationSettings)) {
            if ($organizationSettings->default_values && $organizationSettings->activity_default_values) {
                return array_merge(
                    $organizationSettings->default_values,
                    $organizationSettings->activity_default_values
                );
            }

            if ($organizationSettings->default_values) {
                return $organizationSettings->default_values;
            }

            if ($organizationSettings->activity_default_values) {
                return $organizationSettings->activity_default_values;
            }
        }

        return null;
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
        return $this->activityRepository->getActivitiesHavingIds($activityIds);
    }

    /**
     * Returns allocated recipient region percent.
     *
     * @param $activityId
     *
     * @return float
     */
    public function getAllottedRecipientRegionPercent($activityId): float
    {
        $activity = $this->getActivity($activityId);
        $data = $activity->recipient_country;
        $total = 0;

        if (!empty($data)) {
            foreach ($data as $datum) {
                $total += (float) $datum['percentage'];
            }
        }

        return 100 - $total;
    }

    /**
     * Returns allocated recipient region percent for file upload.
     *
     * @param $recipientCountries
     *
     * @return float
     */
    public function getAllottedRecipientRegionPercentFileUpload($recipientCountries): float
    {
        $data = $recipientCountries;
        $total = 0;

        if (!empty($data)) {
            foreach ($data as $datum) {
                $total += (float) $datum['percentage'];
            }
        }

        return 100 - $total;
    }

    /**
     * Returns allocated recipient region percent.
     *
     * @param $activityId
     *
     * @return float
     */
    public function getAllottedRecipientCountryPercent($activityId): float
    {
        $activity = $this->getActivity($activityId);
        $data = $activity->recipient_region;
        $groupedRegion = [];

        if (!empty($data)) {
            foreach ($data as $datum) {
                if (array_key_exists($datum['region_vocabulary'], $groupedRegion)) {
                    $groupedRegion[$datum['region_vocabulary']] += (float) $datum['percentage'];
                } else {
                    $groupedRegion[$datum['region_vocabulary']] = (float) $datum['percentage'];
                }
            }

            if (!empty($groupedRegion)) {
                $groupedRegion = array_values($groupedRegion);

                return 100 - $groupedRegion[0];
            }
        }

        return 100.0;
    }

    /**
     * Checks if activity has recipient region.
     *
     * @param $activityId
     *
     * @return bool
     */
    public function hasRecipientRegionDefinedInActivity($activityId): bool
    {
        $activity = $this->getActivity($activityId)->toArray();

        return !empty($activity) && (array_key_exists('recipient_region', $activity) && !empty($activity['recipient_region']));
    }

    /**
     * Checks if activity has recipient country.
     *
     * @param $activityId
     *
     * @return bool
     */
    public function hasRecipientCountryDefinedInActivity($activityId): bool
    {
        $activity = $this->getActivity($activityId)->toArray();

        return !empty($activity) && (array_key_exists('recipient_country', $activity) && !empty($activity['recipient_country']));
    }

    /**
     * Checks if activity has sector.
     *
     * @param $activityId
     *
     * @return bool
     */
    public function hasSectorDefinedInActivity($activityId): bool
    {
        $activity = $this->getActivity($activityId)->toArray();

        return !empty($activity) && (array_key_exists('sector', $activity) && !empty($activity['sector']));
    }

    /**
     * Checks if recipient_country of specific activity has been defined in any one of the transactions.
     *
     * @param $activityId
     *
     * @return bool
     */
    public function hasRecipientCountryDefinedInTransactions($activityId): bool
    {
        $transactions = $this->getActivity($activityId)->transactions->toArray();

        if (!empty($transactions)) {
            foreach ($transactions as $transaction) {
                if (
                    !empty($transaction['transaction'])
                    && array_key_exists('recipient_country', $transaction['transaction'])
                    && !empty($transaction['transaction']['recipient_country'])
                    && !$this->isElementEmpty($transaction['transaction']['recipient_country'], 'recipientCountryFields')
                ) {
                    return true;
                }
            }
        }

        return false;
    }

    /**
     * Checks if recipient_region of specific activity has been defined in any one of the transactions.
     *
     * @param $activityId
     *
     * @return bool
     */
    public function hasRecipientRegionDefinedInTransactions($activityId): bool
    {
        $transactions = $this->getActivity($activityId)->transactions->toArray();

        if (!empty($transactions)) {
            foreach ($transactions as $transaction) {
                if (
                    !empty($transaction['transaction'])
                    && array_key_exists('recipient_region', $transaction['transaction'])
                    && !empty($transaction['transaction']['recipient_region'])
                    && !$this->isElementEmpty($transaction['transaction']['recipient_region'], 'recipientRegionFields')
                ) {
                    return true;
                }
            }
        }

        return false;
    }

    /**
     * Checks if sector of specific activity has been defined in any one of the transactions.
     *
     * @param $activityId
     *
     * @return bool
     */
    public function hasSectorDefinedInTransactions($activityId): bool
    {
        $transactions = $this->getActivity($activityId)->transactions->toArray();

        if (!empty($transactions)) {
            foreach ($transactions as $transaction) {
                if (
                    !empty($transaction['transaction'])
                    && array_key_exists('sector', $transaction['transaction'])
                    && !empty($transaction['transaction']['sector'])
                    && !$this->isElementEmpty($transaction['transaction']['sector'], 'sectorFields')
                ) {
                    return true;
                }
            }
        }

        return false;
    }

    /**
     * Checks if any budgets have same type, status, period start and period end.
     *
     * @param $budgets
     *
     * @return array
     */
    public function checkSameMultipleBudgets($budgets): array
    {
        $array = [];
        $ids = [];

        if (count($budgets)) {
            foreach ($budgets as $key => $budget) {
                $getBudgetBudgetType = Arr::get($budget, 'budget_type', '1');
                $getBudgetBudgetStatus = Arr::get($budget, 'budget_status', '1');
                $getBudgetPeriodStartDate = Arr::get($budget, 'period_start.0.date', '');
                $getBudgetPeriodEndDate = Arr::get($budget, 'period_end.0.date', '');
                $getArrayPeriodStartDate = Arr::get($array, $getBudgetBudgetType . '.period_start', '');
                $getArrayPeriodEndDate = Arr::get($array, $getBudgetBudgetType . '.period_end', '');

                if (!array_key_exists($getBudgetBudgetType, $array)) {
                    $array[$getBudgetBudgetType] = [
                        'id' => $key,
                        'budget_status' => $getBudgetBudgetStatus,
                        'period_start' => $getBudgetPeriodStartDate,
                        'period_end' => $getBudgetPeriodEndDate,
                    ];
                } elseif (
                    isDate($getBudgetPeriodStartDate) && isDate($getBudgetPeriodEndDate) && (
                        $getBudgetPeriodStartDate === $getArrayPeriodStartDate
                        || $getBudgetPeriodEndDate === $getArrayPeriodEndDate
                        || Carbon::parse($getBudgetPeriodStartDate)->betweenIncluded($getArrayPeriodStartDate, $getArrayPeriodEndDate)
                        || Carbon::parse($getBudgetPeriodEndDate)->betweenIncluded($getArrayPeriodStartDate, $getArrayPeriodEndDate)
                    )
                ) {
                    if (
                        empty($ids) ||
                        !in_array(Arr::get($array, Arr::get($budget, 'budget_type', '1') . '.id'), Arr::get($ids, Arr::get($budget, 'budget_type', '1'), []), true)
                    ) {
                        $ids[Arr::get($budget, 'budget_type', '1')][] = Arr::get(
                            $array,
                            Arr::get($budget, 'budget_type', '1') . '.id'
                        );
                    }
                    $ids[Arr::get($budget, 'budget_type', '1')][] = $key;
                }
            }
        }

        return $ids;
    }

    /**
     * Sets default values for budget status and type if not provided.
     * @param $budgets
     *
     * @return array
     */
    public function setBudgets($budgets): array
    {
        if (count($budgets)) {
            foreach ($budgets as $key => $budget) {
                $budgets[$key]['budget_status'] = !empty(Arr::get($budget, 'budget_status', '1')) ? Arr::get(
                    $budget,
                    'budget_status',
                    '1'
                ) : '1';
                $budgets[$key]['budget_type'] = !empty(Arr::get($budget, 'budget_type', '1')) ? Arr::get(
                    $budget,
                    'budget_type',
                    '1'
                ) : '1';
            }
        }

        return $budgets;
    }

    /**
     * Checks if revised budgets are valid.
     *
     * @param $budgets
     *
     * @return array
     *
     * @throws \JsonException
     */
    public function checkRevisedBudgets($budgets): array
    {
        $ids = [];
        $originalBudgets = [];

        foreach (getCodeList('BudgetStatus', 'Activity', false) as $statusKey => $budgetStatus) {
            $originalBudgets[$statusKey] = [];
        }

        if (count($budgets)) {
            foreach ($budgets as $key => $budget) {
                if (Arr::get($budget, 'budget_type', '1') === '1') {
                    $originalBudgets[Arr::get($budget, 'budget_type', '1')][] = [
                        'id' => $key,
                        'period_start' => Arr::get($budget, 'period_start.0.date', ''),
                        'period_end' => Arr::get($budget, 'period_end.0.date', ''),
                    ];
                }
            }

            foreach ($budgets as $key => $budget) {
                if ((Arr::get($budget, 'budget_type', '1') === '2')) {
                    $valid = false;

                    foreach ($originalBudgets[1] as $originalBudget) {
                        if (
                            $originalBudget['period_start'] === Arr::get($budget, 'period_start.0.date', '') &&
                            $originalBudget['period_end'] === Arr::get($budget, 'period_end.0.date', '')
                        ) {
                            $valid = true;
                        }
                    }

                    if (!$valid) {
                        $ids[Arr::get($budget, 'budget_type', '1')][] = $key;

                        foreach ($originalBudgets[Arr::get($budget, 'budget_type', '1')] as $originalBudget) {
                            $ids[Arr::get($budget, 'budget_type', '1')][] = $originalBudget['id'];
                        }
                    }
                }
            }
        }

        return $ids;
    }

    /**
     * Checks if narrative is empty.
     *
     * @param $narratives
     *
     * @return bool
     */
    public function isNarrativeEmpty($narratives): bool
    {
        if (count($narratives)) {
            foreach ($narratives as $narrative) {
                if (!empty(Arr::get($narrative, 'narrative', '')) || !empty(Arr::get($narrative, 'language', ''))) {
                    return false;
                }
            }
        }

        return true;
    }

    /**
     * Checks if element is empty.
     *
     * @param $components
     * @param $elementFieldName
     *
     * @return bool
     */
    public function isElementEmpty($components, $elementFieldName): bool
    {
        if (count($components)) {
            foreach ($components as $component) {
                if (!$this->isNarrativeEmpty(Arr::get($component, 'narrative', []))) {
                    return false;
                }

                foreach ($this->$elementFieldName as $componentField) {
                    if (!empty(Arr::get($component, $componentField, ''))) {
                        return false;
                    }
                }
            }
        }

        return true;
    }
}
