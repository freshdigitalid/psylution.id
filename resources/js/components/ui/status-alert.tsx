import { Button } from '@/components/ui/button';
import { Card, CardContent } from '@/components/ui/card';
import { CheckCircle, XCircle, AlertCircle, Info, ArrowLeft } from 'lucide-react';
import { Link } from '@inertiajs/react';
import { cn } from '@/lib/utils';

type AlertType = 'success' | 'error' | 'warning' | 'info';

interface StatusAlertProps {
    type?: AlertType;
    title?: string;
    message?: string;
    buttonText?: string;
    buttonHref?: string;
    onButtonClick?: () => void;
    showBackIcon?: boolean;
    className?: string;
}

const StatusAlert = ({
    type = 'success',
    title,
    message,
    buttonText = 'Go Back',
    buttonHref,
    onButtonClick,
    showBackIcon = false,
    className
}: StatusAlertProps) => {
    const alertConfig = {
        success: {
            icon: CheckCircle,
            bgColor: 'bg-[#E0EFFF]',
            borderColor: 'border-[#3366FF]',
            iconBgColor: 'bg-[#5C7CFF]',
            iconColor: 'text-white',
            titleColor: 'text-gray-900',
            messageColor: 'text-gray-600'
        },
        error: {
            icon: XCircle,
            bgColor: 'bg-red-50',
            borderColor: 'border-red-500',
            iconBgColor: 'bg-red-500',
            iconColor: 'text-white',
            titleColor: 'text-gray-900',
            messageColor: 'text-gray-600'
        },
        warning: {
            icon: AlertCircle,
            bgColor: 'bg-yellow-50',
            borderColor: 'border-yellow-500',
            iconBgColor: 'bg-yellow-500',
            iconColor: 'text-white',
            titleColor: 'text-gray-900',
            messageColor: 'text-gray-600'
        },
        info: {
            icon: Info,
            bgColor: 'bg-blue-50',
            borderColor: 'border-blue-500',
            iconBgColor: 'bg-blue-500',
            iconColor: 'text-white',
            titleColor: 'text-gray-900',
            messageColor: 'text-gray-600'
        }
    };

    const config = alertConfig[type];
    const IconComponent = config.icon;

    const handleButtonClick = () => {
        if (onButtonClick) {
            onButtonClick();
        }
    };

    const ButtonComponent = () => (
        <Button 
            onClick={handleButtonClick}
            className={cn(
                "px-8 py-3 rounded-lg font-medium transition-colors",
                type === 'success' && "bg-[#5C7CFF] hover:bg-[#4A6BFF] text-white",
                type === 'error' && "bg-red-500 hover:bg-red-600 text-white",
                type === 'warning' && "bg-yellow-500 hover:bg-yellow-600 text-white",
                type === 'info' && "bg-blue-500 hover:bg-blue-600 text-white"
            )}
        >
            {showBackIcon && <ArrowLeft className="w-4 h-4 mr-2" />}
            {buttonText}
        </Button>
    );

    return (
        <div className="min-h-screen bg-gray-50 flex items-center justify-center p-4">
            <Card className={cn(
                "w-full max-w-md border-2 rounded-2xl shadow-lg",
                config.bgColor,
                config.borderColor,
                className
            )}>
                <CardContent className="p-8 text-center space-y-6">
                    {/* Icon */}
                    <div className="flex justify-center">
                        <div className={cn(
                            "w-20 h-20 rounded-full flex items-center justify-center",
                            config.iconBgColor
                        )}>
                            <IconComponent className={cn("w-12 h-12", config.iconColor)} />
                        </div>
                    </div>

                    {/* Title */}
                    <div className="space-y-2">
                        <h2 className={cn("text-2xl font-bold", config.titleColor)}>
                            {title}
                        </h2>
                        {message && (
                            <p className={cn("text-sm", config.messageColor)}>
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

export default StatusAlert; 