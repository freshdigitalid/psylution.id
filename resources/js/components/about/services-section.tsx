import { Button } from '@/components/ui/button';
import { Card, CardContent } from '@/components/ui/card';
import { Link } from '@inertiajs/react';

interface Service {
    id: number;
    title: string;
    description: string;
    icon: string;
    link: string;
}

interface ServicesSectionProps {
    title: string;
    services: Service[];
    className?: string;
}

const ServicesSection = ({ title, services, className }: ServicesSectionProps) => {
    return (
        <div className={`bg-gray-50 py-16 ${className}`}>
            <div className="mx-auto max-w-7xl px-4">
                <div className="mb-12 text-center">
                    <h2 className="mb-4 text-3xl font-bold text-gray-900">{title}</h2>
                </div>

                <div className="grid gap-6 md:grid-cols-2 lg:grid-cols-3">
                    {services.map((service) => (
                        <Card key={service.id} className="overflow-hidden transition-shadow hover:shadow-lg">
                            <CardContent className="p-6">
                                {/* Icon Placeholder */}
                                <div className="mb-4 flex h-16 w-16 items-center justify-center rounded-lg border bg-white">
                                    <span className="text-2xl">{service.icon}</span>
                                </div>

                                {/* Content */}
                                <div className="rounded-lg bg-blue-50 p-4">
                                    <h3 className="mb-2 text-lg font-bold text-gray-900">{service.title}</h3>
                                    <p className="mb-4 text-sm text-gray-600">{service.description}</p>
                                    <Button asChild variant="link" className="h-auto p-0 text-blue-600 hover:text-blue-700">
                                        <Link href={service.link}>Learn More</Link>
                                    </Button>
                                </div>
                            </CardContent>
                        </Card>
                    ))}
                </div>
            </div>
        </div>
    );
};

export default ServicesSection;
