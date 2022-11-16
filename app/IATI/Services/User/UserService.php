<?php

declare(strict_types=1);

namespace App\IATI\Services\User;

use App\IATI\Models\User\User;
use App\IATI\Repositories\Organization\OrganizationRepository;
use App\IATI\Repositories\Setting\SettingRepository;
use App\IATI\Repositories\User\UserRepository;
use GuzzleHttp\Client;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

/**
 * Class UserService.
 */
class UserService
{
    /**
     * @var UserRepository
     */
    private UserRepository $userRepo;

    /**
     * @var OrganizationRepository
     */
    private OrganizationRepository $organizationRepo;

    /**
     * @var SettingRepository
     */
    private SettingRepository $settingRepo;

    /**
     * UserService constructor.
     *
     * @param UserRepository         $userRepo
     * @param OrganizationRepository $organizationRepo
     * @param SettingRepository $settingRepo
     */
    public function __construct(UserRepository $userRepo, OrganizationRepository $organizationRepo, SettingRepository $settingRepo)
    {
        $this->userRepo = $userRepo;
        $this->organizationRepo = $organizationRepo;
        $this->settingRepo = $settingRepo;
    }

    /**
     * Store user.
     *
     * @param array $data
     *
     * @return Model
     */
    public function create(array $data): Model
    {
        return $this->userRepo->store($data);
    }

    /**
     * @param array $data
     *
     * @return Model
     */
    public function registerExistingUser(array $data): Model
    {
        $organization = $this->organizationRepo->createOrganization([
            'publisher_id'        => $data['publisher_id'],
            'publisher_name'      => $data['publisher_name'],
            'country'             => $data['country'] ?? null,
            'registration_agency' => $data['registration_agency'],
            'registration_number' => $data['registration_number'],
            'identifier'          => $data['registration_agency'] . '-' . $data['registration_number'],
            'iati_status'         => 'pending',
        ]);

        $user = $this->userRepo->store([
            'username'        => $data['username'],
            'full_name'       => $data['full_name'],
            'email'           => $data['email'],
            'organization_id' => $organization['id'],
            'password'        => Hash::make($data['password']),
        ]);

        User::sendEmail();

        return $user;
    }

    /**
     * @param array $data
     *
     * @return Model
     */
    public function registerNewUser(array $data): Model
    {
        $organization = $this->organizationRepo->createOrganization([
            'publisher_id'        => $data['publisher_id'],
            'publisher_name'      => $data['publisher_name'],
            'country'             => $data['country'] ?? null,
            'registration_agency' => $data['registration_agency'],
            'registration_number' => $data['registration_number'],
            'publisher_type'      => $data['publisher_type'],
            'identifier'          => $data['registration_agency'] . '-' . $data['registration_number'],
            'iati_status'         => 'pending',
            'reporting_org'       => $data['source'] ? ['secondary_reporter' => ($data['source'] === 'secondary_source' ? '1' : '0')] : null,
        ]);

        $this->settingRepo->store([
            'organization_id' => $organization['id'],
            'publishing_info' => [
                'publisher_id' => $data['publisher_id'],
                'api_token' => $data['token'],
                'publisher_verification' => true,
                'token_verification' => true,
            ],
        ]);

        $user = $this->userRepo->store([
            'username'        => $data['username'],
            'full_name'       => $data['full_name'],
            'email'           => $data['email'],
            'organization_id' => $organization['id'],
            'password'        => Hash::make($data['password']),
        ]);

        User::sendEmail();

        return $user;
    }

    /**
     * Check publisher id in iati registry.
     *
     * @param string $publisher_id
     * @param bool $exists
     *
     * @return array
     */
    public function checkPublisher(string $publisher_id, bool $exists = true): array
    {
        $clientConfig = ['base_uri' => env('IATI_API_ENDPOINT')];
        $requestConfig = [
            'http_errors' => false,
            'query'       => ['id' => $data['publisher_id'] ?? ''],
        ];

        if (env('APP_ENV') !== 'production') {
            $clientConfig['headers']['X-CKAN-API-Key'] = env('IATI_API_KEY');
            $requestConfig['auth'] = [env('IATI_USERNAME'), env('IATI_PASSWORD')];
        }

        $client = new Client($clientConfig);
        $res = $client->request('GET', env('IATI_API_ENDPOINT') . '/action/organization_list', $requestConfig);
        $errors = [];

        if ($res->getStatusCode() === 404) {
            if ($exists) {
                $errors['publisher_id'] = ['Publisher ID doesn\'t exist in IATI Registry.'];
            }

            return $errors;
        }

        $response = json_decode($res->getBody()->getContents())->result;

        if (!in_array($publisher_id, $response) && $exists) {
            $errors['publisher_id'] = ['Publisher ID doesn\'t match your IATI Registry information.'];
        }

        if (in_array($publisher_id, $response) && !$exists) {
            $errors['publisher_id'] = ['Publisher ID already exists in IATI Registry.'];
        }

        return $errors;
    }

