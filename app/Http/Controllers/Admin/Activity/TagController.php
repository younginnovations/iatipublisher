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
     * @return View|RedirectResponse
     */
    public function edit(int $id): View|RedirectResponse
    {
        try {
            $element = getElementSchema('tag');
            $activity = $this->tagService->getActivityData($id);
            $form = $this->tagService->formGenerator($id);
            $data = ['title' => $element['label'], 'name' => 'tag'];

            return view('admin.activity.tag.edit', compact('form', 'activity', 'data'));
        } catch (\Exception $e) {
            logger()->error($e->getMessage());

            return redirect()->route('admin.activity.show', $id)->with('error', trans('responses.error_has_occurred_form', ['event'=>trans('events.opening'), 'suffix'=>trans('elements_common.tag')]));
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
            if (!$this->tagService->update($id, $request->all())) {
                return redirect()->route('admin.activity.show', $id)->with('error', trans('responses.error_has_occurred', ['event'=>trans('events.updating'), 'suffix'=>trans('elements_common.tag')]));
            }

            return redirect()->route('admin.activity.show', $id)->with('success', ucfirst(trans('responses.event_successfully', ['prefix'=>trans('elements_common.tag'), 'event'=>trans('events.updated')])));
        } catch (\Exception $e) {
            logger()->error($e->getMessage());

            return redirect()->route('admin.activity.show', $id)->with('error', trans('responses.error_has_occurred', ['event'=>trans('events.updating'), 'suffix'=>trans('elements_common.tag')]));
        }
    }
}
