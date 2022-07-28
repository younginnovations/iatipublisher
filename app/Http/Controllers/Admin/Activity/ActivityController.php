<?php

namespace App\Http\Controllers\Admin\Activity;

use App\Http\Controllers\Controller;
use App\Http\Requests\Activity\ActivityCreateRequest;
use App\IATI\Models\Activity\Activity;
use App\IATI\Services\Activity\ActivityService;
use App\IATI\Services\Activity\ResultService;
use App\IATI\Services\Activity\TransactionService;
use Exception;
use Illuminate\Contracts\View\View;
use Illuminate\Database\DatabaseManager;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

/**
 * Class ActivityController.
 */
class ActivityController extends Controller
{
    /**
     * @var ActivityService
     */
    protected ActivityService $activityService;

    /**
     * @var DatabaseManager
     */
    protected DatabaseManager $db;

    /**
     * @var ResultService
     */
    protected ResultService $resultService;

    /**
     * @var TransactionService
     */
    protected TransactionService $transactionService;

    /**
     * ActivityController Constructor.
     *
     * @param ActivityService $activityService
     * @param DatabaseManager $db
     * @param ResultService $resultService
     * @param TransactionService $transactionService
     */
    public function __construct(ActivityService $activityService, DatabaseManager $db, ResultService $resultService, TransactionService $transactionService)
    {
        $this->activityService = $activityService;
        $this->db = $db;
        $this->resultService = $resultService;
        $this->transactionService = $transactionService;
    }

