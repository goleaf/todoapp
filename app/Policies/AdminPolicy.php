<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\Response;

class AdminPolicy
{
    /**
     * Determine whether the user can view admin privileges of a user.
     */
    public function viewAdminStatus(User $user, User $targetUser): bool
    {
        return $user->hasRole('admin');
    }

    /**
     * Determine whether the user can grant admin privileges to another user.
     */
    public function grantAdminPrivilege(User $user, User $targetUser): bool
    {
        // Only admins can grant admin privileges
        if (!$user->hasRole('admin')) {
            return false;
        }

        // Prevent granting admin privileges to oneself
        if ($user->id === $targetUser->id) {
            return false;
        }

        return true;
    }

    /**
     * Determine whether the user can revoke admin privileges from another user.
     */
    public function revokeAdminPrivilege(User $user, User $targetUser): bool
    {
        // Only admins can revoke admin privileges
        if (!$user->hasRole('admin')) {
            return false;
        }

        // Prevent revoking admin privileges from oneself
        if ($user->id === $targetUser->id) {
            return false;
        }

        return true;
    }

    /**
     * Determine whether the user can access admin logs.
     */
    public function viewAdminLogs(User $user): bool
    {
        return $user->hasRole('admin');
    }

    /**
     * Determine whether the user can manage admin settings.
     */
    public function manageAdminSettings(User $user): bool
    {
        return $user->hasRole('admin');
    }

    /**
     * Determine whether the user can perform system administration.
     */
    public function performSystemAdmin(User $user): bool
    {
        return $user->hasRole('admin');
    }
} 