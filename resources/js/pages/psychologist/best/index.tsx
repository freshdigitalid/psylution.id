import { Card } from "@/components/ui/card";
import { Button } from "@/components/ui/button";
import { ChevronLeft, ChevronRight } from "lucide-react";
import Layout from "@/layouts/layout";

export default function BestPsychologist() {
    return (
        <Layout>
            <div className="max-w-screen-xl mx-auto px-6 xl:px-0 space-y-8">
                {/* Best Psychologists Section */}
                <section>
                    <Card className="p-6 bg-blue-50 border-blue-200 space-y-6">
                        <h2 className="text-xl font-bold text-center">Psikolog Terbaik Kami</h2>
                        <div className="grid grid-cols-1 md:grid-cols-3 gap-6">
                            {Array.from({ length: 3 }).map((_, i) => (
                                <Card key={i} className="p-4 text-center flex flex-col items-center space-y-3">
                                    <div className="w-20 h-20 rounded-full bg-blue-200" />
                                    <div className="text-sm text-gray-600">
                                        Lorem ipsum dolor sit amet consectetur. Ut viverra volutpat velit vitae vehicula. Lectus varius ut et consequat nunc donec nulla aliquam.
                                    </div>
                                    <Button>Booking Sesi</Button>
                                </Card>
                            ))}
                        </div>
                    </Card>
                </section>

                {/* All Psychologists Section */}
                <section>
                    <h2 className="text-xl font-bold mb-4 text-center">Psikolog Kami</h2>
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
                    <div className="flex justify-center items-center gap-2 mt-6">
                        <Button variant="outline" size="icon"><ChevronLeft /></Button>
                        {Array.from({ length: 5 }).map((_, i) => (
                            <Button key={i} variant={i === 1 ? "default" : "outline"}>{i + 1}</Button>
                        ))}
                        <Button variant="outline" size="icon"><ChevronRight /></Button>
                    </div>
                </section>
            </div>
        </Layout>
    );
}
