<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin\Workflow;

use App\Exceptions\PublisherNotFound;
use App\Http\Controllers\Controller;
use App\IATI\Services\Workflow\OrganizationWorkflowService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

/**
 * Class OrganizationWorkflowController.
 */
class OrganizationWorkflowController extends Controller
{
    /**
     * @var OrganizationWorkflowService
     */
    protected OrganizationWorkflowService $organizationWorkflowService;

    /**
     * OrganizationWorkflowController Constructor.
     *
     * @param OrganizationWorkflowService $organizationWorkflowService
     */
    public function __construct(OrganizationWorkflowService $organizationWorkflowService)
    {
        $this->organizationWorkflowService = $organizationWorkflowService;
    }

    /**
     * Publish an organization.
     *
     *
     * @return JsonResponse
     */
    public function publish(): JsonResponse
    {
        try {
            DB::beginTransaction();
            $organization = Auth::user()->organization;

            if ($this->hasNoPublisherInfo($organization->settings)) {
                return response()->json(['success' => false, 'message' => 'Please update the publishing information first.']);
            }

            $this->organizationWorkflowService->publishOrganization($organization);
            DB::commit();

            return response()->json(['success' => true, 'message' => 'Organization has been published successfully.']);
        } catch (PublisherNotFound $message) {
            DB::rollBack();
            logger()->error($message->getMessage());

            return response()->json(['success' => false, 'message' => $message->getMessage()]);
        } catch (\Exception $e) {
            DB::rollBack();
            logger()->error($e->getMessage());

            return response()->json(['success' => false, 'message' => 'Error has occurred while publishing organization.']);
        }
    }

    /**
     * Check if the Organization's publisher_id and api_token has been filled out and are correct.
     *
     * @param $settings
     *
     * @return bool
     */
    protected function hasNoPublisherInfo($settings): bool
    {
        if (!$settings) {
            return true;
        }

        $registryInfo = $settings->publishing_info;

        if (!$registryInfo) {
            return true;
        }

        if (empty(Arr::get($registryInfo, 'publisher_id', null) ||
            empty(Arr::get($registryInfo, 'api_token', null)) ||
            Arr::get($registryInfo, 'publisher_verification', false) ||
            Arr::get($registryInfo, 'token_verification', false))) {
            return true;
        }

        return false;
    }

    /**
     * UnPublish an organization from the IATI registry.
     *
     * @return JsonResponse|RedirectResponse
     */
    public function unPublish(): JsonResponse|RedirectResponse
    {
        try {
            DB::beginTransaction();
            $organization = Auth::user()->organization;

            if (!$organization->is_published && $organization->status === 'draft') {
                return redirect()->route('admin.activities.index')->with('error', 'This organization has not been published to un-publish.');
            }

            $this->organizationWorkflowService->unpublishOrganization($organization);
            DB::commit();

            return response()->json(['success' => true, 'message' => 'Organization has been un-published successfully.']);
        } catch (\Exception $e) {
            DB::rollBack();
            logger()->error($e->getMessage());

            return response()->json(['success' => false, 'message' => 'Error has occurred while un-publishing organization.']);
        }
    }
}
