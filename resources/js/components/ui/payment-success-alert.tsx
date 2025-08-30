import { Button } from '@/components/ui/button';
import { Card, CardContent } from '@/components/ui/card';
import { CheckCircle } from 'lucide-react';
import { Link } from '@inertiajs/react';

interface PaymentSuccessAlertProps {
    title?: string;
    message?: string;
    buttonText?: string;
    buttonHref?: string;
    onButtonClick?: () => void;
}

const PaymentSuccessAlert = ({
    title = 'Payment Success',
    message,
    buttonText = 'Go Back',
    buttonHref,
    onButtonClick
}: PaymentSuccessAlertProps) => {
    const handleButtonClick = () => {
        if (onButtonClick) {
            onButtonClick();
        }
    };

    const ButtonComponent = () => (
        <Button 
            onClick={handleButtonClick}
            className="bg-[#5C7CFF] hover:bg-[#4A6BFF] text-white px-8 py-3 rounded-lg font-medium transition-colors"
        >
            {buttonText}
        </Button>
    );

    return (
        <div className="min-h-screen bg-gray-50 flex items-center justify-center p-4">
            <Card className="w-full max-w-md bg-[#E0EFFF] border-[#3366FF] border-2 rounded-2xl shadow-lg">
                <CardContent className="p-8 text-center space-y-6">
                    {/* Success Icon */}
                    <div className="flex justify-center">
                        <div className="w-20 h-20 bg-[#5C7CFF] rounded-full flex items-center justify-center">
                            <CheckCircle className="w-12 h-12 text-white" />
                        </div>
                    </div>

                    {/* Title */}
                    <div className="space-y-2">
                        <h2 className="text-2xl font-bold text-gray-900">
                            {title}
                        </h2>
                        {message && (
                            <p className="text-gray-600 text-sm">
                                {message}
                            </p>
                        )}
                    </div>

                    {/* Button */}
                    <div className="pt-4">
                        {buttonHref ? (
                            <Link href={buttonHref}>
                                <ButtonComponent />
                            </Link>
                        ) : (
                            <ButtonComponent />
                        )}
                    </div>
                </CardContent>
            </Card>
        </div>
    );
};

export default PaymentSuccessAlert; 