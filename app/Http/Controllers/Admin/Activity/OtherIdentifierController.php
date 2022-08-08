<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin\Activity;

use App\Http\Controllers\Controller;
use App\Http\Requests\Activity\OtherIdentifier\OtherIdentifierRequest;
use App\IATI\Services\Activity\OtherIdentifierService;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;

/**
 * Class OtherIdentifierController.
 */
class OtherIdentifierController extends Controller
{
    /**
     * @var otherIdentifierService
     */
    protected OtherIdentifierService $otherIdentifierService;

    /**
     * OtherIdentifierController Constructor.
     *
     * @param otherIdentifierService $otherIdentifierService
     */
    public function __construct(OtherIdentifierService $otherIdentifierService)
    {
        $this->otherIdentifierService = $otherIdentifierService;
    }

    /**
     * Renders condition edit form.
     *
     * @param int $id
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|void
     */
    public function edit(int $id): View|RedirectResponse
    {
        try {
            $element = getElementSchema('other_identifier');
            $activity = $this->otherIdentifierService->getActivityData($id);
            $form = $this->otherIdentifierService->formGenerator($id);
            $data = ['core' => $element['other_identifier']['criteria'] ?? '', 'title' => $element['other_identifier']['label'], 'name' => 'other_identifier'];

            return view('admin.activity.otherIdentifier.edit', compact('form', 'activity', 'data'));
        } catch (\Exception $e) {
            logger()->error($e->getMessage());

            return redirect()->route('admin.activity.show', $id)->with('error', 'Error has occurred while opening other-identifier edit form.');
        }
    }

    /**
     * Updates condition data.
     *
     * @param OtherIdentifierRequest $request
     * @param $id
     *
     * @return JsonResponse|RedirectResponse
     */
    public function update(OtherIdentifierRequest $request, $id): JsonResponse|RedirectResponse
    {
        try {
            if (!$this->otherIdentifierService->update($id, $request->get('other_identifier'))) {
                return redirect()->route('admin.activity.show', $id)->with('error', 'Error has occurred while updating other-identifier.');
            }

            return redirect()->route('admin.activity.show', $id)->with('success', 'Other-identifier updated successfully.');
        } catch (\Exception $e) {
            logger()->error($e->getMessage());

            return redirect()->route('admin.activity.show', $id)->with('error', 'Error has occurred while updating other-identifier.');
        }
    }
}
