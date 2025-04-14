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
    'status_not_started' => 'Not Started',
    'status_on_hold' => 'On Hold',
    'status_cancelled' => 'Cancelled',
    
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

    // Index Page Specific
    'create_tooltip' => 'Click here to create a new task',
    'shortcuts_tooltip' => 'View keyboard shortcuts',
    'shortcuts_button' => 'Shortcuts',
    'search_tooltip' => 'Type here to search for tasks',
    'search_placeholder' => 'Search todos...',
    'filter_heading' => 'Filter Todos',
    'filter_category_tooltip' => 'Filter tasks by category',
    'category' => 'Category',
    'all_categories' => 'All Categories',
    'filter_status_tooltip' => 'Filter tasks by completion status',
    'all_statuses' => 'All Statuses',
    'sort_tooltip' => 'Choose how to order your tasks',
    'sort_by' => 'Sort By',
    'sort_latest' => 'Newest First',
    'sort_oldest' => 'Oldest First',
    'sort_due_asc' => 'Due Date (Oldest First)',
    'sort_due_desc' => 'Due Date (Newest First)',
    'filter_apply_tooltip' => 'Apply filters',
    'filter_button' => 'Filter',
    'filter_reset_tooltip' => 'Clear all filters',
    'filter_reset_button' => 'Reset',
    'subtasks' => 'Subtask|Subtasks',
    'actions' => 'Actions',
    'category_none' => 'None',
    'no_due_date' => 'No due date',
    'task_options_tooltip' => 'Task options',
    'view_action' => 'View',
    'delete_confirm_message' => 'Are you sure you want to delete this todo? This action cannot be undone.',
    'empty_title_filtered' => 'No todos found matching your criteria.',
    'empty_description_filtered' => 'Try adjusting your search or filters.',
    'empty_title_no_todos' => 'No todos yet!',
    'empty_description_create_first' => 'Create your first todo to get started.',

    // Create/Edit Page Specific
    'create_heading' => 'Create New Todo',
    'edit_heading' => 'Edit Todo',
    'back_to_list' => 'Back to Todos',
    'details_heading' => 'Todo Details',
    'details_subheading' => 'Fill in the details for your task.',
    'description_help' => 'Write a few sentences about the task.',
    'select_category' => 'Select a category',
    'parent_todo' => 'Parent Todo',
    'parent_none' => 'None (Top Level Todo)',
    'select_priority' => 'Select priority',
    'select_status' => 'Select status',
    'cancel_button' => 'Cancel',
    'save_button' => 'Save Changes',
    'view_details_button' => 'View Details',
    'update_details_subheading' => 'Update the details for this task.',
    'completion_heading' => 'Task Completed!',
    'completion_text' => 'Great job finishing this task!',
    'status_tooltip' => 'Change the status to Completed when you finish this task',

    // Show Page Specific
    'back_button' => 'Back',
    'created_at' => 'Created',
    'updated_at' => 'Last Updated',
    'view_parent_button' => 'View Parent',
    'due_label' => 'Due',
    'no_subtasks_yet' => 'No subtasks created yet.',
]; 