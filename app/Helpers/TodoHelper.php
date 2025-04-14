<?php

namespace App\Helpers;

use App\Models\Todo;

class TodoHelper
{
    /**
     * Get priority colors for todo items
     *
     * @return array
     */
    public static function getPriorityColors(): array
    {
        return [
            'low' => 'blue',
            'medium' => 'yellow',
            'high' => 'orange',
            'urgent' => 'red',
        ];
    }

    /**
     * Get status colors for todo items
     *
     * @return array
     */
    public static function getStatusColors(): array
    {
        return [
            'not_started' => 'gray',
            'in_progress' => 'blue',
            'completed' => 'green',
            'on_hold' => 'yellow',
            'cancelled' => 'red',
        ];
    }

    /**
     * Get color for subtask count badge
     *
     * @param Todo $todo
     * @return string
     */
    public static function getSubtaskBadgeColor(Todo $todo): string
    {
        $subtaskCount = $todo->children->count();
        $completedCount = $todo->children->where('status.value', 'completed')->count();
        $badgeColor = 'gray';
        
        if ($subtaskCount > 0) {
            if ($completedCount === $subtaskCount) {
                $badgeColor = 'green';
            } elseif ($completedCount > 0) {
                $badgeColor = 'yellow';
            }
        }
        
        return $badgeColor;
    }
    
    /**
     * Get subtask counts
     *
     * @param Todo $todo
     * @return array
     */
    public static function getSubtaskCounts(Todo $todo): array
    {
        $subtaskCount = $todo->children->count();
        $completedCount = $todo->children->where('status.value', 'completed')->count();
        
        return [
            'total' => $subtaskCount,
            'completed' => $completedCount
        ];
    }
} 