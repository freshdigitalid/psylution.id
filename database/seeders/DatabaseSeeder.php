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
        // Call specific seeders for different user roles
        $this->call([
            AdminUserSeeder::class,
            PatientUserSeeder::class,
            PsychologistUserSeeder::class,
            ServiceSeeder::class, // Add services data
            AboutUsSeeder::class, // Add about us data
        ]);

        // You can also use factories for additional users
        // User::factory(10)->create();
    }
}
