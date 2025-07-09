<?php

namespace Tests\Feature;

use App\Models\Todo;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TodoTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_get_todos()
    {
        $user = User::factory()->create();
        Todo::factory()->count(5)->create(['user_id' => $user->id]);

        $response = $this->actingAs($user)
            ->getJson('/api/todos');

        $response->assertStatus(200)
            ->assertJsonCount(5, 'data');
    }

    public function test_can_create_todo()
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)
            ->postJson('/api/todos', [
                'title' => 'Test Todo',
                'description' => 'This is a test todo',
                'priority' => 'medium',
                'status' => 'pending',
                'due_date' => now()->addDays(3)->toDateTimeString(),
            ]);

        $response->assertStatus(201)
            ->assertJson([
                'data' => [
                    'title' => 'Test Todo',
                    'description' => 'This is a test todo',
                    'priority' => 'medium',
                    'status' => 'pending',
                ],
            ]);
    }

    public function test_can_update_todo()
    {
        $user = User::factory()->create();
        $todo = Todo::factory()->create(['user_id' => $user->id]);

        $response = $this->actingAs($user)
            ->putJson('/api/todos/' . $todo->id, [
                'title' => 'Updated Todo',
                'status' => 'completed',
            ]);

        $response->assertStatus(200)
            ->assertJson([
                'data' => [
                    'title' => 'Updated Todo',
                    'status' => 'completed',
                ],
            ]);
    }

    public function test_can_delete_todo()
    {
        $user = User::factory()->create();
        $todo = Todo::factory()->create(['user_id' => $user->id]);

        $response = $this->actingAs($user)
            ->deleteJson('/api/todos/' . $todo->id);

        $response->assertStatus(204);
        $this->assertDatabaseMissing('todos', ['id' => $todo->id]);
    }
}