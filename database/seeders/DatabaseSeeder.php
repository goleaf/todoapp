<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Call the seeders in order of dependency
        $this->call([
            UserSeeder::class,
            CategorySeeder::class,
            TodoSeeder::class,
        ]);
    }
}
