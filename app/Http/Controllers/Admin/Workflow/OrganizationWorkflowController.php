<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin\Workflow;

use App\Exceptions\PublisherNotFound;
use App\Http\Controllers\Controller;
use App\IATI\Services\Workflow\ActivityWorkflowService;
use App\IATI\Services\Workflow\OrganizationWorkflowService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
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
     * @var ActivityWorkflowService
     */
    protected ActivityWorkflowService $activityWorkflowService;

    /**
     * OrganizationWorkflowController Constructor.
     *
     * @param OrganizationWorkflowService $organizationWorkflowService
     * @param ActivityWorkflowService $activityWorkflowService
     */
    public function __construct(OrganizationWorkflowService $organizationWorkflowService, ActivityWorkflowService $activityWorkflowService)
    {
        $this->organizationWorkflowService = $organizationWorkflowService;
        $this->activityWorkflowService = $activityWorkflowService;
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

            if ($this->activityWorkflowService->hasNoPublisherInfo($organization->settings) || !$this->activityWorkflowService->isUserVerified()) {
                $message = $this->activityWorkflowService->getPublishErrorMessage($organization, 'organization');

                return response()->json(['success' => false, 'message' => $message]);
            }

            $this->organizationWorkflowService->publishOrganization($organization);
            DB::commit();

            return response()->json(['success' => true, 'message' => translateElementSuccessfully('elements_common.organisation', 'published')]);
        } catch (PublisherNotFound $message) {
            DB::rollBack();
            logger()->error($message->getMessage());

            return response()->json(['success' => false, 'message' => $message->getMessage()]);
        } catch (\Exception $e) {
            DB::rollBack();
            logger()->error($e->getMessage());

            return response()->json(['success' => false, 'message' => translateErrorHasOccurred('elements_common.organisation', 'publishing')]);
        }
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
                return redirect()->route('admin.activities.index')->with('error', translateResponses('org_not_been_published_to_unpublish'));
            }

            $this->organizationWorkflowService->unpublishOrganization($organization);
            DB::commit();

            return response()->json(['success' => true, 'message' => translateElementSuccessfully('elements_common.organisation', 'unpublished')]);
        } catch (\Exception $e) {
            DB::rollBack();
            logger()->error($e->getMessage());

            return response()->json(['success' => false, 'message' => translateErrorHasOccurred('elements_common.organisation', 'publishing')]);
        }
    }

    /**
     * Performs required checks for publishing organization.
     *
     * @return JsonResponse
     */
    public function checksForOrganizationPublish(): JsonResponse
    {
        $message = $this->activityWorkflowService->getPublishErrorMessage(auth()->user()->organization, 'organization');

        return !empty($message)
            ? response()->json(['success' => false, 'message' => $message])
            : response()->json(['success' => true, 'message' => translateResponses('organisation_ready_to_publish')]);
    }
}
