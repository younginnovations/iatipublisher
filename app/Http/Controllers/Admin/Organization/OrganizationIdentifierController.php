<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin\Organization;

use App\Http\Controllers\Controller;
use App\Http\Requests\Organization\OrganizationIdentifier\OrganizationIdentifierRequest;
use App\IATI\Services\ApiLog\ApiLogService;
use App\IATI\Services\Organization\OrganizationIdentifierService;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
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
     * @var ApiLogService
     */
    protected ApiLogService $apiLogService;

    /**
     * OrganizationIdentifierController Constructor.
     *
     * @param OrganizationIdentifierService    $organizationIdentifierService
     */
    public function __construct(OrganizationIdentifierService $organizationIdentifierService, ApiLogService $apiLogService)
    {
        $this->organizationIdentifierService = $organizationIdentifierService;
        $this->apiLogService = $apiLogService;
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
            $organization = $this->organizationIdentifierService->getOrganizationData($id);
            $form = $this->organizationIdentifierService->formGenerator($id);
            $data = ['title' => $element['organisation_identifier']['label'], 'name' => 'organisation-identifier'];

            return view('admin.organisation.forms.organisationIdentifier.edit', compact('form', 'organization', 'data'));
        } catch (\Exception $e) {
            logger()->error($e->getMessage());

            return redirect()->route('admin.activities.show', $id)->with('error', trans('responses.error_has_occurred_form', ['event'=>trans('events.opening'), 'suffix'=>trans('elements_common.organisation_identifier')]));
        }
    }

    /**
     * Updates organization identifier data.
     *
     * @param OrganizationIdentifierRequest $request
     *
     * @return RedirectResponse
     * @throws GuzzleException
     */
    public function update(OrganizationIdentifierRequest $request): RedirectResponse
    {
        try {
            $id = Auth::user()->organization_id;
            $organizationIdentifier = $request->all();

            if (!$this->verifyPublisher($organizationIdentifier)) {
                return redirect()->route('admin.organisation.identifier.edit')->with('error', trans('responses.enter_correct_identifier'))->withInput();
            }

            if (!$this->organizationIdentifierService->update($id, $organizationIdentifier)) {
                return redirect()->route('admin.organisation.index')->with('error', trans('responses.error_has_occurred', ['event'=>trans('events.updating'), 'suffix'=>trans('elements_common.organisation_identifier')]));
            }

            return redirect()->route('admin.organisation.index')->with('success', ucfirst(trans('responses.event_successfully', ['prefix'=>trans('elements_common.organisation_identifier'), 'event'=>trans('events.updated')])));
        } catch (\Exception $e) {
            logger()->error($e->getMessage());

            return redirect()->route('admin.organisation.index')->with('error', trans('responses.error_has_occurred', ['event'=>trans('events.updating'), 'suffix'=>trans('elements_common.organisation_identifier')]));
        }
    }

    /**
     * Verify publisher.
     *
     * @param array $data
     *
     * @return bool
     * @throws GuzzleException
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
            $requestOptions = [
                'auth'            => [env('IATI_USERNAME'), env('IATI_PASSWORD')],
                'query'           => ['id' => $organization['publisher_id']],
                'connect_timeout' => 500,
            ];

            $res = $client->request('GET', env('IATI_API_ENDPOINT') . '/action/organization_show', $requestOptions);
            $this->apiLogService->store(generateApiInfo('GET', env('IATI_API_ENDPOINT') . '/action/organization_show', $requestOptions, $res));

            $response = json_decode($res->getBody()->getContents(), false, 512, JSON_THROW_ON_ERROR)->result;

            return $response->publisher_iati_id === $identifier;
        } catch (\Exception $e) {
            logger()->error($e->getMessage());

            return false;
        }
    }
}
