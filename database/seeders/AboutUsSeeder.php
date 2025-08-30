<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\AboutUs;

class AboutUsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $aboutData = [
            [
                'section' => 'vision',
                'title' => 'Visi',
                'description' => 'Menjadi platform konseling terdepan di Indonesia yang memberikan akses mudah, terjangkau, dan berkualitas untuk layanan kesehatan mental bagi semua kalangan masyarakat.',
                'sort_order' => 1,
                'is_active' => true
            ],
            [
                'section' => 'mission',
                'title' => 'Misi',
                'description' => 'Memberikan layanan konseling profesional yang mudah diakses, terjangkau, dan berkualitas tinggi melalui teknologi digital, serta mendukung kesehatan mental masyarakat Indonesia.',
                'sort_order' => 2,
                'is_active' => true
            ],
            [
                'section' => 'services',
                'title' => 'Layanan Kami',
                'description' => 'Berbagai layanan konseling profesional yang disesuaikan dengan kebutuhan Anda.',
                'content' => [
                    [
                        'id' => 1,
                        'title' => 'Konseling Individual',
                        'description' => 'Layanan konseling personal untuk mengatasi masalah pribadi, kecemasan, dan depresi.',
                        'icon' => '🧠',
                        'link' => '/layanan-konseling'
                    ],
                    [
                        'id' => 2,
                        'title' => 'Konseling Keluarga',
                        'description' => 'Bantuan untuk memperbaiki hubungan keluarga dan mengatasi konflik antar anggota.',
                        'icon' => '👨‍👩‍👧‍👦',
                        'link' => '/layanan-konseling'
                    ],
                    [
                        'id' => 3,
                        'title' => 'Konseling Pasangan',
                        'description' => 'Terapi untuk pasangan yang ingin memperbaiki komunikasi dan hubungan.',
                        'icon' => '💕',
                        'link' => '/layanan-konseling'
                    ],
                    [
                        'id' => 4,
                        'title' => 'Terapi Anak',
                        'description' => 'Layanan khusus untuk anak-anak dengan pendekatan yang ramah dan menyenangkan.',
                        'icon' => '👶',
                        'link' => '/layanan-konseling'
                    ],
                    [
                        'id' => 5,
                        'title' => 'Konseling Karir',
                        'description' => 'Bimbingan untuk pengembangan karir dan mengatasi masalah di tempat kerja.',
                        'icon' => '💼',
                        'link' => '/layanan-konseling'
                    ],
                    [
                        'id' => 6,
                        'title' => 'Terapi Trauma',
                        'description' => 'Penanganan khusus untuk trauma dan pengalaman traumatis.',
                        'icon' => '🛡️',
                        'link' => '/layanan-konseling'
                    ]
                ],
                'sort_order' => 3,
                'is_active' => true
            ],
            [
                'section' => 'partners',
                'title' => 'Mitra Psylution',
                'description' => 'Berkolaborasi dengan berbagai institusi dan organisasi untuk memberikan layanan terbaik.',
                'content' => [
                    ['id' => 1, 'name' => 'Universitas Indonesia'],
                    ['id' => 2, 'name' => 'Universitas Gadjah Mada'],
                    ['id' => 3, 'name' => 'Universitas Padjadjaran'],
                    ['id' => 4, 'name' => 'Universitas Airlangga'],
                    ['id' => 5, 'name' => 'Himpunan Psikologi Indonesia'],
                    ['id' => 6, 'name' => 'Kementerian Kesehatan'],
                    ['id' => 7, 'name' => 'BPJS Kesehatan'],
                    ['id' => 8, 'name' => 'Rumah Sakit Jiwa'],
                    ['id' => 9, 'name' => 'Klinik Psikologi'],
                    ['id' => 10, 'name' => 'Lembaga Konseling'],
                    ['id' => 11, 'name' => 'Organisasi Kesehatan Mental'],
                    ['id' => 12, 'name' => 'Asosiasi Psikolog']
                ],
                'sort_order' => 4,
                'is_active' => true
            ],
            [
                'section' => 'podcast',
                'title' => 'Podcast Psylution',
                'description' => 'Dengarkan episode terbaru kami tentang kesehatan mental, tips hidup sehat, dan berbagai topik menarik lainnya.',
                'content' => [
                    'episodes' => [
                        [
                            'id' => 1,
                            'title' => 'Mengatasi Kecemasan di Era Digital',
                            'duration' => '45:30',
                            'date' => '2024-12-01'
                        ],
                        [
                            'id' => 2,
                            'title' => 'Tips Menjaga Kesehatan Mental di Tempat Kerja',
                            'duration' => '38:15',
                            'date' => '2024-11-25'
                        ],
                        [
                            'id' => 3,
                            'title' => 'Membangun Hubungan Sehat dalam Keluarga',
                            'duration' => '52:20',
                            'date' => '2024-11-18'
                        ]
                    ]
                ],
                'sort_order' => 5,
                'is_active' => true
            ]
        ];

        foreach ($aboutData as $data) {
            AboutUs::create($data);
        }
    }
}
