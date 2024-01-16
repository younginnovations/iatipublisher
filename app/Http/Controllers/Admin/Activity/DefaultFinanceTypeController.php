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
     * @return View|RedirectResponse
     */
    public function edit(int $id): View|RedirectResponse
    {
        try {
            $element = getElementSchema('default_finance_type');
            $activity = $this->defaultFinanceTypeService->getActivityData($id);
            $form = $this->defaultFinanceTypeService->formGenerator($id);
            $data = [
                'title' => $element['label'],
                'name' => 'default_finance_type',
            ];

            return view('admin.activity.defaultFinanceType.edit', compact('form', 'activity', 'data'));
        } catch (\Exception $e) {
            logger()->error($e->getMessage());

            return redirect()->route('admin.activity.show', $id)
                ->with('error', translateErrorHasOccurred('elements_common.default_finance_type', 'rendering', 'form'));
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
            $activityDefaultFinanceType = $request->get('default_finance_type') !== null ? (int) $request->get('default_finance_type') : null;

            if (!$this->defaultFinanceTypeService->update($id, $activityDefaultFinanceType)) {
                return redirect()->route('admin.activity.show', $id)->with('error', translateErrorHasOccurred('elements_common.default_finance_type', 'updating'));
            }

            return redirect()->route('admin.activity.show', $id)->with('success', translateElementSuccessfully('default_finance_type', 'updated'));
        } catch (\Exception $e) {
            logger()->error($e->getMessage());

            return redirect()->route('admin.activity.show', $id)->with('error', translateErrorHasOccurred('elements_common.default_finance_type', 'updating'));
        }
    }
}
