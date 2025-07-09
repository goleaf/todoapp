<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\Response;

class AdminRoutePolicy
{
    /**
     * Determine whether the user can access admin dashboard.
     */
    public function accessDashboard(User $user): bool
    {
        return $user->hasRole('admin');
    }

    /**
     * Determine whether the user can manage users.
     */
    public function manageUsers(User $user): bool
    {
        return $user->hasRole('admin');
    }

    /**
     * Determine whether the user can manage todos.
     */
    public function manageTodos(User $user): bool
    {
        return $user->hasRole('admin');
    }

    /**
     * Determine whether the user can manage translations.
     */
    public function manageTranslations(User $user): bool
    {
        return $user->hasRole('admin');
    }

    /**
     * Determine whether the user can view system logs.
     */
    public function viewLogs(User $user): bool
    {
        return $user->hasRole('admin');
    }

    /**
     * Determine whether the user can configure system settings.
     */
    public function configureSettings(User $user): bool
    {
        return $user->hasRole('admin');
    }

    /**
     * Determine whether the user can view stats and analytics.
     */
    public function viewAnalytics(User $user): bool
    {
        return $user->hasRole('admin');
    }
} 