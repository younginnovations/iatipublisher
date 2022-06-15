<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin\Activity;

use App\Http\Controllers\Controller;
use App\Http\Requests\Activity\DefaultFinanceType\DefaultFinanceTypeRequest;
use App\IATI\Elements\Builder\BaseFormCreator;
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
     * @var BaseFormCreator
     */
    protected BaseFormCreator $baseFormCreator;

    /**
     * @var DefaultFinanceTypeService
     */
    protected DefaultFinanceTypeService $defaultFinanceTypeService;

    /**
     * DefaultFinanceTypeController Constructor.
     *
     * @param BaseFormCreator $baseFormCreator
     * @param DefaultFinanceTypeService $defaultFinanceTypeService
     */
    public function __construct(BaseFormCreator $baseFormCreator, DefaultFinanceTypeService $defaultFinanceTypeService)
    {
        $this->baseFormCreator = $baseFormCreator;
        $this->defaultFinanceTypeService = $defaultFinanceTypeService;
    }

    /**
     * Renders default finance type edit form.
     *
     * @param int $id
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|void
     */
    public function edit(int $id):View|RedirectResponse
    {
        try {
            $element = json_decode(file_get_contents(app_path('IATI/Data/elementJsonSchema.json')), true);
            $activity = $this->defaultFinanceTypeService->getActivityData($id);
            $model['default_finance_type'] = $this->defaultFinanceTypeService->getDefaultFinanceTypeData($id);
            $this->baseFormCreator->url = route('admin.activities.default-finance-type.update', [$id]);
            $form = $this->baseFormCreator->editForm($model, $element['default-finance-type']);

            return view('activity.defaultFinanceType.defaultFinanceType', compact('form', 'activity'));
        } catch (\Exception $e) {
            logger()->error($e->getMessage());

            return redirect()->route('admin.activities.show', $id)->with('error', 'Error has occurred while updating default finance type.');
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
            $activityDefaultFinanceType = (int) $request->get('default_finance_type');

            if (!$this->defaultFinanceTypeService->update($activityDefaultFinanceType, $activityData)) {
                return redirect()->route('admin.activities.show', $id)->with('error', 'Error has occurred while updating default finance type.');
            }

            return redirect()->route('admin.activities.show', $id)->with('success', 'Default finance type updated successfully.');
        } catch (\Exception $e) {
            logger()->error($e->getMessage());

            return redirect()->route('admin.activities.show', $id)->with('error', 'Error has occurred while updating default finance type.');
        }
    }
}
