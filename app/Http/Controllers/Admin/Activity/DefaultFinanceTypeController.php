<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin\Activity;

use App\Http\Controllers\Controller;
use App\Http\Requests\Activity\DefaultFinanceType\DefaultFinanceTypeRequest;
use App\IATI\Services\Activity\DefaultFinanceTypeService;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;

/**
 * Class DefaultFinanceTypeController.
 */
class DefaultFinanceTypeController extends Controller
{
    /**
     * @var DefaultFinanceTypeService
     */
    protected DefaultFinanceTypeService $defaultFinanceTypeService;

    /**
     * DefaultFinanceTypeController Constructor.
     *
     * @param DefaultFinanceTypeService $defaultFinanceTypeService
     */
    public function __construct(DefaultFinanceTypeService $defaultFinanceTypeService)
    {
        $this->defaultFinanceTypeService = $defaultFinanceTypeService;
    }

    /**
     * Renders default finance type edit form.
     *
     * @param int $id
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|void
     */
    public function edit(int $id): View|RedirectResponse
    {
        try {
            $element = json_decode(file_get_contents(app_path('IATI/Data/elementJsonSchema.json')), true);
            $activity = $this->defaultFinanceTypeService->getActivityData($id);
            $form = $this->defaultFinanceTypeService->formGenerator($id);
            $data = ['core' => $element['default_finance_type']['criteria'] ?? '', 'title' => $element['default_finance_type']['label'], 'name' => 'default_finance_type'];

            return view('admin.activity.defaultFinanceType.edit', compact('form', 'activity', 'data'));
        } catch (\Exception $e) {
            logger()->error($e->getMessage());

            return redirect()->route('admin.activities.show', $id)->with('error', 'Error has occurred while rendering default-finance-type form.');
        }
    }

    /**
     * Updates default finance type data.
     *
     * @param DefaultFinanceTypeRequest $request
     * @param $id
     *
     * @return JsonResponse|RedirectResponse
     */
    public function update(DefaultFinanceTypeRequest $request, $id): JsonResponse|RedirectResponse
    {
        try {
            $activityData = $this->defaultFinanceTypeService->getActivityData($id);
            $activityDefaultFinanceType = $request->get('default_finance_type') != null ? (int) $request->get('default_finance_type') : null;

            if (!$this->defaultFinanceTypeService->update($activityDefaultFinanceType, $activityData)) {
                return redirect()->route('admin.activities.show', $id)->with('error', 'Error has occurred while updating default-finance-type.');
            }

            return redirect()->route('admin.activities.show', $id)->with('success', 'Default-finance-type updated successfully.');
        } catch (\Exception $e) {
            logger()->error($e->getMessage());

            return redirect()->route('admin.activities.show', $id)->with('error', 'Error has occurred while updating default-finance-type.');
        }
    }
}
