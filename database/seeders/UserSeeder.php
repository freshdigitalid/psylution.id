<?php

namespace Database\Seeders;

use App\Models\Admin;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create Super Admin
        $admin = Admin::firstOrCreate(
            ['email' => 'admin@psylution.id'],
            [
                'name' => 'Super Admin',
                'password' => Hash::make('password'),
                'phone' => '081234567890',
                'is_active' => true,
            ]
        );
        if (!$admin->hasRole('admin')) {
            $admin->assignRole('admin');
        }

        // Create additional admins
        $admin2 = Admin::firstOrCreate(
            ['email' => 'admin2@psylution.id'],
            [
                'name' => 'Admin Psylution',
                'password' => Hash::make('password123'),
                'phone' => '081234567891',
                'is_active' => true,
            ]
        );
        if (!$admin2->hasRole('admin')) {
            $admin2->assignRole('admin');
        }

        // Create regular users
        $user1 = User::firstOrCreate(
            ['email' => 'user@psylution.id'],
            [
                'name' => 'Regular User',
                'password' => Hash::make('password'),
            ]
        );
        if (!$user1->hasRole('user')) {
            $user1->assignRole('user');
        }

        $user2 = User::firstOrCreate(
            ['email' => 'demo@psylution.id'],
            [
                'name' => 'Demo User',
                'password' => Hash::make('password123'),
            ]
        );
        if (!$user2->hasRole('user')) {
            $user2->assignRole('user');
        }
    }
} 