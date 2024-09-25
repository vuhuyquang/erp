<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;

class AppServiceProvider extends ServiceProvider
{
    protected $policies = [];
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->singleton(\App\Repositories\Interfaces\UserRepositoryInterface::class, \App\Repositories\Implements\UserRepository::class);
        $this->app->singleton(\App\Repositories\Interfaces\PermissionRepositoryInterface::class, \App\Repositories\Implements\PermissionRepository::class);
        $this->app->singleton(\App\Repositories\Interfaces\RoleRepositoryInterface::class, \App\Repositories\Implements\RoleRepository::class);
        $this->app->singleton(\App\Repositories\Interfaces\RolePermissionRepositoryInterface::class, \App\Repositories\Implements\RolePermissionRepository::class);
        $this->app->singleton(\App\Repositories\Interfaces\UserRoleRepositoryInterface::class, \App\Repositories\Implements\UserRoleRepository::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        $this->registerPolicies();
        $permissions = $this->getPermissions();
        foreach ($permissions as $permission) {
            Gate::define($permission->scope, function ($user) use ($permission) {
                $permissionIdsOfUser = $this->getPermissionIdsOfUser($user);
                return in_array($permission->id, $permissionIdsOfUser);
            });
        }
    }

    private function getPermissions()
    {
        $permission = DB::table('permissions')->get();
        return $permission;
    }

    private function getPermissionIdsOfUser($user)
    {
        $roleIds = collect(DB::table('users_roles')->where('user_id', $user->id)->get())->pluck('role_id')->toArray();
        $permissionIdsOfUser = collect(DB::table('roles_permissions')->whereIn('role_id', $roleIds)->get())->pluck('permission_id')->toArray();
        return $permissionIdsOfUser;
    }

    private function registerPolicies()
    {
        foreach ($this->policies() as $model => $policy) {
            Gate::policy($model, $policy);
        }
    }

    private function policies()
    {
        return $this->policies;
    }
}
