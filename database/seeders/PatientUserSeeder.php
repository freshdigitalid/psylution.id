<?php

namespace Database\Seeders;

use App\Enums\UserRole;
use App\Models\Patient;
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
        $john = User::create([
            'name' => 'John Doe',
            'email' => 'john.doe@example.com',
            'password' => Hash::make('password'),
            'email_verified_at' => now(),
            'role' => UserRole::Patient,
        ]);

        Patient::create([
            'first_name' => 'John',
            'last_name'  => 'Doe',
            'dob'        => '1992-03-10',
            'user_id'    => $john->id,
        ]);

        // Create Jane Smith
        $jane = User::create([
            'name' => 'Jane Smith',
            'email' => 'jane.smith@example.com',
            'password' => Hash::make('password'),
            'email_verified_at' => now(),
            'role' => UserRole::Patient,
        ]);

        Patient::create([
            'first_name' => 'Jane',
            'last_name'  => 'Smith',
            'dob'        => '1994-07-22',
            'user_id'    => $jane->id,
        ]);

        // Create Test Patient
        $test = User::create([
            'name' => 'Test Patient',
            'email' => 'patient@psylution.id',
            'password' => Hash::make('password'),
            'email_verified_at' => now(),
            'role' => UserRole::Patient,
        ]);

        Patient::create([
            'first_name' => 'Test',
            'last_name'  => 'Patient',
            'dob'        => '1990-01-01',
            'user_id'    => $test->id,
        ]);

        $this->command->info('Patient users seeded successfully!');
        $this->command->info('Sample patient credentials:');
        $this->command->info('Email: patient@psylution.id');
        $this->command->info('Password: password');
    }
}
