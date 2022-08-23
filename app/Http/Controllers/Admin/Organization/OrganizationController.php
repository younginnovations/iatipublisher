<?php

namespace App\Http\Controllers\Admin\Organization;

use App\Http\Controllers\Controller;
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
    protected $organizationService;

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
    public function index()
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
     * @param  \Illuminate\Http\Request  $request
     * @return void
     */
    public function store(Request $request): void
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param $id
     *
     * @return View|RedirectResponse
     */
    public function show(): View|RedirectResponse
    {
        try {
            $toast['message'] = Session::has('error') ? Session::get('error') : (Session::get('success') ? Session::get('success') : '');
            $toast['type'] = Session::has('error') ? 'error' : 'success';
            $elements = json_decode(file_get_contents(app_path('IATI/Data/organizationElementJsonSchema.json')), true);
            $elementGroups = json_decode(file_get_contents(app_path('Data/Organization/OrganisationElementsGroup.json')), true);
            $types = $this->getOrganizationTypes();
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
     * @param  \App\IATI\Models\Organization\Organization  $organization
     * @return void
     */
    public function edit($organization): void
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\IATI\Models\Organization\Organization  $organization
     * @return void
     */
    public function update(Request $request, $organization): void
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\IATI\Models\Organization\Organization  $organization
     * @return void
     */
    public function destroy($organization): void
    {
        //
    }

    /**
     * Returns array of dropdown elements in organization.
     *
     * @return array
     */
    public function getOrganizationTypes(): array
    {
        return [
            'budgetType'       => getCodeList('BudgetStatus', 'Activity', false),
            'languages'        => getCodeList('Language', 'Organization', false),
            'documentCategory' => getCodeList('DocumentCategory', 'Activity'),
            'organizationType' => getCodeList('OrganizationType', 'Organization', false),
            'country'          => getCodeList('Country', 'Organization', false),
            'regionVocabulary' => getCodeList('RegionVocabulary', 'Activity'),
            'region' => getCodeList('Region', 'Activity'),
        ];
    }

    /**
     * Returns list of registration agency specific to a country.
     *
     * @return array
     */
    public function getRegistrationAgency($country_code): array
    {
        $registration_agency = getCodeList('OrganizationRegistrationAgency', 'Organization');
        $filtered_agency = [];

        foreach ($registration_agency as $key => $value) {
            if (in_array(str_split($key, 2)[0], [$country_code, 'XI', 'XR'])) {
                $filtered_agency[$key] = $value;
            }
        }

        return ['message' => 'Filtered Agency successfully fetched', 'data' => $filtered_agency];
    }
}
