<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin\Activity;

use App\Http\Controllers\Controller;
use App\Http\Requests\Activity\Indicator\IndicatorRequest;
use App\IATI\Models\Activity\Indicator;
use App\IATI\Services\Activity\ActivityService;
use App\IATI\Services\Activity\IndicatorService;
use App\IATI\Services\Activity\PeriodService;
use App\IATI\Services\Activity\ResultService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

/**
 * IndicatorController Class.
 */
class IndicatorController extends Controller
{
    /**
     * @var ResultService
     */
    protected ResultService $resultService;

    /**
     * @var IndicatorService
     */
    protected IndicatorService $indicatorService;

    /**
     * @var PeriodService
     */
    protected PeriodService $periodService;

    /**
     * @var ActivityService
     */
    protected ActivityService $activityService;

    /**
     * IndicatorController Constructor.
     *
     * @param ResultService $resultService
     * @param IndicatorService $indicatorService
     * @param PeriodService $periodService
     * @param ActivityService $activityService
     */
    public function __construct(
        ResultService $resultService,
        IndicatorService $indicatorService,
        PeriodService $periodService,
        ActivityService $activityService
    ) {
        $this->indicatorService = $indicatorService;
        $this->periodService = $periodService;
        $this->resultService = $resultService;
        $this->activityService = $activityService;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($activityId, $resultId): \Illuminate\Contracts\View\View|\Illuminate\Http\RedirectResponse
    {
        try {
            $activity = $this->activityService->getActivity($activityId);
            $parentData = [
                'result' => [
                    'id'        => $resultId,
                    'title'     => $this->resultService->getResult($resultId)['result']['title'][0]['narrative'],
                ],
            ];
            $indicators = $this->indicatorService->getResultIndicators($resultId);
            $types = getIndicatorTypes();
            $toast = generateToastData();

            return view('admin.activity.indicator.indicator', compact('activity', 'parentData', 'indicators', 'types', 'toast'));
        } catch (\Exception $e) {
            logger()->error($e->getMessage());

            return redirect()->route('admin.activities.result.index', [$activityId, $resultId])->with(
                'error',
                'Error has occurred while rendering activity transactions listing.'
            );
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @param $activityId
     * @param $resultId
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\RedirectResponse|\Illuminate\Contracts\Foundation\Application
     */
    public function create($activityId, $resultId): \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\RedirectResponse|\Illuminate\Contracts\Foundation\Application
    {
        try {
            $element = json_decode(file_get_contents(app_path('IATI/Data/elementJsonSchema.json')), true);
            $activity = $this->activityService->getActivity($activityId);
            $form = $this->indicatorService->createFormGenerator($activityId, $resultId);
            $data = ['core' => $element['indicator']['criteria'] ?? false, 'status' => false, 'title' => $element['indicator']['label'], 'name' => 'indicator'];

            return view('admin.activity.indicator.edit', compact('form', 'activity', 'data'));
        } catch (\Exception $e) {
            logger()->error($e->getMessage());

            return redirect()->route('admin.activities.result.indicator.index', [$activityId, $resultId])->with(
                'error',
                'Error has occurred while rendering indicator form.'
            );
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param IndicatorRequest $request
     * @param $activityId
     * @param $resultId
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request, $activityId, $resultId): \Illuminate\Http\RedirectResponse
    {
        try {
            $indicatorData = $request->except(['_token']);
            $indicator = $this->indicatorService->create([
                'result_id'     => $resultId,
                'indicator'     => $indicatorData,
            ]);

            return redirect()->route('admin.activities.result.indicator.show', [$activityId, $resultId, $indicator['id']])->with(
                'success',
                'Result indicator created successfully.'
            );
        } catch (\Exception $e) {
            logger()->error($e->getMessage());

            return redirect()->route('admin.activities.result.indicator.index', [$activityId, $resultId])->with(
                'error',
                'Error has occurred while creating result indicator.'
            );
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\IATI\Models\Activity\Indicator  $indicator
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\RedirectResponse|\Illuminate\Contracts\Foundation\Application
     */
    public function show($activityId, $resultId, $indicatorId): \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\RedirectResponse|\Illuminate\Contracts\Foundation\Application
    {
        try {
            $activity = $this->activityService->getActivity($activityId);
            $resultTitle = $this->resultService->getResult($resultId, $activityId)['result']['title'];
            $indicator = $this->indicatorService->getResultIndicator($resultId, $indicatorId);
            $period = $this->periodService->getPeriodOfIndicator($indicatorId)->toArray();
            $types = getIndicatorTypes();
            $toast = generateToastData();

            return view('admin.activity.indicator.detail', compact('activity', 'resultTitle', 'indicator', 'period', 'types', 'toast'));
        } catch (\Exception $e) {
            logger()->error($e->getMessage());

            return redirect()->route('admin.activities.result.indicator.index', [$activityId, $resultId])->with(
                'error',
                'Error has occurred while rending result detail page.'
            );
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  $activityId
     * @param $resultId
     * @param $indicatorId
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\RedirectResponse|\Illuminate\Contracts\Foundation\Application
     */
    public function edit($activityId, $resultId, $indicatorId): \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\RedirectResponse|\Illuminate\Contracts\Foundation\Application
    {
        try {
            $element = json_decode(file_get_contents(app_path('IATI/Data/elementJsonSchema.json')), true);
            $activity = $this->activityService->getActivity($activityId);
            $form = $this->indicatorService->editFormGenerator($activityId, $resultId, $indicatorId);
            $data = ['core' => $element['indicator']['criteria'] ?? false, 'status' => false, 'title' => $element['indicator']['label'], 'name' => 'indicator'];

            return view('admin.activity.indicator.edit', compact('form', 'activity', 'data'));
        } catch (\Exception $e) {
            logger()->error($e->getMessage());

            return redirect()->route('admin.activities.result.indicator.index', [$activityId, $resultId])->with(
                'error',
                'Error has occurred while rendering indicator form.'
            );
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param IndicatorRequest $request
     * @param $activityId
     * @param $resultId
     * @param $indicatorId
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(IndicatorRequest $request, $activityId, $resultId, $indicatorId): \Illuminate\Http\RedirectResponse
    {
        try {
            $indicatorData = $request->except(['_method', '_token']);
            $indicator = $this->indicatorService->getResultIndicator($resultId, $indicatorId);

            if (!$this->indicatorService->update([
                'result_id'     => $resultId,
                'indicator'     => $indicatorData,
            ], $indicator)) {
                return redirect()->route('admin.activities.result.indicator.index', [$activityId, $resultId])->with(
                    'error',
                    'Error has occurred while updating result indicator.'
                );
            }

            return redirect()->route('admin.activities.result.indicator.show', [$activityId, $resultId, $indicator['id']])->with(
                'success',
                'Indicator updated successfully.'
            );
        } catch (\Exception $e) {
            logger()->error($e->getMessage());

            return redirect()->route('admin.activities.result.indicator.index', [$activityId, $resultId])->with(
                'error',
                'Error has occurred while updating indicator.'
            );
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\IATI\Models\Activity\Indicator  $indicator
     * @return \Illuminate\Http\Response
     */
    public function destroy(Indicator $indicator)
    {
        //
    }

    /*
     * Get indicator of the corresponding activity
     *
     * @param $activityId
     * @param $resultId
     * @param $page
     *
     * @return JsonResponse
     */
    public function getIndicator($activityId, $resultId, $page = 1): JsonResponse
    {
        try {
            $indicator = $this->indicatorService->getPaginatedIndicator($resultId, $page);

            return response()->json([
                'success' => true,
                'message' => 'Indicators fetched successfully',
                'data'    => $indicator,
            ]);
        } catch (\Exception $e) {
            logger()->error($e->getMessage());

            return response()->json(['success' => false, 'message' => 'Error occurred while fetching the data']);
        }
    }
}
