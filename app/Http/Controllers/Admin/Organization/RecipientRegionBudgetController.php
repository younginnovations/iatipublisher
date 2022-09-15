<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin\Organization;

use App\Http\Controllers\Controller;
use App\Http\Requests\Organization\RecipientRegionBudget\RecipientRegionBudgetRequest;
use App\IATI\Services\Organization\RecipientRegionBudgetService;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;

/**
 * Class RecipientRegionBudgetController.
 */
class RecipientRegionBudgetController extends Controller
{
    /**
     * @var RecipientRegionBudgetService
     */
    protected RecipientRegionBudgetService $recipientRegionBudgetService;

    /**
     * RecipientRegionBudgetController Constructor.
     *
     * @param recipientRegionBudgetService    $recipientRegionBudgetService
     */
    public function __construct(RecipientRegionBudgetService $recipientRegionBudgetService)
    {
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
            $form = $this->recipientRegionBudgetService->formGenerator($id);
            $data = ['title' => $element['recipient_region_budget']['label'], 'name' => 'recipient_region_budget'];

            return view('admin.organisation.forms.recipientRegionBudget.recipientRegionBudget', compact('form', 'organization', 'data'));
        } catch (\Exception $e) {
            logger()->error($e->getMessage());

            return redirect()->route('admin.organisation.index')->with('error', 'Error has occurred while opening organization recipient-region-budget form.');
        }
    }

    /**
     * Updates organization total budget data.
     *
     * @param RecipientRegionBudgetRequest $request
     *
     * @return RedirectResponse
     */
    public function update(RecipientRegionBudgetRequest $request): RedirectResponse
    {
        try {
            $id = Auth::user()->organization_id;
            $recipientRegionBudgetRequest = $request->all();

            if (!$this->recipientRegionBudgetService->update($id, $recipientRegionBudgetRequest)) {
                return redirect()->route('admin.organisation.index', $id)->with('error', 'Error has occurred while updating organization recipient-region-budget.');
            }

            return redirect()->route('admin.organisation.index', $id)->with('success', 'Organization recipient-region-budget updated successfully.');
        } catch (\Exception $e) {
            logger()->error($e->getMessage());

            return redirect()->route('admin.organisation.index', $id)->with('error', 'Error has occurred while updating organization recipient-region-budget.');
        }
    }
}
