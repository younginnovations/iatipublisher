<?php

declare(strict_types=1);

namespace App\IATI\Services\User;

use App\IATI\Models\User\User;
use App\IATI\Repositories\Organization\OrganizationRepository;
use App\IATI\Repositories\Setting\SettingRepository;
use App\IATI\Repositories\User\RoleRepository;
use App\IATI\Repositories\User\UserRepository;
use GuzzleHttp\Client;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Arr;
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
     * @var RoleRepository
     */
    private RoleRepository $roleRepo;

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
     * @param RoleRepository         $roleRepo
     * @param OrganizationRepository $organizationRepo
     * @param SettingRepository $settingRepo
     */
    public function __construct(UserRepository $userRepo, RoleRepository $roleRepo, OrganizationRepository $organizationRepo, SettingRepository $settingRepo)
    {
        $this->userRepo = $userRepo;
        $this->roleRepo = $roleRepo;
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
     * Register user that already exists in iati registry.
     *
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
            'name'                => [['narrative' => $data['publisher_name'], 'language' => null]],
        ]);

        $user = $this->userRepo->store([
            'username'        => $data['username'],
            'full_name'       => $data['full_name'],
            'email'           => $data['email'],
            'organization_id' => $organization['id'],
            'password'        => Hash::make($data['password']),
            'role_id'         => $this->roleRepo->getOrganizationAdminId(),
            'registration_method' => 'existing_org',
        ]);

        User::sendEmail();

        return $user;
    }

    /**
     * Register new user.
     *
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
            'name'                => [['narrative' => $data['publisher_name'], 'language' => null]],
            'reporting_org'       => $data['source'] ? [[
                'type' => null,
                'ref' => null,
                'secondary_reporter' => ($data['source'] === 'secondary_source' ? '1' : '0'),
                'narrative' => [['narrative' => null, 'language' => null]],
            ]] : null,
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
            'role_id'         => $this->roleRepo->getOrganizationAdminId(),
            'registration_method' => 'new_org',
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
     * Check if iatiIdentifier already exists at registry.
     *
     * @param string $data
     *
     * @return array
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
     * Check user in IATI Registry.
     *
     * @param array $data
     * @param bool $exists
     *
     * @return array
     */
    public function checkUser(array $data, bool $exists = true): array
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
                $errors['username'] = ['User doesn\'t exist in IATI Registry.'];
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
                $errors['username'] = ['Username already exists in IATI Registry.'];
            }

            if ($data['email'] === $response->email) {
                $errors['email'] = ['User with this email already exists in IATI Registry.'];
            }
        }

        return $errors;
    }

    /**
     * Create if user email already exists In Iati Registry.
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
     * @return array
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
        $requestConfig = [
            'http_errors' => false,
            'form_params' => $this->getFormParams($data),
        ];

        if (env('APP_ENV') !== 'production') {
            $requestConfig['auth'] = [env('IATI_USERNAME'), env('IATI_PASSWORD')];
        }

        $clientConfig = ['base_uri' => env('IATI_API_ENDPOINT')];
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
     * Returns form params.
     *
     * @param array $data
     *
     * @return array
     */
    private function getFormParams(array $data): array
    {
        return [
            'publisher_iati_id' => Arr::get($data, 'identifier', ''),
            'publisher_organization_type' => Arr::get($data, 'publisher_type', ''),
            'title' => Arr::get($data, 'publisher_name', ''),
            'publisher_contact_email' => Arr::get($data, 'contact_email', ''),
            'license_id' => Arr::get($data, 'license_id', ''),
            'name' => Arr::get($data, 'publisher_id', ''),
            'full_name' => Arr::get($data, 'fullname', ''),
            'publisher_country' => Arr::get($data, 'country', ''),
            'state' => 'approval_needed',
            'publisher_organization_type' => Arr::get($data, 'publisher_type', ''),
            'publisher_url' => Arr::get($data, 'publisher_url', ''),
            'publisher_contact' => Arr::get($data, 'address', ''),
            'publisher_source_type' => Arr::get($data, 'source', ''),
            'image_url' => Arr::get($data, 'image_url', ''),
            'publisher_url' => Arr::get($data, 'website', ''),
            'publisher_description' => Arr::get($data, 'description', ''),
            'record_exclusion' => Arr::get($data, 'record_exclusions', ''),
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
                'publisher_url' => 'website',
                'publisher_description' => 'description',
                'record_exclusion' => 'record_exclusions',
                'publisher_country' => 'country',
            ],
        ];

        unset($errors['__type']);

        foreach ($errors as $field => $error) {
            if (in_array($field, array_keys($mapper[$type]))) {
                $errors[$mapper[$type][$field]] = $error;
                unset($errors[$field]);
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

    /**
     * Update user password.
     *
     * @param $data
     *
     * @return $bool
     */
    public function updatePassword($userId, $data): bool
    {
        return $this->userRepo->update($userId, [
            'password'        => Hash::make($data['password']),
        ]);
    }

    public function store($data)
    {
        $data['organization_id'] = Auth::user()->organization_id;
        $data['password'] = Hash::make($data['password']);
        $data['role_id'] = isset($data['role_id']) ? $data['role_id'] : $this->roleRepo->getIatiAdminId();
        $data['registration_method'] = 'user_create';
        $user = $this->userRepo->store($data);
        User::sendNewUserEmail($user);

        return $user;
    }

    public function update($id, $data)
    {
        $user = $this->userRepo->find($id);

        if (Arr::get($data, 'password')) {
            $data['password'] = Hash::make($data['password']);
        }

        $user->fill($data);
        $emailChanged = $user->isDirty('email');
        $user->email_verified_at = $emailChanged ? null : $user->email_verified_at;

        $updated = $user->save();

        if ($emailChanged) {
            $user->sendEmailVerificationNotification();
        }

        return $updated;
    }

    public function delete($id)
    {
        $user = $this->userRepo->find($id);
        $users = $this->userRepo->getUserDownloadData(['organization_id' => [$user->organization_id], 'roles' => ['admin']]);

        if (count($users) > 1 || $user->organization_id === null) {
            return $this->userRepo->delete($id);
        }

        return false;
    }

    /**
     * Returns all activities present in database.
     *
     * @param int $page
     * @param array $queryParams
     *
     * @return Collection|LengthAwarePaginator
     */
    public function getPaginatedUsers($page, $queryParams): Collection|LengthAwarePaginator
    {
        $users = $this->userRepo->getPaginatedUsers($page, $queryParams);

        return $users;
    }

    public function toggleUserStatus($id)
    {
        $user = $this->userRepo->find($id);
        $status = $user['status'] ? false : true;

        if (!$status) {
            $users = $this->userRepo->getUserDownloadData(['organization_id' => [$user->organization_id], 'roles' => ['admin'], 'status' => [1]]);

            if (count($users) > 1 || $user->organization_id === null) {
                return $this->userRepo->update($id, ['status' => $status]);
            }

            return false;
        }

        return $this->userRepo->update($id, ['status' => $status]);
    }

    public function getUserDownloadData($queryParams)
    {
        $users = $this->userRepo->getUserDownloadData($queryParams);

        return $users;
    }

    public function getRoles()
    {
        $roles = $this->roleRepo->pluckRoles()->toArray();

        if (Auth::user()->role->role === 'iati_admin' || Auth::user()->role->role === 'superadmin') {
            unset($roles[array_flip($roles)['superadmin']]);
        }

        if (Auth::user()->role->role === 'admin' || Auth::user()->role->role === 'general_user') {
            unset($roles[array_flip($roles)['iati_admin']]);
            unset($roles[array_flip($roles)['superadmin']]);
        }

        return $roles;
    }
}
