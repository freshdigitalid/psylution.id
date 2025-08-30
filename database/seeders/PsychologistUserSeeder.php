<?php

namespace Database\Seeders;

use App\Enums\UserRole;
use App\Models\Psychologist;
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
        //Add Sarah Johnson
        $sarah = User::create([
            'name' => 'Dr. Sarah Johnson',
            'email' => 'sarah.johnson@psylution.id',
            'password' => Hash::make('password'),
            'email_verified_at' => now(),
            'role' => UserRole::Psychologist,
        ]);

        Psychologist::create([
            'first_name' => 'Sarah',
            'last_name'  => 'Johnson',
            'dob'        => '1980-05-15',
            'user_id'    => $sarah->id,
        ]);

        // Add Michael Chen
        $michael = User::create([
            'name' => 'Dr. Michael Chen',
            'email' => 'michael.chen@psylution.id',
            'password' => Hash::make('password'),
            'email_verified_at' => now(),
            'role' => UserRole::Psychologist,
        ]);

        Psychologist::create([
            'first_name' => 'Michael',
            'last_name'  => 'Chen',
            'dob'        => '1978-09-20',
            'user_id'    => $michael->id,
        ]);

        // Add Test Psychologist
        $test = User::create([
            'name' => 'Test Psychologist',
            'email' => 'psychologist@psylution.id',
            'password' => Hash::make('password'),
            'email_verified_at' => now(),
            'role' => UserRole::Psychologist,
        ]);

        Psychologist::create([
            'first_name' => 'Test',
            'last_name'  => 'Psychologist',
            'dob'        => '1990-01-01',
            'user_id'    => $test->id,
        ]);

        $this->command->info('Psychologist users seeded successfully!');
        $this->command->info('Sample psychologist credentials:');
        $this->command->info('Email: psychologist@psylution.id');
        $this->command->info('Password: password');
    }
}
