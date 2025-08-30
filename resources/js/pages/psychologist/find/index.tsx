import { useState } from "react";
import { Card } from "@/components/ui/card";
import { Button } from "@/components/ui/button";
import { Input } from "@/components/ui/input";
import { Select, SelectContent, SelectItem, SelectTrigger, SelectValue } from "@/components/ui/select";
import { Tabs, TabsList, TabsTrigger } from "@/components/ui/tabs";
import { ChevronLeft, ChevronRight } from "lucide-react";
import Layout from "@/layouts/layout";
import { Link, usePage } from "@inertiajs/react";

interface Psychologist {
    id: string;
    first_name: string;
    last_name: string;
    education: string;
    experience: string;
    description: string;
    created_at: string;
    updated_at: string;
}

interface ListOfPsychologist extends Omit<PaginationDto, "data"> {
    data: Psychologist[];
}

export default function PsychologistSchedule() {
    const [sort, setSort] = useState("default");
    const { props: { psychologists } }: { props: { psychologists: ListOfPsychologist } } = usePage();

    return (
        <Layout>
            <div className="flex max-w-screen-xl mx-auto gap-4 px-6 xl:px-0">
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
                        {psychologists.data.map((x, i) => (
                            <Card key={i} className="p-4 flex justify-between">
                                <div className="flex items-center gap-4">
                                    <div className="w-16 h-16 rounded-full bg-blue-200" />
                                    <div>
                                        <h3 className="font-bold text-lg">{x.first_name} {x.last_name}</h3>
                                        <span className="text-xs px-2 py-1 bg-gray-200 rounded-full">Kategori</span>
                                        <p className="text-sm text-gray-600">Jumlah Sesi • Ulasan • Pengalaman</p>
                                        <p className="text-sm text-blue-600">Jadwal Tersedia</p>
                                    </div>
                                </div>
                                <Button asChild>
                                    <Link href={route('psychologist.detail', { id: x.id })}>
                                        Booking Sesi
                                    </Link>
                                </Button>
                            </Card>
                        ))}
                    </div>

                    {/* Pagination */}
                    <div className="flex justify-center items-center gap-2 mt-4">
                        <Button
                            variant="outline"
                            size="icon"
                            disabled={psychologists.current_page === 1}>
                            <Link href={route("psychologist.find", { page: psychologists.current_page - 1 })}>
                                <ChevronLeft />
                            </Link>
                        </Button>
                        {Array.from({ length: psychologists.last_page }).map((_, i) => {
                            const page = i + 1;
                            const current = psychologists.current_page;

                            // Always show:
                            // - first page
                            // - last page
                            // - current page
                            // - 2 pages before/after current
                            // Hide others, but insert ellipsis where needed
                            if (
                                page === 1 ||
                                page === psychologists.last_page ||
                                (page >= current - 2 && page <= current + 2)
                            ) {
                                return (
                                    <Button
                                        key={page}
                                        variant={page === current ? "default" : "outline"}
                                        asChild
                                    >
                                        <Link href={route("psychologist.find", { page })}>{page}</Link>
                                    </Button>
                                );
                            }

                            if (
                                (page === psychologists.last_page - 1 && current < psychologists.last_page - 3) ||
                                (page === 2 && current > 4)
                            ) {
                                return <Button key="ellipsis" variant={"outline"} disabled>...</Button>
                            }

                            return null;
                        })}
                        <Button
                            variant="outline"
                            size="icon"
                            disabled={psychologists.current_page === psychologists.last_page}>
                            <Link href={route("psychologist.find", { page: psychologists.current_page + 1 })}>
                                <ChevronRight />
                            </Link>
                        </Button>
                    </div>
                </main>
            </div>
        </Layout>
    );
}
