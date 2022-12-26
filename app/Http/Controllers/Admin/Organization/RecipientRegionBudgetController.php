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
     * @return View|RedirectResponse
     */
    public function edit(): View|RedirectResponse
    {
        try {
            $id = Auth::user()->organization_id;
            $element = json_decode(file_get_contents(app_path('IATI/Data/organizationElementJsonSchema.json')), true, 512, JSON_THROW_ON_ERROR);
            $organization = $this->recipientRegionBudgetService->getOrganizationData($id);
            $form = $this->recipientRegionBudgetService->formGenerator($id);
            $data = ['title' => $element['recipient_region_budget']['label'], 'name' => 'recipient_region_budget'];

            return view('admin.organisation.forms.recipientRegionBudget.recipientRegionBudget', compact('form', 'organization', 'data'));
        } catch (\Exception $e) {
            logger()->error($e->getMessage());

            return redirect()->route('admin.organisation.index')->with('error', trans('responses.error_has_occurred_form', ['event'=>trans('events.opening'), 'suffix'=>trans('responses.org_recipient_region_budget')]));
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
            if (!$this->recipientRegionBudgetService->update(Auth::user()->organization_id, $request->all())) {
                return redirect()->route('admin.organisation.index')->with('error', trans('responses.error_has_occurred', ['event'=>trans('events.updating'), 'suffix'=>trans('responses.org_recipient_region_budget')]));
            }

            return redirect()->route('admin.organisation.index')->with('success', ucfirst(trans('responses.event_successfully', ['prefix'=>trans('responses.org_recipient_region_budget'), 'event'=>trans('events.updated')])));
        } catch (\Exception $e) {
            logger()->error($e->getMessage());

            return redirect()->route('admin.organisation.index')->with('error', trans('responses.error_has_occurred', ['event'=>trans('events.updating'), 'suffix'=>trans('responses.org_recipient_region_budget')]));
        }
    }
}
