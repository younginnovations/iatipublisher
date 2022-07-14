<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin\Activity;

use App\Http\Controllers\Controller;
use App\Http\Requests\Activity\CapitalSpend\CapitalSpendRequest;
use App\IATI\Elements\Builder\BaseFormCreator;
use App\IATI\Services\Activity\CapitalSpendService;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;

/**
 * Class CapitalSpendController.
 */
class CapitalSpendController extends Controller
{
    /**
     * @var BaseFormCreator
     */
    protected BaseFormCreator $baseFormCreator;

    /**
     * @var CapitalSpendService
     */
    protected CapitalSpendService $capitalSpendService;

    /**
     * CapitalSpendController Constructor.
     *
     * @param BaseFormCreator $baseFormCreator
     * @param CapitalSpendService $capitalSpendService
     */
    public function __construct(BaseFormCreator $baseFormCreator, CapitalSpendService $capitalSpendService)
    {
        $this->baseFormCreator = $baseFormCreator;
        $this->capitalSpendService = $capitalSpendService;
    }

    /**
     * Renders capital spend edit form.
     *
     * @param int $id
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|void
     */
    public function edit(int $id): View|RedirectResponse
    {
        try {
            $element = json_decode(file_get_contents(app_path('IATI/Data/elementJsonSchema.json')), true);
            $activity = $this->capitalSpendService->getActivityData($id);
            $model['capital_spend'] = $this->capitalSpendService->getCapitalSpendData($id);
            $this->baseFormCreator->url = route('admin.activities.capital-spend.update', [$id]);
            $form = $this->baseFormCreator->editForm($model, $element['capital_spend'], 'PUT', '/activities/' . $id);
            $data = ['core' => $element['capital_spend']['criteria'], 'status' => $activity->capital_spend_element_completed, 'title' => $element['capital_spend']['label'], 'name' => 'capital_spend'];

            return view('activity.capitalSpend.capitalSpend', compact('form', 'activity', 'data'));
        } catch (\Exception $e) {
            logger()->error($e->getMessage());

            return redirect()->route('admin.activities.show', $id)->with('error', 'Error has occurred while rendering activity capital-spend form.');
        }
    }

    /**
     * Updates capitals spend data.
     *
     * @param CapitalSpendRequest $request
     * @param $id
     *
     * @return JsonResponse|RedirectResponse
     */
    public function update(CapitalSpendRequest $request, $id): JsonResponse|RedirectResponse
    {
        try {
            $activityData = $this->capitalSpendService->getActivityData($id);
            $activityCapitalSpend = $request->get('capital_spend') != null ? (float) $request->get('capital_spend') : null;

            if (!$this->capitalSpendService->update($activityCapitalSpend, $activityData)) {
                return redirect()->route('admin.activities.show', $id)->with('error', 'Error has occurred while updating activity capital-spend.');
            }

            return redirect()->route('admin.activities.show', $id)->with('success', 'Activity capital-spend updated successfully.');
        } catch (\Exception $e) {
            logger()->error($e->getMessage());

            return redirect()->route('admin.activities.show', $id)->with('error', 'Error has occurred while updating activity capital-spend.');
        }
    }
}
