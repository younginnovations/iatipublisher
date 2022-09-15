<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin\Organization;

use App\Http\Controllers\Controller;
use App\Http\Requests\Organization\RecipientCountryBudget\RecipientCountryBudgetRequest;
use App\IATI\Services\Organization\RecipientCountryBudgetService;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;

/**
 * Class RecipientCountryBudgetController.
 */
class RecipientCountryBudgetController extends Controller
{
    protected RecipientCountryBudgetService $recipientCountryBudgetService;

    /**
     * RecipientCountryBudgetController Constructor.
     *
     * @param recipientCountryBudgetService    $recipientCountryBudgetService
     */
    public function __construct(RecipientCountryBudgetService $recipientCountryBudgetService)
    {
        $this->recipientCountryBudgetService = $recipientCountryBudgetService;
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
            $organization = $this->recipientCountryBudgetService->getOrganizationData($id);
            $form = $this->recipientCountryBudgetService->formGenerator($id);
            $data = ['title' => $element['recipient_country_budget']['label'], 'name' => 'recipient_country_budget'];

            return view('admin.organisation.forms.recipientCountryBudget.recipientCountryBudget', compact('form', 'organization', 'data'));
        } catch (\Exception $e) {
            logger()->error($e->getMessage());

            return redirect()->route('admin.organisation.index')->with('error', 'Error has occurred while opening organization recipient-country-budget form.');
        }
    }

    /**
     * Updates organization total budget data.
     *
     * @param RecipientCountryBudgetRequest $request
     *
     * @return RedirectResponse
     */
    public function update(RecipientCountryBudgetRequest $request): RedirectResponse
    {
        try {
            $id = Auth::user()->organization_id;
            $recipientCountryBudget = $request->all();

            if (!$this->recipientCountryBudgetService->update($id, $recipientCountryBudget)) {
                return redirect()->route('admin.organisation.index', $id)->with('error', 'Error has occurred while updating organization recipient-country-budget.');
            }

            return redirect()->route('admin.organisation.index', $id)->with('success', 'Organization recipient-country-budget updated successfully.');
        } catch (\Exception $e) {
            logger()->error($e->getMessage());

            return redirect()->route('admin.organisation.index', $id)->with('error', 'Error has occurred while updating organization recipient-country-budget.');
        }
    }
}
