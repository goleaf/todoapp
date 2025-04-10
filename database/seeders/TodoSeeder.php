<?php

namespace Database\Seeders;

use App\Models\Todo;
use App\Models\User;
use Illuminate\Database\Seeder;

class TodoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get all users
        $users = User::all();

        // Create 3 todos for each user
        $users->each(function ($user) {
            Todo::factory(3)->create([
                'user_id' => $user->id,
            ]);
        });
    }
}
