<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin\Activity;

use App\Http\Controllers\Controller;
use App\Http\Requests\Activity\DefaultTiedStatus\DefaultTiedStatusRequest;
use App\IATI\Elements\Builder\BaseFormCreator;
use App\IATI\Services\Activity\DefaultTiedStatusService;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;

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
     * Renders default tied status edit form.
     *
     * @param int $id
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|void
     */
    public function edit(int $id): View|RedirectResponse
    {
        try {
            $element = json_decode(file_get_contents(app_path('IATI/Data/elementJsonSchema.json')), true);
            $activity = $this->defaultTiedStatusService->getActivityData($id);
            $model['default_tied_status'] = $this->defaultTiedStatusService->getDefaultTiedStatusData($id);
            $this->baseFormCreator->url = route('admin.activities.default-tied-status.update', [$id]);
            $form = $this->baseFormCreator->editForm($model, $element['default_tied_status']);

            return view('activity.defaultTiedStatus.defaultTiedStatus', compact('form', 'activity'));
        } catch (\Exception $e) {
            logger()->error($e->getMessage());

            return redirect()->route('admin.activities.show', $id)->with('error', 'Error has occurred while rendering default tied status form.');
        }
    }

    /**
     * Updates default tied status data.
     *
     * @param DefaultTiedStatusRequest $request
     * @param $id
     *
     * @return JsonResponse|RedirectResponse
     */
    public function update(DefaultTiedStatusRequest $request, $id): JsonResponse|RedirectResponse
    {
        try {
            $activityData = $this->defaultTiedStatusService->getActivityData($id);
            $activityDefaultTiedStatus = (int) $request->get('default_tied_status');

            if (!$this->defaultTiedStatusService->update($activityDefaultTiedStatus, $activityData)) {
                return redirect()->route('admin.activities.show', $id)->with('error', 'Error has occurred while updating default tied status.');
            }

            return redirect()->route('admin.activities.show', $id)->with('success', 'Default tied status updated successfully.');
        } catch (\Exception $e) {
            logger()->error($e->getMessage());

            return redirect()->route('admin.activities.show', $id)->with('error', 'Error has occurred while updating default tied status.');
        }
    }
}
