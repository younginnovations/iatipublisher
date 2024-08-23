<?php

namespace App\Http\Controllers\Admin\Organization;

use App\Http\Controllers\Controller;
use App\IATI\Services\Organization\OrganizationOnboardingService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

/**
 * Class OrganizationOnboardingController.
 */
class OrganizationOnboardingController extends Controller
{
    /**
     * @param  OrganizationOnboardingService  $organizationOnboardingService
     */
    public function __construct(
        protected OrganizationOnboardingService $organizationOnboardingService
    ) {
    }

    /**
     * Toggles don't show if required.
     *
     * @param  Request  $request
     * @param $value
     *
     * @return JsonResponse
     */
    public function toggleDontShow(Request $request, $value): JsonResponse
    {
        try {
            DB::beginTransaction();

            if (!is_bool($value)) {
                return response()->json(['success' => false, 'message' => 'Invalid value']);
            }

            $this->organizationOnboardingService->updateDontShowAgain(Auth::user()->organization_id, $value);
            DB::commit();

            return response()->json(['success' => true, 'message' => 'Dont show again updated successfully']);
        } catch (\Exception $e) {
            DB::rollBack();
            logger()->error($e->getMessage());

            return response()->json(['success' => false, 'message' => 'Error occurred while storing setting']);
        }
    }
}
