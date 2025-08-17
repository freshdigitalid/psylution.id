<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create roles
        Role::create([
            'name' => 'admin',
            'display_name' => 'Admin',
            'description' => 'Administrator with full access to all features',
        ]);

        Role::create([
            'name' => 'psychologist',
            'display_name' => 'Psychologist',
            'description' => 'Psychologist with access to patient management and therapy sessions',
        ]);

        Role::create([
            'name' => 'patient',
            'display_name' => 'Patient',
            'description' => 'Patient with access to personal dashboard and therapy sessions',
        ]);

        $this->command->info('Roles seeded successfully!');
    }
} 