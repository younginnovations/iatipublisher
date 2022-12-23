<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin\Activity;

use App\Http\Controllers\Controller;
use App\Http\Requests\Activity\ActivityCreateRequest;
use App\IATI\Models\Activity\Activity;
use App\IATI\Services\Activity\ActivityService;
use App\IATI\Services\Activity\ResultService;
use App\IATI\Services\Activity\TransactionService;
use App\IATI\Services\Organization\OrganizationService;
use App\IATI\Services\Validator\ActivityValidatorResponseService;
use Exception;
use Illuminate\Contracts\View\View;
use Illuminate\Database\DatabaseManager;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
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
     * @var ActivityValidatorResponseService
     */
    protected ActivityValidatorResponseService $activityValidatorResponseService;

    /**
     * @var OrganizationService
     */
    private OrganizationService $organizationService;

    /**
     * ActivityController Constructor.
     *
     * @param ActivityService                  $activityService
     * @param DatabaseManager                  $db
     * @param ResultService                    $resultService
     * @param TransactionService               $transactionService
     * @param ActivityValidatorResponseService $activityValidatorResponseService
     * @param OrganizationService              $organizationService
     */
    public function __construct(
        ActivityService $activityService,
        DatabaseManager $db,
        ResultService $resultService,
        TransactionService $transactionService,
        ActivityValidatorResponseService $activityValidatorResponseService,
        OrganizationService $organizationService
    ) {
        $this->activityService = $activityService;
        $this->db = $db;
        $this->resultService = $resultService;
        $this->transactionService = $transactionService;
        $this->activityValidatorResponseService = $activityValidatorResponseService;
        $this->organizationService = $organizationService;
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
            $toast = generateToastData();

            return view('admin.activity.index', compact('languages', 'toast'));
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

    /**
     * Store a newly created resource in storage.
     *
     * @param ActivityCreateRequest $request
     *
     * @return JsonResponse
     * @throws \Throwable
     */
    public function store(ActivityCreateRequest $request): JsonResponse
    {
        try {
            $input = $request->all();

            $this->db->beginTransaction();
            $activity = $this->activityService->store($input);
            $this->db->commit();
            Session::put('success', 'Activity has been created successfully.');

            return response()->json([
                'success' => true,
                'message' => 'Activity created successfully.',
                'data'    => $activity,
            ]);
        } catch (Exception $e) {
            logger()->error($e->getMessage());

            return response()->json(['success' => false, 'message' => 'Error has occurred while saving activity.', 'data' => []]);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param $id
     *
     * @return View|JsonResponse|RedirectResponse
     */
    public function show($id): View|JsonResponse|RedirectResponse
    {
        try {
            $toast = generateToastData();
            $activity = $this->activityService->getActivity($id);
            $elements = readElementJsonSchema();
            $elementGroups = readElementGroup();
            $types = $this->getActivityDetailDataType();
            $results = $this->resultService->getActivityResultsWithIndicatorsAndPeriods($activity->id);
            $hasIndicatorPeriod = $this->resultService->checkResultIndicatorPeriod($results);
            $transactions = $this->transactionService->getActivityTransactions($activity->id);
            $status = $activity->element_status;
            $status['transactions'] = $transactions->count() === 0 ? false : Arr::get($status, 'transactions', false);
            $status['result'] = $results->count() === 0 ? false : Arr::get($status, 'result', false);
            $progress = $this->activityService->activityPublishingProgress($activity);
            $coreCompleted = isCoreElementCompleted(array_merge(['reporting_org' => $activity->organization->reporting_org_element_completed], $activity->element_status));
            $validatorResponse = $this->activityValidatorResponseService->getValidatorResponse($id);
            $organization_identifier = $activity->organization->identifier;
            $activity->iati_identifier = [
                'activity_identifier' => $activity->iati_identifier['activity_identifier'],
                'iati_identifier_text' => $activity->organization->identifier . '-' . $activity->iati_identifier['activity_identifier'],
            ];
            $iatiValidatorResponse = $validatorResponse->response ?? null;

            return view(
                'admin.activity.show',
                compact('elements', 'elementGroups', 'progress', 'activity', 'toast', 'types', 'status', 'results', 'hasIndicatorPeriod', 'transactions', 'coreCompleted', 'iatiValidatorResponse', 'organization_identifier')
            );
        } catch (Exception $e) {
            logger()->error($e->getMessage());

            return redirect()->route('admin.activities.index')->with('error', 'Error has occurred while opening activity detail page.');
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
     * @param Request  $request
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
     * @param $activityId
     *
     * @return JsonResponse
     */
    public function destroy($activityId): JsonResponse
    {
        try {
            $activity = $this->activityService->getActivity($activityId);

            if ($activity->linked_to_iati) {
                Session::put('error', 'Activity must be un-published before deleting.');

                return response()->json(['success' => false, 'message' => 'Activity must be un-published before deleting.']);
            }

            if ($this->activityService->deleteActivity($activity)) {
                Session::put('success', 'Activity has been deleted successfully.');

                return response()->json(['success' => true, 'message' => 'Activity has been deleted successfully.']);
            }

            return response()->json(['success' => false, 'message' => 'Activity delete failed.']);
        } catch (\Exception $e) {
            logger()->error($e->getMessage());

            return response()->json(['success' => false, 'message' => $e->getMessage()]);
        }
    }

    /**
     * Sanitizes the request for removing code injections.
     *
     * @param $request
     *
     * @return array
     */
    public function sanitizeRequest($request): array
    {
        $tableConfig = getTableConfig('activity');
        $queryParams = [];

        if (!empty($request->get('q')) || $request->get('q') === '0') {
            $queryParams['query'] = $request->get('q');
        }

        if (in_array($request->get('orderBy'), $tableConfig['orderBy'], true)) {
            $queryParams['orderBy'] = $request->get('orderBy');

            if (in_array($request->get('direction'), $tableConfig['direction'], true)) {
                $queryParams['direction'] = $request->get('direction');
            }
        }

        return $queryParams;
    }

    /**
     * @param Request $request
     * @param int     $page
     *
     * @return JsonResponse
     */
    public function getPaginatedActivities(Request $request, int $page = 1): JsonResponse
    {
        try {
            $activities = $this->activityService->getPaginatedActivities($page, $this->sanitizeRequest($request));

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

    /**
     * Get activity detail data type.
     *
     * @return array
     * @throws \JsonException
     */
    public function getActivityDetailDataType(): array
    {
        return [
            'languages'                   => getCodeListArray('Languages', 'ActivityArray', false),
            'activityDate'                => getCodeList('ActivityDateType', 'Activity', false),
            'activityScope'               => getCodeList('ActivityScope', 'Activity', false),
            'activityStatus'              => getCodeList('ActivityStatus', 'Activity', false),
            'aidType'                     => getCodeList('AidType', 'Activity', false),
            'aidTypeVocabulary'           => getCodeList('AidTypeVocabulary', 'Activity', false),
            'collaborationType'           => getCodeList('CollaborationType', 'Activity', false),
            'conditionType'               => getCodeList('ConditionType', 'Activity', false),
            'financeType'                 => getCodeList('FinanceType', 'Activity', false),
            'flowType'                    => getCodeList('FlowType', 'Activity', false),
            'relatedActivityType'         => getCodeList('RelatedActivityType', 'Activity', false),
            'tiedStatus'                  => getCodeList('TiedStatus', 'Activity', false),
            'descriptionType'             => getCodeList('DescriptionType', 'Activity', false),
            'humanitarianScopeType'       => getCodeList('HumanitarianScopeType', 'Activity', false),
            'humanitarianScopeVocabulary' => getCodeList('HumanitarianScopeVocabulary', 'Activity', false),
            'earmarkingCategory'          => getCodeList('EarmarkingCategory', 'Activity', false),
            'earmarkingModality'          => getCodeList('EarmarkingModality', 'Activity', false),
            'cashandVoucherModalities'    => getCodeList('CashandVoucherModalities', 'Activity', false),
            'budgetIdentifierVocabulary'  => getCodeList('BudgetIdentifierVocabulary', 'Activity', false),
            'sectorVocabulary'            => getCodeList('SectorVocabulary', 'Activity', false),
            'sectorCode'                  => getCodeList('SectorCode', 'Activity', false),
            'sectorCategory'              => getCodeList('SectorCategory', 'Activity', false),
            'sdgGoals'                    => getCodeList('UNSDG-Goals', 'Activity', false),
            'sdgTarget'                   => getCodeList('UNSDG-Targets', 'Activity', false),
            'regionVocabulary'            => getCodeList('RegionVocabulary', 'Activity', false),
            'region'                      => getCodeList('Region', 'Activity', false),
            'policyMarkerVocabulary'      => getCodeList('PolicyMarkerVocabulary', 'Activity', false),
            'policySignificance'          => getCodeList('PolicySignificance', 'Activity', false),
            'policyMarker'                => getCodeList('PolicyMarker', 'Activity', false),
            'tagVocabulary'               => getCodeList('TagVocabulary', 'Activity', false),
            'budgetType'                  => getCodeList('BudgetType', 'Activity', false),
            'budgetStatus'                => getCodeList('BudgetStatus', 'Activity', false),
            'otherIdentifierType'         => getCodeList('OtherIdentifierType', 'Activity', false),
            'contactType'                 => getCodeList('ContactType', 'Activity', false),
            'country'                     => getCodeList('Country', 'Activity', false),
            'locationType'                => getCodeList('LocationType', 'Activity', false),
            'currency'                    => getCodeList('Currency', 'Activity', false),
            'geographicVocabulary'        => getCodeList('GeographicVocabulary', 'Activity', false),
            'budgetIdentifier'            => getCodeList('BudgetIdentifier', 'Activity', false),
            'organizationType'            => getCodeList('OrganizationType', 'Organization', false),
            'geographicLocationReach'     => getCodeList('GeographicLocationReach', 'Activity', false),
            'organisationRole'            => getCodeList('OrganisationRole', 'Organization', false),
            'documentCategory'            => getCodeList('DocumentCategory', 'Activity', false),
            'geographicExactness'         => getCodeList('GeographicExactness', 'Activity', false),
            'geographicLocationClass'     => getCodeList('GeographicLocationClass', 'Activity', false),
            'resultType'                  => getCodeList('ResultType', 'Activity', false),
            'transactionType'             => getCodeList('TransactionType', 'Activity', false),
            'crsChannelCode'              => getCodeList('CRSChannelCode', 'Activity', false),
        ];
    }
}
