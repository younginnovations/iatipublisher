<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin\Organization;

use App\Constants\Enums;
use App\Http\Controllers\Controller;
use App\Http\Requests\DeleteOrganizationRequest;
use App\IATI\Models\Organization\Organization;
use App\IATI\Services\Organization\OrganizationService;
use App\IATI\Services\Publisher\PublisherService;
use App\IATI\Services\Workflow\OrganizationWorkflowService;
use App\SpamEmail;
use Exception;
use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use JsonException;

/**
 * Class OrganizationController.
 */
class OrganizationController extends Controller
{
    /**
     * @var OrganizationService
     */
    protected OrganizationService $organizationService;
    /**
     * @var OrganizationWorkflowService
     */
    protected OrganizationWorkflowService $organizationWorkflowService;

    /**
     * OrganizationController Constructor.
     *
     * @param OrganizationService $organizationService
     * @param OrganizationWorkflowService $organizationWorkflowService
     */
    public function __construct(OrganizationService $organizationService, OrganizationWorkflowService $organizationWorkflowService)
    {
        $this->organizationService = $organizationService;
        $this->organizationWorkflowService = $organizationWorkflowService;
    }

    /**
     * Display a listing of the resource.
     */
    public function index(): void
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     *
     * @return void
     */
    public function store(Request $request): void
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @return View|RedirectResponse
     */
    public function show(): View|RedirectResponse
    {
        try {
            $toast['message'] = Session::has('error') ? Session::get('error') : (Session::get('success') ? Session::get('success') : '');
            $toast['type'] = Session::has('error') ? 'error' : 'success';
            $elements = json_decode(file_get_contents(app_path('IATI/Data/organizationElementJsonSchema.json')), true, 512, JSON_THROW_ON_ERROR);
            $completePath = 'AppData/Data/Organization/OrganisationElementsGroup.json';
            $jsonContent = getJsonFromSource($completePath);
            $elementGroups = json_decode($jsonContent, true, 512, JSON_THROW_ON_ERROR);
            $types = $this->organizationService->getOrganizationTypes();
            $organization = $this->organizationService->getOrganizationData(Auth::user()->organization_id);
            $progress = $this->organizationService->organizationMandatoryCompletePercentage($organization);
            $mandatoryCompleted = isMandatoryElementCompleted($organization->element_status);
            $status = $organization->element_status;
            $organization['organisation_identifier'] = $organization['identifier'];
            $userRole = Auth::user()->role->role;

            return view('admin.organisation.index', compact('elements', 'elementGroups', 'progress', 'organization', 'toast', 'types', 'mandatoryCompleted', 'status', 'userRole'));
        } catch (Exception $e) {
            logger()->error($e->getMessage());

            return redirect()->route('admin.activities.index')->with('error', 'Error has occurred while opening organization detail page.');
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Organization $organization
     *
     * @return void
     */
    public function edit(Organization $organization): void
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param Organization $organization
     *
     * @return void
     */
    public function update(Request $request, Organization $organization): void
    {
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param DeleteOrganizationRequest $request
     * @param string $orgId
     * @return array
     */
    public function destroy(DeleteOrganizationRequest $request, string $orgId): array
    {
        DB::beginTransaction();

        try {
            $markAsSpam = $request->query->get('markAsSpam', false);
            $markAsSpam = $markAsSpam === 'true';
            $organization = $this->organizationService->getOrganizationData($orgId);

            $publisherId = $organization->publisher_id;
            $apiToken = $organization->settings?->publishing_info['api_token'] ?? false;
            $organizationPublished = $organization->organizationPublished;

            if ($organizationPublished) {
                $this->unlinkOldFilesFromRegistry($publisherId, $apiToken, 'organisation');
                $organizationPublished->delete();
            }

            $activityPublished = $organization->activityPublished;

            if ($activityPublished) {
                $this->unlinkOldFilesFromRegistry($publisherId, $apiToken, 'activities');
                $activityPublished->delete();
            }

            $organization->settings()->delete();

            $activities = $organization->allActivities;

            foreach ($activities as $activity) {
                $activity->delete();
            }

            $users = $organization->users;

            foreach ($users as $user) {
                if ($markAsSpam) {
                    $this->markEmailAsSpam($user->email);
                }

                $user->forceDelete();
            }

            $organization->delete();

            DB::commit();

            return ['success' => true, 'message' => 'Organisation deleted successfully.'];
        } catch (Exception $e) {
            DB::rollBack();

            logger()->error($e->getMessage());

            return ['success' => false, 'message' => 'Error occurred while deleting organisation.'];
        }
    }

    /**
     * @param string $publisherId
     * @param string $orgApiToken
     * @param string $filetype
     *
     * @return bool
     *
     * @throws BindingResolutionException
     */
    private function unlinkOldFilesFromRegistry(string $publisherId, string $orgApiToken, string $filetype): bool
    {
        /** @var PublisherService $publisherService */
        $publisherService = app()->make(PublisherService::class);
        $files = ["$publisherId-$filetype"];

        return $publisherService->unlink($orgApiToken, $files);
    }

    /**
     * @param string $email
     *
     * @return void
     */
    private function markEmailAsSpam(string $email): void
    {
        $existingEmail = SpamEmail::where('email', $email)->first();

        if (!$existingEmail) {
            SpamEmail::create(['email' => $email]);
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return void
     */
    public function create(): void
    {
        //
    }

    /**
     * Returns list of registration agency specific to a country.
     *
     * @param bool|string $country_code
     *
     * @return array
     *
     * @throws JsonException
     */
    public function getRegistrationAgency(bool|string $country_code = false): array
    {
        $registration_agency = getCodeList('OrganizationRegistrationAgency', 'Organization', filterDeprecated: true);
        $filtered_agency = [];

        if (!$country_code) {
            return ['message' => 'Filtered Agency successfully fetched', 'data' => $registration_agency];
        }

        $validOrganisationRegistrationAgency = array_merge([$country_code], Enums::UNCATEGORIZED_ORGANISATION_AGENCY_PREFIX);

        foreach ($registration_agency as $key => $value) {
            if (in_array(str_split($key, 2)[0], $validOrganisationRegistrationAgency, true)) {
                $filtered_agency[$key] = $value;
            }
        }

        return ['message' => 'Filtered Agency successfully fetched', 'data' => $filtered_agency];
    }

    /**
     * Get Publisher status.
     *
     * @return JsonResponse
     */
    public function getPublisherStatus(): JsonResponse
    {
        try {
            $publisher_id = Auth::user()->organization->publisher_id;
            $status = $this->organizationService->isPublisherStateActive($publisher_id);

            return response()->json([
                'success' => true,
                'message' => 'Publisher status successfully retrieved.',
                'data' => ['publisher_active' => $status],
            ]);
        } catch (Exception $e) {
            logger()->error($e);

            return response()->json([
                'success' => false,
                'message' => 'Encountered issue when checking publisher state on registry.',
                'data' => ['publisher_active' => false],
            ]);
        }
    }

    /**
     * Deletes organisation element.
     *
     * @param $element
     *
     * @return Application|ResponseFactory|Response
     */
    public function deleteElement($element): Response|Application|ResponseFactory
    {
        try {
            $notDeletableElements = ['organisation_identifier', 'name', 'reporting_org'];

            if (in_array($element, $notDeletableElements)) {
                return response(['status' => false, 'message' => "The element '${element}' can not be deleted."]);
            }

            DB::beginTransaction();
            if (!$this->organizationService->deleteElement(auth()->user()?->organization_id, $element)) {
                return response(['status' => false, 'message' => 'Error has occurred while deleting organisation element.']);
            }

            DB::commit();
            $message = sprintf('The %s element deleted successfully.', str_replace('_', '-', $element));
            Session::put('success', $message);

            return response(['status' => true, 'message' => $message]);
        } catch (Exception $e) {
            DB::rollBack();
            logger()->error($e->getMessage());

            return response(['status' => false, 'message' => 'Error has occurred while deleting organisation element.']);
        }
    }
}
