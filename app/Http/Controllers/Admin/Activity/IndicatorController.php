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
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
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
     * @param ResultService    $resultService
     * @param IndicatorService $indicatorService
     * @param PeriodService    $periodService
     * @param ActivityService  $activityService
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
    public function index($activityId, $resultId): View|RedirectResponse
    {
        try {
            $activity = $this->activityService->getActivity($activityId);
            $parentData = [
                'result' => [
                    'id'    => $resultId,
                    'title' => $this->resultService->getResult($resultId)['result']['title'][0]['narrative'],
                ],
            ];
            $indicators = $this->indicatorService->getResultIndicators($resultId);
            $types = getIndicatorTypes();
            $toast = generateToastData();

            return view('admin.activity.indicator.indicator', compact('activity', 'parentData', 'indicators', 'types', 'toast'));
        } catch (\Exception $e) {
            logger()->error($e->getMessage());

            return redirect()->route('admin.activity.result.index', [$activityId, $resultId])->with(
                'error',
                'Error has occurred while rendering activity transactions listing.'
            );
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @param $resultId
     *
     * @return Factory|View|RedirectResponse|Application
     */
    public function create($resultId): Factory|View|RedirectResponse|Application
    {
        try {
            $element = json_decode(json: file_get_contents(app_path('IATI/Data/elementJsonSchema.json')), associative: true, depth: 512, flags: JSON_THROW_ON_ERROR);
            $result = $this->resultService->getResult($resultId);
            $activity = $result->activity;
            $form = $this->indicatorService->createFormGenerator($activity->id, $resultId);
            $data = ['core' => $element['indicator']['criteria'] ?? false, 'status' => false, 'title' => $element['indicator']['label'], 'name' => 'indicator'];

            return view('admin.activity.indicator.edit', compact('form', 'activity', 'data'));
        } catch (\Exception $e) {
            logger()->error($e->getMessage());

            return redirect()->route('admin.result.indicator.index', [$activity->id, $resultId])->with(
                'error',
                'Error has occurred while rendering indicator form.'
            );
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param IndicatorRequest $request
     * @param                  $resultId
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request, $resultId): RedirectResponse
    {
        try {
            $result = $this->resultService->getResult($resultId);
            $indicatorData = $request->except(['_token']);
            $indicator = $this->indicatorService->create([
                'result_id' => $resultId,
                'indicator' => $indicatorData,
            ]);

            return redirect()->route('admin.result.indicator.show', [$result->activity->id, $resultId, $indicator['id']])->with(
                'success',
                'Result indicator created successfully.'
            );
        } catch (\Exception $e) {
            logger()->error($e->getMessage());

            return redirect()->route('admin.result.indicator.index', [$resultId])->with(
                'error',
                'Error has occurred while creating result indicator.'
            );
        }
    }

    /**
     * Display the specified resource.
     *
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\RedirectResponse|\Illuminate\Contracts\Foundation\Application
     */
    public function show($resultId, $indicatorId): Factory|View|RedirectResponse|Application
    {
        try {
            $result = $this->resultService->getResult($resultId);
            $resultTitle = $result['result']['title'];
            $activity = $this->activityService->getActivity($result->activity->id);
            $indicator = $this->indicatorService->getResultIndicator($resultId, $indicatorId);
            $period = $this->periodService->getPeriodOfIndicator($indicatorId)->toArray();
            $types = getIndicatorTypes();
            $toast = generateToastData();

            return view('admin.activity.indicator.detail', compact('activity', 'resultTitle', 'indicator', 'period', 'types', 'toast'));
        } catch (\Exception $e) {
            logger()->error($e->getMessage());

            return redirect()->route('admin.result.indicator.index', [$resultId])->with(
                'error',
                'Error has occurred while rending result detail page.'
            );
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  $resultId
     * @param  $indicatorId
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\RedirectResponse|\Illuminate\Contracts\Foundation\Application
     */
    public function edit(
        $resultId,
        $indicatorId
    ): Factory|View|RedirectResponse|Application {
        try {
            $result = $this->resultService->getResult($resultId);
            $element = json_decode(json: file_get_contents(app_path('IATI/Data/elementJsonSchema.json')), associative: true, depth: 512, flags: JSON_THROW_ON_ERROR);
            $activity = $this->activityService->getActivity($result->activity->id);
            $form = $this->indicatorService->editFormGenerator($result->activity->id, $resultId, $indicatorId);
            $data = ['core' => $element['indicator']['criteria'] ?? false, 'status' => false, 'title' => $element['indicator']['label'], 'name' => 'indicator'];

            return view('admin.activity.indicator.edit', compact('form', 'activity', 'data'));
        } catch (\Exception $e) {
            logger()->error($e->getMessage());

            return redirect()->route('admin.result.indicator.index', [$resultId])->with(
                'error',
                'Error has occurred while rendering indicator form.'
            );
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param IndicatorRequest $request
     * @param                  $resultId
     * @param                  $indicatorId
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(IndicatorRequest $request, $resultId, $indicatorId): RedirectResponse
    {
        try {
            $indicatorData = $request->except(['_method', '_token']);
            $result = $this->resultService->getResult($resultId);
            $indicator = $this->indicatorService->getResultIndicator($resultId, $indicatorId);

            if (!$this->indicatorService->update([
                'result_id' => $resultId,
                'indicator' => $indicatorData,
            ], $indicator)) {
                return redirect()->route('admin.result.indicator.index', [$result->activity->id, $resultId])->with(
                    'error',
                    'Error has occurred while updating result indicator.'
                );
            }

            return redirect()->route('admin.result.indicator.show', [$result->activity->id, $resultId, $indicator['id']])->with(
                'success',
                'Indicator updated successfully.'
            );
        } catch (\Exception $e) {
            logger()->error($e->getMessage());

            return redirect()->route('admin.result.indicator.index', [$resultId])->with(
                'error',
                'Error has occurred while updating indicator.'
            );
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\IATI\Models\Activity\Indicator $indicator
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy(Indicator $indicator)
    {
        //
    }

    /*
     * Get indicator of the corresponding activity
     *
     * @param $resultId
     * @param $page
     *
     * @return JsonResponse
     */
    public function getIndicator($resultId, $page = 1): JsonResponse
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
