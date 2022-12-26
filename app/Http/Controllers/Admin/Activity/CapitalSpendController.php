<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin\Activity;

use App\Http\Controllers\Controller;
use App\Http\Requests\Activity\CapitalSpend\CapitalSpendRequest;
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
            $form = $this->capitalSpendService->formGenerator($id);
            $data = [
                'title' => $element['label'],
                'name' => 'capital_spend',
            ];

            return view('admin.activity.capitalSpend.edit', compact('form', 'activity', 'data'));
        } catch (\Exception $e) {
            logger()->error($e->getMessage());

            return redirect()->route('admin.activity.show', $id)->with('error', trans('responses.error_has_occurred', ['event'=>trans('events.rendering'), 'suffix'=>trans('responses.activity_capital_form')]));
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
                return redirect()->route('admin.activity.show', $id)->with('error', trans('responses.error_has_occurred', ['event'=>trans('events.updating'), 'suffix'=>trans('responses.activity_capital_spend')]));
            }

            return redirect()->route('admin.activity.show', $id)->with('success', ucfirst(trans('responses.event_successfully', ['prefix'=>trans('responses.activity_capital_spend'), 'event'=>trans('events.updated')])));
        } catch (\Exception $e) {
            logger()->error($e->getMessage());

            return redirect()->route('admin.activity.show', $id)->with('error', trans('responses.error_has_occurred', ['event'=>trans('events.updating'), 'suffix'=>trans('responses.activity_capital_spend')]));
        }
    }
}
