import Footer from '@/components/footer';
import Navbar from '@/components/navbar/navbar';
import ServiceSection from '@/components/services/service-section';
import { Head } from '@inertiajs/react';

interface Service {
    title: string;
    price: string;
    features: string[];
    isPopular?: boolean;
    duration_minutes: number;
    type: string;
    description: string;
    psychologist_criteria: string[];
}

interface ServiceSectionData {
    title: string;
    description: string;
    services: Service[];
}

interface ServicesPageProps {
    services: ServiceSectionData[];
}

const ServicesPage = ({ services }: ServicesPageProps) => {
    return (
        <>
            <Head title="Layanan Konseling" />

            <div className="min-h-screen bg-white">
                <Navbar />

                {/* Header Section */}
                <div className="px-4 pt-32 pb-16">
                    <div className="mx-auto max-w-4xl text-center">
                        <h1 className="mb-6 text-4xl font-bold text-gray-900 md:text-5xl">Layanan Konseling</h1>
                        <p className="mx-auto max-w-2xl text-lg text-gray-600">
                            Kami menyediakan berbagai layanan konseling yang disesuaikan dengan kebutuhan Anda. Pilih layanan yang tepat untuk
                            mendapatkan bantuan profesional dari psikolog berpengalaman.
                        </p>
                    </div>
                </div>

                {/* Services Sections */}
                <div className="mx-auto max-w-7xl space-y-12 px-4 pb-20">
                    {services.map((section, index) => (
                        <ServiceSection key={index} title={section.title} description={section.description} services={section.services} />
                    ))}
                </div>

                <Footer />
            </div>
        </>
    );
};

export default ServicesPage;
