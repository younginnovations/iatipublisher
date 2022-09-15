<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin\Organization;

use App\Http\Controllers\Controller;
use App\Http\Requests\Organization\ReportingOrg\ReportingOrgRequest;
use App\IATI\Services\Organization\ReportingOrgService;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;

/**
 * Class ReportingOrgController.
 */
class ReportingOrgController extends Controller
{
    /**
     * @var
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
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|void|RedirectResponse
     */
    public function edit(): View|RedirectResponse
    {
        try {
            $id = Auth::user()->organization_id;
            $element = json_decode(file_get_contents(app_path('IATI/Data/organizationElementJsonSchema.json')), true);
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
            $id = Auth::user()->organization_id;
            $reportingOrg = $request->all();

            if (!$this->reportingOrgService->update($id, $reportingOrg)) {
                return redirect()->route('admin.organisation.index', $id)->with('error', 'Error has occurred while updating organization reporting_org.');
            }

            return redirect()->route('admin.organisation.index', $id)->with('success', 'Organization reporting_org updated successfully.');
        } catch (\Exception $e) {
            logger()->error($e->getMessage());

            return redirect()->route('admin.organisation.index', $id)->with('error', 'Error has occurred while updating organization reporting_org.');
        }
    }
}
