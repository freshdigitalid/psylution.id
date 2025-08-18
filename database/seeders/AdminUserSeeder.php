<?php

namespace Database\Seeders;

use App\Enums\UserRole;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create default admin user
        User::create([
            'name' => 'Admin',
            'email' => 'admin@psylution.id',
            'password' => Hash::make('password'),
            'email_verified_at' => now(),
            'role' => UserRole::Admin,
        ]);

        // Create additional admin users if needed
        User::create([
            'name' => 'Super Admin',
            'email' => 'superadmin@psylution.id',
            'password' => Hash::make('password'),
            'email_verified_at' => now(),
            'role' => UserRole::Admin,
        ]);

        $this->command->info('Admin users seeded successfully!');
        $this->command->info('Default admin credentials:');
        $this->command->info('Email: admin@psylution.id');
        $this->command->info('Password: password');
        $this->command->info('Super Admin Email: superadmin@psylution.id');
        $this->command->info('Password: password');
    }
} 