<?php

namespace App\Http\Controllers\Admin\Organization;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Organization\Organization;
use App\IATI\Services\Organization\OrganizationService;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

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
        $elements = json_decode(file_get_contents(app_path('Data/Organization/Element.json')), true);
        $elementGroups = json_decode(file_get_contents(app_path('Data/Organization/ElementGroup.json')), true);
        $progress = 75;
        // $activity = [  "id" => 1,
        // "identifier" => "{"activity_identifier":"SYRZ000041","iati_identifier_text":"CZ-ICO-25755277-SYRZ000041"}",
        // "title" => "[{"narrative":"DGGF Track 3","language":"en"}]",
        // "description" => "[{"type":1,"narrative":[{"narrative":"Education and psychosocial support to children in Aleppo Governorate","language":""}]}]",
        // "status" => "draft",
        // "activity_date" => "[{"date":"2016-10-18","type":"2","narrative":[{"narrative":"","language":""}]},{"date":"2016-12-02","type":"4","narrative":[{"narrative":"","language":""}]}]",
        // "sector" => "[{"sector_vocabulary":1,"vocabulary_uri":"","sector_code":"72050","sector_category_code":"","sector_text":"","percentage":"","narrative":[{"narrative":"","langu ▶",
        // "budget" => "[{"budget_type":"1","status":"2","period_start":[{"date":"2016-10-18"}],"period_end":[{"date":"2016-12-02"}],"value":[{"amount":"35754","currency":"GBP","value_ ▶",
        // "org_id" => 1,
        // "default_field_values" => "[{"linked_data_uri":"","default_language":"en","default_currency":"GBP","default_hierarchy":"1","default_collaboration_type":"","default_flow_type":"","default_ ▶",
        // "is_published" => false,
        // "created_at" => "2022-05-10 07:33:04",
        // "updated_at" => "2022-05-10 07:33:04"];
        $activity = ['organisation_identifier' => [['narrative'=>'Organisation Name', 'language'=>'en']]];

        // return view('admin.activity.show', compact('elements', 'elementGroups', 'progress', 'activity'));
        return view('admin.organisation.index', compact('elements', 'elementGroups', 'progress', 'activity'));
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
     * @param  \App\IATI\Models\Organization\Organization  $organization
     * @return void
     */
    public function show(Organization $organization): void
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\IATI\Models\Organization\Organization  $organization
     * @return void
     */
    public function edit(Organization $organization): void
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
    public function update(Request $request, Organization $organization): void
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\IATI\Models\Organization\Organization  $organization
     * @return void
     */
    public function destroy(Organization $organization): void
    {
        //
    }
}
