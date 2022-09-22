<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin\Organization;

use App\Http\Controllers\Controller;
use App\Http\Requests\Organization\TotalExpenditure\TotalExpenditureRequest;
use App\IATI\Services\Organization\TotalExpenditureService;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;

/**
 * Class TotalExpenditureController.
 */
class TotalExpenditureController extends Controller
{
    /**
     * @var TotalExpenditureService
     */
    protected TotalExpenditureService $totalExpenditureService;

    /**
     * TotalExpenditureController Constructor.
     *
     * @param TotalExpenditureService    $totalExpenditureService
     */
    public function __construct(TotalExpenditureService $totalExpenditureService)
    {
        $this->totalExpenditureService = $totalExpenditureService;
    }

    /**
     * Renders title edit form.
     *
     * @return View|RedirectResponse
     */
    public function edit(): View|RedirectResponse
    {
        try {
            $id = Auth::user()->organization_id;
            $element = json_decode(file_get_contents(app_path('IATI/Data/organizationElementJsonSchema.json')), true, 512, JSON_THROW_ON_ERROR);
            $organization = $this->totalExpenditureService->getOrganizationData($id);
            $form = $this->totalExpenditureService->formGenerator($id);
            $data = ['title'=> $element['total_expenditure']['label'], 'name'=>'total-expenditure'];

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
     * @return RedirectResponse
     */
    public function update(TotalExpenditureRequest $request): RedirectResponse
    {
        try {
            if (!$this->totalExpenditureService->update(Auth::user()->organization_id, $request->all())) {
                return redirect()->route('admin.organisation.index')->with('error', 'Error has occurred while updating organization total-expenditure.');
            }

            return redirect()->route('admin.organisation.index')->with('success', 'Organization total-expenditure updated successfully.');
        } catch (\Exception $e) {
            logger()->error($e->getMessage());

            return redirect()->route('admin.organisation.index')->with('error', 'Error has occurred while updating organization total-expenditure.');
        }
    }
}
