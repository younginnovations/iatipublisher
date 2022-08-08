<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin\Activity;

use App\Http\Controllers\Controller;
use App\Http\Requests\Activity\Sector\SectorRequest;
use App\IATI\Services\Activity\SectorService;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;

/**
 * Class SectorController.
 */
class SectorController extends Controller
{
    /**
     * @var SectorService
     */
    protected SectorService $sectorService;

    /**
     * SectorController Constructor.
     *
     * @param SectorService $sectorService
     */
    public function __construct(SectorService $sectorService)
    {
        $this->sectorService = $sectorService;
    }

    /**
     * Renders Sector edit form.
     *
     * @param int $id
     *
     * @return View|RedirectResponse
     */
    public function edit(int $id): View|RedirectResponse
    {
        try {
            $element = getElementSchema('sector');
            $activity = $this->sectorService->getActivityData($id);
            $form = $this->sectorService->formGenerator($id);
            $data = ['core' => $element['sector']['criteria'] ?? '', 'title' => $element['sector']['label'], 'name' => 'sector'];

            return view('admin.activity.sector.edit', compact('form', 'activity', 'data'));
        } catch (\Exception $e) {
            logger()->error($e->getMessage());

            return redirect()->route('admin.activity.show', $id)->with('error', 'Error has occurred while opening activity sector form.');
        }
    }

    /**
     * Updates sector data.
     *
     * @param Request $request
     * @param         $id
     *
     * @return JsonResponse|RedirectResponse
     */
    public function update(SectorRequest $request, $id): JsonResponse|RedirectResponse
    {
        try {
            if (!$this->sectorService->update($id, $request->all())) {
                return redirect()->route('admin.activity.show', $id)->with('error', 'Error has occurred while updating activity sector.');
            }

            return redirect()->route('admin.activity.show', $id)->with('success', 'Activity sector updated successfully.');
        } catch (\Exception $e) {
            logger()->error($e->getMessage());

            return redirect()->route('admin.activity.show', $id)->with('error', 'Error has occurred while updating activity sector.');
        }
    }
}
