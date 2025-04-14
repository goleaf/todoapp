<?php

namespace App\Observers;

use App\Models\Todo;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;

class TodoObserver
{
    /**
     * Handle the Todo "creating" event.
     */
    public function creating(Todo $todo): void
    {
        // Ensure user_id is set if not provided
        if (empty($todo->user_id) && Auth::check()) {
            $todo->user_id = Auth::id();
        }
    }

    /**
     * Handle the Todo "created" event.
     */
    public function created(Todo $todo): void
    {
        // Log after creation when we have an ID
        $this->logActivity('created', $todo);
    }

    /**
     * Handle the Todo "updating" event.
     */
    public function updating(Todo $todo): void
    {
        // If this is a subtask and parent is completed, prevent marking as pending
        if ($todo->isDirty('status') && $todo->parent_id) {
            $parent = Todo::find($todo->parent_id);
            if ($parent && $parent->status === 'completed' && $todo->status === 'pending') {
                // Cannot set a subtask to pending if parent is completed
                $todo->status = $todo->getOriginal('status');
            }
        }
    }
    
    /**
     * Handle the Todo "updated" event.
     */
    public function updated(Todo $todo): void
    {
        // Log after update is complete
        $this->logActivity('updated', $todo);
    }

    /**
     * Handle the Todo "deleting" event.
     */
    public function deleting(Todo $todo): void
    {
        // No pre-deletion actions needed
    }
    
    /**
     * Handle the Todo "deleted" event.
     */
    public function deleted(Todo $todo): void
    {
        // Log after deletion
        $this->logActivity('deleted', $todo);
    }

    /**
     * Log todo activity for audit purposes
     */
    private function logActivity(string $action, Todo $todo): void
    {
        $user = Auth::user();
        $userId = $user ? $user->id : null;
        $userName = $user ? $user->name : 'System';
        
        $logData = [
            'title' => $todo->title,
            'user_id' => $userId,
            'performed_by' => $userName,
            'action' => $action,
        ];
        
        // Add ID only if it exists (might not exist for some events)
        if ($todo->exists && $todo->id) {
            $logData['todo_id'] = $todo->id;
        }
        
        // Add changes if available
        if ($todo->isDirty()) {
            $logData['changes'] = $todo->getDirty();
        }
        
        Log::info("Todo {$action}", $logData);
    }
} 