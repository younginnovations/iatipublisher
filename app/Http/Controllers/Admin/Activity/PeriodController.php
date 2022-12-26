<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin\Activity;

use App\Http\Controllers\Controller;
use App\Http\Requests\Activity\Period\PeriodRequest;
use App\IATI\Services\Activity\ActivityService;
use App\IATI\Services\Activity\IndicatorService;
use App\IATI\Services\Activity\PeriodService;
use App\IATI\Services\Activity\ResultService;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Session;

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
     * @param PeriodService    $periodService
     * @param IndicatorService $indicatorService
     * @param ResultService    $resultService
     * @param ActivityService  $activityService
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
     * Returns paginated periods.
     *
     * @param int $indicatorId
     * @param int $page
     *
     * @return JsonResponse
     */
    public function getPaginatedPeriods(int $indicatorId, int $page = 1): JsonResponse
    {
        try {
            $period = $this->periodService->getPaginatedPeriod($indicatorId, $page);

            return response()->json([
                'success' => true,
                'message' =>  ucfirst(trans('responses.event_successfully', ['prefix'=>trans('elements_common.period'), 'event'=>trans('events.fetched')])),
                'data'    => $period,
            ]);
        } catch (\Exception $e) {
            logger()->error($e->getMessage());

            return response()->json(['success' => false, 'message' => trans('responses.error_has_occurred', ['event'=>trans('events.fetching'), 'suffix'=>trans('responses.the_data')])]);
        }
    }

    /**
     * Display a listing of the period.
     *
     * @param $indicatorId
     *
     * @return Factory|View|RedirectResponse|Application
     */
    public function index($indicatorId): Factory|View|RedirectResponse|Application
    {
        try {
            $indicator = $this->indicatorService->getIndicator($indicatorId);
            $result = $indicator->result;
            $activity = $result->activity;
            $parentData = [
                'indicator' => [
                    'id'    => $indicatorId,
                    'title' => $this->indicatorService->getIndicator($indicatorId)['indicator']['title'][0]['narrative'],
                ],
                'result'    => [
                    'id'    => $result['id'],
                    'title' => $result['result']['title'][0]['narrative'],
                ],
            ];

            $period = $this->periodService->getPeriods($indicatorId)->toArray();
            $types = getPeriodTypes();
            $toast = generateToastData();

            return view('admin.activity.period.period', compact('activity', 'parentData', 'period', 'types', 'toast'));
        } catch (\Exception $e) {
            logger()->error($e->getMessage());

            return redirect()->route('admin.indicator.period.index', $indicatorId)->with('error', trans('responses.error_has_occurred', ['event'=>trans('events.rendering'), 'suffix'=>trans('responses.activity_transactions_listing')]));
        }
    }

    /**
     * Renders period form.
     *
     * @param $indicatorId
     *
     * @return Factory|View|RedirectResponse|Application
     */
    public function create($indicatorId): Factory|View|RedirectResponse|Application
    {
        try {
            $element = getElementSchema('period');
            $indicator = $this->indicatorService->getIndicator($indicatorId);
            $activity = $indicator->result->activity;
            $form = $this->periodService->createFormGenerator($indicatorId);
            $data = ['title' => $element['label'], 'name' => 'period'];

            return view('admin.activity.period.edit', compact('form', 'activity', 'data'));
        } catch (\Exception $e) {
            logger()->error($e->getMessage());

            return redirect()->route('admin.indicator.period.index', $indicatorId)->with('error', trans('responses.error_has_occurred_form', ['event'=>trans('events.rendering'), 'suffix'=>trans('responses.indicator_period')]));
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param PeriodRequest $request
     * @param               $indicatorId
     *
     * @return RedirectResponse
     */
    public function store(PeriodRequest $request, $indicatorId): RedirectResponse
    {
        try {
            $periodData = $request->except(['_token']);

            $period = $this->periodService->create([
                'indicator_id' => $indicatorId,
                'period'       => $periodData,
            ]);

            return redirect()->route('admin.indicator.period.show', [$indicatorId, $period['id']])->with(
                'success',
                ucfirst(trans('responses.event_successfully', ['prefix'=>trans('responses.indicator_period'), 'event'=>trans('elements_common.created')]))
            );
        } catch (\Exception $e) {
            logger()->error($e->getMessage());

            return redirect()->route('admin.indicator.period.index', $indicatorId)->with(
                'error',
                trans('responses.error_has_occurred', ['event'=>trans('events.creating'), 'suffix'=>trans('responses.indicator_period')])
            );
        }
    }

    /**
     * Render period detail page.
     *
     * @param  $indicatorId
     * @param  $periodId
     *
     * @return Factory|View|RedirectResponse|Application
     */
    public function show($indicatorId, $periodId): Factory|View|RedirectResponse|Application
    {
        try {
            $indicator = $this->indicatorService->getIndicator($indicatorId);
            $result = $indicator->result;
            $activity = $result->activity;

            $parentData = [
                'result'    => [
                    'id'    => $result['id'],
                    'title' => $result['result']['title'][0]['narrative'],
                ],
                'indicator' => [
                    'id'    => $indicatorId,
                    'title' => $indicator['indicator']['title'][0]['narrative'],
                ],
            ];
            $period = $this->periodService->getPeriod($periodId);
            $element = translateJsonValues(getElementSchema('period'));
            $types = getPeriodTypes();
            $toast = generateToastData();

            return view('admin.activity.period.detail', compact('activity', 'parentData', 'period', 'types', 'toast', 'element'));
        } catch (\Exception $e) {
            logger()->error($e->getMessage());

            return redirect()->route('admin.indicator.period.index', [$indicatorId])->with(
                'error',
                trans('responses.error_has_occurred_page', ['event'=>trans('events.rendering'), 'suffix'=>trans('responses.result_detail')])
            );
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param $indicatorId
     * @param $periodId
     *
     * @return Factory|View|RedirectResponse|Application
     */
    public function edit($indicatorId, $periodId): Factory|View|RedirectResponse|Application
    {
        try {
            $element = getElementSchema('period');
            $indicator = $this->indicatorService->getIndicator($indicatorId);
            $activity = $indicator->result->activity;
            $form = $this->periodService->editFormGenerator($indicatorId, $periodId);
            $data = ['title' => $element['label'], 'name' => 'period'];

            return view('admin.activity.period.edit', compact('form', 'activity', 'data'));
        } catch (\Exception $e) {
            logger()->error($e->getMessage());

            return redirect()->route('admin.indicator.period.index', $indicatorId)->with('error', trans('responses.error_has_occurred_form', ['event'=>trans('events.rendering'), 'suffix'=>trans('elements_common.period')]));
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param PeriodRequest $request
     * @param int           $indicatorId
     * @param int           $periodId
     *
     * @return RedirectResponse
     */
    public function update(PeriodRequest $request, int $indicatorId, int $periodId): RedirectResponse
    {
        try {
            $periodData = $request->except(['_method', '_token']);
            $period = $this->periodService->getPeriod($periodId);

            if (!$this->periodService->update($periodId, ['indicator_id' => $indicatorId, 'period' => $periodData])) {
                return redirect()->route('admin.indicator.period.index', [$indicatorId])->with(
                    'error',
                    trans('responses.error_has_occurred', ['event'=>trans('events.updating'), 'suffix'=>trans('elements_common.indicator_period')])
                );
            }

            return redirect()->route('admin.indicator.period.show', [$indicatorId, $period['id']])->with(
                'success',
                ucfirst(trans('responses.event_successfully', ['prefix'=>trans('responses.indicator_period'), 'event'=>trans('elements_common.updated')]))
            );
        } catch (\Exception $e) {
            logger()->error($e->getMessage());

            return redirect()->route('admin.indicator.period.show', [$indicatorId, $periodId])->with(
                'error',
                trans('responses.error_has_occurred', ['event'=>trans('events.updating'), 'suffix'=>trans('elements_common.indicator_period')])
            );
        }
    }

    /**
     * Deletes Specific Period.
     *
     * @param $id
     * @param $periodId
     *
     * @return JsonResponse
     */
    public function destroy($id, $periodId): JsonResponse
    {
        try {
            $this->periodService->deletePeriod($periodId);
            Session::flash('success', ucfirst(trans('responses.event_successfully', ['prefix'=>trans('elements_common.period'), 'event'=>trans('events.deleted')])));

            return response()->json([
                'status'       => true,
                'msg'          =>  ucfirst(trans('responses.event_successfully', ['prefix'=>trans('elements_common.period'), 'event'=>trans('events.deleted')])),
                'indicator_id' => $id,
            ]);
        } catch (\Exception $e) {
            logger()->error($e->getMessage());
            Session::flash('error', ucwords(trans('responses.delete_error', ['prefix'=>trans('elements_common.period')])));

            return response()->json([
                'status'       => true,
                'msg'          => ucwords(trans('responses.delete_error', ['prefix'=>trans('elements_common.period')])),
                'indicator_id' => $id,
            ], 400);
        }
    }
}
