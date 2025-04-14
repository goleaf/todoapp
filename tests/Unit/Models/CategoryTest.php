<?php

namespace Tests\Unit\Models;

use App\Models\Category;
use App\Models\Todo;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CategoryTest extends TestCase
{
    use RefreshDatabase;

    public function test_category_belongs_to_user()
    {
        $user = User::factory()->create();
        $category = Category::factory()->create(['user_id' => $user->id]);
        
        $this->assertInstanceOf(User::class, $category->user);
        $this->assertEquals($user->id, $category->user->id);
    }

    public function test_category_has_many_todos()
    {
        $user = User::factory()->create();
        $category = Category::factory()->create(['user_id' => $user->id]);
        
        // Create multiple todos in this category
        $todos = Todo::factory()->count(3)->create([
            'user_id' => $user->id,
            'category_id' => $category->id
        ]);
        
        $this->assertInstanceOf('Illuminate\Database\Eloquent\Collection', $category->todos);
        $this->assertCount(3, $category->todos);
        
        // Verify each todo belongs to this category
        foreach ($todos as $todo) {
            $this->assertEquals($category->id, $todo->category_id);
        }
    }

    public function test_category_can_be_created_with_valid_data()
    {
        $user = User::factory()->create();
        
        $categoryData = [
            'user_id' => $user->id,
            'name' => 'Test Category',
            'color' => '#FF5733',
        ];
        
        $category = Category::create($categoryData);
        
        $this->assertInstanceOf(Category::class, $category);
        $this->assertDatabaseHas('categories', $categoryData);
    }

    public function test_category_has_fillable_attributes()
    {
        $category = new Category();
        
        $fillable = $category->getFillable();
        
        $this->assertEquals(['user_id', 'name', 'color'], $fillable);
    }
} 