    /**
     * Create User and Publisher In Iati Registry.
     *
     * @param string $data
     *
     * @return array|bool
     */
    public function checkIATIIdentifier(string $identifier): array
    {
        $clientConfig = ['base_uri' => env('IATI_API_ENDPOINT')];
        $requestConfig = [
            'http_errors' => false,
            'query'       => ['q' => $identifier ?? '', 'all_fields' => true, 'include_extras' => true],
        ];

        if (env('APP_ENV') !== 'production') {
            $clientConfig['headers']['X-CKAN-API-Key'] = env('IATI_API_KEY');
            $requestConfig['auth'] = [env('IATI_USERNAME'), env('IATI_PASSWORD')];
        }

        $client = new Client($clientConfig);
        $res = $client->request('GET', env('IATI_API_ENDPOINT') . '/action/organization_list', $requestConfig);
        $errors = [];

        if ($res->getStatusCode() === 404) {
            $errors['error'] = ['Error occurred while trying to check user email.'];

            return $errors;
        }

        $result = json_decode($res->getBody()->getContents())->result;

        if (!empty($result)) {
            foreach ($result as $publisher) {
                if ($publisher->publisher_iati_id === $identifier) {
                    return [
                        'identifier' => [
                            0 => 'IATI Organizational Identifier already exists in IATI Registry.',
                        ],
                    ];
                }
            }
        }

        return $errors;
    }

    /**
     * Create User and Publisher In Iati Registry.
     *
     * @param array $data
     * @param bool $exists
     *
     * @return array|bool
     */
    public function checkUser(array $data, bool $exists = true): array|bool
    {
        $clientConfig = ['base_uri' => env('IATI_API_ENDPOINT')];
        $requestConfig = [
            'http_errors' => false,
            'query'       => ['id' => $data['username'] ?? ''],
        ];

        if (env('APP_ENV') !== 'production') {
            $clientConfig['headers']['X-CKAN-API-Key'] = env('IATI_API_KEY');
            $requestConfig['auth'] = [env('IATI_USERNAME'), env('IATI_PASSWORD')];
        }

        $client = new Client($clientConfig);
        $res = $client->request('GET', env('IATI_API_ENDPOINT') . '/action/user_show', $requestConfig);
        $errors = [];

        if ($res->getStatusCode() === 404) {
            if ($exists) {
                $errors['publisher_id'] = ['User doesn\'t exist in IATI Registry.'];
            }

            return $errors;
        }

        $response = json_decode($res->getBody()->getContents())->result;

        $errors = [];

        if ($exists) {
            if ($data['username'] !== $response->name) {
                $errors['username'] = ['User with this name does not exists in IATI Registry.'];
            }

            if ($data['email'] !== $response->email) {
                $errors['email'] = ['User with this email does not exist in IATI Registry.'];
            }
        } else {
            if ($data['username'] === $response->name) {
                $errors['username'] = ['Publisher Name already exists IATI Registry.'];
            }

            if ($data['email'] === $response->email) {
                $errors['email'] = ['Publisher IATI ID already exists in IATI Registry.'];
            }
        }

        return $errors;
    }

    /**
     * Create User and Publisher In Iati Registry.
     *
     * @param array $email
     *
     * @return array
     */
    public function checkUserEmail(string $email): array
    {
        $clientConfig = ['base_uri' => env('IATI_API_ENDPOINT')];
        $requestConfig = [
            'http_errors' => false,
            'query'       => ['email' => $email ?? ''],
        ];

        if (env('APP_ENV') !== 'production') {
            $clientConfig['headers']['X-CKAN-API-Key'] = env('IATI_API_KEY');
            $requestConfig['auth'] = [env('IATI_USERNAME'), env('IATI_PASSWORD')];
        }

        $client = new Client($clientConfig);
        $res = $client->request('GET', env('IATI_API_ENDPOINT') . '/action/user_list', $requestConfig);
        $errors = [];

        if ($res->getStatusCode() === 404) {
            $errors['error'] = ['Error occurred while trying to check user email.'];

            return $errors;
        }

        $response = json_decode($res->getBody()->getContents())->result;
        $errors = [];

        if (!empty($response)) {
            $errors['email'] = ['User with this email already exist in IATI Registry.'];
        }

        return $errors;
    }

    /**
     * Create User In Iati Registry.
     *
     * @param array $data
     *
     * @return array|bool
     */
    public function createUserInRegistry(array $data): array
    {
        $clientConfig = ['base_uri' => env('IATI_API_ENDPOINT')];
        $requestConfig = [
            'http_errors' => false,
            'form_params'       => [
                'name' => $data['username'] ?? '',
                'email' => $data['email'] ?? '',
                'password' => $data['password'] ?? '',
            ],
        ];

        if (env('APP_ENV') !== 'production') {
            $requestConfig['auth'] = [env('IATI_USERNAME'), env('IATI_PASSWORD')];
        }

        $clientConfig['headers']['X-CKAN-API-Key'] = env('IATI_API_KEY');
        $client = new Client($clientConfig);
        $res = $client->request('POST', env('IATI_API_ENDPOINT') . '/action/user_create', $requestConfig);
        $response = json_decode($res->getBody()->getContents());

        if ($response->success) {
            return [
                'success' => true,
                'token' => $response->result,
            ];
        }

        return [
            'success' => false,
            'errors' => (array) $response->error,
        ];
    }

