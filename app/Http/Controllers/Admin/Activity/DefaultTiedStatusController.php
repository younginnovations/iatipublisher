<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin\Activity;

use App\Http\Controllers\Controller;
use App\Http\Requests\Activity\DefaultTiedStatus\DefaultTiedStatusRequest;
use App\IATI\Elements\Builder\BaseFormCreator;
use App\IATI\Services\Activity\DefaultTiedStatusService;
use Illuminate\Http\JsonResponse;

/**
 * Class DefaultTiedStatusController.
 */
class DefaultTiedStatusController extends Controller
{
    /**
     * @var BaseFormCreator
     */
    protected BaseFormCreator $baseFormCreator;

    /**
     * @var DefaultTiedStatusService
     */
    protected DefaultTiedStatusService $defaultTiedStatusService;

    /**
     * DefaultTiedStatusController Constructor.
     *
     * @param BaseFormCreator $baseFormCreator
     * @param DefaultTiedStatusService $defaultTiedStatusService
     */
    public function __construct(BaseFormCreator $baseFormCreator, DefaultTiedStatusService $defaultTiedStatusService)
    {
        $this->baseFormCreator = $baseFormCreator;
        $this->defaultTiedStatusService = $defaultTiedStatusService;
    }

    /**
     * @param int $id
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|void
     */
    public function edit(int $id)
    {
        try {
            $element = json_decode(file_get_contents(app_path('IATI/Data/elementJsonSchema.json')), true);
            $model['default_tied_status'] = $this->defaultTiedStatusService->getDefaultTiedStatusData($id);
            $this->baseFormCreator->url = route('admin.activities.default-tied-status.update', [$id]);
            $form = $this->baseFormCreator->editForm($model, $element['default-tied-status']);

            return view('activity.defaultTiedStatus.defaultTiedStatus', compact('form'));
        } catch (\Exception $e) {
            dd(logger()->error($e->getMessage()));
            logger()->error($e->getMessage());
        }
    }

    /**
     * @param DefaultTiedStatusRequest $request
     * @param $id
     * @return JsonResponse
     */
    public function update(DefaultTiedStatusRequest $request, $id): JsonResponse
    {
        try {
            $activityData = $this->defaultTiedStatusService->getActivityData($id);
            $activityDefaultTiedStatus = (int) $request->get('default_tied_status');

            if (!$this->defaultTiedStatusService->update($activityDefaultTiedStatus, $activityData)) {
                return response()->json(['success' => false, 'error' => 'Error has occurred while updating activity default tied status.']);
            }

            return response()->json(['success' => true, 'message' => 'Activity default tied status updated successfully.']);
        } catch (\Exception $e) {
            logger()->error($e->getMessage());

            return response()->json(['success' => false, 'error' => 'Error has occurred while updating activity default tied status.']);
        }
    }
}
