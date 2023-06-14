<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin\Activity;

use App\Http\Controllers\Controller;
use App\Http\Requests\Activity\Identifier\IdentifierRequest;
use App\IATI\Services\Activity\ActivityIdentifierService;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;

/**
 * Class IdentifierController.
 */
class IdentifierController extends Controller
{
    /**
     * @var ActivityIdentifierService
     */
    protected ActivityIdentifierService $identifierService;

    /**
     * IdentifierController Constructor.
     *
     * @param ActivityIdentifierService $identifierService
     */
    public function __construct(ActivityIdentifierService $identifierService)
    {
        $this->identifierService = $identifierService;
    }

    /**
     * Renders status edit form.
     *
     * @param int $id
     *
     * @return View|RedirectResponse
     */
    public function edit(int $id): View|RedirectResponse
    {
        try {
            $element = getElementSchema('iati_identifier');
            $activity = $this->identifierService->getActivityData($id);
            $form = $this->identifierService->formGenerator($id);
            $data = ['title' => $element['label'], 'name' => 'iati_identifier'];

            return view('admin.activity.identifier.edit', compact('form', 'activity', 'data'));
        } catch (\Exception $e) {
            logger()->error($e->getMessage());

            return redirect()->route('admin.activity.show', $id)->with('error', trans('responses.error_has_occurred_form', ['event'=>trans('events.opening'), 'suffix'=>trans('responses.activity_title')]));
        }
    }

    /**
     * Updates identifier data.
     *
     * @param IdentifierRequest $request
     * @param                   $id
     *
     * @return JsonResponse|RedirectResponse
     */
    public function update(IdentifierRequest $request, $id): JsonResponse|RedirectResponse
    {
        try {
            DB::beginTransaction();

            if (!$this->identifierService->update($id, $request->except(['_method', '_token']))) {
                return redirect()->route('admin.activity.show', $id)->with('error', trans('responses.error_has_occurred', ['event'=>trans('events.updating'), 'suffix'=>trans('elements_common.iati_identifier')]));
            }

            DB::commit();

            return redirect()->route('admin.activity.show', $id)->with('success', ucfirst(trans('responses.event_successfully', ['prefix'=>trans('elements_common.iati_identifier'), 'event'=>trans('events.updated')])));
        } catch (\Exception $e) {
            DB::rollBack();
            logger()->error($e->getMessage());

            return response()->json(
                ['success' => false, 'error' => trans('responses.error_has_occurred', ['event'=>trans('events.updating'), 'suffix'=>trans('elements_common.iati_identifier')])]
            );
        }
    }
}