    /**
     * Display a listing of the resource.
     *
     * @return View|JsonResponse
     */
    public function index(): View|JsonResponse
    {
        try {
            $languages = getCodeListArray('Languages', 'ActivityArray');

            return view('admin.activity.index', compact('languages'));
        } catch (Exception $e) {
            logger()->error($e->getMessage());

            return response()->json(['success' => false, 'error' => 'Error has occurred while fetching activities.']);
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return void
     */
    public function create(): void
    {
        //
    }

    /*
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     *
     * @return JsonResponse
     */
    public function store(ActivityCreateRequest $request): JsonResponse
    {
        try {
            $input = $request->all();

            $this->db->beginTransaction();
            $activity = $this->activityService->store($input);
            $this->db->commit();

            return response()->json([
                'success' => true,
                'message' => 'Activity created successfully.',
                'data'    => $activity,
            ]);
        } catch (Exception $e) {
            logger()->error($e->getMessage());

            return response()->json(['success' => false, 'error' => 'Error has occurred while saving activity.']);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param Activity $activity
     *
     * @return View|JsonResponse|RedirectResponse
     */
    public function show(Activity $activity): View|JsonResponse|RedirectResponse
    {
        try {
            if ($activity['org_id'] !== Auth::user()->organization_id) {
                return redirect()->route('admin.activities.index');
            }

            $toast['message'] = Session::exists('error') ? Session::get('error') : (Session::exists('success') ? Session::get('success') : '');
            $toast['type'] = Session::exists('error') ? false : 'success';
            Session::forget('success');
            Session::forget('error');
            $elements = json_decode(file_get_contents(app_path('IATI/Data/elementJsonSchema.json')), true);
            $elementGroups = json_decode(file_get_contents(app_path('Data/Activity/ElementGroup.json')), true);
            $types = $this->getActivityDetailDataType();
            $status = $this->getActivityDetailStatus($activity);
            $results = $this->resultService->getActivityResultsWithIndicatorsAndPeriods($activity->id);
            $transactions = $this->transactionService->getActivityTransactions($activity->id);
            $progress = 75;
            $hasIndicator = 0;
            $hasPeriod = 0;

            if (count($results)) {
                foreach ($results as $result) {
                    if (count($result->indicators)) {
                        $hasIndicator = 1;

                        foreach ($result->indicators as $indicator) {
                            if (count($indicator->periods)) {
                                $hasPeriod = 1;
                                break;
                            }
                        }
                    }
                }
            }

            return view(
                'admin.activity.show',
                compact('elements', 'elementGroups', 'progress', 'activity', 'toast', 'types', 'status', 'results', 'hasIndicator', 'hasPeriod', 'transactions')
            );
        } catch (Exception $e) {
            logger()->error($e->getMessage());

            return response()->json(['success' => false, 'error' => 'Error has occurred rendering activity detail page']);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     *
     * @param Activity $activity
     *
     * @return void
     */
    public function edit(Activity $activity): void
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param Activity $activity
     *
     * @return void
     */
    public function update(Request $request, Activity $activity): void
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Activity $activity
     *
     * @return void
     */
    public function destroy(Activity $activity): void
    {
        //
    }

    /*
     * Get activities of the corresponding organization
     *
     * @return JsonResponse
     */
    public function getActivities($page = 1): JsonResponse
    {
        try {
            $activities = $this->activityService->getPaginatedActivities($page);

            return response()->json([
                'success' => true,
                'message' => 'Activities fetched successfully',
                'data'    => $activities,
            ]);
        } catch (\Exception $e) {
            logger()->error($e->getMessage());

            return response()->json(['success' => false, 'message' => 'Error occurred while fetching the data']);
        }
    }

    /*
    * Get languages
    *
    * @return JsonResponse
    */
    public function getLanguagesOrganization(): JsonResponse
    {
        try {
            $languages = getCodeListArray('Languages', 'ActivityArray');
            $organization = Auth::user()->organization;

            return response()->json([
                'success' => true,
                'message' => 'Languages fetched successfully',
                'data'    => [
                    'languages'    => $languages,
                    'organization' => $organization,
                ],
            ]);
        } catch (Exception $e) {
            logger()->error($e->getMessage());

            return response()->json(['success' => false, 'message' => 'Error occurred while fetching the data']);
        }
    }

    /*
    * Get activity detail data type
    *
    * @return array
    */
    public function getActivityDetailDataType(): array
    {
        return [
            'languages'                   => getCodeListArray('Languages', 'ActivityArray'),
            'activityDate'                => getCodeList('ActivityDateType', 'Activity'),
            'activityScope'               => getCodeList('ActivityScope', 'Activity'),
            'activityStatus'              => getCodeList('ActivityStatus', 'Activity'),
            'aidType'                     => getCodeList('AidType', 'Activity'),
            'aidTypeVocabulary'           => getCodeList('AidTypeVocabulary', 'Activity'),
            'collaborationType'           => getCodeList('CollaborationType', 'Activity'),
            'conditionType'               => getCodeList('ConditionType', 'Activity'),
            'financeType'                 => getCodeList('FinanceType', 'Activity'),
            'flowType'                    => getCodeList('FlowType', 'Activity'),
            'relatedActivityType'         => getCodeList('RelatedActivityType', 'Activity'),
            'tiedStatus'                  => getCodeList('TiedStatus', 'Activity'),
            'descriptionType'             => getCodeList('DescriptionType', 'Activity'),
            'humanitarianScopeType'       => getCodeList('HumanitarianScopeType', 'Activity'),
            'humanitarianScopeVocabulary' => getCodeList('HumanitarianScopeVocabulary', 'Activity'),
            'aidTypeVocabulary'           => getCodeList('AidTypeVocabulary', 'Activity'),
            'earmarkingCategory'          => getCodeList('EarmarkingCategory', 'Activity'),
            'earmarkingModality'          => getCodeList('EarmarkingModality', 'Activity'),
            'cashandVoucherModalities'    => getCodeList('CashandVoucherModalities', 'Activity'),
            'budgetIdentifierVocabulary'  => getCodeList('BudgetIdentifierVocabulary', 'Activity'),
            'sectorVocabulary'            => getCodeList('SectorVocabulary', 'Activity'),
            'sectorCode'                  => getCodeList('SectorCode', 'Activity'),
            'sectorCategory'              => getCodeList('SectorCategory', 'Activity'),
            'sdgGoals'                    => getCodeList('UNSDG-Goals', 'Activity'),
            'sdgTarget'                   => getCodeList('UNSDG-Targets', 'Activity'),
            'regionVocabulary'            => getCodeList('RegionVocabulary', 'Activity'),
            'region'                      => getCodeList('Region', 'Activity'),
            'policyMarkerVocabulary'      => getCodeList('PolicyMarkerVocabulary', 'Activity'),
            'policySignificance'          => getCodeList('PolicySignificance', 'Activity'),
            'policyMarker'                => getCodeList('PolicyMarker', 'Activity'),
            'tagVocabulary'               => getCodeList('TagVocabulary', 'Activity'),
            'budgetType'                  => getCodeList('BudgetType', 'Activity'),
            'budgetStatus'                => getCodeList('BudgetStatus', 'Activity'),
            'otherIdentifierType'         => getCodeList('OtherIdentifierType', 'Activity'),
            'contactType'                 => getCodeList('ContactType', 'Activity'),
            'country'                     => getCodeList('Country', 'Activity'),
            'locationType'                => getCodeList('LocationType', 'Activity'),
            'currency'                    => getCodeList('Currency', 'Activity'),
            'geographicVocabulary'        => getCodeList('GeographicVocabulary', 'Activity'),
            'budgetIdentifier'            => getCodeList('BudgetIdentifier', 'Activity'),
            'organizationType'            => getCodeList('OrganizationType', 'Organization'),
            'geographicLocationReach'     => getCodeList('GeographicLocationReach', 'Activity'),
            'organisationRole'            => getCodeList('OrganisationRole', 'Organization'),
            'documentCategory'            => getCodeList('DocumentCategory', 'Activity'),
            'geographicExactness'         => getCodeList('GeographicExactness', 'Activity'),
            'geographicLocationClass'     => getCodeList('GeographicLocationClass', 'Activity'),
            'resultType'                  => getCodeList('ResultType', 'Activity'),
            'transactionType'             => getCodeList('TransactionType', 'Activity'),
        ];
    }

    /**
     * Returns array containing activity detail status.
     *
     * @param Activity $activity
     *
     * @return array
     */
    public function getActivityDetailStatus($activity): array
    {
        return [
            'iati_identifier'           => $activity->identifier_element_completed,
            'title'                => $activity->title_element_completed,
            'description'          => $activity->description_element_completed,
            'activity_status'      => $activity->activity_status_element_completed,
            'activity_date'        => $activity->activity_date_element_completed,
            'activity_scope'       => $activity->activity_scope_element_completed,
            'recipient_country'    => $activity->recipient_country_element_completed,
            'recipient_region'     => $activity->recipient_region_element_completed,
            'collaboration_type'   => $activity->collaboration_type_element_completed,
            'default_finance_type' => $activity->default_finance_type_element_completed,
            'default_aid_type'     => $activity->default_aid_type_element_completed,
            'default_tied_status'  => $activity->default_tied_status_element_completed,
            'capital_spend'        => $activity->capital_spend_element_completed,
            'related_activity'     => $activity->related_activity_element_completed,
            'sector'               => $activity->sector_element_completed,
            'humanitarian_scope'   => $activity->humanitarian_scope_element_completed,
            'legacy_data'          => $activity->legacy_data_element_completed,
            'tag'                  => $activity->tag_element_completed,
            'policy_marker'        => $activity->policy_marker_element_completed,
            'other_identifier'     => $activity->other_identifier_element_completed,
            'country_budget_items' => $activity->country_budget_items_element_completed,
            'budget'               => $activity->budget_element_completed,
        ];
    }
}
