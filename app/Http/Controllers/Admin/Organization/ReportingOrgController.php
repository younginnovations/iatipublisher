<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin\Organization;

use App\Http\Controllers\Controller;
use App\Http\Requests\Organization\ReportingOrg\ReportingOrgRequest;
use App\IATI\Elements\Builder\ParentCollectionFormCreator;
use App\IATI\Services\Organization\ReportingOrgService;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;

/**
 * Class ReportingOrgController.
 */
class ReportingOrgController extends Controller
{
    protected ParentCollectionFormCreator $parentCollectionFormCreator;

    protected reportingOrgService $reportingOrgService;

    /**
     * ReportingOrgController Constructor.
     *
     * @param ParentCollectionFormCreator $parentCollectionFormCreator
     * @param reportingOrgService    $reportingOrgService
     */
    public function __construct(ParentCollectionFormCreator $parentCollectionFormCreator, reportingOrgService $reportingOrgService)
    {
        $this->parentCollectionFormCreator = $parentCollectionFormCreator;
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
            $model['reporting_org'] = $this->reportingOrgService->getReportingOrgData($id) ?? [];
            $this->parentCollectionFormCreator->url = route('admin.organisation.reporting-org.update', [$id]);
            $form = $this->parentCollectionFormCreator->editForm($model, $element['reporting_org'], 'PUT', '/organisation');
            $status = $organization->reporting_org_element_completed ?? false;
            $data = ['core'=> $element['reporting_org']['criteria'] ?? false, 'status'=> $organization->reporting_org_element_completed ?? false, 'title'=> $element['reporting_org']['label'], 'name'=>'reporting-org'];

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
     * @return JsonResponse|RedirectResponse
     */
    public function update(ReportingOrgRequest $request): JsonResponse| RedirectResponse
    {
        try {
            $id = Auth::user()->organization_id;
            $organizationData = $this->reportingOrgService->getOrganizationData($id);
            $organizationTitle = $request->all();

            if (!$this->reportingOrgService->update($organizationTitle, $organizationData)) {
                return redirect()->route('admin.organisation.index', $id)->with('error', 'Error has occurred while updating organization reporting_org.');
            }

            return redirect()->route('admin.organisation.index', $id)->with('success', 'Organization reporting_org updated successfully.');
        } catch (\Exception $e) {
            logger()->error($e->getMessage());

            return redirect()->route('admin.organisation.index', $id)->with('error', 'Error has occurred while updating organization reporting_org.');
        }
    }
}
