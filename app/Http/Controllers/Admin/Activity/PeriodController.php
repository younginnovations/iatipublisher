<?php

namespace App\Http\Controllers\Admin\Activity;

use App\Http\Controllers\Controller;
use App\Http\Requests\Activity\Period\PeriodRequest;
use App\IATI\Models\Activity\Period;
use App\IATI\Services\Activity\ActivityService;
use App\IATI\Services\Activity\PeriodService;

class PeriodController extends Controller
{
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
     * @param PeriodService $periodService
     * @param ActivityService $activityService
     */
    public function __construct(
        PeriodService $periodService,
        ActivityService $activityService
    ) {
        $this->periodService = $periodService;
        $this->activityService = $activityService;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @param $activityId
     * @param $resultId
     * @param $indicatorId
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\RedirectResponse|\Illuminate\Contracts\Foundation\Application
     */
    public function create($activityId, $resultId, $indicatorId): \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\RedirectResponse|\Illuminate\Contracts\Foundation\Application
    {
        try {
            $element = json_decode(file_get_contents(app_path('IATI/Data/elementJsonSchema.json')), true);
            $activity = $this->activityService->getActivity($activityId);
            $form = $this->periodService->createFormGenerator($activityId, $resultId, $indicatorId);
            $data = ['core' => $element['period']['criteria'] ?? false, 'status' => false, 'title' => $element['period']['label'], 'name' => 'period'];

            return view('admin.activity.period.edit', compact('form', 'activity', 'data'));
        } catch (\Exception $e) {
            logger()->error($e->getMessage());

            return redirect()->route('admin.activities.show', $activityId)->with(
                'error',
                'Error has occurred while rendering indicator period form.'
            );
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  PeriodRequest  $request
     * @param $activityId
     * @param $resultId
     * @param $indicatorId
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(PeriodRequest $request, $activityId, $resultId, $indicatorId): \Illuminate\Http\RedirectResponse
    {
        try {
            $periodData = $request->except(['_token']);

            if (!$this->periodService->create([
                'indicator_id'  => $indicatorId,
                'period'        => $periodData,
            ])) {
                return redirect()->route('admin.activities.show', $activityId)->with(
                    'error',
                    'Error has occurred while creating indicator period.'
                );
            }

            return redirect()->route('admin.activities.show', $activityId)->with(
                'success',
                'Indicator period created successfully.'
            );
        } catch (\Exception $e) {
            logger()->error($e->getMessage());

            return redirect()->route('admin.activities.show', $activityId)->with(
                'error',
                'Error has occurred while creating indicator period.'
            );
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\IATI\Models\Activity\Period  $period
     * @return \Illuminate\Http\Response
     */
    public function show(Period $period)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param $activityId
     * @param $resultId
     * @param $indicatorId
     * @param $periodId
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\RedirectResponse|\Illuminate\Contracts\Foundation\Application
     */
    public function edit($activityId, $resultId, $indicatorId, $periodId): \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\RedirectResponse|\Illuminate\Contracts\Foundation\Application
    {
        try {
            $element = json_decode(file_get_contents(app_path('IATI/Data/elementJsonSchema.json')), true);
            $activity = $this->activityService->getActivity($activityId);
            $form = $this->periodService->editFormGenerator($activityId, $resultId, $indicatorId, $periodId);
            $data = ['core' => $element['period']['criteria'] ?? false, 'status' => false, 'title' => $element['period']['label'], 'name' => 'period'];

            return view('admin.activity.period.edit', compact('form', 'activity', 'data'));
        } catch (\Exception $e) {
            logger()->error($e->getMessage());

            return redirect()->route('admin.activities.show', $activityId)->with(
                'error',
                'Error has occurred while rendering indicator period form.'
            );
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  PeriodRequest  $request
     * @param $activityId
     * @param $resultId
     * @param $indicatorId
     * @param $periodId
     *
     * @return
     */
    public function update(PeriodRequest $request, $activityId, $resultId, $indicatorId, $periodId)
    {
        try {
            $periodData = $request->except(['_method', '_token']);
            $period = $this->periodService->getIndicatorPeriod($indicatorId, $periodId);

            if (!$this->periodService->update([
                'indicator_id'  => $indicatorId,
                'period'        => $periodData,
            ], $period)) {
                return redirect()->route('admin.activities.show', $activityId)->with(
                    'error',
                    'Error has occurred while updating indicator period.'
                );
            }

            return redirect()->route('admin.activities.show', $activityId)->with(
                'success',
                'Indicator period updated successfully.'
            );
        } catch (\Exception $e) {
            logger()->error($e->getMessage());

            return redirect()->route('admin.activities.show', $activityId)->with(
                'error',
                'Error has occurred while updating indicator period.'
            );
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\IATI\Models\Activity\Period  $period
     * @return \Illuminate\Http\Response
     */
    public function destroy(Period $period)
    {
        //
    }
}
