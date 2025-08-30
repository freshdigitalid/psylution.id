import { Button } from '@/components/ui/button';
import { Card } from '@/components/ui/card';
import { Input } from '@/components/ui/input';
import { Select, SelectContent, SelectItem, SelectTrigger, SelectValue } from '@/components/ui/select';
import { Tabs, TabsList, TabsTrigger } from '@/components/ui/tabs';
import Layout from '@/layouts/layout';
import { Link } from '@inertiajs/react';
import { ChevronLeft, ChevronRight } from 'lucide-react';
import { useState } from 'react';

export default function PsychologistSchedule() {
    const [setSort] = useState('default');

    // Mock data for psychologists
    const psychologists = [
        {
            id: 1,
            name: 'Dr. Sarah Johnson',
            category: 'Konseling Individual',
            sessions: 150,
            reviews: 4.8,
            experience: '5 tahun',
            schedule: 'Senin - Jumat, 09:00 - 17:00',
            avatar: '/avatars/sarah.jpg',
        },
        {
            id: 2,
            name: 'Dr. Michael Chen',
            category: 'Konseling Keluarga',
            sessions: 200,
            reviews: 4.9,
            experience: '8 tahun',
            schedule: 'Selasa - Sabtu, 10:00 - 18:00',
            avatar: '/avatars/michael.jpg',
        },
        {
            id: 3,
            name: 'Dr. Lisa Rodriguez',
            category: 'Konseling Pasangan',
            sessions: 120,
            reviews: 4.7,
            experience: '6 tahun',
            schedule: 'Rabu - Minggu, 14:00 - 20:00',
            avatar: '/avatars/lisa.jpg',
        },
        {
            id: 4,
            name: 'Dr. Ahmad Rahman',
            category: 'Konseling Individual',
            sessions: 180,
            reviews: 4.8,
            experience: '7 tahun',
            schedule: 'Senin - Jumat, 08:00 - 16:00',
            avatar: '/avatars/ahmad.jpg',
        },
    ];

    return (
        <Layout>
            <div className="mx-auto flex max-w-screen-xl gap-4 px-6 py-20 xl:px-0">
                {/* Sidebar */}
                <aside className="w-64 space-y-4">
                    <Card className="p-4">
                        <h2 className="mb-2 text-lg font-bold">Categories</h2>
                        <ul className="space-y-1 text-sm">
                            <li className="cursor-pointer hover:underline">Konseling Individual</li>
                            <li className="cursor-pointer hover:underline">Konseling Keluarga</li>
                            <li className="cursor-pointer hover:underline">Konseling Pasangan</li>
                            <li className="cursor-pointer hover:underline">Terapi Anak</li>
                            <li className="cursor-pointer hover:underline">Konseling Karir</li>
                            <li className="cursor-pointer hover:underline">Terapi Trauma</li>
                            <li className="cursor-pointer hover:underline">Konseling Adiksi</li>
                            <li className="cursor-pointer hover:underline">Terapi Depresi</li>
                            <li className="cursor-pointer hover:underline">Konseling Kecemasan</li>
                            <li className="cursor-pointer hover:underline">Terapi Gangguan Makan</li>
                        </ul>
                    </Card>

                    <Card className="p-4">
                        <h2 className="mb-2 text-lg font-bold">Sort By</h2>
                        <Select onValueChange={setSort} defaultValue="default">
                            <SelectTrigger>
                                <SelectValue placeholder="Default" />
                            </SelectTrigger>
                            <SelectContent>
                                <SelectItem value="default">Default</SelectItem>
                                <SelectItem value="low-to-high">Lowest to Highest Price</SelectItem>
                                <SelectItem value="high-to-low">Highest to Lowest Price</SelectItem>
                                <SelectItem value="rating">Highest Rating</SelectItem>
                                <SelectItem value="a-z">Name A-Z</SelectItem>
                                <SelectItem value="z-a">Name Z-A</SelectItem>
                            </SelectContent>
                        </Select>
                    </Card>
                </aside>

                {/* Main Content */}
                <main className="flex-1 space-y-4">
                    {/* Search */}
                    <div className="flex gap-2">
                        <Input placeholder="Nama Psikolog" className="flex-1" />
                        <Button variant="default">Search</Button>
                    </div>

                    {/* Filter Tabs */}
                    <Tabs defaultValue="all" className="w-full">
                        <TabsList className="grid w-full grid-cols-2">
                            <TabsTrigger value="all">Semua Hari</TabsTrigger>
                            <TabsTrigger value="time">Semua Waktu</TabsTrigger>
                        </TabsList>
                    </Tabs>

                    {/* Cards */}
                    <div className="space-y-4">
                        {psychologists.map((psychologist) => (
                            <Card key={psychologist.id} className="flex justify-between p-4">
                                <div className="flex items-center gap-4">
                                    <div className="flex h-16 w-16 items-center justify-center rounded-full bg-blue-200 font-semibold text-blue-600">
                                        {psychologist.name
                                            .split(' ')
                                            .map((n) => n[0])
                                            .join('')}
                                    </div>
                                    <div>
                                        <span className="rounded-full bg-gray-200 px-2 py-1 text-xs">{psychologist.category}</span>
                                        <h3 className="text-lg font-bold">{psychologist.name}</h3>
                                        <p className="text-sm text-gray-600">
                                            {psychologist.sessions} Sesi • ⭐ {psychologist.reviews} • {psychologist.experience} Pengalaman
                                        </p>
                                        <p className="text-sm text-blue-600">{psychologist.schedule}</p>
                                    </div>
                                </div>
                                <div className="flex flex-col gap-2">
                                    <Button asChild>
                                        <Link href={route('booking')}>Booking Sesi</Link>
                                    </Button>
                                    <Button variant="outline" size="sm">
                                        Lihat Detail
                                    </Button>
                                </div>
                            </Card>
                        ))}
                    </div>

                    {/* Pagination */}
                    <div className="mt-4 flex items-center justify-center gap-2">
                        <Button variant="outline" size="icon">
                            <ChevronLeft />
                        </Button>
                        {Array.from({ length: 5 }).map((_, i) => (
                            <Button key={i} variant={i === 1 ? 'default' : 'outline'}>
                                {i + 1}
                            </Button>
                        ))}
                        <Button variant="outline" size="icon">
                            <ChevronRight />
                        </Button>
                    </div>
                </main>
            </div>
        </Layout>
    );
}
