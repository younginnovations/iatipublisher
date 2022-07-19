<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin\Activity;

use App\Http\Controllers\Controller;
use App\Http\Requests\Activity\Sector\SectorRequest;
use App\IATI\Elements\Builder\ParentCollectionFormCreator;
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
     * @var ParentCollectionFormCreator
     */
    protected ParentCollectionFormCreator $parentCollectionFormCreator;

    /**
     * @var SectorService
     */
    protected SectorService $sectorService;

    /**
     * SectorController Constructor.
     *
     * @param ParentCollectionFormCreator $parentCollectionFormCreator
     * @param SectorService $sectorService
     */
    public function __construct(ParentCollectionFormCreator $parentCollectionFormCreator, SectorService $sectorService)
    {
        $this->parentCollectionFormCreator = $parentCollectionFormCreator;
        $this->sectorService = $sectorService;
    }

    /**
     * Renders Sector edit form.
     *
     * @param int $id
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|void
     */
    public function edit(int $id): View|RedirectResponse
    {
        try {
            $element = json_decode(file_get_contents(app_path('IATI/Data/elementJsonSchema.json')), true);
            $activity = $this->sectorService->getActivityData($id);
            $model['sector'] = $this->sectorService->getSectorData($id);
            $this->parentCollectionFormCreator->url = route('admin.activities.sector.update', [$id]);
            $form = $this->parentCollectionFormCreator->editForm($model, $element['sector'], 'PUT', '/activities/' . $id);
            $data = ['core'=> $element['sector']['criteria'] ?? '', 'status'=> $activity->sector_element_completed, 'title'=> $element['sector']['label'], 'name'=>'sector'];

            return view('activity.sector.sector', compact('form', 'activity', 'data'));
        } catch (\Exception $e) {
            logger()->error($e->getMessage());

            return redirect()->route('admin.activities.show', $id)->with('error', 'Error has occurred while opening activity sector form.');
        }
    }

    /**
     * Updates sector data.
     *
     * @param Request $request
     * @param $id
     *
     * @return JsonResponse|RedirectResponse
     */
    public function update(SectorRequest $request, $id): JsonResponse|RedirectResponse
    {
        try {
            $activityData = $this->sectorService->getActivityData($id);
            $activityDescription = $request->all();

            if (!$this->sectorService->update($activityDescription, $activityData)) {
                return redirect()->route('admin.activities.show', $id)->with('error', 'Error has occurred while updating activity sector.');
            }

            return redirect()->route('admin.activities.show', $id)->with('success', 'Activity sector updated successfully.');
        } catch (\Exception $e) {
            logger()->error($e->getMessage());

            return redirect()->route('admin.activities.show', $id)->with('error', 'Error has occurred while updating activity sector.');
        }
    }
}
