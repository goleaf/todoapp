<?php

namespace App\Policies;

use App\Models\Category;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class CategoryPolicy
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
    public function view(User $user, Category $category): bool
    {
        // Admin can view any category
        if ($user->hasRole('admin')) {
            return true;
        }

        // Regular users can only view their own categories
        return $user->id === $category->user_id;
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
    public function update(User $user, Category $category): bool
    {
        // Admin can update any category
        if ($user->hasRole('admin')) {
            return true;
        }

        // Regular users can only update their own categories
        return $user->id === $category->user_id;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Category $category): bool
    {
        // Admin can delete any category
        if ($user->hasRole('admin')) {
            return true;
        }

        // Regular users can only delete their own categories
        return $user->id === $category->user_id;
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Category $category): bool
    {
        // Admin can restore any category
        if ($user->hasRole('admin')) {
            return true;
        }

        // Regular users can only restore their own categories
        return $user->id === $category->user_id;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Category $category): bool
    {
        // Admin can force delete any category
        if ($user->hasRole('admin')) {
            return true;
        }

        // Regular users can only force delete their own categories
        return $user->id === $category->user_id;
    }
}
