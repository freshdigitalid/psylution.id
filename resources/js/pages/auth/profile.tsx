import { Button } from "@/components/ui/button";
import { Card, CardContent, CardDescription, CardHeader, CardTitle } from "@/components/ui/card";
import { Input } from "@/components/ui/input";
import { Label } from "@/components/ui/label";
import { Avatar, AvatarFallback, AvatarImage } from "@/components/ui/avatar";
import { Badge } from "@/components/ui/badge";
import { Separator } from "@/components/ui/separator";
import { Tabs, TabsContent, TabsList, TabsTrigger } from "@/components/ui/tabs";
import { usePage } from "@inertiajs/react";
import { SharedData } from "@/types";
import { useState } from "react";
import { toast } from "sonner";

const ProfilePage = () => {
    const { auth } = usePage<SharedData>().props;
    const user = auth.user;

    const [isEditing, setIsEditing] = useState(false);
    const [formData, setFormData] = useState({
        name: user?.name || '',
        email: user?.email || '',
        avatar: user?.avatar || '',
    });

    const handleInputChange = (e: React.ChangeEvent<HTMLInputElement>) => {
        const { name, value } = e.target;
        setFormData(prev => ({
            ...prev,
            [name]: value
        }));
    };

    const handleSave = () => {
        // TODO: Implement save functionality
        toast.success("Profile updated successfully!");
        setIsEditing(false);
    };

    const handleCancel = () => {
        setFormData({
            name: user?.name || '',
            email: user?.email || '',
            avatar: user?.avatar || '',
        });
        setIsEditing(false);
    };

    const getInitials = (name: string) => {
        return name
            .split(' ')
            .map(word => word.charAt(0))
            .join('')
            .toUpperCase()
            .slice(0, 2);
    };

    return (
        <div className="min-h-screen bg-gradient-to-br from-blue-50 to-indigo-100 dark:from-gray-900 dark:to-gray-800">
            <div className="container mx-auto px-4 py-8">
                <div className="max-w-4xl mx-auto space-y-8">
                    {/* Header */}
                    <div className="text-center">
                        <h1 className="text-3xl font-bold text-gray-900 dark:text-white mb-2">
                            My Profile
                        </h1>
                        <p className="text-gray-600 dark:text-gray-400">
                            Manage your account settings and preferences
                        </p>
                    </div>

                    <Tabs defaultValue="profile" className="space-y-6">
                        <TabsList className="grid w-full grid-cols-3">
                            <TabsTrigger value="profile">Profile</TabsTrigger>
                            <TabsTrigger value="security">Security</TabsTrigger>
                            <TabsTrigger value="preferences">Preferences</TabsTrigger>
                        </TabsList>

                        <TabsContent value="profile" className="space-y-6">
                            <Card>
                                <CardHeader>
                                    <CardTitle>Personal Information</CardTitle>
                                    <CardDescription>
                                        Update your personal information and profile picture
                                    </CardDescription>
                                </CardHeader>
                                <CardContent className="space-y-6">
                                    {/* Avatar Section */}
                                    <div className="flex items-center space-x-6">
                                        <Avatar className="h-24 w-24">
                                            <AvatarImage src={formData.avatar} alt={user?.name} />
                                            <AvatarFallback className="text-lg">
                                                {getInitials(user?.name || '')}
                                            </AvatarFallback>
                                        </Avatar>
                                        <div className="space-y-2">
                                            <h3 className="text-lg font-medium">{user?.name}</h3>
                                            <Badge variant="secondary" className="capitalize">
                                                {user?.role?.name || 'Patient'}
                                            </Badge>
                                            <p className="text-sm text-gray-500 dark:text-gray-400">
                                                Member since {new Date(user?.created_at || '').toLocaleDateString()}
                                            </p>
                                        </div>
                                    </div>

                                    <Separator />

                                    {/* Form Fields */}
                                    <div className="grid grid-cols-1 md:grid-cols-2 gap-6">
                                        <div className="space-y-2">
                                            <Label htmlFor="name">Full Name</Label>
                                            <Input
                                                id="name"
                                                name="name"
                                                value={formData.name}
                                                onChange={handleInputChange}
                                                disabled={!isEditing}
                                                placeholder="Enter your full name"
                                            />
                                        </div>

                                        <div className="space-y-2">
                                            <Label htmlFor="email">Email Address</Label>
                                            <Input
                                                id="email"
                                                name="email"
                                                type="email"
                                                value={formData.email}
                                                onChange={handleInputChange}
                                                disabled={!isEditing}
                                                placeholder="Enter your email"
                                            />
                                        </div>

                                        <div className="space-y-2 md:col-span-2">
                                            <Label htmlFor="avatar">Avatar URL</Label>
                                            <Input
                                                id="avatar"
                                                name="avatar"
                                                value={formData.avatar}
                                                onChange={handleInputChange}
                                                disabled={!isEditing}
                                                placeholder="Enter avatar URL"
                                            />
                                        </div>
                                    </div>

                                    {/* Action Buttons */}
                                    <div className="flex justify-end space-x-3">
                                        {!isEditing ? (
                                            <Button onClick={() => setIsEditing(true)}>
                                                Edit Profile
                                            </Button>
                                        ) : (
                                            <>
                                                <Button variant="outline" onClick={handleCancel}>
                                                    Cancel
                                                </Button>
                                                <Button onClick={handleSave}>
                                                    Save Changes
                                                </Button>
                                            </>
                                        )}
                                    </div>
                                </CardContent>
                            </Card>
                        </TabsContent>

                        <TabsContent value="security" className="space-y-6">
                            <Card>
                                <CardHeader>
                                    <CardTitle>Security Settings</CardTitle>
                                    <CardDescription>
                                        Manage your password and security preferences
                                    </CardDescription>
                                </CardHeader>
                                <CardContent className="space-y-6">
                                    <div className="space-y-4">
                                        <div className="space-y-2">
                                            <Label htmlFor="current-password">Current Password</Label>
                                            <Input
                                                id="current-password"
                                                type="password"
                                                placeholder="Enter current password"
                                            />
                                        </div>

                                        <div className="space-y-2">
                                            <Label htmlFor="new-password">New Password</Label>
                                            <Input
                                                id="new-password"
                                                type="password"
                                                placeholder="Enter new password"
                                            />
                                        </div>

                                        <div className="space-y-2">
                                            <Label htmlFor="confirm-password">Confirm New Password</Label>
                                            <Input
                                                id="confirm-password"
                                                type="password"
                                                placeholder="Confirm new password"
                                            />
                                        </div>

                                        <Button>Update Password</Button>
                                    </div>
                                </CardContent>
                            </Card>
                        </TabsContent>

                        <TabsContent value="preferences" className="space-y-6">
                            <Card>
                                <CardHeader>
                                    <CardTitle>Preferences</CardTitle>
                                    <CardDescription>
                                        Customize your experience and notification settings
                                    </CardDescription>
                                </CardHeader>
                                <CardContent className="space-y-6">
                                    <div className="space-y-4">
                                        <div className="flex items-center justify-between">
                                            <div>
                                                <h4 className="font-medium">Email Notifications</h4>
                                                <p className="text-sm text-gray-500 dark:text-gray-400">
                                                    Receive email notifications for important updates
                                                </p>
                                            </div>
                                            <Button variant="outline" size="sm">
                                                Configure
                                            </Button>
                                        </div>

                                        <Separator />

                                        <div className="flex items-center justify-between">
                                            <div>
                                                <h4 className="font-medium">Appointment Reminders</h4>
                                                <p className="text-sm text-gray-500 dark:text-gray-400">
                                                    Get reminded about upcoming appointments
                                                </p>
                                            </div>
                                            <Button variant="outline" size="sm">
                                                Configure
                                            </Button>
                                        </div>

                                        <Separator />

                                        <div className="flex items-center justify-between">
                                            <div>
                                                <h4 className="font-medium">Privacy Settings</h4>
                                                <p className="text-sm text-gray-500 dark:text-gray-400">
                                                    Manage your privacy and data preferences
                                                </p>
                                            </div>
                                            <Button variant="outline" size="sm">
                                                Configure
                                            </Button>
                                        </div>
                                    </div>
                                </CardContent>
                            </Card>
                        </TabsContent>
                    </Tabs>
                </div>
            </div>
        </div>
    );
};

export default ProfilePage; 