<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin\Activity;

use App\Http\Controllers\Controller;
use App\Http\Requests\Activity\DocumentLink\DocumentLinkRequest;
use App\IATI\Elements\Builder\MultilevelSubElementFormCreator;
use App\IATI\Elements\Builder\ParentCollectionFormCreator;
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
     * @var MultilevelSubElementFormCreator
     */
    protected MultilevelSubElementFormCreator $multilevelSubElementFormCreator;

    /**
     * @var ParentCollectionFormCreator
     */
    protected ParentCollectionFormCreator $parentCollectionFormCreator;

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
     * @param MultilevelSubElementFormCreator $multilevelSubElementFormCreator
     * @param DocumentLinkService $documentLinkService
     */
    public function __construct(MultilevelSubElementFormCreator $multilevelSubElementFormCreator, DocumentLinkService $documentLinkService, DocumentService $documentService, DatabaseManager $db, ParentCollectionFormCreator $parentCollectionFormCreator)
    {
        $this->multilevelSubElementFormCreator = $multilevelSubElementFormCreator;
        $this->parentCollectionFormCreator = $parentCollectionFormCreator;
        $this->documentLinkService = $documentLinkService;
        $this->documentService = $documentService;
        $this->db = $db;
    }

    /**
     * Renders country budget item edit form.
     *
     * @param int $id
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|void
     */
    public function edit(int $id): View|RedirectResponse
    {
        try {
            $element = json_decode(file_get_contents(app_path('IATI/Data/elementJsonSchema.json')), true);
            $activity = $this->documentLinkService->getActivityData($id);
            $model['document_link'] = $this->documentLinkService->getDocumentLinkData($id) ?: [];
            $documentLinks = $activity->documentLinks()->orderBy('updated_at', 'desc')->get()->toArray();

            foreach ($model['document_link'] as $key => $document) {
                foreach ($documentLinks as $findIndex => $file) {
                    unset($document['document']);
                    $document_link = (array) json_decode($file['document_link']);
                    unset($document_link['document']);

                    if (json_encode($document) == json_encode($document_link)) {
                        $model['document_link'][$key]['document'] = '';
                    }
                }
            }

            $this->parentCollectionFormCreator->url = route('admin.activities.document-link.update', [$id]);
            $form = $this->parentCollectionFormCreator->editForm($model, $element['document_link'], 'PUT', '/activities/' . $id);
            $data = ['core' => false, 'status' => $activity->document_link_element_completed ?? false, 'title' => $element['document_link']['label'], 'name' => 'document_link'];

            return view('activity.documentLink.documentLink', compact('form', 'activity', 'data'));
        } catch (\Exception $e) {
            logger()->error($e->getMessage());

            return redirect()->route('admin.activities.show', $id)->with('error', 'Error has occurred while rendering document-link form.');
        }
    }

    /**
     * Updates country budget item data.
     *
     * @param DocumentLinkRequest $request
     * @param $id
     *
     * @return JsonResponse|RedirectResponse
     */
    public function update(DocumentLinkRequest $request, $id): JsonResponse|RedirectResponse
    {
        try {
            $activityData = $this->documentLinkService->getActivityData($id);
            $documentLink = $request->except(['_token', '_method']);

            $this->db->beginTransaction();

            $this->documentLinkService->update($documentLink, $activityData);
            $this->documentService->update($documentLink, $activityData);

            $this->db->commit();

            return redirect()->route('admin.activities.show', $id)->with('success', 'Document-link updated successfully.');
        } catch (\Exception $e) {
            logger()->error($e->getMessage());

            return redirect()->route('admin.activities.show', $id)->with('error', 'Error has occurred while updating document-link.');
        }
    }
}
