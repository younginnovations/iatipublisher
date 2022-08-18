<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin\Organization;

use App\Http\Controllers\Controller;
use App\Http\Requests\Organization\TotalBudget\TotalBudgetRequest;
use App\IATI\Services\Organization\TotalBudgetService;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;

/**
 * Class TotalBudgetController.
 */
class TotalBudgetController extends Controller
{
    protected totalBudgetService $totalBudgetService;

    /**
     * TotalBudgetController Constructor.
     *
     * @param totalBudgetService    $totalBudgetService
     */
    public function __construct(TotalBudgetService $totalBudgetService)
    {
        $this->totalBudgetService = $totalBudgetService;
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
            $organization = $this->totalBudgetService->getOrganizationData($id);
            $form = $this->totalBudgetService->formGenerator($id);
            $data = ['core'=> $element['total_budget']['criteria'] ?? false, 'status'=> $organization->total_budget_element_completed ?? false, 'title'=> $element['total_budget']['label'], 'name'=>'total-budget'];

            return view('admin.organisation.forms.totalBudget.totalBudget', compact('form', 'organization', 'data'));
        } catch (\Exception $e) {
            logger()->error($e->getMessage());

            return redirect()->route('admin.organisation.index')->with('error', 'Error has occurred while opening organization reporting_org form.');
        }
    }

    /**
     * Updates organization total budget data.
     *
     * @param TotalBudgetRequest $request
     *
     * @return RedirectResponse
     */
    public function update(TotalBudgetRequest $request): RedirectResponse
    {
        try {
            $id = Auth::user()->organization_id;
            $totalBudget = $request->all();

            if (!$this->totalBudgetService->update($id, $totalBudget)) {
                return redirect()->route('admin.organisation.index', $id)->with('error', 'Error has occurred while updating organization total-budget.');
            }

            return redirect()->route('admin.organisation.index', $id)->with('success', 'Organization total-budget updated successfully.');
        } catch (\Exception $e) {
            logger()->error($e->getMessage());

            return redirect()->route('admin.organisation.index', $id)->with('error', 'Error has occurred while updating organization total-budget.');
        }
    }
}
