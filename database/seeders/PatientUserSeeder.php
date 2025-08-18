<?php

namespace Database\Seeders;

use App\Models\Role;
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
        // Get patient role
        $patientRole = Role::where('name', 'patient')->first();

        if (!$patientRole) {
            $this->command->error('Patient role not found. Please run RoleSeeder first.');
            return;
        }

        // Create sample patient users
        User::create([
            'name' => 'John Doe',
            'email' => 'john.doe@example.com',
            'password' => Hash::make('password'),
            'email_verified_at' => now(),
            'role_id' => $patientRole->id,
        ]);

        User::create([
            'name' => 'Jane Smith',
            'email' => 'jane.smith@example.com',
            'password' => Hash::make('password'),
            'email_verified_at' => now(),
            'role_id' => $patientRole->id,
        ]);

        User::create([
            'name' => 'Test Patient',
            'email' => 'patient@psylution.id',
            'password' => Hash::make('password'),
            'email_verified_at' => now(),
            'role_id' => $patientRole->id,
        ]);

        $this->command->info('Patient users seeded successfully!');
        $this->command->info('Sample patient credentials:');
        $this->command->info('Email: patient@psylution.id');
        $this->command->info('Password: password');
    }
} 