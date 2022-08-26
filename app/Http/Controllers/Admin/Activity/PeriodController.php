<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin\Activity;

use App\Http\Controllers\Controller;
use App\Http\Requests\Activity\Period\PeriodRequest;
use App\IATI\Models\Activity\Period;
use App\IATI\Services\Activity\ActivityService;
use App\IATI\Services\Activity\IndicatorService;
use App\IATI\Services\Activity\PeriodService;
use App\IATI\Services\Activity\ResultService;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;

/**
 * PeriodController Class.
 */
class PeriodController extends Controller
{
    /**
     * @var PeriodService
     */
    protected PeriodService $periodService;

    /**
     * @var IndicatorService
     */
    protected IndicatorService $indicatorService;

    /**
     * @var ResultService
     */
    protected ResultService $resultService;

    /**
     * @var ActivityService
     */
    protected ActivityService $activityService;

    /**
     * IndicatorController Constructor.
     *
     * @param PeriodService $periodService
     * @param IndicatorService $indicatorService
     * @param ResultService $resultService
     * @param ActivityService $activityService
     */
    public function __construct(
        PeriodService $periodService,
        IndicatorService $indicatorService,
        ResultService $resultService,
        ActivityService $activityService
    ) {
        $this->periodService = $periodService;
        $this->indicatorService = $indicatorService;
        $this->resultService = $resultService;
        $this->activityService = $activityService;
    }

