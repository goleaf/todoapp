<?php

namespace Database\Factories;

use App\Enums\TodoPriority;
use App\Enums\TodoStatus;
use App\Models\Category;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Todo>
 */
class TodoFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        // Ensure a user exists, potentially creating one
        $user = User::inRandomOrder()->first() ?? User::factory()->create();

        // Optionally assign a category owned by the same user
        $category = Category::where('user_id', $user->id)->inRandomOrder()->first();
        // Leave parent_id null by default (top-level task)

        return [
            'user_id' => $user->id,
            'category_id' => $this->faker->boolean(25) ? ($category?->id) : null, // 25% chance of having a category
            'parent_id' => null,
            'title' => $this->faker->sentence(),
            'description' => $this->faker->paragraph(),
            'due_date' => $this->faker->dateTimeBetween('now', '+1 year'),
            'priority' => $this->faker->randomElement(TodoPriority::cases()),
            'status' => TodoStatus::Pending,
        ];
    }

    /**
     * Indicate that the todo is a subtask.
     */
    public function subtask(int $parentId): static
    {
        return $this->state(fn (array $attributes) => [
            'parent_id' => $parentId,
        ]);
    }

     /**
     * Indicate that the todo belongs to a specific category.
     */
    public function categorized(int $categoryId): static
    {
        return $this->state(fn (array $attributes) => [
            'category_id' => $categoryId,
        ]);
    }
}
