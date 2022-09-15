<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin\Organization;

use App\Http\Controllers\Controller;
use App\Http\Requests\Organization\OrganizationIdentifier\OrganizationIdentifierRequest;
use App\IATI\Services\Organization\OrganizationIdentifierService;
use GuzzleHttp\Client;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;

/**
 * Class OrganizationIdentifierController.
 */
class OrganizationIdentifierController extends Controller
{
    /**
     * @var OrganizationIdentifierService
     */
    protected OrganizationIdentifierService $organizationIdentifierService;

    /**
     * OrganizationIdentifierController Constructor.
     *
     * @param OrganizationIdentifierService    $organizationIdentifierService
     */
    public function __construct(OrganizationIdentifierService $organizationIdentifierService)
    {
        $this->organizationIdentifierService = $organizationIdentifierService;
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
            $organization = $this->organizationIdentifierService->getOrganizationData($id);
            $form = $this->organizationIdentifierService->formGenerator($id);
            $data = ['title' => $element['organisation_identifier']['label'], 'name' => 'organisation-identifier'];

            return view('admin.organisation.forms.organisationIdentifier.edit', compact('form', 'organization', 'data'));
        } catch (\Exception $e) {
            logger()->error($e->getMessage());

            return redirect()->route('admin.activities.show', $id)->with('error', 'Error has occurred while opening organization identifier form.');
        }
    }

    /**
     * Updates organization identifier data.
     *
     * @param OrganizationIdentifierRequest $request
     *
     * @return RedirectResponse
     */
    public function update(OrganizationIdentifierRequest $request): RedirectResponse
    {
        try {
            $id = Auth::user()->organization_id;
            $organizationIdentifier = $request->all();

            if (!$this->verifyPublisher($organizationIdentifier)) {
                return redirect()->route('admin.organisation.index', $id)->with('error', 'Error has occurred while updating organization identifier. Please enter correct identifier as present in IATI Registry.');
            }

            if (!$this->organizationIdentifierService->update($id, $organizationIdentifier)) {
                return redirect()->route('admin.organisation.index', $id)->with('error', 'Error has occurred while updating organization identifier.');
            }

            return redirect()->route('admin.organisation.index', $id)->with('success', 'Organization identifier updated successfully.');
        } catch (\Exception $e) {
            logger()->error($e->getMessage());

            return redirect()->route('admin.organisation.index', $id)->with('error', 'Error has occurred while updating organization identifier.');
        }
    }

    /**
     * Verify publisher.
     *
     * @param array $data
     *
     * @return bool
     */
    public function verifyPublisher(array $data): bool
    {
        try {
            $organization = Auth::user()->organization;
            $identifier = $data['organization_registration_agency'] . '-' . $data['registration_number'];

            $client = new Client(
                [
                    'base_uri' => env('IATI_API_ENDPOINT'),
                    'headers'  => [
                        'X-CKAN-API-Key' => env('IATI_API_KEY'),
                    ],
                ]
            );

            $res = $client->request('GET', env('IATI_API_ENDPOINT') . '/action/organization_show', [
                'auth'            => [env('IATI_USERNAME'), env('IATI_PASSWORD')],
                'query'           => ['id' => $organization['publisher_id']],
                'connect_timeout' => 500,
            ]);

            $response = json_decode($res->getBody()->getContents())->result;

            if ($response->publisher_iati_id === $identifier) {
                return true;
            }

            return false;
        } catch (\Exception $e) {
            logger()->error($e->getMessage());

            return false;
        }
    }
}
