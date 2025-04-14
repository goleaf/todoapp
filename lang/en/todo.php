<?php

return [
    // Todo model attributes
    'id' => 'ID',
    'title' => 'Title',
    'description' => 'Description',
    'due_date' => 'Due Date',
    'status' => 'Status',
    'priority' => 'Priority',
    'created_at' => 'Created At',
    'updated_at' => 'Updated At',
    
    // Status options
    'status_pending' => 'Pending',
    'status_in_progress' => 'In Progress',
    'status_completed' => 'Completed',
    
    // Priority options
    'priority_low' => 'Low',
    'priority_medium' => 'Medium',
    'priority_high' => 'High',
    
    // API messages
    'created' => 'Todo created successfully.',
    'updated' => 'Todo updated successfully.',
    'deleted' => 'Todo deleted successfully.',
    'not_found' => 'Todo not found.',
    'unauthorized' => 'You are not authorized to access this todo.',
    'invalid_parent' => 'Invalid parent task specified.',
    'self_parent' => 'Task cannot be its own parent.',
    
    // UI labels
    'todos' => 'Todos',
    'todo' => 'Todo',
    'create' => 'Create Todo',
    'edit' => 'Edit Todo',
    'delete' => 'Delete Todo',
    'add_new' => 'Add New Todo',
    'mark_completed' => 'Mark as Completed',
    'mark_in_progress' => 'Mark as In Progress',
    'mark_pending' => 'Mark as Pending',
    'no_todos' => 'No todos found.',
    'due_today' => 'Due Today',
    'overdue' => 'Overdue',
    'completed_todos' => 'Completed Todos',
    'pending_todos' => 'Pending Todos',
    'in_progress_todos' => 'In Progress Todos',
    'view_subtasks' => 'View Subtasks',
    'add_subtask' => 'Add Subtask',
]; 