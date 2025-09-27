<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;

class TestimoniController extends Controller
{
    public function index(Request $request)
    {
        // Sample testimonials data - in real app, this would come from database
        $testimonials = collect([
            [
                'id' => 1,
                'name' => 'Sarah Johnson',
                'role' => 'Mahasiswa',
                'rating' => 5,
                'content' => 'Psylution sangat membantu saya mengatasi masalah kecemasan. Konselor sangat profesional dan memahami kondisi saya.',
                'avatar' => 'https://images.unsplash.com/photo-1494790108755-2616b612b786?w=150&h=150&fit=crop&crop=face',
                'date' => '2024-01-15'
            ],
            [
                'id' => 2,
                'name' => 'Michael Chen',
                'role' => 'Profesional',
                'rating' => 5,
                'content' => 'Layanan konseling online sangat praktis dan efektif. Saya bisa konsultasi kapan saja tanpa harus keluar rumah.',
                'avatar' => 'https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?w=150&h=150&fit=crop&crop=face',
                'date' => '2024-01-12'
            ],
            [
                'id' => 3,
                'name' => 'Lisa Rodriguez',
                'role' => 'Ibu Rumah Tangga',
                'rating' => 4,
                'content' => 'Psikolog di Psylution sangat sabar dan memberikan solusi yang tepat untuk masalah keluarga saya.',
                'avatar' => 'https://images.unsplash.com/photo-1438761681033-6461ffad8d80?w=150&h=150&fit=crop&crop=face',
                'date' => '2024-01-10'
            ],
            [
                'id' => 4,
                'name' => 'David Kim',
                'role' => 'Pengusaha',
                'rating' => 5,
                'content' => 'Konseling stress management sangat membantu saya mengelola tekanan kerja. Highly recommended!',
                'avatar' => 'https://images.unsplash.com/photo-1472099645785-5658abf4ff4e?w=150&h=150&fit=crop&crop=face',
                'date' => '2024-01-08'
            ],
            [
                'id' => 5,
                'name' => 'Emma Wilson',
                'role' => 'Pelajar',
                'rating' => 5,
                'content' => 'Sangat membantu untuk masalah akademik dan sosial. Konselor memberikan tips yang sangat berguna.',
                'avatar' => 'https://images.unsplash.com/photo-1544005313-94ddf0286df2?w=150&h=150&fit=crop&crop=face',
                'date' => '2024-01-05'
            ],
            [
                'id' => 6,
                'name' => 'James Brown',
                'role' => 'Karyawan',
                'rating' => 4,
                'content' => 'Layanan konseling yang sangat profesional. Saya merasa lebih tenang setelah beberapa sesi konseling.',
                'avatar' => 'https://images.unsplash.com/photo-1500648767791-00dcc994a43e?w=150&h=150&fit=crop&crop=face',
                'date' => '2024-01-03'
            ],
            [
                'id' => 7,
                'name' => 'Maria Garcia',
                'role' => 'Guru',
                'rating' => 5,
                'content' => 'Psylution membantu saya mengatasi burnout. Konselor sangat memahami kondisi pekerjaan saya.',
                'avatar' => 'https://images.unsplash.com/photo-1487412720507-e7ab37603c6f?w=150&h=150&fit=crop&crop=face',
                'date' => '2024-01-01'
            ],
            [
                'id' => 8,
                'name' => 'Alex Thompson',
                'role' => 'Freelancer',
                'rating' => 4,
                'content' => 'Konseling online sangat fleksibel untuk jadwal saya yang tidak teratur. Kualitas layanan sangat baik.',
                'avatar' => 'https://images.unsplash.com/photo-1506794778202-cad84cf45f1d?w=150&h=150&fit=crop&crop=face',
                'date' => '2023-12-28'
            ],
            [
                'id' => 9,
                'name' => 'Sophie Lee',
                'role' => 'Mahasiswa',
                'rating' => 5,
                'content' => 'Sangat membantu untuk masalah relationship. Konselor memberikan perspektif yang berbeda dan sangat membantu.',
                'avatar' => 'https://images.unsplash.com/photo-1534528741775-53994a69daeb?w=150&h=150&fit=crop&crop=face',
                'date' => '2023-12-25'
            ],
            [
                'id' => 10,
                'name' => 'Ryan Miller',
                'role' => 'Engineer',
                'rating' => 4,
                'content' => 'Konseling untuk anxiety sangat efektif. Saya belajar teknik-teknik coping yang sangat berguna.',
                'avatar' => 'https://images.unsplash.com/photo-1519085360753-af0119f7cbe7?w=150&h=150&fit=crop&crop=face',
                'date' => '2023-12-22'
            ],
            [
                'id' => 11,
                'name' => 'Nina Patel',
                'role' => 'Dokter',
                'rating' => 5,
                'content' => 'Sebagai tenaga medis, saya sangat menghargai profesionalisme dan kualitas layanan Psylution.',
                'avatar' => 'https://images.unsplash.com/photo-1582750433449-648ed127bb54?w=150&h=150&fit=crop&crop=face',
                'date' => '2023-12-20'
            ],
            [
                'id' => 12,
                'name' => 'Tom Anderson',
                'role' => 'Manager',
                'rating' => 4,
                'content' => 'Konseling leadership dan management sangat membantu karir saya. Terima kasih Psylution!',
                'avatar' => 'https://images.unsplash.com/photo-1560250097-0b93528c311a?w=150&h=150&fit=crop&crop=face',
                'date' => '2023-12-18'
            ]
        ]);

        // Pagination
        $perPage = 6;
        $currentPage = $request->get('page', 1);
        $offset = ($currentPage - 1) * $perPage;
        
        $paginatedTestimonials = $testimonials->slice($offset, $perPage)->values();
        $total = $testimonials->count();
        $lastPage = ceil($total / $perPage);

        // Pagination data
        $pagination = [
            'current_page' => $currentPage,
            'last_page' => $lastPage,
            'per_page' => $perPage,
            'total' => $total,
            'from' => $offset + 1,
            'to' => min($offset + $perPage, $total),
            'has_more_pages' => $currentPage < $lastPage,
            'has_prev_pages' => $currentPage > 1,
        ];

        return Inertia::render('testimoni/index', [
            'testimonials' => $paginatedTestimonials,
            'pagination' => $pagination,
        ]);
    }
}
