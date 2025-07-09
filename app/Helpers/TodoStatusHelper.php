<?php

namespace App\Helpers;

class TodoStatusHelper
{
    /**
     * Get status options for todos
     *
     * @return array
     */
    public static function getStatusOptions(): array
    {
        return [
            'not_started' => __('todo.status_not_started'),
            'in_progress' => __('todo.status_in_progress'),
            'completed' => __('todo.status_completed'),
            'on_hold' => __('todo.status_on_hold'),
            'cancelled' => __('todo.status_cancelled')
        ];
    }

    /**
     * Get icon mapping for todo statuses
     *
     * @return array
     */
    public static function getIconMap(): array
    {
        return [
            'not_started' => 'heroicon-o-clock',
            'in_progress' => 'heroicon-o-play',
            'completed' => 'heroicon-o-check-circle',
            'on_hold' => 'heroicon-o-pause',
            'cancelled' => 'heroicon-o-x-circle'
        ];
    }

    /**
     * Get size classes for todo status component
     *
     * @return array
     */
    public static function getSizeClasses(): array
    {
        return [
            'sm' => 'text-sm py-1 px-2',
            'md' => 'text-base py-1.5 px-3',
            'lg' => 'text-lg py-2 px-4'
        ];
    }
} 