<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin\Activity;

use App\Http\Controllers\Controller;
use App\Http\Requests\Activity\Tag\TagRequest;
use App\IATI\Services\Activity\TagService;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;

/**
 * Class TagController.
 */
class TagController extends Controller
{
    /**
     * @var TagService
     */
    protected TagService $tagService;

    /**
     * TagController Constructor.
     *
     * @param TagService $tagService
     */
    public function __construct(TagService $tagService)
    {
        $this->tagService = $tagService;
    }

    /**
     * Renders tag edit form.
     *
     * @param int $id
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|void
     */
    public function edit(int $id): View|RedirectResponse
    {
        try {
            $element = json_decode(file_get_contents(app_path('IATI/Data/elementJsonSchema.json')), true);
            $activity = $this->tagService->getActivityData($id);
            $form = $this->tagService->formGenerator($id);
            $data = ['core' => $element['tag']['criteria'] ?? '', 'title' => $element['tag']['label'], 'name' => 'tag'];

            return view('admin.activity.tag.edit', compact('form', 'activity', 'data'));
        } catch (\Exception $e) {
            logger()->error($e->getMessage());

            return redirect()->route('admin.activities.show', $id)->with('error', 'Error has occurred while opening tag form.');
        }
    }

    /**
     * Updates tag form.
     *
     * @param TagRequest $request
     * @param $id
     *
     * @return JsonResponse|RedirectResponse
     */
    public function update(TagRequest $request, $id): JsonResponse|RedirectResponse
    {
        try {
            $activityData = $this->tagService->getActivityData($id);
            $activityTag = $request->all();

            if (!$this->tagService->update($activityTag, $activityData)) {
                return redirect()->route('admin.activities.show', $id)->with('error', 'Error has occurred while updating tag.');
            }

            return redirect()->route('admin.activities.show', $id)->with('success', 'Tag updated successfully.');
        } catch (\Exception $e) {
            logger()->error($e->getMessage());

            return redirect()->route('admin.activities.show', $id)->with('error', 'Error has occurred while updating tag.');
        }
    }
}
