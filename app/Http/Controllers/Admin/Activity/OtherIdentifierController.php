<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin\Activity;

use App\Http\Controllers\Controller;
use App\Http\Requests\Activity\OtherIdentifier\OtherIdentifierRequest;
use App\IATI\Services\Activity\OtherIdentifierService;
use Exception;
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
     * @return View|RedirectResponse
     */
    public function edit(int $id): View|RedirectResponse
    {
        try {
            $element = getElementSchema('other_identifier');
            $activity = $this->otherIdentifierService->getActivityData($id);
            $form = $this->otherIdentifierService->formGenerator($id);
            $data = ['title' => $element['label'], 'name' => 'other_identifier'];

            return view('admin.activity.otherIdentifier.edit', compact('form', 'activity', 'data'));
        } catch (Exception $e) {
            logger()->error($e->getMessage());

            return redirect()->route('admin.activity.show', $id)
                ->with('error', translateErrorHasOccurred('elements_common.other_identifier', 'opening', 'form'));
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
                return redirect()->route('admin.activity.show', $id)
                    ->with('error', translateErrorHasOccurred('elements_common.other_identifier', 'updating'));
            }

            return redirect()->route('admin.activity.show', $id)
                ->with('success', translateElementSuccessfully('other_identifier', 'updated'));
        } catch (Exception $e) {
            logger()->error($e->getMessage());

            return redirect()->route('admin.activity.show', $id)
                ->with('error', translateErrorHasOccurred('elements_common.other_identifier', 'updating'));
        }
    }
}