    /**
     * Creates API token.
     *
     * @param string $data
     *
     * @return array
     */
    public function createAPItoken(string $username): array
    {
        $clientConfig = ['base_uri' => env('IATI_API_ENDPOINT')];
        $requestConfig = [
            'http_errors' => false,
            'form_params'       => [
                'user' => $username ?? '',
                'name' => $username ?? '',
            ],
        ];

        if (env('APP_ENV') !== 'production') {
            $requestConfig['auth'] = [env('IATI_USERNAME'), env('IATI_PASSWORD')];
        }

        $clientConfig['headers']['X-CKAN-API-Key'] = env('IATI_API_KEY');
        $client = new Client($clientConfig);
        $res = $client->request('POST', env('IATI_API_ENDPOINT') . '/action/api_token_create', $requestConfig);
        $response = json_decode($res->getBody()->getContents());

        if ($response->success) {
            return [
                'success' => true,
                'token' => $response->result->token,
            ];
        }

        return [
            'success' => false,
            'errors' => (array) $response->error->message,
        ];
    }

    /**
     * Create User and Publisher In Iati Registry.
     *
     * @param array $data
     *
     * @return array
     */
    public function createPublisherInRegistry(array $data, $token): array
    {
        $clientConfig = ['base_uri' => env('IATI_API_ENDPOINT')];

        $requestConfig = [
            'http_errors' => false,
            'form_params'       => [
                'publisher_iati_id' => $data['identifier'] ?? '',
                'publisher_organization_type' => $data['publisher_type'] ?? '',
                'title' => $data['publisher_name'] ?? '',
                'publisher_contact_email' => $data['contact_email'] ?? '',
                'license_id' => $data['license_id'] ?? '',
                'name' => $data['publisher_id'] ?? '',
                'full_name' => $data['fullname'] ?? '',
                'state' => 'approval_needed',
                'publisher_organization_type' => $data['publisher_type'] ?? '',
                'publisher_url' => $data['publisher_url'] ?? '',
                'publisher_contact' => $data['address'] ?? '',
                'publisher_source_type' => $data['source'] ?? '',
                'image_url' => $data['image_url'] ?? '',
                'website' => $data['website'] ?? '',
                'description' => $data['description'] ?? '',
                'record_exclusion' => $data['record_exclusions'] ?? '',
            ],
        ];

        if (env('APP_ENV') !== 'production') {
            $requestConfig['auth'] = [env('IATI_USERNAME'), env('IATI_PASSWORD')];
        }

        $clientConfig['headers']['X-CKAN-API-Key'] = $token;
        $client = new Client($clientConfig);
        $res = $client->request('POST', env('IATI_API_ENDPOINT') . '/action/organization_create', $requestConfig);
        $response = json_decode($res->getBody()->getContents());

        if ($response->success) {
            return [
                'success' => true,
                'token' => $response->result,
            ];
        }

        return [
            'success' => false,
            'errors' => (array) $response->error,
        ];
    }

    /**
     * Map IATI errors to system error.
     *
     * @param string type
     * @param array $errors
     *
     * @return array
     */
    public function mapError($type, $errors): array
    {
        $mapper = [
            'user' => [
                'name' => 'username',
                'contact_email' => 'email',
                'password' => 'password',
            ],
            'publisher' => [
                'publisher_iati_id' => 'identifier',
                'publisher_organization_type' => 'publisher_type',
                'title' => 'publisher_name',
                'publisher_contact_email' => 'contact_email',
                'license_id' => 'license_id',
                'name' => 'publisher_id',
                'full_name' => 'fullname',
                'publisher_organization_type' => 'publisher_type',
                'publisher_url' => 'publisher_url',
                'publisher_contact' => 'address',
                'publisher_source_type' => 'source',
                'image_url' => 'image_url',
                'website' => 'website',
                'record_exclusion' => 'record_exclusions',
            ],
        ];

        unset($errors['__type']);

        foreach ($errors as $field => $error) {
            if (in_array($field, array_keys($mapper[$type]))) {
                $errors[$mapper[$type][$field]] = $error;
            }
        }

        return $errors;
    }

    /**
     * Stores the user that exists in IATI.
     *
     * @return bool
     */
    public function getStatus(): bool
    {
        return $this->userRepo->getStatus(Auth::user()->id);
    }

    /**
     * Stores the user that exists in IATI.
     *
     * @return void
     */
    public function resendVerificationEmail(): void
    {
        User::sendEmail();
        User::resendEmail(Auth::user());
    }

    /**
     * Returns user if found.
     *
     * @param $id
     *
     * @return object
     */
    public function getUser($id): object
    {
        return $this->userRepo->getUser($id);
    }
}
