<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

        $this->call([
            UserSeeder::class,
            HolidaySeeder::class,
            // Document2020Seeder::class,
            // Document2021Seeder::class,
            // Document2022Seeder::class,
            // Document2023Seeder::class,
        ]);
    }
}
