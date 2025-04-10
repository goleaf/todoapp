<?php

namespace Tests\Feature\Api;

use App\Enums\TodoPriority;
use App\Models\Todo;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class TodoTest extends TestCase
{
    use RefreshDatabase;

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
        $priority = 'medium';

        $response = $this->postJson('/api/todos', [
            'title' => 'Test Todo',
            'description' => 'Test Description',
            'status' => 'pending',
            'priority' => $priority,
        ]);

        $response->assertStatus(201);

        $this->assertDatabaseHas('todos', ['title' => 'Test Todo', 'user_id' => $user->id]);
    }

    public function test_todo_cannot_be_created_by_unauthenticated_user(): void
    {
        $response = $this->postJson('/api/todos', [
            'title' => '',
        ]);

        $response->assertStatus(422);
        $response->assertJsonValidationErrors(['title']);

    }

    public function test_todo_can_be_updated_by_owner(): void
    {
        $user = User::factory()->create();
        Sanctum::actingAs($user);

        $todo = Todo::factory()->create(['user_id' => $user->id]);
        $priority = 'high';

        $response = $this->putJson('/api/todos/'.$todo->id, [
            'title' => 'Updated Todo',
            'status' => 'completed',
            'priority' => $priority,
        ]);

        $response->assertStatus(200);

        $this->assertDatabaseHas('todos', ['id' => $todo->id, 'title' => 'Updated Todo']);
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

        $todo = Todo::factory()->create(['user_id' => $user->id, 'status' => 'pending']);

        $response = $this->putJson('/api/todos/'.$todo->id, [
            'status' => 'completed',
        ]);

        $response->assertStatus(200)
            ->assertJson(['status' => 'completed']);
        $this->assertDatabaseHas('todos', ['id' => $todo->id, 'status' => 'completed']);
    }

    public function test_todos_can_be_filtered_by_status(): void
    {
        $user = User::factory()->create();
        Sanctum::actingAs($user);

        // Create todos with different statuses
        Todo::factory()->create(['user_id' => $user->id, 'status' => 'pending']);
        Todo::factory()->create(['user_id' => $user->id, 'status' => 'completed']);
        Todo::factory()->create(['user_id' => $user->id, 'status' => 'pending']);

        // Filter by pending status
        $response = $this->getJson('/api/todos?status=pending');

        $response->assertStatus(200)
            ->assertJsonCount(2)
            ->assertJson(function ($json) {
                $json->whereAll('*.status', 'pending')
                    ->etc();
            });

        // Filter by complete status
        $response = $this->getJson('/api/todos?status=completed');

        $response->assertStatus(200)
            ->assertJsonCount(1)
            ->assertJson(function ($json) {
                $json->whereAll('*.status', 'completed')
                    ->etc();
            });
    }

    public function test_todos_can_be_filtered_by_priority(): void
    {
        $user = User::factory()->createOne();
        Sanctum::actingAs($user);

        // Create todos with different priorities

        Todo::factory()->create(['user_id' => $user->id, 'priority' => TodoPriority::Low]);
        Todo::factory()->create(['user_id' => $user->id, 'priority' => TodoPriority::Medium]);
        Todo::factory()->create(['user_id' => $user->id, 'priority' => TodoPriority::High]);
        Todo::factory()->create(['user_id' => $user->id, 'priority' => TodoPriority::Low]);

        // Filter by low priority
        $response = $this->getJson('/api/todos?priority=low');
        $response->assertStatus(200)
            ->assertJsonCount(2)
            ->assertJson(function ($json) {
                $json->whereAll('*.priority', 'low')
                    ->etc();
            });

        // Filter by high priority
        $response = $this->getJson('/api/todos?priority=high');

        $response->assertStatus(200)
            ->assertJsonCount(1)
            ->assertJson(function ($json) {
                $json->whereAll('*.priority', 'high')->etc();
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

        // Create todos with different priorities
        $todo1 = Todo::factory()->create(['user_id' => $user->id, 'priority' => 'medium']);
        $todo2 = Todo::factory()->create(['user_id' => $user->id, 'priority' => 'low']);
        $todo3 = Todo::factory()->create(['user_id' => $user->id, 'priority' => 'high']);

        // Sort by priority ascending (low to high)
        $response = $this->getJson('/api/todos?sort=priority&direction=asc');

        $response->assertStatus(200)
            ->assertJsonPath('data.0.id', $todo2->id)
            ->assertJsonPath('data.1.id', $todo1->id)
            ->assertJsonPath('data.2.id', $todo3->id);
    }
}
