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

        $users->each(function ($user) {
            Category::factory(3)->create([
                'user_id' => $user->id,
            ]);
        });
    }
}
