<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;
use App\Models\Todo;
use App\Models\User;
use App\Models\Category;
use App\Models\Language;
use App\Policies\TodoPolicy;
use App\Policies\UserPolicy;
use App\Policies\CategoryPolicy;
use App\Policies\LanguagePolicy;
use App\Policies\AdminPolicy;
use App\Policies\AdminRoutePolicy;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        Todo::class => TodoPolicy::class,
        User::class => UserPolicy::class,
        Category::class => CategoryPolicy::class,
        Language::class => LanguagePolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        $this->registerPolicies();

        // Define admin role gate
        Gate::define('admin', function ($user) {
            return $user->is_admin === 1;
        });
        
        // Register admin-specific gates
        Gate::define('access-admin-dashboard', [AdminRoutePolicy::class, 'accessDashboard']);
        Gate::define('manage-users', [AdminRoutePolicy::class, 'manageUsers']);
        Gate::define('manage-todos', [AdminRoutePolicy::class, 'manageTodos']);
        Gate::define('manage-translations', [AdminRoutePolicy::class, 'manageTranslations']);
        Gate::define('view-logs', [AdminRoutePolicy::class, 'viewLogs']);
        Gate::define('configure-settings', [AdminRoutePolicy::class, 'configureSettings']);
        Gate::define('view-analytics', [AdminRoutePolicy::class, 'viewAnalytics']);
        
        // Register admin privilege management gates
        Gate::define('view-admin-status', [AdminPolicy::class, 'viewAdminStatus']);
        Gate::define('grant-admin-privilege', [AdminPolicy::class, 'grantAdminPrivilege']);
        Gate::define('revoke-admin-privilege', [AdminPolicy::class, 'revokeAdminPrivilege']);
        Gate::define('view-admin-logs', [AdminPolicy::class, 'viewAdminLogs']);
        Gate::define('manage-admin-settings', [AdminPolicy::class, 'manageAdminSettings']);
        Gate::define('perform-system-admin', [AdminPolicy::class, 'performSystemAdmin']);
    }
}

