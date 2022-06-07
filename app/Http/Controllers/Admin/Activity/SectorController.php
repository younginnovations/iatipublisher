<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin\Activity;

use App\Http\Controllers\Controller;
use App\Http\Requests\Activity\Sector\SectorRequest;
use App\IATI\Elements\Builder\ParentCollectionFormCreator;
use App\IATI\Services\Activity\SectorService;
use Illuminate\Http\JsonResponse;

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
     * @param int $id
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|void
     */
    public function edit(int $id)
    {
        try {
            $element = json_decode(file_get_contents(app_path('IATI/Data/elementJsonSchema.json')), true);
            $activity = $this->sectorService->getActivityData($id);
            $model['sector'] = $this->sectorService->getSectorData($id);
            $this->parentCollectionFormCreator->url = route('admin.activities.sector.update', [$id]);
            $form = $this->parentCollectionFormCreator->editForm($model, $element['sector']);

            return view('activity.sector.sector', compact('form', 'activity'));
        } catch (\Exception $e) {
            logger()->error($e->getMessage());
            dd($e);
        }
    }

    /**Sector SectorRequest $request
     * @param $id
     * @return JsonResponse
     */
    public function update(SectorRequest $request, $id): JsonResponse
    {
        try {
            $activityData = $this->sectorService->getActivityData($id);
            $activityDescription = $request->all();

            if (!$this->sectorService->update($activityDescription, $activityData)) {
                return response()->json(['success' => false, 'error' => 'Error has occurred while updating activity description.']);
            }

            return response()->json(['success' => true, 'message' => 'Activity description updated successfully.']);
        } catch (\Exception $e) {
            logger()->error($e->getMessage());

            return response()->json(['success' => false, 'error' => 'Error has occurred while updating activity description.']);
        }
    }
}
