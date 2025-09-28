import { Avatar, AvatarFallback, AvatarImage } from '@/components/ui/avatar';
import { Button } from '@/components/ui/button';
import { Card } from '@/components/ui/card';
import { Dialog, DialogContent, DialogHeader, DialogTitle } from '@/components/ui/dialog';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import Layout from '@/layouts/layout';
import { Head, router } from '@inertiajs/react';
import { Calendar, Camera, Edit3, Eye, EyeOff, Mail, Phone, Save, X } from 'lucide-react';
import { useRef, useState } from 'react';
import { toast } from 'sonner';

interface User {
    id: number;
    name: string;
    email: string;
    phone_number?: string;
    avatar?: string;
    created_at: string;
}

interface ProfilePageProps {
    user: User;
}

export default function ProfilePage({ user }: ProfilePageProps) {
    const [isEditing, setIsEditing] = useState(false);
    const [isUploading, setIsUploading] = useState(false);
    const [showPasswordModal, setShowPasswordModal] = useState(false);
    const [showCurrentPassword, setShowCurrentPassword] = useState(false);
    const [showNewPassword, setShowNewPassword] = useState(false);
    const [showConfirmPassword, setShowConfirmPassword] = useState(false);
    const [passwordData, setPasswordData] = useState({
        current_password: '',
        password: '',
        password_confirmation: '',
    });
    const [formData, setFormData] = useState({
        name: user.name,
        email: user.email,
        phone_number: user.phone_number || '',
    });
    const fileInputRef = useRef<HTMLInputElement>(null);

    const handleInputChange = (e: React.ChangeEvent<HTMLInputElement>) => {
        const { name, value } = e.target;
        setFormData((prev) => ({
            ...prev,
            [name]: value,
        }));
    };

    const handleSave = () => {
        router.put(route('profile.update'), formData, {
            onSuccess: () => {
                toast.success('Profil berhasil diperbarui!');
                setIsEditing(false);
            },
            onError: (errors) => {
                console.error('Update errors:', errors);
                toast.error('Gagal memperbarui profil');
            },
        });
    };

    const handleCancel = () => {
        setFormData({
            name: user.name,
            email: user.email,
            phone_number: user.phone_number || '',
        });
        setIsEditing(false);
    };

    const handlePasswordChange = (e: React.ChangeEvent<HTMLInputElement>) => {
        const { name, value } = e.target;
        setPasswordData((prev) => ({
            ...prev,
            [name]: value,
        }));
    };

    const handlePasswordSubmit = () => {
        if (passwordData.password !== passwordData.password_confirmation) {
            toast.error('Konfirmasi password tidak cocok');
            return;
        }

        router.put(route('password.update'), passwordData, {
            onSuccess: () => {
                toast.success('Password berhasil diubah!');
                setShowPasswordModal(false);
                setPasswordData({
                    current_password: '',
                    password: '',
                    password_confirmation: '',
                });
            },
            onError: (errors) => {
                console.error('Password update errors:', errors);
                if (errors.current_password) {
                    toast.error('Password saat ini salah');
                } else if (errors.password) {
                    toast.error('Password baru tidak valid');
                } else {
                    toast.error('Gagal mengubah password');
                }
            },
        });
    };

    const handleAvatarClick = () => {
        fileInputRef.current?.click();
    };

    const handleFileChange = async (e: React.ChangeEvent<HTMLInputElement>) => {
        const file = e.target.files?.[0];
        if (!file) return;

        // Validate file type
        if (!file.type.startsWith('image/')) {
            toast.error('Please select an image file');
            return;
        }

        // Validate file size (max 2MB)
        if (file.size > 2 * 1024 * 1024) {
            toast.error('File size must be less than 2MB');
            return;
        }

        setIsUploading(true);
        toast.loading('Uploading avatar...');

        try {
            const formData = new FormData();
            formData.append('avatar', file);

            // Use Inertia.js router for better error handling
            router.post(route('profile.avatar'), formData, {
                forceFormData: true,
                onSuccess: () => {
                    toast.success('Avatar updated successfully!');
                    router.reload();
                },
                onError: (errors) => {
                    console.error('Upload errors:', errors);
                    if (errors.avatar) {
                        toast.error(errors.avatar);
                    } else {
                        toast.error('Failed to upload avatar');
                    }
                },
                onFinish: () => {
                    setIsUploading(false);
                },
            });
        } catch (error) {
            console.error('Error uploading avatar:', error);
            toast.error('Failed to upload avatar');
            setIsUploading(false);
        }
    };

    const getInitials = (name: string) => {
        return name
            .split(' ')
            .map((word) => word.charAt(0))
            .join('')
            .toUpperCase()
            .slice(0, 2);
    };

    const formatDate = (dateString: string) => {
        return new Date(dateString).toLocaleDateString('id-ID', {
            year: 'numeric',
            month: 'long',
            day: 'numeric',
        });
    };

    return (
        <>
            <Head title="Profile" />
            <Layout>
                <div className="mx-auto max-w-4xl px-6 py-8">
                    <div className="mb-8">
                        <h1 className="text-3xl font-bold">Profile Saya</h1>
                        <p className="text-muted-foreground">Kelola informasi profil dan pengaturan akun Anda</p>
                    </div>

                    <div className="grid gap-6 lg:grid-cols-3">
                        {/* Profile Card */}
                        <div className="lg:col-span-1">
                            <Card className="p-6">
                                <div className="flex flex-col items-center text-center">
                                    <div className="relative mb-4">
                                        <Avatar className="h-24 w-24">
                                            <AvatarImage src={user.avatar} alt={user.name} />
                                            <AvatarFallback className="text-lg font-semibold">{getInitials(user.name)}</AvatarFallback>
                                        </Avatar>
                                        <Button
                                            size="sm"
                                            className="absolute -right-2 -bottom-2 h-8 w-8 rounded-full p-0"
                                            variant="secondary"
                                            onClick={handleAvatarClick}
                                            disabled={isUploading}
                                        >
                                            {isUploading ? (
                                                <div className="h-4 w-4 animate-spin rounded-full border-2 border-gray-300 border-t-gray-600"></div>
                                            ) : (
                                                <Camera className="h-4 w-4" />
                                            )}
                                        </Button>
                                        <input ref={fileInputRef} type="file" accept="image/*" onChange={handleFileChange} className="hidden" />
                                    </div>

                                    <h2 className="text-xl font-semibold">{user.name}</h2>

                                    <div className="mt-4 w-full space-y-2">
                                        <div className="flex items-center gap-2 text-sm text-muted-foreground">
                                            <Calendar className="h-4 w-4" />
                                            <span>Bergabung {formatDate(user.created_at)}</span>
                                        </div>
                                        <div className="flex items-center gap-2 text-sm text-muted-foreground">
                                            <Mail className="h-4 w-4" />
                                            <span>{user.email}</span>
                                        </div>
                                        {user.phone_number && (
                                            <div className="flex items-center gap-2 text-sm text-muted-foreground">
                                                <Phone className="h-4 w-4" />
                                                <span>{user.phone_number}</span>
                                            </div>
                                        )}
                                    </div>
                                </div>
                            </Card>
                        </div>

                        {/* Profile Form */}
                        <div className="lg:col-span-2">
                            <Card className="p-6">
                                <div className="mb-6 flex items-center justify-between">
                                    <h3 className="text-xl font-semibold">Informasi Profil</h3>
                                    {!isEditing ? (
                                        <Button variant="outline" size="sm" onClick={() => setIsEditing(true)}>
                                            <Edit3 className="mr-2 h-4 w-4" />
                                            Edit Profil
                                        </Button>
                                    ) : (
                                        <div className="flex gap-2">
                                            <Button variant="outline" size="sm" onClick={handleCancel}>
                                                <X className="mr-2 h-4 w-4" />
                                                Batal
                                            </Button>
                                            <Button size="sm" onClick={handleSave}>
                                                <Save className="mr-2 h-4 w-4" />
                                                Simpan
                                            </Button>
                                        </div>
                                    )}
                                </div>

                                <div className="space-y-4">
                                    <div className="grid gap-4 sm:grid-cols-2">
                                        <div className="space-y-2">
                                            <Label htmlFor="name">Nama Lengkap</Label>
                                            <Input
                                                id="name"
                                                name="name"
                                                value={formData.name}
                                                onChange={handleInputChange}
                                                disabled={!isEditing}
                                                placeholder="Masukkan nama lengkap"
                                            />
                                        </div>
                                        <div className="space-y-2">
                                            <Label htmlFor="email">Email</Label>
                                            <Input
                                                id="email"
                                                name="email"
                                                type="email"
                                                value={formData.email}
                                                onChange={handleInputChange}
                                                disabled={!isEditing}
                                                placeholder="Masukkan email"
                                            />
                                        </div>
                                    </div>

                                    <div className="space-y-2">
                                        <Label htmlFor="phone_number">Nomor Telepon</Label>
                                        <Input
                                            id="phone_number"
                                            name="phone_number"
                                            value={formData.phone_number}
                                            onChange={handleInputChange}
                                            disabled={!isEditing}
                                            placeholder="Masukkan nomor telepon"
                                        />
                                    </div>
                                </div>
                            </Card>

                            {/* Additional Information */}
                            <Card className="mt-6 p-6">
                                <h3 className="mb-4 text-xl font-semibold">Informasi Tambahan</h3>
                                <div className="grid gap-4 sm:grid-cols-2">
                                    <div className="space-y-2">
                                        <Label>Tanggal Bergabung</Label>
                                        <Input value={formatDate(user.created_at)} disabled className="bg-muted" />
                                    </div>
                                    <div className="space-y-2">
                                        <Label>Status Akun</Label>
                                        <Input value="Aktif" disabled className="bg-muted" />
                                    </div>
                                </div>
                            </Card>

                            {/* Action Buttons */}
                            <div className="mt-6 flex flex-wrap gap-3">
                                <Button variant="outline" onClick={() => setShowPasswordModal(true)}>
                                    Ubah Password
                                </Button>
                                <Button variant="outline">Download Data</Button>
                                <Button variant="destructive">Hapus Akun</Button>
                            </div>
                        </div>
                    </div>
                </div>

                {/* Password Change Modal */}
                <Dialog open={showPasswordModal} onOpenChange={setShowPasswordModal}>
                    <DialogContent className="sm:max-w-[425px]">
                        <DialogHeader>
                            <DialogTitle>Ubah Password</DialogTitle>
                        </DialogHeader>
                        <div className="space-y-4">
                            <div className="space-y-2">
                                <Label htmlFor="current_password">Password Saat Ini</Label>
                                <div className="relative">
                                    <Input
                                        id="current_password"
                                        name="current_password"
                                        type={showCurrentPassword ? 'text' : 'password'}
                                        value={passwordData.current_password}
                                        onChange={handlePasswordChange}
                                        placeholder="Masukkan password saat ini"
                                    />
                                    <Button
                                        type="button"
                                        variant="ghost"
                                        size="sm"
                                        className="absolute top-0 right-0 h-full px-3 py-2 hover:bg-transparent"
                                        onClick={() => setShowCurrentPassword(!showCurrentPassword)}
                                    >
                                        {showCurrentPassword ? <EyeOff className="h-4 w-4" /> : <Eye className="h-4 w-4" />}
                                    </Button>
                                </div>
                            </div>

                            <div className="space-y-2">
                                <Label htmlFor="password">Password Baru</Label>
                                <div className="relative">
                                    <Input
                                        id="password"
                                        name="password"
                                        type={showNewPassword ? 'text' : 'password'}
                                        value={passwordData.password}
                                        onChange={handlePasswordChange}
                                        placeholder="Masukkan password baru"
                                    />
                                    <Button
                                        type="button"
                                        variant="ghost"
                                        size="sm"
                                        className="absolute top-0 right-0 h-full px-3 py-2 hover:bg-transparent"
                                        onClick={() => setShowNewPassword(!showNewPassword)}
                                    >
                                        {showNewPassword ? <EyeOff className="h-4 w-4" /> : <Eye className="h-4 w-4" />}
                                    </Button>
                                </div>
                            </div>

                            <div className="space-y-2">
                                <Label htmlFor="password_confirmation">Konfirmasi Password Baru</Label>
                                <div className="relative">
                                    <Input
                                        id="password_confirmation"
                                        name="password_confirmation"
                                        type={showConfirmPassword ? 'text' : 'password'}
                                        value={passwordData.password_confirmation}
                                        onChange={handlePasswordChange}
                                        placeholder="Konfirmasi password baru"
                                    />
                                    <Button
                                        type="button"
                                        variant="ghost"
                                        size="sm"
                                        className="absolute top-0 right-0 h-full px-3 py-2 hover:bg-transparent"
                                        onClick={() => setShowConfirmPassword(!showConfirmPassword)}
                                    >
                                        {showConfirmPassword ? <EyeOff className="h-4 w-4" /> : <Eye className="h-4 w-4" />}
                                    </Button>
                                </div>
                            </div>

                            <div className="flex justify-end gap-2 pt-4">
                                <Button variant="outline" onClick={() => setShowPasswordModal(false)}>
                                    Batal
                                </Button>
                                <Button onClick={handlePasswordSubmit}>Simpan Password</Button>
                            </div>
                        </div>
                    </DialogContent>
                </Dialog>
            </Layout>
        </>
    );
}
