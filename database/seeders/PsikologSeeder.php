<?php

namespace Database\Seeders;

use App\Models\Psikolog;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class PsikologSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create verified and active psychologists
        $psikolog1 = Psikolog::firstOrCreate(
            ['email' => 'sarah.wijaya@psylution.id'],
            [
                'name' => 'Dr. Sarah Wijaya, M.Psi',
                'password' => Hash::make('password'),
                'phone' => '081234567892',
                'license_number' => 'PSI-001-2024',
                'specialization' => 'Clinical Psychology',
                'experience_years' => 5,
                'is_active' => true,
                'is_verified' => true,
            ]
        );
        if (!$psikolog1->hasRole('psikolog')) {
            $psikolog1->assignRole('psikolog');
        }

        $psikolog2 = Psikolog::firstOrCreate(
            ['email' => 'ahmad.rahman@psylution.id'],
            [
                'name' => 'Dr. Ahmad Rahman, M.Psi',
                'password' => Hash::make('password'),
                'phone' => '081234567893',
                'license_number' => 'PSI-002-2024',
                'specialization' => 'Child Psychology',
                'experience_years' => 8,
                'is_active' => true,
                'is_verified' => true,
            ]
        );
        if (!$psikolog2->hasRole('psikolog')) {
            $psikolog2->assignRole('psikolog');
        }

        $psikolog3 = Psikolog::firstOrCreate(
            ['email' => 'maya.sari@psylution.id'],
            [
                'name' => 'Dr. Maya Sari, M.Psi',
                'password' => Hash::make('password'),
                'phone' => '081234567894',
                'license_number' => 'PSI-003-2024',
                'specialization' => 'Cognitive Behavioral Therapy',
                'experience_years' => 3,
                'is_active' => true,
                'is_verified' => true,
            ]
        );
        if (!$psikolog3->hasRole('psikolog')) {
            $psikolog3->assignRole('psikolog');
        }

        // Create pending verification psychologist
        $psikolog4 = Psikolog::firstOrCreate(
            ['email' => 'budi.santoso@psylution.id'],
            [
                'name' => 'Dr. Budi Santoso, M.Psi',
                'password' => Hash::make('password'),
                'phone' => '081234567895',
                'license_number' => 'PSI-004-2024',
                'specialization' => 'Family Therapy',
                'experience_years' => 2,
                'is_active' => false,
                'is_verified' => false,
            ]
        );
        if (!$psikolog4->hasRole('psikolog')) {
            $psikolog4->assignRole('psikolog');
        }

        // Create inactive psychologist (suspended)
        $psikolog5 = Psikolog::firstOrCreate(
            ['email' => 'lisa.chen@psylution.id'],
            [
                'name' => 'Dr. Lisa Chen, M.Psi',
                'password' => Hash::make('password'),
                'phone' => '081234567896',
                'license_number' => 'PSI-005-2024',
                'specialization' => 'Trauma Therapy',
                'experience_years' => 6,
                'is_active' => false,
                'is_verified' => true,
            ]
        );
        if (!$psikolog5->hasRole('psikolog')) {
            $psikolog5->assignRole('psikolog');
        }
    }
}
