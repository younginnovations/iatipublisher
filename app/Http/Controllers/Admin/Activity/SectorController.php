<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin\Activity;

use App\Http\Controllers\Controller;
use App\Http\Requests\Activity\Sector\SectorRequest;
use App\IATI\Services\Activity\SectorService;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use JsonException;

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
            $activity = $this->sectorService->getActivityData($id);
            $element = $this->getSectorManipulatedElementSchema($activity);
            $form = $this->sectorService->formGenerator($id, $element);
            $data = ['title' => $element['label'], 'name' => 'sector'];

            return view('admin.activity.sector.edit', compact('form', 'activity', 'data'));
        } catch (\Exception $e) {
            logger()->error($e->getMessage());

            return redirect()->route('admin.activity.show', $id)->with('error', 'Error has occurred while opening activity sector form.');
        }
    }

    /**
     * Updates sector data.
     *
     * @param SectorRequest $request
     * @param               $id
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

    /**
     * @param $activity
     *
     * @return array
     *
     * @throws JsonException
     */
    public function getSectorManipulatedElementSchema($activity): array
    {
        $element = getElementSchema('sector');

        if (count($activity->transactions)) {
            $sector = $activity->transactions->pluck('transaction.sector')->toArray();

            if (!is_array_value_empty($sector)) {
                $element['freeze'] = true;
            }
        }

        return $element;
    }
}
