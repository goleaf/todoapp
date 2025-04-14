<?php

namespace Tests\Feature;

use App\Enums\TodoPriority;
use App\Enums\TodoStatus;
use App\Models\Category;
use App\Models\Todo;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\Traits\AuthHelpers;
use Tests\TestCase;

class TodoTest extends TestCase
{
    use RefreshDatabase, AuthHelpers;

    /**
     * Test that authenticated users can access the dashboard.
     */
    public function test_authenticated_users_can_access_dashboard(): void
    {
        // Using the trait helper method
        $this->login();

        $response = $this->get('/dashboard');
        
        $response->assertStatus(200);
    }
    
    /**
     * Test that guests are redirected to login when accessing dashboard.
     */
    public function test_guests_cannot_access_dashboard(): void
    {
        $response = $this->get('/dashboard');
        
        $response->assertRedirect('/login');
    }

    /**
     * Test that users can create todos.
     */
    public function test_users_can_create_todos(): void
    {
        $user = $this->login();
        
        $todoData = [
            'title' => 'Test Todo',
            'description' => 'This is a test todo',
            'priority' => TodoPriority::Medium->value,
            'status' => TodoStatus::Pending->value,
            'due_date' => now()->addDays(7)->format('Y-m-d'),
        ];
        
        $response = $this->post(route('todos.store'), $todoData);
        
        $response->assertRedirect(route('todos.index'));
        $response->assertSessionHas('success');
        $this->assertDatabaseHas('todos', [
            'user_id' => $user->id,
            'title' => 'Test Todo',
            'description' => 'This is a test todo',
        ]);
    }

    /**
     * Test that users can view their own todos.
     */
    public function test_users_can_view_their_todos(): void
    {
        $user = $this->login();
        
        $todo = Todo::factory()->create([
            'user_id' => $user->id,
            'title' => 'My Test Todo',
        ]);
        
        $response = $this->get(route('todos.index'));
        
        $response->assertStatus(200);
        $response->assertSee('My Test Todo');
    }

    /**
     * Test that users can view a specific todo.
     */
    public function test_users_can_view_specific_todo(): void
    {
        $user = $this->login();
        
        $todo = Todo::factory()->create([
            'user_id' => $user->id,
            'title' => 'Specific Todo',
            'description' => 'This is a specific todo',
        ]);
        
        $response = $this->get(route('todos.show', $todo));
        
        $response->assertStatus(200);
        $response->assertSee('Specific Todo');
        $response->assertSee('This is a specific todo');
    }

    /**
     * Test that users cannot view others' todos.
     */
    public function test_users_cannot_view_others_todos(): void
    {
        $this->login();
        
        $otherUser = User::factory()->create();
        $todo = Todo::factory()->create([
            'user_id' => $otherUser->id,
            'title' => 'Other User Todo',
        ]);
        
        $response = $this->get(route('todos.show', $todo));
        
        $response->assertStatus(403); // Forbidden
    }

    /**
     * Test that users can update their todos.
     */
    public function test_users_can_update_their_todos(): void
    {
        $user = $this->login();
        
        $todo = Todo::factory()->create([
            'user_id' => $user->id,
            'title' => 'Original Title',
            'description' => 'Original description',
        ]);
        
        $updateData = [
            'title' => 'Updated Title',
            'description' => 'Updated description',
            'priority' => TodoPriority::High->value,
            'status' => TodoStatus::InProgress->value,
            'due_date' => now()->addDays(5)->format('Y-m-d'),
        ];
        
        $response = $this->put(route('todos.update', $todo), $updateData);
        
        $response->assertRedirect(route('todos.index'));
        $response->assertSessionHas('success');
        $this->assertDatabaseHas('todos', [
            'id' => $todo->id,
            'title' => 'Updated Title',
            'description' => 'Updated description',
        ]);
    }

    /**
     * Test that users cannot update others' todos.
     */
    public function test_users_cannot_update_others_todos(): void
    {
        $this->login();
        
        $otherUser = User::factory()->create();
        $todo = Todo::factory()->create([
            'user_id' => $otherUser->id,
        ]);
        
        $response = $this->put(route('todos.update', $todo), [
            'title' => 'Hacked Title',
            'description' => 'Hacked description',
            'priority' => TodoPriority::High->value,
            'status' => TodoStatus::Completed->value,
        ]);
        
        $response->assertStatus(403); // Forbidden
    }

    /**
     * Test that users can delete their todos.
     */
    public function test_users_can_delete_their_todos(): void
    {
        $user = $this->login();
        
        $todo = Todo::factory()->create([
            'user_id' => $user->id,
        ]);
        
        $response = $this->delete(route('todos.destroy', $todo));
        
        $response->assertRedirect(route('todos.index'));
        $response->assertSessionHas('success');
        $this->assertDatabaseMissing('todos', ['id' => $todo->id]);
    }

    /**
     * Test that users cannot delete others' todos.
     */
    public function test_users_cannot_delete_others_todos(): void
    {
        $this->login();
        
        $otherUser = User::factory()->create();
        $todo = Todo::factory()->create([
            'user_id' => $otherUser->id,
        ]);
        
        $response = $this->delete(route('todos.destroy', $todo));
        
        $response->assertStatus(403); // Forbidden
        $this->assertDatabaseHas('todos', ['id' => $todo->id]);
    }

    /**
     * Test filtering todos by category.
     */
    public function test_users_can_filter_todos_by_category(): void
    {
        $user = $this->login();
        
        $category1 = Category::factory()->create(['user_id' => $user->id, 'name' => 'Work']);
        $category2 = Category::factory()->create(['user_id' => $user->id, 'name' => 'Personal']);
        
        $workTodo = Todo::factory()->create([
            'user_id' => $user->id,
            'category_id' => $category1->id,
            'title' => 'Work Todo',
        ]);
        
        $personalTodo = Todo::factory()->create([
            'user_id' => $user->id,
            'category_id' => $category2->id,
            'title' => 'Personal Todo',
        ]);
        
        $response = $this->get(route('todos.index', ['category_id' => $category1->id]));
        
        $response->assertStatus(200);
        $response->assertSee('Work Todo');
        $response->assertDontSee('Personal Todo');
    }

    /**
     * Test filtering todos by status.
     */
    public function test_users_can_filter_todos_by_status(): void
    {
        $user = $this->login();
        
        $pendingTodo = Todo::factory()->create([
            'user_id' => $user->id,
            'title' => 'Pending Todo',
            'status' => TodoStatus::Pending,
        ]);
        
        $completedTodo = Todo::factory()->create([
            'user_id' => $user->id,
            'title' => 'Completed Todo',
            'status' => TodoStatus::Completed,
        ]);
        
        $response = $this->get(route('todos.index', ['status' => TodoStatus::Completed->value]));
        
        $response->assertStatus(200);
        $response->assertSee('Completed Todo');
        $response->assertDontSee('Pending Todo');
    }

    /**
     * Test users can update todo status via AJAX.
     */
    public function test_users_can_update_todo_status_via_ajax(): void
    {
        $user = $this->login();
        
        $todo = Todo::factory()->create([
            'user_id' => $user->id,
            'status' => TodoStatus::Pending,
        ]);
        
        $response = $this->postJson(route('todos.update-status', $todo), [
            'status' => 'completed'
        ]);
        
        $response->assertStatus(200)
            ->assertJson([
                'success' => true,
            ]);
            
        $this->assertDatabaseHas('todos', [
            'id' => $todo->id,
            'status' => 'completed',
        ]);
    }
}
