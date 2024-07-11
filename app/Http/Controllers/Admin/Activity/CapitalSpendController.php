<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin\Activity;

use App\Http\Controllers\Controller;
use App\Http\Requests\Activity\CapitalSpend\CapitalSpendRequest;
use App\IATI\Services\Activity\CapitalSpendService;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Arr;

/**
 * Class CapitalSpendController.
 */
class CapitalSpendController extends Controller
{
    /**
     * @var CapitalSpendService
     */
    protected CapitalSpendService $capitalSpendService;

    /**
     * CapitalSpendController Constructor.
     *
     * @param CapitalSpendService $capitalSpendService
     */
    public function __construct(CapitalSpendService $capitalSpendService)
    {
        $this->capitalSpendService = $capitalSpendService;
    }

    /**
     * Renders capital spend edit form.
     *
     * @param int $id
     *
     * @return View|RedirectResponse
     */
    public function edit(int $id): View|RedirectResponse
    {
        try {
            $element = getElementSchema('capital_spend');
            $activity = $this->capitalSpendService->getActivityData($id);
            $deprecationStatusMap = Arr::get($activity->deprecation_status_map, 'capital_spend', []);
            $form = $this->capitalSpendService->formGenerator($id, deprecationStatusMap: $deprecationStatusMap);
            $data = [
                'title' => $element['label'],
                'name' => 'capital_spend',
            ];

            return view('admin.activity.capitalSpend.edit', compact('form', 'activity', 'data'));
        } catch (\Exception $e) {
            logger()->error($e->getMessage());

            return redirect()->route('admin.activity.show', $id)->with('error', 'Error has occurred while rendering activity capital-spend form.');
        }
    }

    /**
     * Updates capitals spend data.
     *
     * @param $id
     * @param CapitalSpendRequest $request
     *
     * @return JsonResponse|RedirectResponse
     */
    public function update($id, CapitalSpendRequest $request): JsonResponse|RedirectResponse
    {
        try {
            $activityCapitalSpend = $request->get('capital_spend') !== null ? (float) $request->get('capital_spend') : null;

            if (!$this->capitalSpendService->update($id, $activityCapitalSpend)) {
                return redirect()->route('admin.activity.show', $id)->with('error', 'Error has occurred while updating activity capital-spend.');
            }

            return redirect()->route('admin.activity.show', $id)->with('success', 'Activity capital-spend updated successfully.');
        } catch (\Exception $e) {
            logger()->error($e->getMessage());

            return redirect()->route('admin.activity.show', $id)->with('error', 'Error has occurred while updating activity capital-spend.');
        }
    }
}