    /**
     * Display a listing of the period.
     *
     * @param $activityId
     * @param $resultId
     * @param $indicatorId
     *
     * @return \Illuminate\Contracts\View\Factory|View|RedirectResponse|\Illuminate\Contracts\Foundation\Application
     */
    public function index(
        $activityId,
        $resultId,
        $indicatorId
    ): \Illuminate\Contracts\View\Factory|View|RedirectResponse|\Illuminate\Contracts\Foundation\Application {
        try {
            $activity = $this->activityService->getActivity($activityId);
            $parentData = [
                'result'    => [
                    'id'    => $resultId,
                    'title' => $this->resultService->getResult(
                        $resultId,
                        $activityId
                    )['result']['title'][0]['narrative'],
                ],
                'indicator' => [
                    'id'    => $indicatorId,
                    'title' => $this->indicatorService->getResultIndicator(
                        $resultId,
                        $indicatorId
                    )['indicator']['title'][0]['narrative'],
                ],
            ];

            $period = $this->periodService->getPeriodOfIndicator($indicatorId)->toArray();

            $types = getPeriodTypes();
            $toast = generateToastData();

            return view('admin.activity.period.period', compact('activity', 'parentData', 'period', 'types', 'toast'));
        } catch (\Exception $e) {
            logger()->error($e->getMessage());

            return redirect()->route(
                'admin.activities.result.indicator.period.index',
                [$activityId, $resultId, $indicatorId]
            )->with(
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
     * @param $indicatorId
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\RedirectResponse|\Illuminate\Contracts\Foundation\Application
     */
    public function create(
        $activityId,
        $resultId,
        $indicatorId
    ): \Illuminate\Contracts\View\Factory|View|RedirectResponse|\Illuminate\Contracts\Foundation\Application {
        try {
            $element = getElementSchema('period');
            $activity = $this->activityService->getActivity($activityId);
            $form = $this->periodService->createFormGenerator($activityId, $resultId, $indicatorId);
            $data = [
                'core'   => $element['criteria'] ?? false,
                'status' => false,
                'title'  => $element['label'],
                'name'   => 'period',
            ];

            return view('admin.activity.period.edit', compact('form', 'activity', 'data'));
        } catch (\Exception $e) {
            logger()->error($e->getMessage());

            return redirect()->route(
                'admin.activities.result.indicator.period.index',
                [$activityId, $resultId, $indicatorId]
            )->with(
                'error',
                'Error has occurred while rendering indicator period form.'
            );
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param PeriodRequest $request
     * @param $activityId
     * @param $resultId
     * @param $indicatorId
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(PeriodRequest $request, $activityId, $resultId, $indicatorId): RedirectResponse
    {
        try {
            $periodData = $request->except(['_token']);
            $messages = $this->validateData([
                'measure' => $this->indicatorService->getResultIndicator($resultId, $indicatorId)['measure'],
                'period'  => $periodData,
            ]);

            if ($messages) {
                return redirect()->route(
                    'admin.activities.result.indicator.period.create',
                    [$activityId, $resultId, $indicatorId]
                )->with('error', $messages)->withInput();
            }

            $period = $this->periodService->create([
                'indicator_id' => $indicatorId,
                'period'       => $periodData,
            ]);

            return redirect()->route(
                'admin.activities.result.indicator.period.show',
                [$activityId, $resultId, $indicatorId, $period]
            )->with(
                'success',
                'Indicator period created successfully.'
            );
        } catch (\Exception $e) {
            logger()->error($e->getMessage());

            return redirect()->route(
                'admin.activities.result.indicator.period.index',
                [$activityId, $resultId, $indicatorId]
            )->with(
                'error',
                'Error has occurred while creating indicator period.'
            );
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  $activityId
     * @param  $resultId
     * @param  $indicatorId
     * @param  $periodId
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\RedirectResponse|\Illuminate\Contracts\Foundation\Application
     */
    public function show(
        $activityId,
        $resultId,
        $indicatorId,
        $periodId
    ): \Illuminate\Contracts\View\Factory|View|RedirectResponse|\Illuminate\Contracts\Foundation\Application {
        try {
            $activity = $this->activityService->getActivity($activityId);
            $parentData = [
                'result'    => [
                    'id'    => $resultId,
                    'title' => $this->resultService->getResult(
                        $resultId,
                        $activityId
                    )['result']['title'][0]['narrative'],
                ],
                'indicator' => [
                    'id'    => $indicatorId,
                    'title' => $this->indicatorService->getResultIndicator(
                        $resultId,
                        $indicatorId
                    )['indicator']['title'][0]['narrative'],
                ],
            ];
            $period = $this->periodService->getIndicatorPeriod($indicatorId, $periodId);
            $types = getPeriodTypes();
            $toast = generateToastData();

            return view('admin.activity.period.detail', compact('activity', 'parentData', 'period', 'types', 'toast'));
        } catch (\Exception $e) {
            logger()->error($e->getMessage());

            return redirect()->route(
                'admin.activities.result.indicator.period.index',
                [$activityId, $resultId, $indicatorId]
            )->with(
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
     * @param $indicatorId
     * @param $periodId
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\RedirectResponse|\Illuminate\Contracts\Foundation\Application
     */
    public function edit(
        $activityId,
        $resultId,
        $indicatorId,
        $periodId
    ): \Illuminate\Contracts\View\Factory|View|RedirectResponse|\Illuminate\Contracts\Foundation\Application {
        try {
            $element = getElementSchema('period');
            $activity = $this->activityService->getActivity($activityId);
            $form = $this->periodService->editFormGenerator($activityId, $resultId, $indicatorId, $periodId);
            $data = [
                'core'   => $element['criteria'] ?? false,
                'status' => false,
                'title'  => $element['label'],
                'name'   => 'period',
            ];

            return view('admin.activity.period.edit', compact('form', 'activity', 'data'));
        } catch (\Exception $e) {
            logger()->error($e->getMessage());

            return redirect()->route(
                'admin.activities.result.indicator.period.index',
                [$activityId, $resultId, $indicatorId]
            )->with('error', 'Error has occurred while rendering period form.');
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param PeriodRequest $request
     * @param $activityId
     * @param $resultId
     * @param $indicatorId
     * @param $periodId
     *
     * @return
     */
    public function update(PeriodRequest $request, $activityId, $resultId, $indicatorId, $periodId): RedirectResponse
    {
        try {
            $periodData = $request->except(['_method', '_token']);
            $period = $this->periodService->getIndicatorPeriod($indicatorId, $periodId);

            $messages = $this->validateData([
                'measure' => $this->indicatorService->getResultIndicator(
                    $resultId,
                    $indicatorId
                )['indicator']['measure'],
                'period'  => $periodData,
            ]);

            if ($messages) {
                return redirect()->route(
                    'admin.activities.result.indicator.period.edit',
                    [$activityId, $resultId, $indicatorId, $periodId]
                )->with('error', $messages)->withInput();
            }

            if (!$this->periodService->update([
                'indicator_id' => $indicatorId,
                'period'       => $periodData,
            ], $period)) {
                return redirect()->route(
                    'admin.activities.result.indicator.period.index',
                    [$activityId, $resultId, $indicatorId]
                )->with(
                    'error',
                    'Error has occurred while updating indicator period.'
                );
            }

            return redirect()->route(
                'admin.activities.result.indicator.period.show',
                [$activityId, $resultId, $indicatorId, $period['id']]
            )->with(
                'success',
                'Indicator period updated successfully.'
            );
        } catch (\Exception $e) {
            logger()->error($e->getMessage());

            return redirect()->route(
                'admin.activities.result.indicator.period.show',
                [$activityId, $resultId, $indicatorId, $periodId]
            )->with(
                'error',
                'Error has occurred while updating indicator period.'
            );
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\IATI\Models\Activity\Period $period
     * @return \Illuminate\Http\Response
     */
    public function destroy(Period $period)
    {
        //
    }

    /*
     * Get period of the corresponding indicator
     *
     * @param $activityId
     * @param $resultId
     * @param $indicatorId
     * @param $page
     *
     * @return JsonResponse
     */
    public function getPeriod($activityId, $resultId, $indicatorId, $page = 1): JsonResponse
    {
        try {
            $period = $this->periodService->getPaginatedPeriod($indicatorId, $page);

            return response()->json([
                'success' => true,
                'message' => 'Period fetched successfully',
                'data'    => $period,
            ]);
        } catch (\Exception $e) {
            logger()->error($e->getMessage());

            return response()->json(['success' => false, 'message' => 'Error occurred while fetching the data']);
        }
    }

    /**
     * Validate value data based on quantitative and non-quantitative measure.
     *
     * @param array $period
     * @return string
     */
    private function validateData(array $period): string
    {
        $messages = '';
        $repeated = false;
        $measure = $period['measure'];

        if ($measure == '5') {
            foreach ($period['target'] as $target) {
                if ($target['value']) {
                    return 'Value must be omitted when the indicator measure is qualitative.';
                }
            }

            foreach ($period['actual'] as $actual) {
                if ($actual['value']) {
                    return 'Value must be omitted when the indicator measure is qualitative.';
                }
            }
        }

        return $messages;
    }
}
