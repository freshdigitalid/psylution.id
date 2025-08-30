import { Button } from '@/components/ui/button';
import { useState } from 'react';
import ServiceCard from './service-card';

interface ServiceSectionProps {
    title: string;
    description: string;
    services: {
        title: string;
        price: string;
        features: string[];
        isPopular?: boolean;
    }[];
}

const ServiceSection = ({ title, description, services }: ServiceSectionProps) => {
    const [sessionType, setSessionType] = useState<'offline' | 'online'>('online');

    return (
        <div className="bg-blue-50 rounded-2xl p-8 space-y-6">
            <div className="text-center space-y-4">
                <h2 className="text-3xl font-bold text-gray-900">{title}</h2>
                <p className="text-gray-600 max-w-2xl mx-auto">
                    {description}
                </p>
                
                {/* Session Type Selection */}
                <div className="flex justify-center gap-4 mt-6">
                    <Button
                        variant={sessionType === 'offline' ? 'default' : 'outline'}
                        onClick={() => setSessionType('offline')}
                        className="min-w-[120px]"
                    >
                        Offline
                    </Button>
                    <Button
                        variant={sessionType === 'online' ? 'default' : 'outline'}
                        onClick={() => setSessionType('online')}
                        className="min-w-[120px]"
                    >
                        Online
                    </Button>
                </div>
            </div>

            {/* Service Cards */}
            <div className="grid md:grid-cols-3 gap-6 mt-8">
                {services.map((service, index) => (
                    <ServiceCard
                        key={index}
                        title={service.title}
                        price={service.price}
                        features={service.features}
                        isPopular={service.isPopular}
                    />
                ))}
            </div>
        </div>
    );
};

export default ServiceSection; 