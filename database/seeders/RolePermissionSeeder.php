<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // Create permissions for Admin
        $adminPermissions = [
            'manage-users',
            'manage-admins',
            'manage-psikologs',
            'manage-pasiens',
            'view-all-sessions',
            'view-all-reports',
            'manage-settings',
            'verify-psikologs',
            'activate-deactivate-users',
        ];

        // Create permissions for Psikolog
        $psikologPermissions = [
            'view-own-profile',
            'edit-own-profile',
            'view-assigned-pasiens',
            'manage-sessions',
            'create-session-notes',
            'view-session-reports',
            'schedule-appointments',
        ];

        // Create permissions for Pasien
        $pasienPermissions = [
            'view-own-profile',
            'edit-own-profile',
            'view-own-sessions',
            'book-appointments',
            'view-own-reports',
            'chat-with-psikolog',
        ];

        // Create permissions for regular User
        $userPermissions = [
            'view-public-content',
            'contact-support',
        ];

        // Create all permissions
        $allPermissions = array_merge($adminPermissions, $psikologPermissions, $pasienPermissions, $userPermissions);
        foreach (array_unique($allPermissions) as $permission) {
            Permission::firstOrCreate(['name' => $permission]);
        }

        // Create roles for each guard and assign permissions
        $adminRole = Role::firstOrCreate(['name' => 'admin', 'guard_name' => 'admin']);
        $adminRole->syncPermissions($adminPermissions);

        $psikologRole = Role::firstOrCreate(['name' => 'psikolog', 'guard_name' => 'psikolog']);
        $psikologRole->syncPermissions($psikologPermissions);

        $pasienRole = Role::firstOrCreate(['name' => 'pasien', 'guard_name' => 'pasien']);
        $pasienRole->syncPermissions($pasienPermissions);

        $userRole = Role::firstOrCreate(['name' => 'user', 'guard_name' => 'web']);
        $userRole->syncPermissions($userPermissions);
    }
}