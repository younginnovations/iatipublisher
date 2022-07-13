<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin\Organization;

use App\Http\Controllers\Controller;
use App\Http\Requests\Organization\Name\NameRequest;
use App\IATI\Elements\Builder\BaseFormCreator;
use App\IATI\Services\Organization\NameService;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;

/**
 * Class NameController.
 */
class NameController extends Controller
{
    protected BaseFormCreator $baseFormCreator;

    protected NameService $nameService;

    /**
     * NameController Constructor.
     *
     * @param BaseFormCreator $baseFormCreator
     * @param NameService    $nameService
     */
    public function __construct(BaseFormCreator $baseFormCreator, NameService $nameService)
    {
        $this->baseFormCreator = $baseFormCreator;
        $this->nameService = $nameService;
    }

    /**
     * Renders title edit form.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|void|RedirectResponse
     */
    public function edit(): View|RedirectResponse
    {
        try {
            $id = Auth::user()->organization_id;
            $element = json_decode(file_get_contents(app_path('IATI/Data/organizationElementJsonSchema.json')), true);
            $organization = $this->nameService->getOrganizationData($id);
            $model['narrative'] = $this->nameService->getNameData($id);
            $this->baseFormCreator->url = route('admin.organisation.name.update', [$id]);
            $form = $this->baseFormCreator->editForm($model, $element['name'], 'PUT', '/organisation');
            $status = $organization->name_element_completed ?? false;
            $data = ['core'=> $element['name']['criteria'] ?? false, 'status'=> $organization->name_element_completed ?? false, 'title'=> $element['name']['label'], 'name'=>'name'];

            return view('admin.organisation.forms.name.name', compact('form', 'organization', 'data'));
        } catch (\Exception $e) {
            logger()->error($e->getMessage());

            return redirect()->route('admin.activities.show', $id)->with('error', 'Error has occurred while opening organization name form.');
        }
    }

    /**
     * Updates organization title data.
     *
     * @param NameRequest $request
     *
     * @return JsonResponse|RedirectResponse
     */
    public function update(NameRequest $request): JsonResponse| RedirectResponse
    {
        try {
            $id = Auth::user()->organization_id;
            $organizationData = $this->nameService->getOrganizationData($id);
            $organizationTitle = $request->all();

            if (!$this->nameService->update($organizationTitle, $organizationData)) {
                return redirect()->route('admin.organisation.index', $id)->with('error', 'Error has occurred while updating organization name.');
            }

            return redirect()->route('admin.organisation.index', $id)->with('success', 'Organization name updated successfully.');
        } catch (\Exception $e) {
            logger()->error($e->getMessage());

            return redirect()->route('admin.organisation.index', $id)->with('error', 'Error has occurred while updating organization name.');
        }
    }
}
