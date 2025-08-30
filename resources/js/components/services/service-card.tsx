import { Button } from '@/components/ui/button';
import { Card, CardContent, CardHeader, CardTitle } from '@/components/ui/card';
import { Check } from 'lucide-react';

interface ServiceCardProps {
    title: string;
    price: string;
    features: string[];
    isPopular?: boolean;
}

const ServiceCard = ({ title, price, features, isPopular = false }: ServiceCardProps) => {
    return (
        <Card className={`relative ${isPopular ? 'border-blue-500 shadow-lg' : ''}`}>
            {isPopular && (
                <div className="absolute -top-3 left-1/2 -translate-x-1/2 transform">
                    <span className="rounded-full bg-blue-500 px-3 py-1 text-xs font-medium text-white">Terpopuler</span>
                </div>
            )}
            <CardHeader className="pb-4 text-center">
                <CardTitle className="text-xl font-bold">{title}</CardTitle>
                <div className="text-2xl font-bold text-blue-600">{price}</div>
                <p className="text-sm text-muted-foreground">per sesi</p>
            </CardHeader>
            <CardContent className="space-y-4">
                <ul className="space-y-3">
                    {features.map((feature, index) => (
                        <li key={index} className="flex items-start gap-3">
                            <Check className="mt-0.5 h-5 w-5 flex-shrink-0 text-green-500" />
                            <span className="text-sm">{feature}</span>
                        </li>
                    ))}
                </ul>
                <Button className="mt-6 w-full" variant={isPopular ? 'default' : 'outline'}>
                    Pilih Paket
                </Button>
            </CardContent>
        </Card>
    );
};

export default ServiceCard;
