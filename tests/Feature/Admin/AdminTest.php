<?php

namespace Tests\Feature\Admin;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_users_page_is_accessible_by_authenticated_user(): void
    {
        $user = User::factory()->create(['is_admin' => true]);

        $response = $this->actingAs($user)
                         ->get(route('admin.users.index'));

        $response->assertStatus(200);
        $response->assertViewIs('admin.users.index');
    }

    public function test_admin_todos_page_is_accessible_by_authenticated_user(): void
    {
        $user = User::factory()->create(['is_admin' => true]);

        $response = $this->actingAs($user)
                         ->get(route('admin.todos.index'));

        $response->assertStatus(200);
        $response->assertViewIs('admin.todos.index');
    }

    public function test_admin_users_page_is_not_accessible_by_unauthenticated_user(): void
    {
        $response = $this->get(route('admin.users.index'));

        $response->assertRedirect('/login');
    }

    public function test_admin_todos_page_is_not_accessible_by_unauthenticated_user(): void
    {
        $response = $this->get(route('admin.todos.index'));

        $response->assertRedirect('/login');
    }

    public function test_admin_can_create_user(): void
    {
        $admin = User::factory()->create(['is_admin' => true]);
        $this->actingAs($admin);

        $response = $this->get('/admin/users/create');
        $response->assertStatus(200);
        $response->assertViewIs('admin.users.create');

        $userData = [
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => 'password',
            'password_confirmation' => 'password',
        ];
        $response = $this->post('/admin/users', $userData);
        $response->assertRedirect('/admin/users');
        $this->assertDatabaseHas('users', ['email' => 'test@example.com']);
    }

    public function test_admin_can_edit_user(): void
    {
        $admin = User::factory()->create(['is_admin' => true]);
        $user = User::factory()->create();
        $this->actingAs($admin);

        $response = $this->get('/admin/users/'.$user->id.'/edit');
        $response->assertStatus(200);
        $response->assertViewIs('admin.users.edit');

        $userData = [
            'name' => 'Updated User',
            'email' => 'updated@example.com',
        ];
        $response = $this->put('/admin/users/'.$user->id, $userData);
        $response->assertRedirect('/admin/users');
        $this->assertDatabaseHas('users', ['id' => $user->id, 'name' => 'Updated User']);
    }

    public function test_admin_can_delete_user(): void
    {
        $admin = User::factory()->create(['is_admin' => true]);
        $user = User::factory()->create();
        $this->actingAs($admin);

        $response = $this->delete('/admin/users/'.$user->id);
        $response->assertRedirect('/admin/users');
        $this->assertDatabaseMissing('users', ['id' => $user->id]);
    }

    public function test_admin_can_create_todo(): void
    {
        $admin = User::factory()->create(['is_admin' => true]);
        $user = User::factory()->create();
        $this->actingAs($admin);

        $response = $this->get('/admin/todos/create');
        $response->assertStatus(200);
        $response->assertViewIs('admin.todos.create');

        $todoData = [
            'user_id' => $user->id,
            'title' => 'Test Todo',
            'description' => 'Test Description',
            'completed' => false,
        ];
        $response = $this->post('/admin/todos', $todoData);
        $response->assertRedirect('/admin/todos');
        $this->assertDatabaseHas('todos', ['title' => 'Test Todo']);
    }

    public function test_admin_can_edit_todo(): void
    {
        $admin = User::factory()->create(['is_admin' => true]);
        $user = User::factory()->create();
        $todo = \App\Models\Todo::factory()->create(['user_id' => $user->id]);
        $this->actingAs($admin);

        $response = $this->get('/admin/todos/'.$todo->id.'/edit');
        $response->assertStatus(200);
        $response->assertViewIs('admin.todos.edit');

        $todoData = [
            'user_id' => $user->id,
            'title' => 'Updated Todo',
            'description' => 'Updated Description',
            'completed' => true,
        ];
        $response = $this->put('/admin/todos/'.$todo->id, $todoData);
        $response->assertRedirect('/admin/todos');
        $this->assertDatabaseHas('todos', ['id' => $todo->id, 'title' => 'Updated Todo']);
    }

    public function test_admin_can_delete_todo(): void
    {
        $admin = User::factory()->create(['is_admin' => true]);
        $user = User::factory()->create();
        $todo = \App\Models\Todo::factory()->create(['user_id' => $user->id]);
        $this->actingAs($admin);

        $response = $this->delete('/admin/todos/'.$todo->id);
        $response->assertRedirect('/admin/todos');
        $this->assertDatabaseMissing('todos', ['id' => $todo->id]);
    }

    public function test_user_validation_on_create(): void
    {
        $admin = User::factory()->create(['is_admin' => true]);
        $this->actingAs($admin);

        $userData = [
            'name' => '',
            'email' => 'invalid-email',
            'password' => 'short',
            'password_confirmation' => 'mismatch',
        ];
        $response = $this->post('/admin/users', $userData);

        $response->assertSessionHasErrors(['name', 'email', 'password']);
    }

    public function test_user_validation_on_update(): void
    {
        $admin = User::factory()->create(['is_admin' => true]);
        $user = User::factory()->create();
        $this->actingAs($admin);

        $userData = [
            'name' => '',
            'email' => 'invalid-email',
        ];
        $response = $this->put('/admin/users/'.$user->id, $userData);

        $response->assertSessionHasErrors(['name', 'email']);
    }

    public function test_todo_validation_on_create(): void
    {
        $admin = User::factory()->create(['is_admin' => true]);
        $this->actingAs($admin);

        $todoData = [
            'user_id' => '',
            'title' => '',
        ];
        $response = $this->post('/admin/todos', $todoData);

        $response->assertSessionHasErrors(['user_id', 'title']);
    }

    public function test_todo_validation_on_update(): void
    {
        $admin = User::factory()->create(['is_admin' => true]);
        $user = User::factory()->create();
        $todo = \App\Models\Todo::factory()->create(['user_id' => $user->id]);
        $this->actingAs($admin);

        $todoData = [
            'user_id' => '',
            'title' => '',
        ];
        $response = $this->put('/admin/todos/'.$todo->id, $todoData);

        $response->assertSessionHasErrors(['user_id', 'title']);
    }
}
