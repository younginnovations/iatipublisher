<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin\Activity;

use App\Http\Controllers\Controller;
use App\Http\Requests\Activity\DocumentLink\DocumentLinkRequest;
use App\IATI\Services\Activity\DocumentLinkService;
use App\IATI\Services\Document\DocumentService;
use Illuminate\Contracts\View\View;
use Illuminate\Database\DatabaseManager;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;

/**
 * Class DocumentLinkController
 *.
 */
class DocumentLinkController extends Controller
{
    /**
     * @var DocumentLinkService
     */
    protected DocumentLinkService $documentLinkService;

    /**
     * @var DocumentService
     */
    protected DocumentService $documentService;

    /**
     * @var DatabaseManager
     */
    protected DatabaseManager $db;

    /**
     * DocumentLinkControllerConstructor.
     *
     * @param DocumentLinkService $documentLinkService
     * @param DocumentService     $documentService
     * @param DatabaseManager     $db
     */
    public function __construct(
        DocumentLinkService $documentLinkService,
        DocumentService $documentService,
        DatabaseManager $db
    ) {
        $this->documentLinkService = $documentLinkService;
        $this->documentService = $documentService;
        $this->db = $db;
    }

    /**
     * Renders country budget item edit form.
     *
     * @param int $id
     *
     * @return View|RedirectResponse
     */
    public function edit(int $id): View|RedirectResponse
    {
        try {
            $element = getElementSchema('document_link');
            $activity = $this->documentLinkService->getActivityData($id);
            $form = $this->documentLinkService->formGenerator($id);
            $data = ['core' => false, 'title' => $element['document_link']['label'], 'name' => 'document_link'];

            return view('admin.activity.documentLink.edit', compact('form', 'activity', 'data'));
        } catch (\Exception $e) {
            logger()->error($e->getMessage());

            return redirect()->route('admin.activity.show', $id)->with('error', 'Error has occurred while rendering document-link form.');
        }
    }

    /**
     * Updates country budget item data.
     *
     * @param DocumentLinkRequest $request
     * @param                     $id
     *
     * @return JsonResponse|RedirectResponse
     * @throws \Throwable
     */
    public function update(DocumentLinkRequest $request, $id): JsonResponse|RedirectResponse
    {
        try {
            $this->db->beginTransaction();
            $documentLink = $request->except(['_token', '_method']);
            $this->documentLinkService->update($id, $documentLink);
            $this->documentService->update($documentLink, $this->documentLinkService->getActivityData($id));

            $this->db->commit();

            return redirect()->route('admin.activity.show', $id)->with('success', 'Document-link updated successfully.');
        } catch (\Exception $e) {
            $this->db->rollBack();
            logger()->error($e->getMessage());

            return redirect()->route('admin.activity.show', $id)->with('error', 'Error has occurred while updating document-link.');
        }
    }
}
