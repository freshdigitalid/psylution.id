<?php

namespace Database\Seeders;

use App\Enums\UserRole;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class PsychologistUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create sample psychologist users
        User::create([
            'name' => 'Dr. Sarah Johnson',
            'email' => 'sarah.johnson@psylution.id',
            'password' => Hash::make('password'),
            'email_verified_at' => now(),
            'role' => UserRole::Psychologist,
        ]);

        User::create([
            'name' => 'Dr. Michael Chen',
            'email' => 'michael.chen@psylution.id',
            'password' => Hash::make('password'),
            'email_verified_at' => now(),
            'role' => UserRole::Psychologist,
        ]);

        User::create([
            'name' => 'Test Psychologist',
            'email' => 'psychologist@psylution.id',
            'password' => Hash::make('password'),
            'email_verified_at' => now(),
            'role' => UserRole::Psychologist,
        ]);

        $this->command->info('Psychologist users seeded successfully!');
        $this->command->info('Sample psychologist credentials:');
        $this->command->info('Email: psychologist@psylution.id');
        $this->command->info('Password: password');
    }
} 