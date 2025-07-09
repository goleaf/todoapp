<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CategoryTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_get_categories()
    {
        $user = User::factory()->create();
        Category::factory()->count(3)->create(['user_id' => $user->id]);

        $response = $this->actingAs($user)
            ->getJson('/api/categories');

        $response->assertStatus(200)
            ->assertJsonCount(3, 'data');
    }

    public function test_can_create_category()
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)
            ->postJson('/api/categories', [
                'name' => 'Test Category',
                'description' => 'A test category description',
                'color' => '#FF5733',
            ]);

        $response->assertStatus(201)
            ->assertJson([
                'data' => [
                    'name' => 'Test Category',
                    'description' => 'A test category description',
                    'color' => '#FF5733',
                ],
            ]);
    }

    public function test_can_update_category()
    {
        $user = User::factory()->create();
        $category = Category::factory()->create(['user_id' => $user->id]);

        $response = $this->actingAs($user)
            ->putJson('/api/categories/' . $category->id, [
                'name' => 'Updated Category',
                'description' => 'Updated category description',
                'color' => '#33FF57',
            ]);

        $response->assertStatus(200)
            ->assertJson([
                'data' => [
                    'name' => 'Updated Category',
                    'description' => 'Updated category description',
                    'color' => '#33FF57',
                ],
            ]);
    }

    public function test_can_delete_category()
    {
        $user = User::factory()->create();
        $category = Category::factory()->create(['user_id' => $user->id]);

        $response = $this->actingAs($user)
            ->deleteJson('/api/categories/' . $category->id);

        $response->assertStatus(200);
        $this->assertDatabaseMissing('categories', ['id' => $category->id]);
    }
}