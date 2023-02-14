<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin\Organization;

use App\Http\Controllers\Controller;
use App\Http\Requests\Organization\ReportingOrg\ReportingOrgRequest;
use App\IATI\Services\Organization\ReportingOrgService;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

/**
 * Class ReportingOrgController.
 */
class ReportingOrgController extends Controller
{
    /**
     * @var ReportingOrgService
     */
    protected reportingOrgService $reportingOrgService;

    /**
     * ReportingOrgController Constructor.
     *
     * @param reportingOrgService    $reportingOrgService
     */
    public function __construct(reportingOrgService $reportingOrgService)
    {
        $this->reportingOrgService = $reportingOrgService;
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
            $organization = $this->reportingOrgService->getOrganizationData($id);
            $form = $this->reportingOrgService->formGenerator($id);
            $data = ['title'=> $element['reporting_org']['label'], 'name'=>'reporting-org'];

            return view('admin.organisation.forms.reportingOrg.reportingOrg', compact('form', 'organization', 'data'));
        } catch (\Exception $e) {
            logger()->error($e->getMessage());

            return redirect()->route('admin.organisation.index')->with('error', 'Error has occurred while opening organization reporting_org form.');
        }
    }

    /**
     * Updates organization title data.
     *
     * @param ReportingOrgRequest $request
     *
     * @return RedirectResponse
     */
    public function update(ReportingOrgRequest $request): RedirectResponse
    {
        try {
            DB::beginTransaction();

            if (!$this->reportingOrgService->update(Auth::user()->organization_id, $request->all())) {
                return redirect()->route('admin.organisation.index')->with('error', 'Error has occurred while updating organization reporting_org.');
            }

            DB::commit();

            return redirect()->route('admin.organisation.index')->with('success', 'Organization reporting_org updated successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            logger()->error($e->getMessage());

            return redirect()->route('admin.organisation.index')->with('error', 'Error has occurred while updating organization reporting_org.');
        }
    }
}
