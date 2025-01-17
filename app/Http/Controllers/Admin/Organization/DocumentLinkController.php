<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin\Organization;

use App\Http\Controllers\Controller;
use App\Http\Requests\Organization\DocumentLink\DocumentLinkRequest;
use App\IATI\Services\Organization\DocumentLinkService;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;

/**
 * Class DocumentLinkController.
 */
class DocumentLinkController extends Controller
{
    /**
     * var DocumentLinkService.
     */
    protected DocumentLinkService $documentLinkService;

    /**
     * DocumentLinkController Constructor.
     *
     * @param DocumentLinkService    $documentLinkService
     */
    public function __construct(DocumentLinkService $documentLinkService)
    {
        $this->documentLinkService = $documentLinkService;
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
            $organization = $this->documentLinkService->getOrganizationData($id);
            $form = $this->documentLinkService->formGenerator($id, deprecationStatusMap: Arr::get($organization->deprecation_status_map, 'document_link', []));
            $status = $organization->document_link_element_completed ?? false;
            $data = ['status'=> $organization->document_link_element_completed ?? false, 'title'=> $element['document_link']['label'], 'name'=>'document-link'];

            return view('admin.organisation.forms.documentLink.documentLink', compact('form', 'organization', 'data'));
        } catch (\Exception $e) {
            logger()->error($e->getMessage());

            return redirect()->route('admin.organisation.index')->with('error', 'Error has occurred while opening organization document-link form.');
        }
    }

    /**
     * Updates organization document link data.
     *
     * @param DocumentLinkRequest $request
     *
     * @return RedirectResponse
     */
    public function update(DocumentLinkRequest $request): RedirectResponse
    {
        try {
            if (!$this->documentLinkService->update(Auth::user()->organization_id, $request->all())) {
                return redirect()->route('admin.organisation.index')->with('error', 'Error has occurred while updating organization document-link.');
            }

            return redirect()->route('admin.organisation.index')->with('success', 'Organization document-link updated successfully.');
        } catch (\Exception $e) {
            logger()->error($e->getMessage());

            return redirect()->route('admin.organisation.index')->with('error', 'Error has occurred while updating organization document-link.');
        }
    }
}
