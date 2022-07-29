<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin\Organization;

use App\Http\Controllers\Controller;
use App\Http\Requests\Organization\RecipientRegionBudget\RecipientRegionBudgetRequest;
use App\IATI\Elements\Builder\ParentCollectionFormCreator;
use App\IATI\Services\Organization\RecipientRegionBudgetService;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;

/**
 * Class RecipientRegionBudgetController.
 */
class RecipientRegionBudgetController extends Controller
{
    protected ParentCollectionFormCreator $parentCollectionFormCreator;

    protected RecipientRegionBudgetService $recipientRegionBudgetService;

    /**
     * RecipientRegionBudgetController Constructor.
     *
     * @param ParentCollectionFormCreator $parentCollectionFormCreator
     * @param recipientRegionBudgetService    $recipientRegionBudgetService
     */
    public function __construct(ParentCollectionFormCreator $parentCollectionFormCreator, RecipientRegionBudgetService $recipientRegionBudgetService)
    {
        $this->parentCollectionFormCreator = $parentCollectionFormCreator;
        $this->recipientRegionBudgetService = $recipientRegionBudgetService;
    }

    /**
     * Renders title edit form.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|void|RedirectResponse
     */
    public function edit(): View|RedirectResponse
    {
        try {
            $id = Auth::user()->organization_id;
            $element = json_decode(file_get_contents(app_path('IATI/Data/organizationElementJsonSchema.json')), true);
            $organization = $this->recipientRegionBudgetService->getOrganizationData($id);
            $model['recipient_region_budget'] = $this->recipientRegionBudgetService->getRecipientRegionBudgetData($id) ?? [];
            $this->parentCollectionFormCreator->url = route('admin.organisation.recipient-region-budget.update', [$id]);
            $form = $this->parentCollectionFormCreator->editForm($model, $element['recipient_region_budget'], 'PUT', '/organisation');
            $status = $organization->recipient_region_budget_element_completed ?? false;
            $data = ['core'=> $element['recipient_region_budget']['criteria'] ?? false, 'status'=> $organization->recipient_region_budget_element_completed ?? false, 'title'=> $element['recipient_region_budget']['label'], 'name'=>'recipient_region_budget'];

            return view('admin.organisation.forms.recipientRegionBudget.recipientRegionBudget', compact('form', 'organization', 'data'));
        } catch (\Exception $e) {
            logger()->error($e->getMessage());

            return redirect()->route('admin.organisation.index')->with('error', 'Error has occurred while opening organization reporting_org form.');
        }
    }

    /**
     * Updates organization total budget data.
     *
     * @param RecipientRegionBudgetRequest $request
     *
     * @return JsonResponse|RedirectResponse
     */
    public function update(RecipientRegionBudgetRequest $request): JsonResponse| RedirectResponse
    {
        try {
            $id = Auth::user()->organization_id;
            $organizationData = $this->recipientRegionBudgetService->getOrganizationData($id);
            $organizationTitle = $request->all();

            if (!$this->recipientRegionBudgetService->update($organizationTitle, $organizationData)) {
                return redirect()->route('admin.organisation.index', $id)->with('error', 'Error has occurred while updating organization total-budget.');
            }

            return redirect()->route('admin.organisation.index', $id)->with('success', 'Organization total-budget updated successfully.');
        } catch (\Exception $e) {
            logger()->error($e->getMessage());

            return redirect()->route('admin.organisation.index', $id)->with('error', 'Error has occurred while updating organization total-budget.');
        }
    }
}
