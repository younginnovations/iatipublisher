<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin\Organization;

use App\Http\Controllers\Controller;
use App\Http\Requests\Organization\TotalExpenditure\TotalExpenditureRequest;
use App\IATI\Elements\Builder\ParentCollectionFormCreator;
use App\IATI\Services\Organization\TotalExpenditureService;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;

/**
 * Class TotalExpenditureController.
 */
class TotalExpenditureController extends Controller
{
    protected ParentCollectionFormCreator $parentCollectionFormCreator;

    protected TotalExpenditureService $totalExpenditureService;

    /**
     * TotalExpenditureController Constructor.
     *
     * @param ParentCollectionFormCreator $parentCollectionFormCreator
     * @param totalExpenditureService    $totalExpenditureService
     */
    public function __construct(ParentCollectionFormCreator $parentCollectionFormCreator, totalExpenditureService $totalExpenditureService)
    {
        $this->parentCollectionFormCreator = $parentCollectionFormCreator;
        $this->totalExpenditureService = $totalExpenditureService;
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
            $organization = $this->totalExpenditureService->getOrganizationData($id);
            $model['total_expenditure'] = $this->totalExpenditureService->getTotalExpenditureData($id) ?? [];
            $this->parentCollectionFormCreator->url = route('admin.organisation.total-expenditure.update', [$id]);
            $form = $this->parentCollectionFormCreator->editForm($model, $element['total_expenditure'], 'PUT', '/organisation');
            $status = $organization->total_expenditure_element_completed ?? false;
            $data = ['core'=> $element['total_expenditure']['criteria'] ?? false, 'status'=> $organization->total_expenditure_element_completed ?? false, 'title'=> $element['total_expenditure']['label'], 'name'=>'total-expenditure'];

            return view('admin.organisation.forms.totalExpenditure.totalExpenditure', compact('form', 'organization', 'data'));
        } catch (\Exception $e) {
            logger()->error($e->getMessage());

            return redirect()->route('admin.organisation.index')->with('error', 'Error has occurred while opening organization total-expenditure form.');
        }
    }

    /**
     * Updates organization total expenditure data.
     *
     * @param TotalExpenditureRequest $request
     *
     * @return JsonResponse|RedirectResponse
     */
    public function update(TotalExpenditureRequest $request): JsonResponse| RedirectResponse
    {
        try {
            $id = Auth::user()->organization_id;
            $organizationData = $this->totalExpenditureService->getOrganizationData($id);
            $organizationTitle = $request->all();

            if (!$this->totalExpenditureService->update($organizationTitle, $organizationData)) {
                return redirect()->route('admin.organisation.index', $id)->with('error', 'Error has occurred while updating organization total-expenditure.');
            }

            return redirect()->route('admin.organisation.index', $id)->with('success', 'Organization total-expenditure updated successfully.');
        } catch (\Exception $e) {
            logger()->error($e->getMessage());

            return redirect()->route('admin.organisation.index', $id)->with('error', 'Error has occurred while updating organization total-expenditure.');
        }
    }
}
