<?php

namespace Tests\Unit\Models;

use App\Enums\TodoPriority;
use App\Enums\TodoStatus;
use App\Models\Category;
use App\Models\Todo;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TodoTest extends TestCase
{
    use RefreshDatabase;

    public function test_todo_belongs_to_user()
    {
        $user = User::factory()->create();
        $todo = Todo::factory()->create(['user_id' => $user->id]);
        
        $this->assertInstanceOf(User::class, $todo->user);
        $this->assertEquals($user->id, $todo->user->id);
    }

    public function test_todo_belongs_to_category()
    {
        $user = User::factory()->create();
        $category = Category::factory()->create(['user_id' => $user->id]);
        $todo = Todo::factory()->create([
            'user_id' => $user->id,
            'category_id' => $category->id
        ]);
        
        $this->assertInstanceOf(Category::class, $todo->category);
        $this->assertEquals($category->id, $todo->category->id);
    }

    public function test_todo_has_parent_relationship()
    {
        $user = User::factory()->create();
        $parentTodo = Todo::factory()->create(['user_id' => $user->id]);
        $childTodo = Todo::factory()->create([
            'user_id' => $user->id,
            'parent_id' => $parentTodo->id
        ]);
        
        $this->assertInstanceOf(Todo::class, $childTodo->parent);
        $this->assertEquals($parentTodo->id, $childTodo->parent->id);
    }

    public function test_todo_has_subtasks_relationship()
    {
        $user = User::factory()->create();
        $parentTodo = Todo::factory()->create(['user_id' => $user->id]);
        $childTodo = Todo::factory()->create([
            'user_id' => $user->id,
            'parent_id' => $parentTodo->id
        ]);
        
        $this->assertInstanceOf('Illuminate\Database\Eloquent\Collection', $parentTodo->subtasks);
        $this->assertContains($childTodo->id, $parentTodo->subtasks->pluck('id'));
    }

    public function test_todo_casts_attributes_correctly()
    {
        $todo = Todo::factory()->create([
            'priority' => TodoPriority::Medium,
            'status' => TodoStatus::Pending,
            'due_date' => now()
        ]);
        
        $this->assertInstanceOf(\DateTime::class, $todo->due_date);
        $this->assertInstanceOf(TodoPriority::class, $todo->priority);
        $this->assertInstanceOf(TodoStatus::class, $todo->status);
    }
} 