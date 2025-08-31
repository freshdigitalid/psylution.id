import { Card, CardContent } from '@/components/ui/card';

interface VisionMissionSectionProps {
    type: 'vision' | 'mission';
    title: string;
    description: string;
    imagePosition: 'left' | 'right';
    className?: string;
}

const VisionMissionSection = ({ 
    type, 
    title, 
    description, 
    imagePosition, 
    className 
}: VisionMissionSectionProps) => {
    const content = (
        <div className="space-y-4">
            <h2 className="text-3xl font-bold text-gray-900">{title}</h2>
            <p className="text-lg text-gray-600 leading-relaxed">
                {description}
            </p>
        </div>
    );

    const imagePlaceholder = (
        <div className="w-full h-80 bg-blue-100 rounded-2xl flex items-center justify-center">
            <div className="text-blue-600 text-4xl font-bold">
                {type === 'vision' ? '🎯' : '🚀'}
            </div>
        </div>
    );

    return (
        <div className={`py-16 ${className}`}>
            <div className="max-w-7xl mx-auto px-4">
                <div className="grid lg:grid-cols-2 gap-12 items-center">
                    {imagePosition === 'left' ? (
                        <>
                            {imagePlaceholder}
                            {content}
                        </>
                    ) : (
                        <>
                            {content}
                            {imagePlaceholder}
                        </>
                    )}
                </div>
            </div>
        </div>
    );
};

export default VisionMissionSection; 