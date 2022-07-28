<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin\Organization;

use App\Http\Controllers\Controller;
use App\Http\Requests\Organization\OrganizationIdentifier\OrganizationIdentifierRequest;
use App\IATI\Elements\Builder\BaseFormCreator;
use App\IATI\Services\Organization\OrganizationIdentifierService;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;

/**
 * Class OrganizationIdentifierController.
 */
class OrganizationIdentifierController extends Controller
{
    protected BaseFormCreator $baseFormCreator;

    protected OrganizationIdentifierService $organizationIdentifierService;

    /**
     * OrganizationIdentifierController Constructor.
     *
     * @param BaseFormCreator $baseFormCreator
     * @param OrganizationIdentifierService    $organizationIdentifierService
     */
    public function __construct(BaseFormCreator $baseFormCreator, OrganizationIdentifierService $organizationIdentifierService)
    {
        $this->baseFormCreator = $baseFormCreator;
        $this->organizationIdentifierService = $organizationIdentifierService;
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
            $organization = $this->organizationIdentifierService->getOrganizationData($id);
            $model['organisation_identifier'] = $this->organizationIdentifierService->getIdentifierData($id);
            $this->baseFormCreator->url = route('admin.organisation.identifier.update', [$id]);
            $form = $this->baseFormCreator->editForm($model, $element['organisation_identifier'], 'PUT', '/organisation');
            $status = $organization->name_element_completed ?? false;
            $data = ['core'=> $element['organisation_identifier']['criteria'] ?? false, 'status'=> $organization->identifier_element_completed ?? false, 'title'=> $element['organisation_identifier']['label'], 'name'=>'organisation-identifier'];

            return view('admin.organisation.forms.organisationIdentifier.edit', compact('form', 'organization', 'data'));
        } catch (\Exception $e) {
            dd($e);
            logger()->error($e->getMessage());

            return redirect()->route('admin.activities.show', $id)->with('error', 'Error has occurred while opening organization name form.');
        }
    }

    /**
     * Updates organization title data.
     *
     * @param OrganizationIdentifierRequest $request
     *
     * @return JsonResponse|RedirectResponse
     */
    public function update(OrganizationIdentifierRequest $request): JsonResponse| RedirectResponse
    {
        try {
            $id = Auth::user()->organization_id;
            $organizationData = $this->organizationIdentifierService->getOrganizationData($id);
            $organizationTitle = $request->all();

            if (!$this->organizationIdentifierService->update($organizationTitle, $organizationData)) {
                return redirect()->route('admin.organisation.index', $id)->with('error', 'Error has occurred while updating organization name.');
            }

            return redirect()->route('admin.organisation.index', $id)->with('success', 'Organization name updated successfully.');
        } catch (\Exception $e) {
            logger()->error($e->getMessage());

            return redirect()->route('admin.organisation.index', $id)->with('error', 'Error has occurred while updating organization name.');
        }
    }
}
