<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Service;

class ServiceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $services = [
            // Counseling Corner - Individual Services
            [
                'name' => 'Essential',
                'category' => 'Counseling Corner',
                'type' => 'Individual',
                'price' => 469000.00,
                'currency' => 'IDR',
                'duration_minutes' => 60,
                'description' => 'Konseling individual dengan psikolog tingkat Essential',
                'features' => [
                    'Sesi konseling 60 menit',
                    'Konsultasi tatap muka atau online',
                    'Laporan sesi konseling',
                    'Follow-up 1x dalam seminggu'
                ],
                'psychologist_criteria' => [
                    'usia' => '26 - 30 tahun',
                    'pengalaman' => '2 - 4 tahun',
                    'jumlah_klien' => '301 - 500 orang',
                    'kasus_ditangani' => [
                        'Kecemasan',
                        'Emosi',
                        'Depresi',
                        'Psikosomatis',
                        'Self-harm',
                        'Relasi'
                    ]
                ],
                'is_active' => true,
                'sort_order' => 1
            ],
            [
                'name' => 'Profesional',
                'category' => 'Counseling Corner',
                'type' => 'Individual',
                'price' => 569000.00,
                'currency' => 'IDR',
                'duration_minutes' => 60,
                'description' => 'Konseling individual dengan psikolog tingkat Professional',
                'features' => [
                    'Sesi konseling 60 menit',
                    'Konsultasi tatap muka atau online',
                    'Laporan sesi konseling detail',
                    'Follow-up 2x dalam seminggu',
                    'Konsultasi tambahan via chat'
                ],
                'psychologist_criteria' => [
                    'usia' => '30 - 40 tahun',
                    'pengalaman' => '4 - 10 tahun',
                    'jumlah_klien' => '501 - 900 orang',
                    'kasus_ditangani' => [
                        'Trauma',
                        'Karir',
                        'Adiksi',
                        'Kekerasan',
                        'Pernikahan',
                        'Kecemasan',
                        'Depresi'
                    ]
                ],
                'is_active' => true,
                'sort_order' => 2
            ],
            [
                'name' => 'Premium',
                'category' => 'Counseling Corner',
                'type' => 'Individual',
                'price' => 969000.00,
                'currency' => 'IDR',
                'duration_minutes' => 60,
                'description' => 'Konseling individual dengan psikolog tingkat Premium',
                'features' => [
                    'Sesi konseling 60 menit',
                    'Konsultasi tatap muka atau online',
                    'Laporan sesi konseling komprehensif',
                    'Follow-up 3x dalam seminggu',
                    'Konsultasi tambahan via chat dan video call',
                    'Emergency support 24/7'
                ],
                'psychologist_criteria' => [
                    'usia' => '40+ tahun',
                    'pengalaman' => '10+ tahun',
                    'jumlah_klien' => '901 - 2000 orang',
                    'kasus_ditangani' => [
                        'Kepribadian',
                        'Pernikahan',
                        'Gangguan klinis berat',
                        'Trauma kompleks',
                        'Adiksi berat',
                        'Gangguan psikotik'
                    ]
                ],
                'is_active' => true,
                'sort_order' => 3
            ],

            // e-Counseling Services
            [
                'name' => 'Essential',
                'category' => 'e-Counseling',
                'type' => 'Individual',
                'price' => 369000.00,
                'currency' => 'IDR',
                'duration_minutes' => 60,
                'description' => 'Konseling online dengan psikolog tingkat Essential',
                'features' => [
                    'Sesi konseling online 60 menit',
                    'Platform video call terintegrasi',
                    'Laporan sesi konseling',
                    'Follow-up via email'
                ],
                'psychologist_criteria' => [
                    'usia' => '26 - 30 tahun',
                    'pengalaman' => '2 - 4 tahun',
                    'jumlah_klien' => '301 - 500 orang',
                    'kasus_ditangani' => [
                        'Kecemasan ringan',
                        'Stress kerja',
                        'Masalah relasi',
                        'Self-esteem'
                    ]
                ],
                'is_active' => true,
                'sort_order' => 4
            ],
            [
                'name' => 'Premium',
                'category' => 'e-Counseling',
                'type' => 'Individual',
                'price' => 569000.00,
                'currency' => 'IDR',
                'duration_minutes' => 60,
                'description' => 'Konseling online dengan psikolog tingkat Premium',
                'features' => [
                    'Sesi konseling online 60 menit',
                    'Platform video call terintegrasi',
                    'Laporan sesi konseling detail',
                    'Follow-up via chat dan email',
                    'Konsultasi tambahan via chat'
                ],
                'psychologist_criteria' => [
                    'usia' => '30 - 40 tahun',
                    'pengalaman' => '4 - 10 tahun',
                    'jumlah_klien' => '501 - 900 orang',
                    'kasus_ditangani' => [
                        'Trauma',
                        'Depresi',
                        'Kecemasan berat',
                        'Masalah keluarga',
                        'Karir'
                    ]
                ],
                'is_active' => true,
                'sort_order' => 5
            ],
            [
                'name' => 'Basic',
                'category' => 'e-Counseling',
                'type' => 'Individual',
                'price' => 269000.00,
                'currency' => 'IDR',
                'duration_minutes' => 45,
                'description' => 'Konseling online dengan psikolog tingkat Basic',
                'features' => [
                    'Sesi konseling online 45 menit',
                    'Platform video call terintegrasi',
                    'Laporan sesi konseling singkat'
                ],
                'psychologist_criteria' => [
                    'usia' => '25 - 30 tahun',
                    'pengalaman' => '1 - 3 tahun',
                    'jumlah_klien' => '100 - 300 orang',
                    'kasus_ditangani' => [
                        'Stress sehari-hari',
                        'Masalah komunikasi',
                        'Self-development',
                        'Motivasi'
                    ]
                ],
                'is_active' => true,
                'sort_order' => 6
            ]
        ];

        foreach ($services as $service) {
            Service::create($service);
        }
    }
}
