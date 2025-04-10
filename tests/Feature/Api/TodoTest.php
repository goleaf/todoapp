<?php

namespace Tests\Feature\Api;

use App\Enums\TodoPriority;
use App\Enums\TodoStatus;
use App\Models\Todo;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class TodoTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Prevent automatic seeding when using RefreshDatabase.
     */
    public function seed($seeder = null): void
    {
        // Do nothing, override default seeding behavior
    }

    public function test_todos_can_be_listed_by_authenticated_user(): void
    {
        $user = User::factory()->create();
        Sanctum::actingAs($user);

        Todo::factory(3)->create(['user_id' => $user->id]);

        $response = $this->getJson('/api/todos');

        $response->assertStatus(200)
            ->assertJsonCount(3);
    }

    public function test_todos_cannot_be_listed_by_unauthenticated_user(): void
    {
        $response = $this->getJson('/api/todos');

        $response->assertStatus(401);
    }

    public function test_todo_can_be_created_by_authenticated_user(): void
    {
        $user = User::factory()->create();
        Sanctum::actingAs($user);

        $response = $this->postJson('/api/todos', [
            'title' => 'Test Todo',
            'description' => 'Test Description',
            'status' => TodoStatus::Pending->value,
            'priority' => TodoPriority::Medium->value,
        ]);

        $response->assertStatus(201);

        $this->assertDatabaseHas('todos', [
            'title' => 'Test Todo',
            'user_id' => $user->id,
            'priority' => TodoPriority::Medium,
            'status' => TodoStatus::Pending,
        ]);
    }

    public function test_todo_cannot_be_created_by_unauthenticated_user(): void
    {
        $response = $this->postJson('/api/todos', [
            'title' => 'Test Todo',
            'priority' => TodoPriority::Low->value,
        ]);

        $response->assertStatus(401);
    }

    public function test_todo_can_be_updated_by_owner(): void
    {
        $user = User::factory()->create();
        Sanctum::actingAs($user);

        $todo = Todo::factory()->create(['user_id' => $user->id]);

        $response = $this->putJson('/api/todos/'.$todo->id, [
            'title' => 'Updated Todo',
            'status' => TodoStatus::Completed->value,
            'priority' => TodoPriority::High->value,
        ]);

        $response->assertStatus(200);

        $this->assertDatabaseHas('todos', [
            'id' => $todo->id,
            'title' => 'Updated Todo',
            'priority' => TodoPriority::High,
            'status' => TodoStatus::Completed,
        ]);
    }

    public function test_todo_cannot_be_updated_by_non_owner(): void
    {
        $user1 = User::factory()->create();
        $user2 = User::factory()->create();
        Sanctum::actingAs($user2);

        $todo = Todo::factory()->create(['user_id' => $user1->id]);

        $response = $this->putJson('/api/todos/'.$todo->id, [
            'title' => 'Updated Todo',
        ]);

        $response->assertStatus(403);
    }

    public function test_todo_can_be_deleted_by_owner(): void
    {
        $user = User::factory()->create();
        Sanctum::actingAs($user);

        $todo = Todo::factory()->create(['user_id' => $user->id]);

        $response = $this->deleteJson('/api/todos/'.$todo->id);

        $response->assertStatus(204);

        $this->assertDatabaseMissing('todos', ['id' => $todo->id]);
    }

    public function test_todo_cannot_be_deleted_by_non_owner(): void
    {
        $user1 = User::factory()->create();
        $user2 = User::factory()->create();
        Sanctum::actingAs($user2);

        $todo = Todo::factory()->create(['user_id' => $user1->id]);

        $response = $this->deleteJson('/api/todos/'.$todo->id);

        $response->assertStatus(403);
    }

    public function test_todo_validation_on_create(): void
    {
        $user = User::factory()->create();
        Sanctum::actingAs($user);

        $response = $this->postJson('/api/todos', [
            'title' => '',
        ]);

        $response->assertStatus(422);
        $response->assertJsonValidationErrors(['title']);
    }

    public function test_todo_validation_on_update(): void
    {
        $user = User::factory()->create();
        Sanctum::actingAs($user);

        $todo = Todo::factory()->create(['user_id' => $user->id]);

        $response = $this->putJson('/api/todos/'.$todo->id, [
            'title' => '',
        ]);

        $response->assertStatus(422);
        $response->assertJsonValidationErrors(['title']);
    }

    public function test_can_update_todo_status_to_completed(): void
    {
        $user = User::factory()->create();
        Sanctum::actingAs($user);

        $todo = Todo::factory()->create(['user_id' => $user->id, 'status' => TodoStatus::Pending]);

        $response = $this->putJson('/api/todos/'.$todo->id, [
            'status' => TodoStatus::Completed->value,
        ]);

        $response->assertStatus(200)
            ->assertJson(['status' => TodoStatus::Completed->value]);
        $this->assertDatabaseHas('todos', [
            'id' => $todo->id,
            'status' => TodoStatus::Completed,
        ]);
    }

    public function test_todos_can_be_filtered_by_status(): void
    {
        $user = User::factory()->create();
        Sanctum::actingAs($user);

        // Create todos with different statuses using Enum cases
        Todo::factory()->create(['user_id' => $user->id, 'status' => TodoStatus::Pending]);
        Todo::factory()->create(['user_id' => $user->id, 'status' => TodoStatus::Completed]);
        Todo::factory()->create(['user_id' => $user->id, 'status' => TodoStatus::Pending]);

        // Filter by pending status using Enum case value
        $response = $this->getJson('/api/todos?status='.TodoStatus::Pending->value);

        $response->assertStatus(200)
            ->assertJsonCount(2)
            ->assertJson(function ($json) {
                // Assert against Enum case value in JSON response
                $json->whereAll('*.status', TodoStatus::Pending->value)
                    ->etc();
            });

        // Filter by complete status using Enum case value
        $response = $this->getJson('/api/todos?status='.TodoStatus::Completed->value);

        $response->assertStatus(200)
            ->assertJsonCount(1)
            ->assertJson(function ($json) {
                // Assert against Enum case value in JSON response
                $json->whereAll('*.status', TodoStatus::Completed->value)
                    ->etc();
            });
    }

    public function test_todos_can_be_filtered_by_priority(): void
    {
        $user = User::factory()->createOne();
        Sanctum::actingAs($user);

        // Create todos with different priorities using Enum cases
        Todo::factory()->create(['user_id' => $user->id, 'priority' => TodoPriority::Low]);
        Todo::factory()->create(['user_id' => $user->id, 'priority' => TodoPriority::Medium]);
        Todo::factory()->create(['user_id' => $user->id, 'priority' => TodoPriority::High]);
        Todo::factory()->create(['user_id' => $user->id, 'priority' => TodoPriority::Low]);

        // Filter by low priority using Enum case value
        $response = $this->getJson('/api/todos?priority='.TodoPriority::Low->value);
        $response->assertStatus(200)
            ->assertJsonCount(2)
            ->assertJson(function ($json) {
                // Assert against Enum case value in JSON response
                $json->whereAll('*.priority', TodoPriority::Low->value)
                    ->etc();
            });

        // Filter by high priority using Enum case value
        $response = $this->getJson('/api/todos?priority='.TodoPriority::High->value);
        $response->assertStatus(200)
            ->assertJsonCount(1)
            ->assertJson(function ($json) {
                // Assert against Enum case value in JSON response
                $json->whereAll('*.priority', TodoPriority::High->value)->etc();
            });
    }

    public function test_todos_can_be_filtered_by_due_date(): void
    {
        $user = User::factory()->create();
        Sanctum::actingAs($user);

        // Create todos with different due dates
        $futureDate = now()->addDays(5)->format('Y-m-d H:i:s');
        $pastDate = now()->subDays(5)->format('Y-m-d H:i:s');

        Todo::factory()->create(['user_id' => $user->id, 'due_date' => $futureDate]);
        Todo::factory()->create(['user_id' => $user->id, 'due_date' => $pastDate]);
        Todo::factory()->create(['user_id' => $user->id, 'due_date' => $futureDate]);

        // Filter by future due date
        $response = $this->getJson('/api/todos?due_date='.$futureDate);

        $response->assertStatus(200)
            ->assertJsonCount(2)
            ->assertJsonPath('*.due_date', [$futureDate, $futureDate]);
    }

    public function test_index_returns_paginated_results(): void
    {
        $user = User::factory()->create();
        Sanctum::actingAs($user);

        // Create more todos than the default pagination limit (e.g., 15 if the limit is 10)
        Todo::factory(15)->create(['user_id' => $user->id]);

        $response = $this->getJson('/api/todos');

        $response->assertStatus(200)
            ->assertJsonStructure([
                'data',
                'links',
                'meta',
            ])
            ->assertJsonCount(10, 'data'); // Assuming the default pagination is 10
    }

    public function test_index_can_sort_todos_by_due_date(): void
    {
        $user = User::factory()->create();
        Sanctum::actingAs($user);

        // Create todos with different due dates
        $date1 = now()->addDays(2)->format('Y-m-d H:i:s');
        $date2 = now()->addDays(1)->format('Y-m-d H:i:s');
        $date3 = now()->addDays(3)->format('Y-m-d H:i:s');

        $todo1 = Todo::factory()->create(['user_id' => $user->id, 'due_date' => $date1]);
        $todo2 = Todo::factory()->create(['user_id' => $user->id, 'due_date' => $date2]);
        $todo3 = Todo::factory()->create(['user_id' => $user->id, 'due_date' => $date3]);

        // Sort by due_date ascending
        $response = $this->getJson('/api/todos?sort=due_date&direction=asc');

        $response->assertStatus(200)
            ->assertJsonPath('data.0.id', $todo2->id)
            ->assertJsonPath('data.1.id', $todo1->id)
            ->assertJsonPath('data.2.id', $todo3->id);
    }

    public function test_index_can_sort_todos_by_priority(): void
    {
        $user = User::factory()->create();
        Sanctum::actingAs($user);

        // Create todos with different priorities using Enum cases
        $todo1 = Todo::factory()->create(['user_id' => $user->id, 'priority' => TodoPriority::Medium]);
        $todo2 = Todo::factory()->create(['user_id' => $user->id, 'priority' => TodoPriority::Low]);
        $todo3 = Todo::factory()->create(['user_id' => $user->id, 'priority' => TodoPriority::High]);

        // Sort by priority ascending (low to high)
        // Assuming the API sorts based on the string value ('low', 'medium', 'high')
        // If it sorts based on DB enum order, assertions might need adjustment.
        $response = $this->getJson('/api/todos?sort=priority&direction=asc');

        $response->assertStatus(200)
            ->assertJsonPath('data.0.id', $todo2->id)
            ->assertJsonPath('data.1.id', $todo1->id)
            ->assertJsonPath('data.2.id', $todo3->id);
    }
}
