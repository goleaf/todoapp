<?php

namespace App\Policies;

use App\Models\Todo;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class TodoPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return true;
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Todo $todo): bool
    {
        // Admin can view any todo
        if ($user->hasRole('admin')) {
            return true;
        }

        // Regular users can only view their own todos
        return $user->id === $todo->user_id;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return true;
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Todo $todo): bool
    {
        // Admin can update any todo
        if ($user->hasRole('admin')) {
            return true;
        }

        // Regular users can only update their own todos
        return $user->id === $todo->user_id;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Todo $todo): bool
    {
        // Admin can delete any todo
        if ($user->hasRole('admin')) {
            return true;
        }

        // Regular users can only delete their own todos
        return $user->id === $todo->user_id;
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Todo $todo): bool
    {
        // Admin can restore any todo
        if ($user->hasRole('admin')) {
            return true;
        }

        // Regular users can only restore their own todos
        return $user->id === $todo->user_id;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Todo $todo): bool
    {
        // Admin can force delete any todo
        if ($user->hasRole('admin')) {
            return true;
        }

        // Regular users can only force delete their own todos
        return $user->id === $todo->user_id;
    }
} 