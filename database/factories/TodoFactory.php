<?php

namespace Database\Factories;

use App\Enums\TodoPriority;
use App\Enums\TodoStatus;
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
        $user = User::inRandomOrder()->first();

        // Create user if none exists (important for initial seeding or empty DB tests)
        if (! $user) {
            $user = User::factory()->create();
        }

        return [
            'user_id' => $user->id,
            'title' => $this->faker->sentence(),
            'description' => $this->faker->paragraph(),
            'due_date' => $this->faker->dateTimeBetween('now', '+1 year'),
            // Use Enum cases directly
            'priority' => $this->faker->randomElement(TodoPriority::cases()),
            'status' => TodoStatus::Pending, // Default to Pending Enum case
        ];
    }
}
