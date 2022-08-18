<?php

namespace App\Http\Controllers\Admin\Activity;

use App\Http\Controllers\Controller;
use App\Http\Requests\Activity\Result\ResultRequest;
use App\IATI\Services\Activity\ActivityService;
use App\IATI\Services\Activity\ResultService;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;

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
     * @param ResultService   $resultService
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
        } catch (\Exception $e) {
            logger()->error($e->getMessage());

            return redirect()->route('admin.activity.result.index', $activityId)->with(
                'error',
                'Error has occurred while rendering activity transactions listing.'
            );
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
                'message' => 'Results fetched successfully',
                'data'    => $result,
            ]);
        } catch (\Exception $e) {
            logger()->error($e->getMessage());

            return response()->json(['success' => false, 'message' => 'Error occurred while fetching the data']);
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
            $data = ['core' => $element['criteria'] ?? false, 'status' => false, 'title' => $element['label'], 'name' => 'result'];

            return view('admin.activity.result.edit', compact('form', 'activity', 'data'));
        } catch (\Exception $e) {
            logger()->error($e->getMessage());

            return redirect()->route('admin.activity.result.index', $id)->with(
                'error',
                'Error has occurred while rendering activity result form.'
            );
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
                'result'      => $resultData,
            ]);

            return redirect()->route('admin.activity.result.show', [$activityId, $result['id']])->with(
                'success',
                'Activity result created successfully.'
            );
        } catch (\Exception $e) {
            logger()->error($e->getMessage());

            return redirect()->route('admin.activity.result.index', $activityId)->with(
                'error',
                'Error has occurred while creating activity result.'
            );
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
            $types = getResultTypes();

            return view('admin.activity.result.detail', compact('activity', 'result', 'types', 'toast'));
        } catch (\Exception $e) {
            logger()->error($e->getMessage());

            return redirect()->route('admin.activity.result.index', $activityId)->with(
                'error',
                'Error has occurred while rending result detail page.'
            );
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
            $form = $this->resultService->editFormGenerator($activityId, $resultId);
            $data = ['core' => $element['criteria'] ?? false, 'status' => false, 'title' => $element['label'], 'name' => 'result'];

            return view('admin.activity.result.edit', compact('form', 'activity', 'data'));
        } catch (\Exception $e) {
            logger()->error($e->getMessage());

            return redirect()->route('admin.activity.result.index', $activityId)->with(
                'error',
                'Error has occurred while rendering activity result form.'
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
                return redirect()->route('admin.activity.result.index', $activityId)->with(
                    'error',
                    'Error has occurred while updating activity result.'
                );
            }

            return redirect()->route('admin.activity.result.show', [$activityId, $resultId])->with(
                'success',
                'Activity result updated successfully.'
            );
        } catch (\Exception $e) {
            logger()->error($e->getMessage());

            return redirect()->route('admin.activity.result.index', $activityId)->with(
                'error',
                'Error has occurred while updating activity result.'
            );
        }
    }
}
