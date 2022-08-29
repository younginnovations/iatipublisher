<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin\Organization;

use App\Http\Controllers\Controller;
use App\Http\Requests\Organization\RecipientOrgBudget\RecipientOrgBudgetRequest;
use App\IATI\Services\Organization\RecipientOrgBudgetService;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;

/**
 * Class RecipientOrgBudgetController.
 */
class RecipientOrgBudgetController extends Controller
{
    /**
     * @var RecipientOrgBudgetService
     */
    protected RecipientOrgBudgetService $recipientOrgBudgetService;

    /**
     * RecipientOrgBudgetController Constructor.
     *
     * @param recipientOrgBudgetService    $recipientOrgBudgetService
     */
    public function __construct(RecipientOrgBudgetService $recipientOrgBudgetService)
    {
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
            $form = $this->recipientOrgBudgetService->formGenerator($id);
            $data = ['core' => $element['recipient_region_budget']['criteria'] ?? false, 'status' => $organization->element_status['recipient_region_budget'] ?? false, 'title' => $element['recipient_org_budget']['label'], 'name' => 'recipient_org_budget'];

            return view('admin.organisation.forms.recipientOrgBudget.recipientOrgBudget', compact('form', 'organization', 'data'));
        } catch (\Exception $e) {
            logger()->error($e->getMessage());

            return redirect()->route('admin.organisation.index')->with('error', 'Error has occurred while opening organization recipient-org-budget form.');
        }
    }

    /**
     * Updates organization total budget data.
     *
     * @param RecipientOrgBudgetRequest $request
     *
     * @return RedirectResponse
     */
    public function update(RecipientOrgBudgetRequest $request): RedirectResponse
    {
        try {
            $id = Auth::user()->organization_id;
            $organizationTitle = $request->all();

            if (!$this->recipientOrgBudgetService->update($id, $organizationTitle)) {
                return redirect()->route('admin.organisation.index', $id)->with('error', 'Error has occurred while updating organization recipient-org-budget.');
            }

            return redirect()->route('admin.organisation.index', $id)->with('success', 'Organization recipient-org-budget updated successfully.');
        } catch (\Exception $e) {
            logger()->error($e->getMessage());

            return redirect()->route('admin.organisation.index', $id)->with('error', 'Error has occurred while updating organization recipient-org-budget.');
        }
    }
}
