<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin\Activity;

use App\Http\Controllers\Controller;
use App\Http\Requests\Activity\CapitalSpend\CapitalSpendRequest;
use App\IATI\Elements\Builder\BaseFormCreator;
use App\IATI\Services\Activity\CapitalSpendService;
use Illuminate\Http\JsonResponse;

/**
 * Class CapitalSpendController.
 */
class CapitalSpendController extends Controller
{
    /**
     * @var BaseFormCreator
     */
    protected BaseFormCreator $baseFormCreator;

    /**
     * @var CapitalSpendService
     */
    protected CapitalSpendService $capitalSpendService;

    /**
     * CapitalSpendController Constructor.
     *
     * @param BaseFormCreator $baseFormCreator
     * @param CapitalSpendService $capitalSpendService
     */
    public function __construct(BaseFormCreator $baseFormCreator, CapitalSpendService $capitalSpendService)
    {
        $this->baseFormCreator = $baseFormCreator;
        $this->capitalSpendService = $capitalSpendService;
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
            $activity = $this->capitalSpendService->getActivityData($id);
            $model['capital_spend'] = $this->capitalSpendService->getCapitalSpendData($id);
            $this->baseFormCreator->url = route('admin.activities.capital-spend.update', [$id]);
            $form = $this->baseFormCreator->editForm($model, $element['capital-spend']);

            return view('activity.capitalSpend.capitalSpend', compact('form', 'activity'));
        } catch (\Exception $e) {
            dd(logger()->error($e->getMessage()));
            logger()->error($e->getMessage());
        }
    }

    /**
     * @param CapitalSpendRequest $request
     * @param $id
     * @return JsonResponse
     */
    public function update(CapitalSpendRequest $request, $id): JsonResponse
    {
        try {
            $activityData = $this->capitalSpendService->getActivityData($id);
            $activityCapitalSpend = (float) $request->get('capital_spend');

            if (!$this->capitalSpendService->update($activityCapitalSpend, $activityData)) {
                return response()->json(['success' => false, 'error' => 'Error has occurred while updating activity capital spend.']);
            }

            return response()->json(['success' => true, 'message' => 'Activity capital spend updated successfully.']);
        } catch (\Exception $e) {
            logger()->error($e->getMessage());

            return response()->json(['success' => false, 'error' => 'Error has occurred while updating activity capital spend.']);
        }
    }
}
