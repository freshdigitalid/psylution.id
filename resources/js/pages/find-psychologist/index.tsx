import { useState } from "react";
import { Card } from "@/components/ui/card";
import { Button } from "@/components/ui/button";
import { Input } from "@/components/ui/input";
import { Select, SelectContent, SelectItem, SelectTrigger, SelectValue } from "@/components/ui/select";
import { Tabs, TabsList, TabsTrigger } from "@/components/ui/tabs";
import { ChevronLeft, ChevronRight } from "lucide-react";
import Layout from "@/layouts/layout";

export default function PsychologistSchedule() {
    const [sort, setSort] = useState("default");

    return (
        <Layout>
            <div className="flex max-w-screen-xl mx-auto gap-4 py-20 px-6 xl:px-0 min-h">
                {/* Sidebar */}
                <aside className="w-64 space-y-4">
                    <Card className="p-4">
                        <h2 className="font-bold text-lg mb-2">Categories</h2>
                        <ul className="space-y-1 text-sm">
                            {Array.from({ length: 10 }).map((_, i) => (
                                <li key={i} className="cursor-pointer hover:underline">Lorem Ipsum</li>
                            ))}
                        </ul>
                    </Card>

                    <Card className="p-4">
                        <h2 className="font-bold text-lg mb-2">Sort By</h2>
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
                        <TabsList className="grid grid-cols-2 w-full">
                            <TabsTrigger value="all">Semua Hari</TabsTrigger>
                            <TabsTrigger value="time">Semua Waktu</TabsTrigger>
                        </TabsList>
                    </Tabs>

                    {/* Cards */}
                    <div className="space-y-4">
                        {Array.from({ length: 4 }).map((_, i) => (
                            <Card key={i} className="p-4 flex justify-between">
                                <div className="flex items-center gap-4">
                                    <div className="w-16 h-16 rounded-full bg-blue-200" />
                                    <div>
                                        <span className="text-xs px-2 py-1 bg-gray-200 rounded-full">Kategori</span>
                                        <h3 className="font-bold text-lg">Lorem Ipsum</h3>
                                        <p className="text-sm text-gray-600">Jumlah Sesi • Ulasan • Pengalaman</p>
                                        <p className="text-sm text-blue-600">Jadwal Tersedia</p>
                                    </div>
                                </div>
                                <Button>Booking Sesi</Button>
                            </Card>
                        ))}
                    </div>

                    {/* Pagination */}
                    <div className="flex justify-center items-center gap-2 mt-4">
                        <Button variant="outline" size="icon"><ChevronLeft /></Button>
                        {Array.from({ length: 5 }).map((_, i) => (
                            <Button key={i} variant={i === 1 ? "default" : "outline"}>{i + 1}</Button>
                        ))}
                        <Button variant="outline" size="icon"><ChevronRight /></Button>
                    </div>
                </main>
            </div>
        </Layout>
    );
}
