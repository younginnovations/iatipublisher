<?php

namespace Modules\VisualModule\Http\Controllers;

use App\IATI\Models\Organization\Organization;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

/**
 * Class VisualModuleController
 *
 * @package Modules\VisualModule\Http\Controllers
 */
class VisualModuleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return View|JsonResponse
     */
    public function index(): JsonResponse|View
    {
        try {
            $orgStatusData = $this->getOrganizationByStatus();
            $usersPerOrgData = $this->getTopFiveOrgsByUsers();
            $activityStatusData = $this->getActivityStatusData();
            $activityByUploadMedium = $this->getActivityByUploadMedium();

            return view('visualmodule::index', compact('orgStatusData', 'usersPerOrgData', 'activityStatusData', 'activityByUploadMedium'));
        } catch (\Exception $e) {
            logger()->error($e);

            return response()->json(['success' => false, 'error' => 'Error has occurred while generating visualizations.']);
        }
    }

    /**
     * Returns array of organizations by status
     *
     * @return array
     */
    public function getOrganizationByStatus(): array
    {
        $organizations = DB::table('organizations')->get();

        return [
            'draft' => $organizations->where('status', 'draft')->count(),
            'published' => $organizations->where('status', 'published')->count(),
        ];
    }

    /**
     * Returns array of top 5 organizations by users.
     *
     * @return array
     */
    public function getTopFiveOrgsByUsers(): array
    {
        $topOrganizations = DB::table('organizations')
                              ->leftJoin('users', 'organizations.id', '=', 'users.organization_id')
                              ->select('organizations.*', DB::raw('COUNT(users.id) as users_count'))
                              ->groupBy('organizations.id')
                              ->orderBy('users_count', 'desc')
                              ->take(5)
                              ->get();

        $data = [];

        foreach ($topOrganizations as $organization) {
            $key = strlen($organization->publisher_name) > 20 ? substr($organization->publisher_name, 0, 20) . '...' : $organization->publisher_name;
            $data[$key] = $organization->users_count;
        }

        return $data;
    }

    /**
     * Returns array of activity status data
     *
     * @return array
     */
    public function getActivityStatusData(): array
    {
        $activities = DB::table('activities')->get();

        return [
            'draft' => $activities->where('status', 'draft')->count(),
            'published' => $activities->where('status', 'published')->count(),
        ];
    }

    /**
     * Returns array of activity by upload medium
     *
     * @return array
     */
    public function getActivityByUploadMedium(): array
    {
        $activities = DB::table('activities')->get();
        $mediums = ['manual', 'xls', 'csv', 'xml'];
        $data = [];

        foreach ($mediums as $medium) {
            $data[$medium] = $activities->where('upload_medium', $medium)->count();
        }

        return $data;
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        return view('visualmodule::create');
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function show($id)
    {
        return view('visualmodule::show');
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit($id)
    {
        return view('visualmodule::edit');
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Renderable
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Renderable
     */
    public function destroy($id)
    {
        //
    }
}
