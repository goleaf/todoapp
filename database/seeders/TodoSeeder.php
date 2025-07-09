<?php

namespace Database\Seeders;

use App\Models\Todo;
use App\Models\User;
use App\Models\Category;
use Illuminate\Database\Seeder;

class TodoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get users to assign todos to
        $users = User::all();
        
        if ($users->isEmpty()) {
            // Create a user if none exist
            $users = [User::factory()->create([
                'name' => 'Test User',
                'email' => 'test@example.com',
            ])];
        }
        
        foreach ($users as $user) {
            // Get existing categories or create some if none exist
            $categories = Category::where('user_id', $user->id)->get();
            
            if ($categories->isEmpty()) {
                $categories = Category::factory()
                    ->count(3)
                    ->create(['user_id' => $user->id]);
            }
                
            // Create top-level todos
            $topLevelTodos = Todo::factory()
                ->count(20)
                ->create([
                    'user_id' => $user->id,
                    'category_id' => function () use ($categories) {
                        return $categories->random()->id;
                    },
                ]);
                
            // Create subtasks for some of the top-level todos
            foreach ($topLevelTodos->random(10) as $parent) {
                Todo::factory()
                    ->count(rand(2, 5))
                    ->create([
                        'user_id' => $user->id,
                        'parent_id' => $parent->id,
                        'category_id' => $parent->category_id,
                    ]);
            }
        }
    }
}