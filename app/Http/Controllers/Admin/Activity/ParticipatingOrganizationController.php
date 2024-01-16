<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin\Activity;

use App\Http\Controllers\Controller;
use App\Http\Requests\Activity\ParticipatingOrganization\ParticipatingOrganizationRequest;
use App\IATI\Services\Activity\ParticipatingOrganizationService;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;

/**
 * Class ParticipatingOrganizationController
 *.
 */
class ParticipatingOrganizationController extends Controller
{
    /**
     * @var ParticipatingOrganizationService
     */
    protected ParticipatingOrganizationService $participatingOrganizationService;

    /**
     * ParticipatingOrganizationController Constructor.
     *
     * @param ParticipatingOrganizationService $participatingOrganizationService
     */
    public function __construct(ParticipatingOrganizationService $participatingOrganizationService)
    {
        $this->participatingOrganizationService = $participatingOrganizationService;
    }

    /**
     * Renders participating organization edit form.
     *
     * @param int $id
     *
     * @return View|RedirectResponse
     */
    public function edit(int $id): View|RedirectResponse
    {
        try {
            $element = getElementSchema('participating_org');
            $activity = $this->participatingOrganizationService->getActivityData($id);
            $form = $this->participatingOrganizationService->formGenerator($id);
            $data = ['title' => $element['label'], 'name' => 'participating_org'];

            return view('admin.activity.participatingOrganization.edit', compact('form', 'activity', 'data'));
        } catch (\Exception $e) {
            logger()->error($e->getMessage());

            return redirect()->route('admin.activity.show', $id)
                ->with('error', translateErrorHasOccurred('elements_common.participating_organisation', 'rendering', 'form'));
        }
    }

    /**
     * Updates participating-organization data.
     *
     * @param ParticipatingOrganizationRequest $request
     * @param                                  $id
     *
     * @return JsonResponse|RedirectResponse
     */
    public function update(ParticipatingOrganizationRequest $request, $id): JsonResponse|RedirectResponse
    {
        try {
            if (!$this->participatingOrganizationService->update($id, $request->except(['_token', '_method']))) {
                return redirect()->route('admin.activities.show', $id)
                    ->with('error', translateErrorHasOccurred('elements_common.participating_organisation', 'updating'));
            }

            return redirect()->route('admin.activity.show', $id)
               ->with('success', translateElementSuccessfully('participating_organisation', 'updated'));
        } catch (\Exception $e) {
            logger()->error($e->getMessage());

            return redirect()->route('admin.activity.show', $id)
               ->with('error', translateErrorHasOccurred('elements_common.participating_organisation', 'updating'));
        }
    }
}
