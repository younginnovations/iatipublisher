<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin\Activity;

use App\Http\Controllers\Controller;
use App\Http\Requests\Activity\Title\TitleRequest;
use App\IATI\Services\Activity\TitleService;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;

/**
 * Class TitleController.
 */
class TitleController extends Controller
{
    /**
     * @var TitleService
     */
    protected TitleService $titleService;

    /**
     * TitleController Constructor.
     *
     * @param TitleService $titleService
     */
    public function __construct(TitleService $titleService)
    {
        $this->titleService = $titleService;
    }

    /**
     * Renders title edit form.
     *
     * @param int $id
     *
     * @return Factory|View|RedirectResponse|Application
     */
    public function edit(int $id): Factory|View|RedirectResponse|Application
    {
        try {
            $element = getElementSchema('title');
            $activity = $this->titleService->getActivityData($id);
            $form = $this->titleService->formGenerator($id);
            $data = ['title' => $element['label'], 'name' => 'title'];

            return view('admin.activity.title.edit', compact('form', 'activity', 'data'));
        } catch (\Exception $e) {
            logger()->error($e->getMessage());

            return redirect()->route('admin.activity.show', $id)->with('error', 'Error has occurred while opening activity title form.');
        }
    }

    /**
     * Updates activity title data.
     *
     * @param TitleRequest $request
     * @param              $id
     *
     * @return JsonResponse|RedirectResponse
     */
    public function update(TitleRequest $request, $id): JsonResponse|RedirectResponse
    {
        try {
            if (!$this->titleService->update($id, $request->all())) {
                return redirect()->route('admin.activity.show', $id)->with('error', 'Error has occurred while updating activity title.');
            }

            return redirect()->route('admin.activity.show', $id)->with('success', 'Activity title updated successfully.');
        } catch (\Exception $e) {
            logger()->error($e->getMessage());

            return redirect()->route('admin.activity.show', $id)->with('error', 'Error has occurred while updating activity title.');
        }
    }
}
