<?php

namespace App\Http\Controllers\Admin\Workflow;

use App\Exceptions\PublisherNotFound;
use App\Http\Controllers\Controller;
use App\IATI\Services\Workflow\OrganizationWorkflowService;
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
     * @param $organizationId
     *
     * @return mixed
     */
    public function publish()
    {
        try {
            $organizationId = Auth::user()->organization_id;
            $organization = $this->organizationWorkflowService->findOrganization($organizationId);

            if ($this->hasNoPublisherInfo($organization->settings)) {
                return response()->json(['success' => false, 'error' => 'Please update the publishing information first.']);
            }

            DB::beginTransaction();
            $this->organizationWorkflowService->publishOrganization($organization);
            DB::commit();

            return redirect()->route('admin.activities.index')->with('success', 'Organization has been published successfully.');
        } catch (PublisherNotFound $message) {
            DB::rollBack();
            logger()->error($message->getMessage());

            return redirect()->route('admin.activities.index')->with('error', $message->getMessage());
        } catch (\Exception $e) {
            DB::rollBack();
            logger()->error($e->getMessage());

            return redirect()->route('admin.activities.index')->with('error', 'Error has occurred while publishing organization.');
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
        if (!$settings || !($registryInfo = $settings->publishing_info)) {
            return true;
        }

        if (empty(Arr::get($registryInfo, 'publisher_id', null) ||
            empty(Arr::get($registryInfo, 'api_token', null)) ||
            Arr::get($registryInfo, 'publisher_verification', false) ||
            Arr::get($registryInfo, 'token_verification', false)
        )) {
            return true;
        }

        return false;
    }

    /**
     * Unpublish an organization from the IATI registry.
     *
     * @param $organizationId
     *
     * @return \Illuminate\Http\RedirectResponse|void
     */
    public function unpublish($organizationId)
    {
        try {
            DB::beginTransaction();
            $organization = $this->organizationWorkflowService->findOrganization($organizationId);

            if (!$organization->already_published && $organization->status === 'draft') {
                return redirect()->route('admin.activities.index')->with('error', 'This organization has not been published to un-publish.');
            }

            $this->organizationWorkflowService->unpublishOrganization($organization);
            DB::commit();

            return redirect()->route('admin.activities.index')->with('success', 'Organization has been un-published successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            logger()->error($e->getMessage());

            return redirect()->route('admin.activities.index')->with('error', 'Error has occurred while un-publishing organization.');
        }
    }
}
