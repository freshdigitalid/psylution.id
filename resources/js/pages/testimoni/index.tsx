import { Button } from '@/components/ui/button';
import { Card } from '@/components/ui/card';
import { Input } from '@/components/ui/input';
import { TestimonialPagination } from '@/components/ui/testimonial-pagination';
import Layout from '@/layouts/layout';
import { useState } from 'react';

interface Testimonial {
    id: number;
    name: string;
    role: string;
    content: string;
    rating: number;
}

export default function TestimoniPage() {
    const [currentPage, setCurrentPage] = useState(1);
    const itemsPerPage = 6;

    // Sample testimonials data
    const allTestimonials: Testimonial[] = [
        {
            id: 1,
            name: 'Sarah Johnson',
            role: 'Mahasiswa',
            content:
                'Sangat membantu dalam mengatasi anxiety saya. Psikolog yang profesional dan ramah. Sesi konseling online sangat nyaman dan efektif.',
            rating: 5,
        },
        {
            id: 2,
            name: 'Michael Chen',
            role: 'Karyawan',
            content:
                'Platform yang sangat baik untuk konseling. Mudah digunakan dan psikolog yang berpengalaman. Sangat merekomendasikan untuk yang membutuhkan bantuan.',
            rating: 5,
        },
        {
            id: 3,
            name: 'Lisa Rodriguez',
            role: 'Ibu Rumah Tangga',
            content: 'Terima kasih atas bantuan yang diberikan. Konseling membantu saya mengatasi stress dan depresi. Tim yang sangat supportive.',
            rating: 5,
        },
        {
            id: 4,
            name: 'David Kim',
            role: 'Freelancer',
            content: 'Layanan konseling yang sangat berkualitas. Psikolog yang memahami masalah saya dan memberikan solusi yang tepat.',
            rating: 4,
        },
        {
            id: 5,
            name: 'Emma Wilson',
            role: 'Guru',
            content: 'Sangat puas dengan layanan konseling di sini. Proses booking mudah dan psikolog yang sangat profesional.',
            rating: 5,
        },
        {
            id: 6,
            name: 'James Brown',
            role: 'Wiraswasta',
            content: 'Konseling online yang sangat membantu. Tidak perlu keluar rumah dan tetap mendapatkan layanan berkualitas tinggi.',
            rating: 5,
        },
        {
            id: 7,
            name: 'Maria Garcia',
            role: 'Dokter',
            content: 'Sebagai tenaga medis, saya sangat menghargai profesionalisme tim psikolog di sini. Sangat membantu dalam mengatasi burnout.',
            rating: 5,
        },
        {
            id: 8,
            name: 'Alex Thompson',
            role: 'Mahasiswa',
            content: 'Layanan konseling yang sangat baik untuk mahasiswa. Harga terjangkau dan kualitas layanan yang memuaskan.',
            rating: 4,
        },
        {
            id: 9,
            name: 'Sophie Lee',
            role: 'Desainer',
            content: 'Konseling membantu saya mengatasi creative block dan anxiety. Psikolog yang sangat memahami dunia kreatif.',
            rating: 5,
        },
        {
            id: 10,
            name: 'Robert Davis',
            role: 'Manager',
            content: 'Layanan konseling yang sangat profesional. Membantu saya mengatasi masalah kepemimpinan dan stress kerja.',
            rating: 5,
        },
        {
            id: 11,
            name: 'Anna Martinez',
            role: 'Perawat',
            content: 'Sebagai perawat, saya sering mengalami stress. Konseling di sini sangat membantu dalam mengelola emosi dan stress.',
            rating: 5,
        },
        {
            id: 12,
            name: 'Kevin Park',
            role: 'Developer',
            content: 'Konseling online yang sangat praktis untuk developer seperti saya. Membantu mengatasi imposter syndrome dan anxiety.',
            rating: 4,
        },
    ];

    const totalPages = Math.ceil(allTestimonials.length / itemsPerPage);
    const startIndex = (currentPage - 1) * itemsPerPage;
    const endIndex = startIndex + itemsPerPage;
    const currentTestimonials = allTestimonials.slice(startIndex, endIndex);

    const renderStars = (rating: number) => {
        return Array.from({ length: 5 }).map((_, index) => (
            <span key={index} className={`text-sm ${index < rating ? 'text-yellow-400' : 'text-gray-300'}`}>
                ★
            </span>
        ));
    };

    return (
        <Layout>
            <div className="mx-auto max-w-screen-xl px-6">
                <h1 className="mb-6 text-center text-3xl font-extrabold">Testimoni</h1>

                {/* Testimonials Grid */}
                <div className="grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
                    {currentTestimonials.map((testimonial) => (
                        <Card key={testimonial.id} className="overflow-hidden">
                            <div className="p-4">
                                <div className="mb-3 flex items-center gap-1">{renderStars(testimonial.rating)}</div>
                                <div className="text-sm text-muted-foreground">"{testimonial.content}"</div>
                            </div>
                            <div className="flex items-center gap-3 border-t bg-primary/5 p-4">
                                <div className="flex h-10 w-10 items-center justify-center rounded-full bg-primary/30">
                                    <span className="text-sm font-bold text-primary">{testimonial.name.charAt(0)}</span>
                                </div>
                                <div>
                                    <div className="text-sm font-bold">{testimonial.name}</div>
                                    <div className="text-xs text-muted-foreground">{testimonial.role}</div>
                                </div>
                            </div>
                        </Card>
                    ))}
                </div>

                {/* Pagination */}
                <TestimonialPagination currentPage={currentPage} totalPages={totalPages} onPageChange={setCurrentPage} />

                {/* Submit Feedback */}
                <div className="mt-8 rounded-xl border bg-primary/10 p-6">
                    <h2 className="text-2xl font-extrabold">Submit Your Feedback</h2>
                    <p className="mt-2 text-sm text-muted-foreground">
                        Lorem ipsum dolor sit amet consectetur. Aliquet bibendum fringilla cras nisl commodo sit facilisi massa euismod. Ornare tellus
                        in et montes. Et pharetra morbi vel mauris faucibus hendrerit fermentum senectus. Ornare viverra elementum at aenean maecenas
                        nunc egestas.
                    </p>
                    <div className="mt-4 flex items-center gap-3">
                        <Input placeholder="Type your feedback" className="flex-1" />
                        <Button>Submit</Button>
                    </div>
                </div>
            </div>
        </Layout>
    );
}
