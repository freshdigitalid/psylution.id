import { Button } from '@/components/ui/button';
import { Card } from '@/components/ui/card';
import { Input } from '@/components/ui/input';
import { Pagination, PaginationContent, PaginationItem, PaginationLink, PaginationNext, PaginationPrevious } from '@/components/ui/pagination';
import Layout from '@/layouts/layout';
import { Head, router } from '@inertiajs/react';
import { useState } from 'react';

interface Testimonial {
    id: number;
    name: string;
    role: string;
    content: string;
    rating: number;
    avatar: string;
    date: string;
}

interface PaginationData {
    current_page: number;
    last_page: number;
    per_page: number;
    total: number;
    from: number;
    to: number;
    has_more_pages: boolean;
    has_prev_pages: boolean;
}

interface TestimoniPageProps {
    testimonials: Testimonial[];
    pagination: PaginationData;
}

export default function TestimoniPage({ testimonials, pagination }: TestimoniPageProps) {
    const [feedback, setFeedback] = useState('');

    const renderStars = (rating: number) => {
        return Array.from({ length: 5 }).map((_, index) => (
            <span key={index} className={`text-sm ${index < rating ? 'text-yellow-400' : 'text-gray-300'}`}>
                ★
            </span>
        ));
    };

    const handlePageChange = (page: number) => {
        router.get(
            route('testimoni'),
            { page },
            {
                preserveState: true,
                preserveScroll: true,
            },
        );
    };

    const renderPaginationItems = () => {
        const items = [];
        const { current_page, last_page } = pagination;

        // Previous button
        if (pagination.has_prev_pages) {
            items.push(
                <PaginationItem key="prev">
                    <PaginationPrevious
                        href="#"
                        onClick={(e) => {
                            e.preventDefault();
                            handlePageChange(current_page - 1);
                        }}
                    />
                </PaginationItem>,
            );
        }

        // Page numbers
        const startPage = Math.max(1, current_page - 2);
        const endPage = Math.min(last_page, current_page + 2);

        if (startPage > 1) {
            items.push(
                <PaginationItem key={1}>
                    <PaginationLink
                        href="#"
                        onClick={(e) => {
                            e.preventDefault();
                            handlePageChange(1);
                        }}
                    >
                        1
                    </PaginationLink>
                </PaginationItem>,
            );
            if (startPage > 2) {
                items.push(
                    <PaginationItem key="ellipsis1">
                        <span className="flex h-9 w-9 items-center justify-center">...</span>
                    </PaginationItem>,
                );
            }
        }

        for (let i = startPage; i <= endPage; i++) {
            items.push(
                <PaginationItem key={i}>
                    <PaginationLink
                        href="#"
                        isActive={i === current_page}
                        onClick={(e) => {
                            e.preventDefault();
                            handlePageChange(i);
                        }}
                    >
                        {i}
                    </PaginationLink>
                </PaginationItem>,
            );
        }

        if (endPage < last_page) {
            if (endPage < last_page - 1) {
                items.push(
                    <PaginationItem key="ellipsis2">
                        <span className="flex h-9 w-9 items-center justify-center">...</span>
                    </PaginationItem>,
                );
            }
            items.push(
                <PaginationItem key={last_page}>
                    <PaginationLink
                        href="#"
                        onClick={(e) => {
                            e.preventDefault();
                            handlePageChange(last_page);
                        }}
                    >
                        {last_page}
                    </PaginationLink>
                </PaginationItem>,
            );
        }

        // Next button
        if (pagination.has_more_pages) {
            items.push(
                <PaginationItem key="next">
                    <PaginationNext
                        href="#"
                        onClick={(e) => {
                            e.preventDefault();
                            handlePageChange(current_page + 1);
                        }}
                    />
                </PaginationItem>,
            );
        }

        return items;
    };

    return (
        <>
            <Head title="Testimoni" />
            <Layout>
                <div className="mx-auto max-w-screen-xl px-6">
                    <h1 className="mb-6 text-center text-3xl font-extrabold">Testimoni</h1>

                    {/* Testimonials Grid */}
                    <div className="grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
                        {testimonials.map((testimonial) => (
                            <Card key={testimonial.id} className="overflow-hidden">
                                <div className="p-4">
                                    <div className="mb-3 flex items-center gap-1">{renderStars(testimonial.rating)}</div>
                                    <div className="text-sm text-muted-foreground">"{testimonial.content}"</div>
                                </div>
                                <div className="flex items-center gap-3 border-t bg-primary/5 p-4">
                                    <img src={testimonial.avatar} alt={testimonial.name} className="h-10 w-10 rounded-full object-cover" />
                                    <div>
                                        <div className="text-sm font-bold">{testimonial.name}</div>
                                        <div className="text-xs text-muted-foreground">{testimonial.role}</div>
                                        <div className="text-xs text-muted-foreground">{testimonial.date}</div>
                                    </div>
                                </div>
                            </Card>
                        ))}
                    </div>

                    {/* Pagination */}
                    <div className="mt-8">
                        <Pagination>
                            <PaginationContent>{renderPaginationItems()}</PaginationContent>
                        </Pagination>
                    </div>

                    {/* Submit Feedback */}
                    <div className="mt-8 rounded-xl border bg-primary/10 p-6">
                        <h2 className="text-2xl font-extrabold">Submit Your Feedback</h2>
                        <p className="mt-2 text-sm text-muted-foreground">
                            Lorem ipsum dolor sit amet consectetur. Aliquet bibendum fringilla cras nisl commodo sit facilisi massa euismod. Ornare
                            tellus in et montes. Et pharetra morbi vel mauris faucibus hendrerit fermentum senectus. Ornare viverra elementum at
                            aenean maecenas nunc egestas.
                        </p>
                        <div className="mt-4 flex items-center gap-3">
                            <Input
                                placeholder="Type your feedback"
                                className="flex-1"
                                value={feedback}
                                onChange={(e) => setFeedback(e.target.value)}
                            />
                            <Button>Submit</Button>
                        </div>
                    </div>
                </div>
            </Layout>
        </>
    );
}
