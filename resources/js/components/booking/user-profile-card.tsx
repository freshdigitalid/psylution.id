import { Avatar, AvatarFallback, AvatarImage } from '@/components/ui/avatar';
import { Badge } from '@/components/ui/badge';
import { Card, CardContent } from '@/components/ui/card';

interface UserProfileCardProps {
    user?: {
        name: string;
        avatar?: string;
        email: string;
        tags?: string[];
    };
    className?: string;
}

const UserProfileCard = ({ user, className }: UserProfileCardProps) => {
    const defaultUser = {
        name: 'John Doe',
        email: 'john.doe@example.com',
        tags: ['Patient', 'Regular', 'Premium'],
    };

    const userData = user || defaultUser;

    const getInitials = (name: string) => {
        return name
            .split(' ')
            .map((word) => word.charAt(0))
            .join('')
            .toUpperCase()
            .slice(0, 2);
    };

    return (
        <Card className={className}>
            <CardContent className="space-y-4 p-6 text-center">
                {/* Avatar */}
                <div className="flex justify-center">
                    <Avatar className="h-20 w-20">
                        <AvatarImage src={userData.avatar} alt={userData.name} />
                        <AvatarFallback className="bg-blue-100 text-lg font-semibold text-blue-600">{getInitials(userData.name)}</AvatarFallback>
                    </Avatar>
                </div>

                {/* Name */}
                <div>
                    <h3 className="text-lg font-semibold text-gray-900">{userData.name}</h3>
                    <p className="text-sm text-gray-600">{userData.email}</p>
                </div>

                {/* Tags */}
                {userData.tags && userData.tags.length > 0 && (
                    <div className="flex flex-wrap justify-center gap-2">
                        {userData.tags.map((tag, index) => (
                            <Badge key={index} variant="secondary" className="bg-blue-100 text-blue-700 hover:bg-blue-200">
                                {tag}
                            </Badge>
                        ))}
                    </div>
                )}

                {/* Additional Info */}
                <div className="text-sm text-gray-500">Booking Information</div>
            </CardContent>
        </Card>
    );
};

export default UserProfileCard;
