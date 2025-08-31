import ServiceSection from '@/components/services/service-section';
import Layout from '@/layouts/layout';
import { Head } from '@inertiajs/react';

interface Service {
    title: string;
    price: string;
    features: string[];
    isPopular?: boolean;
    duration_minutes: number;
    type: string;
    description: string;
}

interface ServiceSectionData {
    title: string;
    description: string;
    services: Service[];
}

const ServicesPage = () => {
    return (
        <>
            <Head title="Layanan Konseling" />

            <Layout>
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
                        <ServiceSection
                            key={index}
                            title={section.title}
                            description={section.description}
                            services={section.services} />
                    ))}
                </div>
            </Layout>
        </>
    );
};

export default ServicesPage;

const services: ServiceSectionData[] = [
    {
        title: "Konseling Individu",
        description: "Konseling yang dilakukan antara individu bersama Psikolog baik secara tatap muka ataupun online dengan durasi 60 menit/sesi.",
        services: [
            {
                title: "Essential",
                price: "Rp 469.000",
                features: [
                    "Sesi konseling 60 menit",
                    "Konsultasi tatap muka atau online",
                    "Laporan sesi konseling",
                    "Follow-up 1x dalam seminggu"
                ],
                isPopular: false,
                duration_minutes: 60,
                type: "Individual",
                description: "Konseling individual dengan psikolog tingkat Essential",
            },
            {
                title: "Profesional",
                price: "Rp 569.000",
                features: [
                    "Sesi konseling 60 menit",
                    "Konsultasi tatap muka atau online",
                    "Laporan sesi konseling detail",
                    "Follow-up 2x dalam seminggu",
                    "Konsultasi tambahan via chat"
                ],
                isPopular: false,
                duration_minutes: 60,
                type: "Individual",
                description: "Konseling individual dengan psikolog tingkat Professional",
            },
            {
                title: "Premium",
                price: "Rp 969.000",
                features: [
                    "Sesi konseling 60 menit",
                    "Konsultasi tatap muka atau online",
                    "Laporan sesi konseling komprehensif",
                    "Follow-up 3x dalam seminggu",
                    "Konsultasi tambahan via chat dan video call",
                    "Emergency support 24/7"
                ],
                isPopular: true,
                duration_minutes: 60,
                type: "Individual",
                description: "Konseling individual dengan psikolog tingkat Premium",
            }
        ]
    },
    {
        title: "Konseling Online",
        description: "Konseling online yang dapat diakses dari mana saja dengan fleksibilitas waktu dan kenyamanan konsultasi dari rumah.",
        services: [
            {
                title: "Essential",
                price: "Rp 369.000",
                features: [
                    "Sesi konseling online 60 menit",
                    "Platform video call terintegrasi",
                    "Laporan sesi konseling",
                    "Follow-up via email"
                ],
                isPopular: false,
                duration_minutes: 60,
                type: "Individual",
                description: "Konseling online dengan psikolog tingkat Essential",
            },
            {
                title: "Premium",
                price: "Rp 569.000",
                features: [
                    "Sesi konseling online 60 menit",
                    "Platform video call terintegrasi",
                    "Laporan sesi konseling detail",
                    "Follow-up via chat dan email",
                    "Konsultasi tambahan via chat"
                ],
                isPopular: true,
                duration_minutes: 60,
                type: "Individual",
                description: "Konseling online dengan psikolog tingkat Premium",
            },
            {
                title: "Basic",
                price: "Rp 269.000",
                features: [
                    "Sesi konseling online 45 menit",
                    "Platform video call terintegrasi",
                    "Laporan sesi konseling singkat"
                ],
                isPopular: false,
                duration_minutes: 45,
                type: "Individual",
                description: "Konseling online dengan psikolog tingkat Basic",
            }
        ]
    }
]
