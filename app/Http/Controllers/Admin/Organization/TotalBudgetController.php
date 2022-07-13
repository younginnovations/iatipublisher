<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin\Organization;

use App\Http\Controllers\Controller;
use App\Http\Requests\Organization\TotalBudget\TotalBudgetRequest;
use App\IATI\Elements\Builder\ParentCollectionFormCreator;
use App\IATI\Services\Organization\TotalBudgetService;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;

/**
 * Class TotalBudgetController.
 */
class TotalBudgetController extends Controller
{
    protected ParentCollectionFormCreator $parentCollectionFormCreator;

    protected totalBudgetService $totalBudgetService;

    /**
     * TotalBudgetController Constructor.
     *
     * @param ParentCollectionFormCreator $parentCollectionFormCreator
     * @param totalBudgetService    $totalBudgetService
     */
    public function __construct(ParentCollectionFormCreator $parentCollectionFormCreator, totalBudgetService $totalBudgetService)
    {
        $this->parentCollectionFormCreator = $parentCollectionFormCreator;
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
            $model['total_budget'] = $this->totalBudgetService->getTotalBudgetData($id) ?? [];
            $this->parentCollectionFormCreator->url = route('admin.organisation.total-budget.update', [$id]);
            $form = $this->parentCollectionFormCreator->editForm($model, $element['total_budget']);
            $status = $organization->total_budget_element_completed ?? false;
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
     * @return JsonResponse|RedirectResponse
     */
    public function update(TotalBudgetRequest $request): JsonResponse| RedirectResponse
    {
        try {
            $id = Auth::user()->organization_id;
            $organizationData = $this->totalBudgetService->getOrganizationData($id);
            $organizationTitle = $request->all();

            if (!$this->totalBudgetService->update($organizationTitle, $organizationData)) {
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
