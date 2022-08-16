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
            $indicators = $this->indicatorService->getResultIndicators($resultId);
            $types = getIndicatorTypes();
            $toast = generateToastData();

            return view('admin.activity.indicator.indicator', compact('activity', 'parentData', 'indicators', 'types', 'toast'));
        } catch (\Exception $e) {
            logger()->error($e->getMessage());

            return redirect()->route('admin.activity.result.index', [$resultId])->with(
                'error',
                'Error has occurred while rendering activity transactions listing.'
            );
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
            $element = json_decode(json: file_get_contents(app_path('IATI/Data/elementJsonSchema.json')), associative: true, depth: 512, flags: JSON_THROW_ON_ERROR);
            $result = $this->resultService->getResult($resultId);
            $activity = $result->activity;
            $form = $this->indicatorService->createFormGenerator($activity->id, $resultId);
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
     * Creates new indicator.
     *
     * @param IndicatorRequest $request
     * @param                  $resultId
     *
     * @return RedirectResponse
     */
    public function store(Request $request, $resultId): RedirectResponse
    {
        try {
            $indicatorData = $request->except(['_token']);
            $indicator = $this->indicatorService->create([
                'result_id' => $resultId,
                'indicator' => $indicatorData,
            ]);

            return redirect()->route('admin.result.indicator.show', [$resultId, $indicator['id']])->with(
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
     * Renders indicator detail page.
     *
     * @param $indicatorId
     *
     * @return Factory|View|RedirectResponse|Application
     */
    public function show($indicatorId): Factory|View|RedirectResponse|Application
    {
        try {
            $indicator = $this->indicatorService->getIndicator($indicatorId);
            $result = $indicator->result;
            $resultTitle = $result['result']['title'];
            $activity = $result->activity;
            $period = $this->periodService->getPeriodOfIndicator($indicatorId)->toArray();
            $types = getIndicatorTypes();
            $toast = generateToastData();

            return view('admin.activity.indicator.detail', compact('activity', 'resultTitle', 'indicator', 'period', 'types', 'toast'));
        } catch (\Exception $e) {
            logger()->error($e->getMessage());

            return redirect()->route('admin.result.indicator.index', [$result->id])->with(
                'error',
                'Error has occurred while rending result detail page.'
            );
        }
    }

    /**
     * Renders indicator edit form.
     *
     * @param $indicatorId
     *
     * @return Factory|View|RedirectResponse|Application
     */
    public function edit($indicatorId): Factory|View|RedirectResponse|Application
    {
        try {
            $element = json_decode(json: file_get_contents(app_path('IATI/Data/elementJsonSchema.json')), associative: true, depth: 512, flags: JSON_THROW_ON_ERROR);
            $indicator = $this->indicatorService->getIndicator($indicatorId);
            $result = $indicator->result;
            $activity = $result->activity;
            $form = $this->indicatorService->editFormGenerator($activity->id, $result->id, $indicatorId);
            $data = ['core' => $element['indicator']['criteria'] ?? false, 'status' => false, 'title' => $element['indicator']['label'], 'name' => 'indicator'];

            return view('admin.activity.indicator.edit', compact('form', 'activity', 'data'));
        } catch (\Exception $e) {
            dd($e->getMessage());
            logger()->error($e->getMessage());

            return redirect()->route('admin.result.indicator.index', [$result->id])->with(
                'error',
                'Error has occurred while rendering indicator form.'
            );
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param IndicatorRequest $request
     * @param                  $indicatorId
     *
     * @return RedirectResponse
     */
    public function update(IndicatorRequest $request, $indicatorId): RedirectResponse
    {
        try {
            $indicatorData = $request->except(['_method', '_token']);
            $indicator = $this->indicatorService->getIndicator($indicatorId);
            $result = $indicator->result;

            if (!$this->indicatorService->update([
                'result_id' => $result->id,
                'indicator' => $indicatorData,
            ], $indicator)) {
                return redirect()->route('admin.result.indicator.index', [$result->id])->with(
                    'error',
                    'Error has occurred while updating result indicator.'
                );
            }

            return redirect()->route('admin.result.indicator.show', [$result->id, $indicator['id']])->with(
                'success',
                'Indicator updated successfully.'
            );
        } catch (\Exception $e) {
            logger()->error($e->getMessage());

            return redirect()->route('admin.result.indicator.index', [$result->id])->with(
                'error',
                'Error has occurred while updating indicator.'
            );
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Indicator $indicator
     *
     * @return void
     */
    public function destroy(Indicator $indicator): void
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
