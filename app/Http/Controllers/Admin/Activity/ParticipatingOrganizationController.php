<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin\Activity;

use App\Http\Controllers\Controller;
use App\Http\Requests\Activity\ParticipatingOrganization\ParticipatingOrganizationRequest;
use App\IATI\Elements\Builder\ParentCollectionFormCreator;
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
     * @var ParentCollectionFormCreator
     */
    protected ParentCollectionFormCreator $parentCollectionFormCreator;

    /**
     * @var ParticipatingOrganizationService
     */
    protected ParticipatingOrganizationService $participatingOrganizationService;

    /**
     * ParticipatingOrganizationController Constructor.
     *
     * @param ParentCollectionFormCreator $parentCollectionFormCreator
     * @param ParticipatingOrganizationService $participatingOrganizationService
     */
    public function __construct(ParticipatingOrganizationService $participatingOrganizationService, ParentCollectionFormCreator $parentCollectionFormCreator)
    {
        $this->parentCollectionFormCreator = $parentCollectionFormCreator;
        $this->participatingOrganizationService = $participatingOrganizationService;
    }

    /**
     * Renders participating organization edit form.
     *
     * @param int $id
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|void
     */
    public function edit(int $id):View|RedirectResponse
    {
        try {
            $element = json_decode(file_get_contents(app_path('IATI/Data/elementJsonSchema.json')), true);
            $activity = $this->participatingOrganizationService->getActivityData($id);
            $model['participating_org'] = $this->participatingOrganizationService->getParticipatingOrganizationData($id) ?: [];
            $this->parentCollectionFormCreator->url = route('admin.activities.participating-org.update', [$id]);
            $form = $this->parentCollectionFormCreator->editForm($model, $element['participating_org']);

            return view('activity.participatingOrganization.participatingOrganization', compact('form', 'activity'));
        } catch (\Exception $e) {
            dd($e);
            logger()->error($e->getMessage());

            return redirect()->route('admin.activities.show', $id)->with('error', 'Error has occurred while rendering participating organization form.');
        }
    }

    /**
     * Updates participating organization data.
     *
     * @param ParticipatingOrganizationRequest $request
     * @param $id
     *
     * @return JsonResponse|RedirectResponse
     */
    public function update(ParticipatingOrganizationRequest $request, $id): JsonResponse|RedirectResponse
    {
        try {
            $activityData = $this->participatingOrganizationService->getActivityData($id);
            $activityCountryBudgetItem = $request->except(['_token', '_method']);

            if (!$this->participatingOrganizationService->update($activityCountryBudgetItem, $activityData)) {
                return redirect()->route('admin.activities.show', $id)->with('error', 'Error has occurred while updating participating organization.');
            }

            return redirect()->route('admin.activities.show', $id)->with('success', 'Participating organization updated successfully.');
        } catch (\Exception $e) {
            logger()->error($e->getMessage());

            return redirect()->route('admin.activities.show', $id)->with('error', 'Error has occurred while updating participating organization.');
        }
    }
}
