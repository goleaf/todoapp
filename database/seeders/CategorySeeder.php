<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = User::all();

        if ($users->isEmpty()) {
            // Create a default user if none exist, so categories can be created
            $users = User::factory(1)->create();
        }

        // Define some preset categories
        $categories = [
            [
                'name' => 'Work',
                'description' => 'Work-related tasks and projects',
                'color' => '#4a5568',
            ],
            [
                'name' => 'Personal',
                'description' => 'Personal tasks and errands',
                'color' => '#48bb78',
            ],
            [
                'name' => 'Urgent',
                'description' => 'High priority tasks that need immediate attention',
                'color' => '#e53e3e',
            ],
        ];

        $users->each(function ($user) use ($categories) {
            // Create preset categories for each user
            foreach ($categories as $category) {
                Category::create([
                    'user_id' => $user->id,
                    'name' => $category['name'],
                    'description' => $category['description'],
                    'color' => $category['color'],
                ]);
            }
            
            // Create some random categories as well
            Category::factory(2)->create([
                'user_id' => $user->id,
            ]);
        });
    }
}
