<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin\Activity;

use App\Http\Controllers\Controller;
use App\Http\Requests\Activity\Indicator\IndicatorRequest;
use App\IATI\Services\Activity\ActivityService;
use App\IATI\Services\Activity\IndicatorService;
use App\IATI\Services\Activity\PeriodService;
use App\IATI\Services\Activity\ResultService;
use Exception;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Session;

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
     * Renders indicator listing page.
     *
     * @param $resultId
     *
     * @return View|RedirectResponse
     */
    public function index($resultId): View|RedirectResponse
    {
        try {
            $result = $this->resultService->getResult($resultId);
            $activity = $result->activity;
            $parentData = [
                'result' => [
                    'id'    => $resultId,
                    'title' => $result['result']['title'][0]['narrative'],
                ],
            ];
            $indicators = $this->indicatorService->getIndicators($resultId);
            $types = getIndicatorTypes();
            $toast = generateToastData();

            return view('admin.activity.indicator.indicator', compact('activity', 'parentData', 'indicators', 'types', 'toast'));
        } catch (Exception $e) {
            logger()->error($e->getMessage());

            return redirect()->route('admin.activity.result.index', $resultId)->with(
                'error',
                trans('responses.error_has_occurred', ['event'=>trans('events.rendering'), 'suffix'=>trans('responses.activity_transactions_listing')])
            );
        }
    }

    /**
     * Returns paginated indicator.
     *
     * @param int $resultId
     * @param int $page
     *
     * @return JsonResponse
     */
    public function getPaginatedIndicators(int $resultId, int $page = 1): JsonResponse
    {
        try {
            $indicator = $this->indicatorService->getPaginatedIndicator($resultId, $page);

            return response()->json([
                'success' => true,
                'message' => ucfirst(trans('responses.event_successfully', ['prefix'=>trans('elements_common.indicators'), 'event'=>trans('events.fetched')])),
                'data'    => $indicator,
            ]);
        } catch (Exception $e) {
            logger()->error($e->getMessage());

            return response()->json(['success' => false, 'message' => trans('responses.error_has_occurred', ['event'=>trans('events.fetching'), 'suffix'=>trans('responses.the_data')])]);
        }
    }

    /**
     * Renders indicator create page.
     *
     * @param $resultId
     *
     * @return Factory|View|RedirectResponse|Application
     */
    public function create($resultId): Factory|View|RedirectResponse|Application
    {
        try {
            $element = getElementSchema('indicator');
            $result = $this->resultService->getResult($resultId);
            $activity = $result->activity;
            $form = $this->indicatorService->createFormGenerator($resultId);
            $data = ['status' => false, 'title' => $element['label'], 'name' => 'indicator'];

            return view('admin.activity.indicator.edit', compact('form', 'activity', 'data'));
        } catch (Exception $e) {
            logger()->error($e->getMessage());

            return redirect()->route('admin.result.indicator.index', [$resultId])->with(
                'error',
                trans('responses.error_has_occurred_form', ['event'=>trans('events.rendering'), 'suffix'=>trans('elements_common.indicator')])
            );
        }
    }

    /**
     * Creates new indicator.
     *
     * @param IndicatorRequest $request
     * @param                  $resultId
     *
     * @return RedirectResponse
     */
    public function store(IndicatorRequest $request, $resultId): RedirectResponse
    {
        try {
            $indicatorData = $request->except(['_token']);
            $result = $this->resultService->getResult($resultId);
            $indicator = $this->indicatorService->create([
                'result_id' => $resultId,
                'indicator' => $indicatorData,
                'default_field_values'=>$result->activity->default_field_values,
            ]);

            return redirect()->route('admin.result.indicator.show', [$resultId, $indicator['id']])->with(
                'success',
                ucfirst(trans('responses.event_successfully', ['prefix'=>trans('responses.result_indicator'), 'event'=>trans('events.created')]))
            );
        } catch (Exception $e) {
            logger()->error($e->getMessage());

            return redirect()->route('admin.result.indicator.index', $resultId)->with(
                'error',
                trans('responses.error_has_occurred', ['event'=>trans('events.creating'), 'suffix'=>trans('responses.result_indicator')])
            );
        }
    }

    /**
     * Renders indicator detail page.
     *
     * @param $resultId
     * @param $indicatorId
     *
     * @return Factory|View|RedirectResponse|Application
     */
    public function show($resultId, $indicatorId): Factory|View|RedirectResponse|Application
    {
        try {
            $indicator = $this->indicatorService->getIndicator($indicatorId);
            $result = $indicator->result;
            $resultTitle = $result['result']['title'];
            $activity = $result->activity;
            $period = $this->periodService->getPeriods($indicatorId)->toArray();
            $element = translateJsonValues(getElementSchema('indicator'));
            $types = getIndicatorTypes();
            $toast = generateToastData();

            return view('admin.activity.indicator.detail', compact('activity', 'resultTitle', 'indicator', 'period', 'types', 'toast', 'element'));
        } catch (Exception $e) {
            logger()->error($e->getMessage());

            return redirect()->route('admin.result.indicator.index', $resultId)->with(
                'error',
                trans('responses.error_has_occurred_page', ['event'=>trans('events.rendering'), 'suffix'=>trans('responses.result_detail')])
            );
        }
    }

    /**
     * Renders indicator edit form.
     *
     * @param $resultId
     * @param $indicatorId
     *
     * @return Factory|View|RedirectResponse|Application
     */
    public function edit($resultId, $indicatorId): Factory|View|RedirectResponse|Application
    {
        try {
            $result = $this->resultService->getResult($resultId);
            $element = getElementSchema('indicator');
            $activity = $this->activityService->getActivity($result->activity->id);
            $form = $this->indicatorService->editFormGenerator($resultId, $indicatorId);
            $data = ['title' => $element['label'], 'name' => 'indicator'];

            return view('admin.activity.indicator.edit', compact('form', 'activity', 'data'));
        } catch (Exception $e) {
            logger()->error($e->getMessage());

            return redirect()->route('admin.result.indicator.index', $resultId)->with(
                'error',
                trans('responses.error_has_occurred_form', ['event'=>trans('events.rendering'), 'suffix'=>trans('elements_common.indicator')])
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
     * @return RedirectResponse
     */
    public function update(IndicatorRequest $request, $resultId, $indicatorId): RedirectResponse
    {
        try {
            $indicatorData = $request->except(['_method', '_token']);
            $indicator = $this->indicatorService->getIndicator($indicatorId);
            $result = $indicator->result;

            if (!$this->indicatorService->update($indicatorId, ['result_id' => $result->id, 'indicator' => $indicatorData])) {
                return redirect()->route('admin.result.indicator.index', $resultId)->with(
                    'error',
                    trans('responses.error_has_occurred', ['event'=>trans('events.updating'), 'suffix'=>trans('responses.result_indicator')])
                );
            }

            return redirect()->route('admin.result.indicator.show', [$resultId, $indicatorId])->with(
                'success',
                'Indicator updated successfully.'
            );
        } catch (Exception $e) {
            logger()->error($e->getMessage());

            return redirect()->route('admin.result.indicator.index', $resultId)->with(
                'error',
                trans('responses.error_has_occurred', ['event'=>trans('events.updating'), 'suffix'=>trans('elements_common.indicator')])
            );
        }
    }

    /**
     * Deletes Specific Indicator.
     *
     * @param $id
     * @param $indicatorId
     *
     * @return JsonResponse
     */
    public function destroy($id, $indicatorId): JsonResponse
    {
        try {
            $this->indicatorService->deleteIndicator($indicatorId);
            Session::flash('success', ucfirst(trans('responses.event_successfully', ['prefix'=>trans('elements_common.indicator'), 'event'=>trans('events.deleted')])));

            return response()->json([
                'status'    => true,
                'msg'       => ucfirst(trans('responses.event_successfully', ['prefix'=>trans('elements_common.indicator'), 'event'=>trans('events.deleted')])),
                'result_id' => $id,
            ]);
        } catch (Exception $e) {
            logger()->error($e->getMessage());
            Session::flash('error', ucwords(trans('responses.delete_error', ['prefix'=>trans('elements_common.indicator')])));

            return response()->json([
                'status'    => true,
                'msg'       => ucwords(trans('responses.delete_error', ['prefix'=>trans('elements_common.indicator')])),
                'result_id' => $id,
            ], 400);
        }
    }
}
