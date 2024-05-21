<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin\Organization;

use App\Http\Controllers\Controller;
use App\Http\Requests\Organization\Name\NameRequest;
use App\IATI\Services\Organization\NameService;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;

/**
 * Class NameController.
 */
class NameController extends Controller
{
    /**
     * @var NameService
     */
    protected NameService $nameService;

    /**
     * NameController Constructor.
     *
     * @param NameService    $nameService
     */
    public function __construct(NameService $nameService)
    {
        $this->nameService = $nameService;
    }

    /**
     * Renders title edit form.
     *
     * @return View|RedirectResponse
     */
    public function edit(): View|RedirectResponse
    {
        try {
            $id = Auth::user()->organization_id;
            $element = json_decode(file_get_contents(app_path('IATI/Data/organizationElementJsonSchema.json')), true, 512, JSON_THROW_ON_ERROR);
            $organization = $this->nameService->getOrganizationData($id);
            $form = $this->nameService->formGenerator($id, deprecationStatusMap: Arr::get($organization->deprecation_status_map, 'name', []));
            $data = ['title'=> $element['name']['label'], 'name'=>'name'];

            return view('admin.organisation.forms.name.name', compact('form', 'organization', 'data'));
        } catch (\Exception $e) {
            logger()->error($e->getMessage());

            return redirect()->route('admin.organisation.index')->with('error', 'Error has occurred while opening organization name form.');
        }
    }

    /**
     * Updates organization title data.
     *
     * @param NameRequest $request
     *
     * @return RedirectResponse
     */
    public function update(NameRequest $request): RedirectResponse
    {
        try {
            if (!$this->nameService->update(Auth::user()->organization_id, $request->all())) {
                return redirect()->route('admin.organisation.index')->with('error', 'Error has occurred while updating organization name.');
            }

            return redirect()->route('admin.organisation.index')->with('success', 'Organization name updated successfully.');
        } catch (\Exception $e) {
            logger()->error($e->getMessage());

            return redirect()->route('admin.organisation.index')->with('error', 'Error has occurred while updating organization name.');
        }
    }
}
