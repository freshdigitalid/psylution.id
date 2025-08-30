import { Head } from '@inertiajs/react';
import Navbar from '@/components/navbar/navbar';
import Footer from '@/components/footer';
import VisionMissionSection from '@/components/about/vision-mission-section';
import ServicesSection from '@/components/about/services-section';
import PartnersSection from '@/components/about/partners-section';
import PodcastSection from '@/components/about/podcast-section';
import { Button } from '@/components/ui/button';
import { Link } from '@inertiajs/react';

const AboutPage = () => {
    const services = [
        {
            id: 1,
            title: 'Konseling Individual',
            description: 'Layanan konseling personal untuk mengatasi masalah pribadi, kecemasan, dan depresi.',
            icon: '🧠',
            link: '/layanan-konseling'
        },
        {
            id: 2,
            title: 'Konseling Keluarga',
            description: 'Bantuan untuk memperbaiki hubungan keluarga dan mengatasi konflik antar anggota.',
            icon: '👨‍👩‍👧‍👦',
            link: '/layanan-konseling'
        },
        {
            id: 3,
            title: 'Konseling Pasangan',
            description: 'Terapi untuk pasangan yang ingin memperbaiki komunikasi dan hubungan.',
            icon: '💕',
            link: '/layanan-konseling'
        },
        {
            id: 4,
            title: 'Terapi Anak',
            description: 'Layanan khusus untuk anak-anak dengan pendekatan yang ramah dan menyenangkan.',
            icon: '👶',
            link: '/layanan-konseling'
        },
        {
            id: 5,
            title: 'Konseling Karir',
            description: 'Bimbingan untuk pengembangan karir dan mengatasi masalah di tempat kerja.',
            icon: '💼',
            link: '/layanan-konseling'
        },
        {
            id: 6,
            title: 'Terapi Trauma',
            description: 'Penanganan khusus untuk trauma dan pengalaman traumatis.',
            icon: '🛡️',
            link: '/layanan-konseling'
        }
    ];

    const partners = [
        { id: 1, name: 'Partner 1' },
        { id: 2, name: 'Partner 2' },
        { id: 3, name: 'Partner 3' },
        { id: 4, name: 'Partner 4' },
        { id: 5, name: 'Partner 5' },
        { id: 6, name: 'Partner 6' },
        { id: 7, name: 'Partner 7' },
        { id: 8, name: 'Partner 8' },
        { id: 9, name: 'Partner 9' },
        { id: 10, name: 'Partner 10' },
        { id: 11, name: 'Partner 11' },
        { id: 12, name: 'Partner 12' }
    ];

    return (
        <>
            <Head title="About Us - Psylution" />
            
            <div className="min-h-screen bg-white">
                <Navbar />
                
                {/* Hero Section */}
                <div className="bg-white py-20">
                    <div className="max-w-4xl mx-auto px-4 text-center">
                        <h1 className="text-4xl md:text-5xl font-bold text-gray-900 mb-6">
                            Tentang Psylution
                        </h1>
                        <p className="text-lg text-gray-600 mb-8 max-w-2xl mx-auto">
                            Psylution adalah platform konseling online yang menghubungkan individu dengan psikolog profesional 
                            untuk mendapatkan bantuan mental health yang berkualitas dan terjangkau.
                        </p>
                        <Button asChild size="lg" className="bg-blue-600 hover:bg-blue-700">
                            <Link href="/layanan-konseling">
                                Mulai Konseling
                            </Link>
                        </Button>
                    </div>
                </div>

                {/* Vision Section */}
                <VisionMissionSection
                    type="vision"
                    title="Visi"
                    description="Menjadi platform konseling terdepan di Indonesia yang memberikan akses mudah, terjangkau, dan berkualitas untuk layanan kesehatan mental bagi semua kalangan masyarakat."
                    imagePosition="left"
                />

                {/* Mission Section */}
                <VisionMissionSection
                    type="mission"
                    title="Misi"
                    description="Memberikan layanan konseling profesional yang mudah diakses, terjangkau, dan berkualitas tinggi melalui teknologi digital, serta mendukung kesehatan mental masyarakat Indonesia."
                    imagePosition="right"
                />

                {/* Services Section */}
                <ServicesSection
                    title="Layanan Kami"
                    services={services}
                />

                {/* Partners Section */}
                <PartnersSection
                    title="Mitra Psylution"
                    partners={partners}
                />

                {/* Podcast Section */}
                <PodcastSection
                    title="Podcast Psylution"
                    description="Dengarkan episode terbaru kami tentang kesehatan mental, tips hidup sehat, dan berbagai topik menarik lainnya."
                />

                <Footer />
            </div>
        </>
    );
};

export default AboutPage; 