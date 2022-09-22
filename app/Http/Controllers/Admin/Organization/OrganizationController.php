<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin\Organization;

use App\Http\Controllers\Controller;
use App\IATI\Models\Organization\Organization;
use App\IATI\Services\Organization\OrganizationService;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
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
            $elementGroups = json_decode(file_get_contents(app_path('Data/Organization/OrganisationElementsGroup.json')), true, 512, JSON_THROW_ON_ERROR);
            $types = $this->organizationService->getOrganizationTypes();
            $organization = $this->organizationService->getOrganizationData(Auth::user()->organization_id);
            $progress = $this->organizationService->organizationMandatoryCompletePercentage($organization);
            $mandatoryCompleted = isMandatoryElementCompleted($organization->element_status);
            $status = $organization->element_status;
            $organization['organisation_identifier'] = $organization['identifier'];

            return view('admin.organisation.index', compact('elements', 'elementGroups', 'progress', 'organization', 'toast', 'types', 'mandatoryCompleted', 'status', ));
        } catch (\Exception $e) {
            logger()->error($e->getMessage());

            return redirect()->route('admin.activities.index')->with('error', 'Error has occurred while opening organization detail page]12345.');
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
     * @return array
     * @throws \JsonException
     */
    public function getRegistrationAgency($country_code): array
    {
        $registration_agency = getCodeList('OrganizationRegistrationAgency', 'Organization');
        $filtered_agency = [];

        foreach ($registration_agency as $key => $value) {
            if (in_array(str_split($key, 2)[0], [$country_code, 'XI', 'XR'], true)) {
                $filtered_agency[$key] = $value;
            }
        }

        return ['message' => 'Filtered Agency successfully fetched', 'data' => $filtered_agency];
    }
}
