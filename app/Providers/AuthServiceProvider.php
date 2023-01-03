<?php

namespace App\Providers;

use App\IATI\Models\Organization\Organization;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * Activity permissions.
     * @var array
     */
    /**
     * Activity permissions.
     * @var array
     */
    protected $superadmin_permissions = ['view_organizations', 'proxy_user', 'crud_iati_admin'];
    protected $admin_permissions = ['crud_activity', 'publish_activity', 'import_activity', 'crud_organization', 'view_settings', 'edit_settings', 'crud_admin', 'crud_general_user'];
    protected $general_user_permissions = ['crud_activity', 'publish_activity', 'view_settings', 'view_organization'];

    /**
     * The policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        // 'App\Models\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        Gate::before(
            function ($user, $ability, $model) {
                if ($this->getUserRole($user) === 'admin') {
                    if ($model instanceof Organization) {
                        if ($this->doesUserBelongToOrganization($user, $model)) {
                            return true;
                        }
                    }
                }
            }
        );

        foreach ($this->superadmin_permissions as $permission) {
            Gate::define(
                $permission,
                function ($user) {
                    return $this->getUserRole($user) === 'superadmin' || $this->getUserRole($user) === 'iati_admin' ? true : false;
                }
            );
        }

        foreach ($this->admin_permissions as $permission) {
            Gate::define(
                $permission,
                function ($user) {
                    return $this->getUserRole($user) === 'admin' ? true : false;
                }
            );
        }

        foreach ($this->general_user_permissions as $permission) {
            Gate::define(
                $permission,
                function ($user) {
                    return $this->getUserRole($user) === 'general_user' ? true : false;
                }
            );
        }
    }

    /**
     * Check if the current user belongs to an Organization.
     *
     * @param $user
     * @param $organization
     *
     * @return bool
     */
    protected function doesUserBelongToOrganization($user, $organization)
    {
        if ($organization instanceof Organization) {
            return $user->org_id == $organization->id;
        }

        return false;
    }

    protected function getUserRole($user): string
    {
        return $user->role->role;
    }
}
