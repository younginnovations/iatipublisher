<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin\Activity;

use App\Http\Controllers\Controller;
use App\Http\Requests\Activity\ReportingOrg\ReportingOrgRequest;
use App\IATI\Services\Activity\ReportingOrgService;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;

/**
 * Class ReportingOrgController.
 */
class ReportingOrgController extends Controller
{
    /**
     * @var ReportingOrgService
     */
    protected ReportingOrgService $reportingOrgService;

    /**
     * ReportingOrgController Constructor.
     *
     * @param reportingOrgService    $reportingOrgService
     */
    public function __construct(ReportingOrgService $reportingOrgService)
    {
        $this->reportingOrgService = $reportingOrgService;
    }

    /**
     * Renders reporting-org edit form.
     *
     * @param int $id
     *
     * @return View|RedirectResponse
     */
    public function edit(int $id): View|RedirectResponse
    {
        try {
            $element = getElementSchema('reporting_org');
            $activity = $this->reportingOrgService->getActivityData($id);

            $form = $this->reportingOrgService->formGenerator($id);
            $data = ['title' => $element['label'], 'name' => 'reporting_org'];

            return view('admin.activity.reportingOrg.edit', compact('form', 'activity', 'data'));
        } catch (\Exception $e) {
            logger()->error($e->getMessage());

            return redirect()->route('admin.activity.show', $id)->with('error', 'Error has occurred while opening activity reporting_org form.');
        }
    }

    /**
     * Updates activity reporting-org data.
     *
     * @param ReportingOrgRequest $request
     * @param int $id
     *
     * @return RedirectResponse
     */
    public function update(ReportingOrgRequest $request, int $id): RedirectResponse
    {
        try {
            DB::beginTransaction();

            if (!$this->reportingOrgService->update($id, $request->all())) {
                return redirect()->route('admin.activity.show', $id)->with('error', 'Error has occurred while updating reporting-org.');
            }

            DB::commit();

            return redirect()->route('admin.activity.show', $id)->with('success', 'Activity reporting-org updated successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            logger()->error($e->getMessage());

            return redirect()->route('admin.activity.show', $id)->with('error', 'Error has occurred while updating activity reporting-org.');
        }
    }
}
