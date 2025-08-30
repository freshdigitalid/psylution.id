<?php

namespace App\Http\Controllers;

use App\Models\Service;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ServiceController extends Controller
{
    public function index()
    {
        $services = Service::active()
            ->orderBy('sort_order')
            ->get()
            ->groupBy('category');
            
        $transformedServices = [];
        
        foreach ($services as $category => $categoryServices) {
            $serviceData = [
                'title' => $this->getCategoryTitle($category),
                'description' => $this->getCategoryDescription($category),
                'services' => $categoryServices->map(function ($service) {
                    return [
                        'title' => $service->name,
                        'price' => 'Rp ' . number_format($service->price, 0, ',', '.'),
                        'features' => $service->features ?? [],
                        'isPopular' => $service->name === 'Premium', // Mark Premium as popular
                        'duration_minutes' => $service->duration_minutes,
                        'type' => $service->type,
                        'description' => $service->description,
                        'psychologist_criteria' => $service->psychologist_criteria,
                    ];
                })->toArray()
            ];
            
            $transformedServices[] = $serviceData;
        }

        return Inertia::render('services/index', [
            'services' => $transformedServices
        ]);
    }

    private function getCategoryTitle($category)
    {
        $titles = [
            'Counseling Corner' => 'Konseling Individu',
            'e-Counseling' => 'Konseling Online',
        ];

        return $titles[$category] ?? $category;
    }

    private function getCategoryDescription($category)
    {
        $descriptions = [
            'Counseling Corner' => 'Konseling yang dilakukan antara individu bersama Psikolog baik secara tatap muka ataupun online dengan durasi 60 menit/sesi.',
            'e-Counseling' => 'Konseling online yang dapat diakses dari mana saja dengan fleksibilitas waktu dan kenyamanan konsultasi dari rumah.',
        ];

        return $descriptions[$category] ?? 'Layanan konseling profesional yang disesuaikan dengan kebutuhan Anda.';
    }
}
