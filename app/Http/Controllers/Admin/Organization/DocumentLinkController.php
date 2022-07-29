<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin\Organization;

use App\Http\Controllers\Controller;
use App\Http\Requests\Organization\DocumentLink\DocumentLinkRequest;
use App\IATI\Elements\Builder\ParentCollectionFormCreator;
use App\IATI\Services\Organization\DocumentLinkService;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;

/**
 * Class DocumentLinkController.
 */
class DocumentLinkController extends Controller
{
    protected ParentCollectionFormCreator $parentCollectionFormCreator;

    protected DocumentLinkService $documentLinkService;

    /**
     * DocumentLinkController Constructor.
     *
     * @param ParentCollectionFormCreator $parentCollectionFormCreator
     * @param documentLinkService    $documentLinkService
     */
    public function __construct(ParentCollectionFormCreator $parentCollectionFormCreator, documentLinkService $documentLinkService)
    {
        $this->parentCollectionFormCreator = $parentCollectionFormCreator;
        $this->documentLinkService = $documentLinkService;
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
            $organization = $this->documentLinkService->getOrganizationData($id);
            $model['document_link'] = $this->documentLinkService->getDocumentLinkData($id) ?? [];
            $this->parentCollectionFormCreator->url = route('admin.organisation.document-link.update', [$id]);
            $form = $this->parentCollectionFormCreator->editForm($model, $element['document_link'], 'PUT', '/organisation');
            $status = $organization->document_link_element_completed ?? false;
            $data = ['core'=> $element['document_link']['criteria'] ?? false, 'status'=> $organization->document_link_element_completed ?? false, 'title'=> $element['document_link']['label'], 'name'=>'document-link'];

            return view('admin.organisation.forms.documentLink.documentLink', compact('form', 'organization', 'data'));
        } catch (\Exception $e) {
            logger()->error($e->getMessage());

            return redirect()->route('admin.organisation.index')->with('error', 'Error has occurred while opening organization document-link form.');
        }
    }

    /**
     * Updates organization total expenditure data.
     *
     * @param DocumentLinkRequest $request
     *
     * @return JsonResponse|RedirectResponse
     */
    public function update(DocumentLinkRequest $request): JsonResponse| RedirectResponse
    {
        try {
            $id = Auth::user()->organization_id;
            $organizationData = $this->documentLinkService->getOrganizationData($id);
            $organizationTitle = $request->all();

            if (!$this->documentLinkService->update($organizationTitle, $organizationData)) {
                return redirect()->route('admin.organisation.index', $id)->with('error', 'Error has occurred while updating organization document-link.');
            }

            return redirect()->route('admin.organisation.index', $id)->with('success', 'Organization document-link updated successfully.');
        } catch (\Exception $e) {
            logger()->error($e->getMessage());

            return redirect()->route('admin.organisation.index', $id)->with('error', 'Error has occurred while updating organization document-link.');
        }
    }
}
