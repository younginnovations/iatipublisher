<?php

namespace App\Http\Controllers\Admin\Activity;

use App\Http\Controllers\Controller;
use App\Http\Requests\Activity\Result\ResultRequest;
use App\IATI\Models\Activity\Result;
use App\IATI\Services\Activity\ActivityService;
use App\IATI\Services\Activity\ResultService;
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
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($activityId): View|RedirectResponse
    {
        try {
            $activity = $this->activityService->getActivity($activityId);
            $results = $this->resultService->getActivityResult($activityId);
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
     * Show the form for creating a new resource.
     *
     * @param $id
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\RedirectResponse|\Illuminate\Contracts\Foundation\Application
     */
    public function create($id): \Illuminate\Contracts\View\Factory|View|RedirectResponse|\Illuminate\Contracts\Foundation\Application
    {
        try {
            $element = json_decode(file_get_contents(app_path('IATI/Data/elementJsonSchema.json')), true);
            $activity = $this->activityService->getActivity($id);
            $form = $this->resultService->createFormGenerator($id);
            $data = ['core' => $element['result']['criteria'] ?? false, 'status' => false, 'title' => $element['result']['label'], 'name' => 'result'];

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
     * Store a newly created resource in storage.
     *
     * @param ResultRequest $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(ResultRequest $request, $activityId): RedirectResponse
    {
        try {
            $resultData = $request->except(['_token']);
            $result = $this->resultService->create([
                'activity_id' => $activityId,
                'result'      => $resultData,
            ]);

            return redirect()->route('admin.activities.result.show', [$activityId, $result['id']])->with(
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
     * Show the form for editing the specified resource.
     *
     * @param $activityId
     * @param $resultId
     *
     * @return \Illuminate\Contracts\View\View|\Illuminate\Http\RedirectResponse
     */
    public function edit($activityId, $resultId): View|RedirectResponse
    {
        try {
            $element = json_decode(file_get_contents(app_path('IATI/Data/elementJsonSchema.json')), true);
            $activity = $this->activityService->getActivity($activityId);
            $form = $this->resultService->editFormGenerator($resultId, $activityId);
            $data = ['core' => $element['result']['criteria'] ?? false, 'status' => false, 'title' => $element['result']['label'], 'name' => 'result'];

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
     * Update the specified resource in storage.
     *
     * @param $activityId
     * @param $resultId
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(ResultRequest $request, $activityId, $resultId): RedirectResponse
    {
        try {
            $resultData = $request->except(['_method', '_token']);
            $result = $this->resultService->getResult($resultId, $activityId);

            if (!$this->resultService->update([
                'activity_id' => $activityId,
                'result'      => $resultData,
            ], $result)) {
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

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\IATI\Models\Activity\Result $result
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy(Result $result)
    {
        //
    }

    /*
     * Get results of the corresponding activity
     *
     * @param $activityId
     * @param $page
     *
     * @return JsonResponse
     */
    public function getResult($activityId, $page = 1): JsonResponse
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
}
