<?php

namespace Tests\Unit\Observers;

use App\Enums\TodoStatus;
use App\Models\Todo;
use App\Models\User;
use App\Observers\TodoObserver;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Auth;
use Tests\TestCase;

class TodoObserverTest extends TestCase
{
    use RefreshDatabase;
    
    /**
     * Test creating event sets the user_id if not provided.
     */
    public function test_creating_sets_user_id_if_missing(): void
    {
        // Create and authenticate a user
        $user = User::factory()->create();
        Auth::login($user);
        
        // Create a new todo without setting user_id
        $todo = new Todo([
            'title' => 'Observer Test Todo',
            'description' => 'Testing the observer',
        ]);
        
        // Manually call the observer method
        $observer = new TodoObserver();
        $observer->creating($todo);
        
        // Assert that the user_id was set automatically
        $this->assertEquals($user->id, $todo->user_id);
    }
    
    /**
     * Test creating does not override user_id if provided.
     */
    public function test_creating_does_not_override_provided_user_id(): void
    {
        // Create two users
        $user1 = User::factory()->create();
        $user2 = User::factory()->create();
        
        // Authenticate as user1
        Auth::login($user1);
        
        // Create a new todo with user_id explicitly set to user2
        $todo = new Todo([
            'title' => 'Observer Test Todo',
            'description' => 'Testing the observer',
            'user_id' => $user2->id,
        ]);
        
        // Manually call the observer method
        $observer = new TodoObserver();
        $observer->creating($todo);
        
        // Assert that the user_id was not changed
        $this->assertEquals($user2->id, $todo->user_id);
    }
    
    /**
     * Test that updating prevents marking a subtask as pending if parent is completed.
     */
    public function test_updating_prevents_marking_subtask_as_pending_if_parent_completed(): void
    {
        // Create a user
        $user = User::factory()->create();
        
        // Create a parent todo that's completed
        $parentTodo = Todo::factory()->create([
            'user_id' => $user->id,
            'status' => TodoStatus::Completed,
        ]);
        
        // Create a subtask that's also completed
        $subtask = Todo::factory()->create([
            'user_id' => $user->id,
            'parent_id' => $parentTodo->id,
            'status' => TodoStatus::Completed,
        ]);
        
        // Try to mark the subtask as pending
        $subtask->status = TodoStatus::Pending;
        
        // Manually call the observer method
        $observer = new TodoObserver();
        $observer->updating($subtask);
        
        // Assert that the status was reverted
        $this->assertEquals(TodoStatus::Completed, $subtask->status);
    }
    
    /**
     * Test that updating allows marking a subtask as pending if parent is not completed.
     */
    public function test_updating_allows_marking_subtask_as_pending_if_parent_not_completed(): void
    {
        // Create a user
        $user = User::factory()->create();
        
        // Create a parent todo that's pending
        $parentTodo = Todo::factory()->create([
            'user_id' => $user->id,
            'status' => TodoStatus::Pending,
        ]);
        
        // Create a subtask that's completed
        $subtask = Todo::factory()->create([
            'user_id' => $user->id,
            'parent_id' => $parentTodo->id,
            'status' => TodoStatus::Completed,
        ]);
        
        // Try to mark the subtask as pending
        $subtask->status = TodoStatus::Pending;
        
        // Manually call the observer method
        $observer = new TodoObserver();
        $observer->updating($subtask);
        
        // Assert that the status was not reverted
        $this->assertEquals(TodoStatus::Pending, $subtask->status);
    }
} 