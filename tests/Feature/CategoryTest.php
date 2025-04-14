<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\Traits\AuthHelpers;
use Tests\TestCase;

class CategoryTest extends TestCase
{
    use RefreshDatabase, AuthHelpers;

    /**
     * Test that authenticated users can view categories.
     */
    public function test_authenticated_users_can_view_categories(): void
    {
        $user = $this->login();
        
        $category = Category::factory()->create([
            'user_id' => $user->id,
            'name' => 'Test Category',
            'color' => '#FF5733',
        ]);
        
        $response = $this->get(route('categories.index'));
        
        $response->assertStatus(200);
        $response->assertSee('Test Category');
        $response->assertSee('#FF5733');
    }
    
    /**
     * Test that users can create categories.
     */
    public function test_users_can_create_categories(): void
    {
        $user = $this->login();
        
        $categoryData = [
            'name' => 'New Category',
            'color' => '#33FF57',
        ];
        
        $response = $this->post(route('categories.store'), $categoryData);
        
        $response->assertRedirect(route('categories.index'));
        $response->assertSessionHas('success');
        
        $this->assertDatabaseHas('categories', [
            'user_id' => $user->id,
            'name' => 'New Category',
            'color' => '#33FF57',
        ]);
    }
    
    /**
     * Test that users can update their categories.
     */
    public function test_users_can_update_their_categories(): void
    {
        $user = $this->login();
        
        $category = Category::factory()->create([
            'user_id' => $user->id,
            'name' => 'Original Name',
            'color' => '#000000',
        ]);
        
        $updateData = [
            'name' => 'Updated Name',
            'color' => '#FFFFFF',
        ];
        
        $response = $this->put(route('categories.update', $category), $updateData);
        
        $response->assertRedirect(route('categories.index'));
        $response->assertSessionHas('success');
        
        $this->assertDatabaseHas('categories', [
            'id' => $category->id,
            'name' => 'Updated Name',
            'color' => '#FFFFFF',
        ]);
    }
    
    /**
     * Test that users cannot update others' categories.
     */
    public function test_users_cannot_update_others_categories(): void
    {
        $this->login();
        
        $otherUser = User::factory()->create();
        $category = Category::factory()->create([
            'user_id' => $otherUser->id,
        ]);
        
        $response = $this->put(route('categories.update', $category), [
            'name' => 'Hacked Name',
        ]);
        
        $response->assertStatus(403); // Forbidden
    }
    
    /**
     * Test that users can delete their categories.
     */
    public function test_users_can_delete_their_categories(): void
    {
        $user = $this->login();
        
        $category = Category::factory()->create([
            'user_id' => $user->id,
        ]);
        
        $response = $this->delete(route('categories.destroy', $category));
        
        $response->assertRedirect(route('categories.index'));
        $response->assertSessionHas('success');
        
        $this->assertDatabaseMissing('categories', ['id' => $category->id]);
    }
    
    /**
     * Test that users cannot delete others' categories.
     */
    public function test_users_cannot_delete_others_categories(): void
    {
        $this->login();
        
        $otherUser = User::factory()->create();
        $category = Category::factory()->create([
            'user_id' => $otherUser->id,
        ]);
        
        $response = $this->delete(route('categories.destroy', $category));
        
        $response->assertStatus(403); // Forbidden
        $this->assertDatabaseHas('categories', ['id' => $category->id]);
    }
    
    /**
     * Test validation when creating a category.
     */
    public function test_category_validation_on_creation(): void
    {
        $this->login();
        
        // Missing required fields
        $response = $this->post(route('categories.store'), []);
        
        $response->assertSessionHasErrors(['name', 'color']);
        
        // Name too long
        $response = $this->post(route('categories.store'), [
            'name' => str_repeat('a', 256), // 256 chars, exceeding typical 255 limit
            'color' => '#AABBCC',
        ]);
        
        $response->assertSessionHasErrors(['name']);
        
        // Invalid color format
        $response = $this->post(route('categories.store'), [
            'name' => 'Valid Name',
            'color' => 'not-a-color',
        ]);
        
        $response->assertSessionHasErrors(['color']);
    }
} 