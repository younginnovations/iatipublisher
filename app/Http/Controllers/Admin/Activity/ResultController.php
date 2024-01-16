<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin\Activity;

use App\Http\Controllers\Controller;
use App\Http\Requests\Activity\Result\ResultRequest;
use App\IATI\Services\Activity\ActivityService;
use App\IATI\Services\Activity\ResultService;
use Exception;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Session;

/**
 * Class ResultController.
 */
class ResultController extends Controller
{
    /**
     * @var ResultService
     */
    protected ResultService $resultService;

    /**
     * @var ActivityService
     */
    protected ActivityService $activityService;

    /**
     * ResultController Constructor.
     *
     * @param ResultService $resultService
     * @param ActivityService $activityService
     */
    public function __construct(
        ResultService $resultService,
        ActivityService $activityService
    ) {
        $this->resultService = $resultService;
        $this->activityService = $activityService;
    }

    /**
     * Renders result listing page.
     *
     * @param $activityId
     *
     * @return View|RedirectResponse
     */
    public function index($activityId): View|RedirectResponse
    {
        try {
            $activity = $this->activityService->getActivity($activityId);
            $results = $this->resultService->getActivityResults($activityId);
            $types = getResultTypes();
            $toast = generateToastData();

            return view('admin.activity.result.index', compact('activity', 'results', 'types', 'toast'));
        } catch (Exception $e) {
            logger()->error($e->getMessage());

            return redirect()->route('admin.activity.result.index', $activityId)
                ->with('error', translateErrorHasOccurred('responses.activity_transactions_listing', 'rendering', 'form'));
        }
    }

    /**
     * Returns paginated results.
     *
     * @param int $activityId
     * @param int $page
     *
     * @return JsonResponse
     */
    public function getPaginatedResults(int $activityId, int $page = 1): JsonResponse
    {
        try {
            $result = $this->resultService->getPaginatedResult($activityId, $page);

            return response()->json([
                'success' => true,
                'message' => translateElementSuccessfully('results', 'fetched'),
                'data' => $result,
            ]);
        } catch (Exception $e) {
            logger()->error($e->getMessage());

            return response()->json(['success' => false, 'message' => translateErrorHasOccurred('responses.the_data', 'fetching')]);
        }
    }

    /**
     * Renders result create form.
     *
     * @param $id
     *
     * @return Factory|View|RedirectResponse|Application
     */
    public function create($id): Factory|View|RedirectResponse|Application
    {
        try {
            $element = getElementSchema('result');
            $activity = $this->activityService->getActivity($id);
            $form = $this->resultService->createFormGenerator($id);
            $data = ['title' => $element['label'], 'name' => 'result'];

            return view('admin.activity.result.edit', compact('form', 'activity', 'data'));
        } catch (Exception $e) {
            logger()->error($e->getMessage());

            return redirect()->route('admin.activity.result.index', $id)
                ->with('error', translateErrorHasOccurred('elements_common.result', 'rendering', 'form'));
        }
    }

    /**
     * Saves new result.
     *
     * @param ResultRequest $request
     * @param               $activityId
     *
     * @return RedirectResponse
     */
    public function store(ResultRequest $request, $activityId): RedirectResponse
    {
        try {
            $resultData = $request->except(['_token']);
            $result = $this->resultService->create([
                'activity_id' => $activityId,
                'result' => $resultData,
            ]);

            return redirect()->route('admin.activity.result.show', [$activityId, $result['id']])
                ->with('success', translateElementSuccessfully('activity_result', 'created'));
        } catch (Exception $e) {
            logger()->error($e->getMessage());

            return redirect()->route('admin.activity.result.index', $activityId)
                ->with('error', translateErrorHasOccurred('responses.activity_result', 'creating'));
        }
    }

    /**
     * Display the specified resource.
     *
     * @param $activityId
     * @param $resultId
     *
     * @return View|RedirectResponse
     */
    public function show($activityId, $resultId): View|RedirectResponse
    {
        try {
            $toast = generateToastData();
            $activity = $this->activityService->getActivity($activityId);
            $result = $this->resultService->getResultWithIndicatorAndPeriod($resultId, $activityId);
            $element = translateJsonValues(getElementSchema('result'));
            $types = getResultTypes();

            return view('admin.activity.result.detail', compact('activity', 'result', 'types', 'toast', 'element'));
        } catch (Exception $e) {
            logger()->error($e->getMessage());

            return redirect()->route('admin.activity.result.index', $activityId)
                ->with('error', translateErrorHasOccurred('responses.result_detail', 'rendering', 'page'));
        }
    }

    /**
     * Renders result edit page.
     *
     * @param $activityId
     * @param $resultId
     *
     * @return View|RedirectResponse
     */
    public function edit($activityId, $resultId): View|RedirectResponse
    {
        try {
            $element = getElementSchema('result');
            $activity = $this->activityService->getActivity($activityId);
            $form = $this->resultService->editFormGenerator($resultId, $activityId);
            $data = ['title' => $element['label'], 'name' => 'result'];

            return view('admin.activity.result.edit', compact('form', 'activity', 'data'));
        } catch (Exception $e) {
            logger()->error($e->getMessage());

            return redirect()->route('admin.activity.result.index', $activityId)
                ->with(
                    'error',
                    translateErrorHasOccurred('responses.activity_result', 'rendering')
                );
        }
    }

    /**
     * Updates specific result.
     *
     * @param ResultRequest $request
     * @param               $activityId
     * @param               $resultId
     *
     * @return RedirectResponse
     */
    public function update(ResultRequest $request, $activityId, $resultId): RedirectResponse
    {
        try {
            $resultData = $request->except(['_method', '_token']);

            if (!$this->resultService->update($resultId, ['activity_id' => $activityId, 'result' => $resultData])) {
                return redirect()->route('admin.activity.result.index', $activityId)
                    ->with('error', translateErrorHasOccurred('responses.activity_result', 'updating'));
            }

            return redirect()->route('admin.activity.result.show', [$activityId, $resultId])
                ->with('success', translateElementSuccessfully('activity_result', 'updated'));
        } catch (Exception $e) {
            logger()->error($e->getMessage());

            return redirect()->route('admin.activity.result.index', $activityId)
                ->with('error', translateErrorHasOccurred('responses.activity_result', 'updating'));
        }
    }

    /**
     * Deletes Specific Result.
     *
     * @param $id
     * @param $resultId
     *
     * @return JsonResponse
     */
    public function destroy($id, $resultId): JsonResponse
    {
        try {
            $this->resultService->deleteResult($resultId);
            Session::flash('success', translateElementSuccessfully('result', 'deleted'));

            return response()->json([
                'status' => true,
                'msg' => translateElementSuccessfully('result', 'deleted'),
                'activity_id' => $id,
            ]);
        } catch (Exception $e) {
            logger()->error($e->getMessage());
            Session::flash('error', translateElementDeleteError('elements_common.result'));

            return response()->json([
                'status' => true,
                'msg' => translateElementDeleteError('elements_common.result'),
                'activity_id' => $id,
            ], 400);
        }
    }
}
