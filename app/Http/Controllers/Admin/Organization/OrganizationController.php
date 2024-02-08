<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin\Organization;

use App\Constants\Enums;
use App\Http\Controllers\Controller;
use App\IATI\Models\Organization\Organization;
use App\IATI\Services\Organization\OrganizationService;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

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
     * OrganizationController Constructor.
     * @param OrganizationService $organizationService
     */
    public function __construct(OrganizationService $organizationService)
    {
        $this->organizationService = $organizationService;
    }

    /**
     * Display a listing of the resource.
     */
    public function index(): void
    {
        //
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
            $jsonContent = Cache::get($completePath) ?? file_get_contents(public_path($completePath));
            $elementGroups = json_decode($jsonContent, true, 512, JSON_THROW_ON_ERROR);
            $types = $this->organizationService->getOrganizationTypes();
            $organization = $this->organizationService->getOrganizationData(Auth::user()->organization_id);
            $progress = $this->organizationService->organizationMandatoryCompletePercentage($organization);
            $mandatoryCompleted = isMandatoryElementCompleted($organization->element_status);
            $status = $organization->element_status;
            $organization['organisation_identifier'] = $organization['identifier'];
            $userRole = Auth::user()->role->role;

            return view('admin.organisation.index', compact('elements', 'elementGroups', 'progress', 'organization', 'toast', 'types', 'mandatoryCompleted', 'status', 'userRole'));
        } catch (\Exception $e) {
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
     * @param Request      $request
     * @param Organization $organization
     *
     * @return void
     */
    public function update(Request $request, Organization $organization): void
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Organization $organization
     *
     * @return void
     */
    public function destroy(Organization $organization): void
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
     * @throws \JsonException
     */
    public function getRegistrationAgency(bool|string $country_code = false): array
    {
        $registration_agency = getCodeList('OrganizationRegistrationAgency', 'Organization');
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
        } catch (\Exception $e) {
            logger()->error($e->getMessage());

            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
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
        } catch (\Exception $e) {
            DB::rollBack();
            logger()->error($e->getMessage());

            return response(['status' => false, 'message' => 'Error has occurred while deleting organisation element.']);
        }
    }
}
