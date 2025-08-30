<?php

namespace Database\Seeders;

use App\Models\Role;
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
        // Get psychologist role
        $psychologistRole = Role::where('name', 'psychologist')->first();

        if (!$psychologistRole) {
            $this->command->error('Psychologist role not found. Please run RoleSeeder first.');
            return;
        }

        // Create sample psychologist users
        User::create([
            'name' => 'Dr. Sarah Johnson',
            'email' => 'sarah.johnson@psylution.id',
            'password' => Hash::make('password'),
            'email_verified_at' => now(),
            'role_id' => $psychologistRole->id,
        ]);

        User::create([
            'name' => 'Dr. Michael Chen',
            'email' => 'michael.chen@psylution.id',
            'password' => Hash::make('password'),
            'email_verified_at' => now(),
            'role_id' => $psychologistRole->id,
        ]);

        User::create([
            'name' => 'Test Psychologist',
            'email' => 'psychologist@psylution.id',
            'password' => Hash::make('password'),
            'email_verified_at' => now(),
            'role_id' => $psychologistRole->id,
        ]);

        $this->command->info('Psychologist users seeded successfully!');
        $this->command->info('Sample psychologist credentials:');
        $this->command->info('Email: psychologist@psylution.id');
        $this->command->info('Password: password');
    }
} 