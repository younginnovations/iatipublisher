<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin\Activity;

use App\Http\Controllers\Controller;
use App\Http\Requests\Activity\PolicyMarker\PolicyMarkerRequest;
use App\IATI\Services\Activity\PolicyMarkerService;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;

/**
 * Class PolicyMarkerController.
 */
class PolicyMarkerController extends Controller
{
    /**
     * @var PolicyMarkerService
     */
    protected PolicyMarkerService $policyMarkerService;

    /**
     * PolicyMarkerController Constructor.
     *
     * @param PolicyMarkerService $policyMarkerService
     */
    public function __construct(PolicyMarkerService $policyMarkerService)
    {
        $this->policyMarkerService = $policyMarkerService;
    }

    /**
     * Renders humanitarian edit form.
     *
     * @param int $id
     *
     * @return View|RedirectResponse
     */
    public function edit(int $id): View|RedirectResponse
    {
        try {
            $element = getElementSchema('policy_marker');
            $activity = $this->policyMarkerService->getActivityData($id);
            $form = $this->policyMarkerService->formGenerator($id);
            $data = ['core' => $element['policy_marker']['criteria'] ?? '', 'title' => $element['policy_marker']['label'], 'name' => 'policy_marker'];

            return view('admin.activity.policyMarker.edit', compact('form', 'activity', 'data'));
        } catch (\Exception $e) {
            logger()->error($e->getMessage());

            return redirect()->route('admin.activity.show', $id)->with('error', 'Error has occurred while opening policy-marker form.');
        }
    }

    /**
     * Updates policy-marker form.
     *
     * @param PolicyMarkerRequest $request
     * @param $id
     *
     * @return JsonResponse|RedirectResponse
     */
    public function update(PolicyMarkerRequest $request, $id): JsonResponse|RedirectResponse
    {
        try {
            if (!$this->policyMarkerService->update($id, $request->all())) {
                return redirect()->route('admin.activity.show', $id)->with('error', 'Error has occurred while updating policy-marker.');
            }

            return redirect()->route('admin.activity.show', $id)->with('success', 'Policy-marker updated successfully.');
        } catch (\Exception $e) {
            logger()->error($e->getMessage());

            return redirect()->route('admin.activity.show', $id)->with('error', 'Error has occurred while updating policy-marker.');
        }
    }
}
