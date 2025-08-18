<?php

namespace Database\Seeders;

use App\Enums\UserRole;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class PatientUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create sample patient users
        User::create([
            'name' => 'John Doe',
            'email' => 'john.doe@example.com',
            'password' => Hash::make('password'),
            'email_verified_at' => now(),
            'role' => UserRole::Patient,
        ]);

        User::create([
            'name' => 'Jane Smith',
            'email' => 'jane.smith@example.com',
            'password' => Hash::make('password'),
            'email_verified_at' => now(),
            'role' => UserRole::Patient,
        ]);

        User::create([
            'name' => 'Test Patient',
            'email' => 'patient@psylution.id',
            'password' => Hash::make('password'),
            'email_verified_at' => now(),
            'role' => UserRole::Patient,
        ]);

        $this->command->info('Patient users seeded successfully!');
        $this->command->info('Sample patient credentials:');
        $this->command->info('Email: patient@psylution.id');
        $this->command->info('Password: password');
    }
} 