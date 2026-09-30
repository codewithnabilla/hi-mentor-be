<?php

namespace App\Providers;

use App\Models\Menu;
use App\Models\Career;
use App\Models\Department;
use App\Models\Permission;
use App\Models\Role;
use App\Models\Skill;
use App\Models\User;
use App\Policies\CareerPolicy;
use App\Policies\DepartmentPolicy;
use App\Policies\MenuPolicy;
use App\Policies\PermissionPolicy;
use App\Policies\RolePolicy;
use App\Policies\SkillPolicy;
use App\Policies\UserPolicy;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        Gate::policy(Career::class, CareerPolicy::class);
        Gate::policy(Department::class, DepartmentPolicy::class);
        Gate::policy(Menu::class, MenuPolicy::class);
        Gate::policy(Permission::class, PermissionPolicy::class);
        Gate::policy(Role::class, RolePolicy::class);
        Gate::policy(Skill::class, SkillPolicy::class);
        Gate::policy(User::class, UserPolicy::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
