<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin\Organization;

use App\Http\Controllers\Controller;
use App\Http\Requests\Organization\RecipientOrgBudget\RecipientOrgBudgetRequest;
use App\IATI\Elements\Builder\ParentCollectionFormCreator;
use App\IATI\Services\Organization\RecipientOrgBudgetService;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;

/**
 * Class RecipientOrgBudgetController.
 */
class RecipientOrgBudgetController extends Controller
{
    protected ParentCollectionFormCreator $parentCollectionFormCreator;

    protected RecipientOrgBudgetService $recipientOrgBudgetService;

    /**
     * RecipientOrgBudgetController Constructor.
     *
     * @param ParentCollectionFormCreator $parentCollectionFormCreator
     * @param recipientOrgBudgetService    $recipientOrgBudgetService
     */
    public function __construct(ParentCollectionFormCreator $parentCollectionFormCreator, RecipientOrgBudgetService $recipientOrgBudgetService)
    {
        $this->parentCollectionFormCreator = $parentCollectionFormCreator;
        $this->recipientOrgBudgetService = $recipientOrgBudgetService;
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
            $organization = $this->recipientOrgBudgetService->getOrganizationData($id);
            $model['recipient_org_budget'] = $this->recipientOrgBudgetService->getRecipientOrgBudgetData($id) ?? [];
            $this->parentCollectionFormCreator->url = route('admin.organisation.recipient-org-budget.update', [$id]);
            $form = $this->parentCollectionFormCreator->editForm($model, $element['recipient_org_budget'], 'PUT', '/organisation');
            $status = $organization->total_budget_element_completed ?? false;
            $data = ['core'=> $element['total_budget']['criteria'] ?? false, 'status'=> $organization->total_budget_element_completed ?? false, 'title'=> $element['recipient_org_budget']['label'], 'name'=>'recipient_org_budget'];

            return view('admin.organisation.forms.recipientOrgBudget.recipientOrgBudget', compact('form', 'organization', 'data'));
        } catch (\Exception $e) {
            dd($e);
            logger()->error($e->getMessage());

            return redirect()->route('admin.organisation.index')->with('error', 'Error has occurred while opening organization reporting_org form.');
        }
    }

    /**
     * Updates organization total budget data.
     *
     * @param RecipientOrgBudgetRequest $request
     *
     * @return JsonResponse|RedirectResponse
     */
    public function update(RecipientOrgBudgetRequest $request): JsonResponse| RedirectResponse
    {
        try {
            $id = Auth::user()->organization_id;
            $organizationData = $this->recipientOrgBudgetService->getOrganizationData($id);
            $organizationTitle = $request->all();

            if (!$this->recipientOrgBudgetService->update($organizationTitle, $organizationData)) {
                return redirect()->route('admin.organisation.index', $id)->with('error', 'Error has occurred while updating organization total-budget.');
            }

            return redirect()->route('admin.organisation.index', $id)->with('success', 'Organization total-budget updated successfully.');
        } catch (\Exception $e) {
            dd($e);
            logger()->error($e->getMessage());

            return redirect()->route('admin.organisation.index', $id)->with('error', 'Error has occurred while updating organization total-budget.');
        }
    }
}
