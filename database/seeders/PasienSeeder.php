<?php

namespace Database\Seeders;

use App\Models\Pasien;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class PasienSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create active patients
        $pasien1 = Pasien::firstOrCreate(
            ['email' => 'andi.pratama@email.com'],
            [
                'name' => 'Andi Pratama',
                'password' => Hash::make('password'),
                'phone' => '081234567897',
                'date_of_birth' => '1995-05-15',
                'gender' => 'male',
                'address' => 'Jl. Sudirman No. 123, Jakarta Pusat',
                'emergency_contact' => '081234567898',
                'is_active' => true,
            ]
        );
        if (!$pasien1->hasRole('pasien')) {
            $pasien1->assignRole('pasien');
        }

        $pasien2 = Pasien::firstOrCreate(
            ['email' => 'siti.nurhaliza@email.com'],
            [
                'name' => 'Siti Nurhaliza',
                'password' => Hash::make('password'),
                'phone' => '081234567899',
                'date_of_birth' => '1992-08-22',
                'gender' => 'female',
                'address' => 'Jl. Thamrin No. 456, Jakarta Pusat',
                'emergency_contact' => '081234567900',
                'is_active' => true,
            ]
        );
        if (!$pasien2->hasRole('pasien')) {
            $pasien2->assignRole('pasien');
        }

        $pasien3 = Pasien::firstOrCreate(
            ['email' => 'riko.saputra@email.com'],
            [
                'name' => 'Riko Saputra',
                'password' => Hash::make('password'),
                'phone' => '081234567901',
                'date_of_birth' => '1998-12-10',
                'gender' => 'male',
                'address' => 'Jl. Gatot Subroto No. 789, Jakarta Selatan',
                'emergency_contact' => '081234567902',
                'is_active' => true,
            ]
        );
        if (!$pasien3->hasRole('pasien')) {
            $pasien3->assignRole('pasien');
        }

        $pasien4 = Pasien::firstOrCreate(
            ['email' => 'diana.putri@email.com'],
            [
                'name' => 'Diana Putri',
                'password' => Hash::make('password'),
                'phone' => '081234567903',
                'date_of_birth' => '1990-03-28',
                'gender' => 'female',
                'address' => 'Jl. Kuningan No. 321, Jakarta Selatan',
                'emergency_contact' => '081234567904',
                'is_active' => true,
            ]
        );
        if (!$pasien4->hasRole('pasien')) {
            $pasien4->assignRole('pasien');
        }

        $pasien5 = Pasien::firstOrCreate(
            ['email' => 'budi.hermawan@email.com'],
            [
                'name' => 'Budi Hermawan',
                'password' => Hash::make('password'),
                'phone' => '081234567905',
                'date_of_birth' => '1985-11-05',
                'gender' => 'male',
                'address' => 'Jl. Senayan No. 654, Jakarta Pusat',
                'emergency_contact' => '081234567906',
                'is_active' => true,
            ]
        );
        if (!$pasien5->hasRole('pasien')) {
            $pasien5->assignRole('pasien');
        }

        // Create inactive patient
        $pasien6 = Pasien::firstOrCreate(
            ['email' => 'lina.maharani@email.com'],
            [
                'name' => 'Lina Maharani',
                'password' => Hash::make('password'),
                'phone' => '081234567907',
                'date_of_birth' => '1993-07-18',
                'gender' => 'female',
                'address' => 'Jl. Kemang No. 987, Jakarta Selatan',
                'emergency_contact' => '081234567908',
                'is_active' => false,
            ]
        );
        if (!$pasien6->hasRole('pasien')) {
            $pasien6->assignRole('pasien');
        }

        // Create patient with minimal data
        $pasien7 = Pasien::firstOrCreate(
            ['email' => 'alex.johnson@email.com'],
            [
                'name' => 'Alex Johnson',
                'password' => Hash::make('password'),
                'phone' => null,
                'date_of_birth' => null,
                'gender' => 'other',
                'address' => null,
                'emergency_contact' => null,
                'is_active' => true,
            ]
        );
        if (!$pasien7->hasRole('pasien')) {
            $pasien7->assignRole('pasien');
        }
    }
}