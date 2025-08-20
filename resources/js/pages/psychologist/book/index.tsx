import { useState } from "react"
import { Button } from "@/components/ui/button"
import { Input } from "@/components/ui/input"
import { Card } from "@/components/ui/card"
import { Textarea } from "@/components/ui/textarea"
import { Calendar } from "@/components/ui/calendar"
import Layout from "@/layouts/layout"

export default function PsychologistBooking() {
    const [date, setDate] = useState<Date | undefined>(new Date())
    const [selectedHour, setSelectedHour] = useState<string | null>(null)
    const [consultation, setConsultation] = useState<"online" | "offline">("online")

    const hours = [
        "08:00", "09:00", "10:00", "11:00",
        "13:00", "14:00", "15:00", "16:00"
    ]

    return (
        <Layout>
            <div className="w-full max-w-4xl mx-auto space-y-6 p-6">
                {/* Top Section */}
                <div className="grid grid-cols-1 md:grid-cols-3 gap-6">
                    {/* Profile card */}
                    <Card className="flex flex-col items-center justify-center p-4">
                        <div className="w-24 h-24 rounded-full bg-blue-100" />
                        <h2 className="mt-4 font-semibold">Lorem Ipsum</h2>
                        <div className="flex flex-col gap-2 mt-2">
                            <Button variant="outline" size="sm">Lorem ipsum</Button>
                            <Button variant="outline" size="sm">Lorem ipsum</Button>
                            <Button variant="outline" size="sm">Lorem ipsum</Button>
                        </div>
                    </Card>

                    {/* Form fields */}
                    <div className="md:col-span-2 space-y-4 flex flex-col">
                        <div className="space-y-2">
                            <label className="text-sm font-medium">Name</label>
                            <Input placeholder="Your name" />
                        </div>

                        <div className="space-y-2">
                            <label className="text-sm font-medium">Birthday</label>
                            <Input type="date" />
                        </div>

                        <div className="space-y-2">
                            <label className="text-sm font-medium">Jenis Konsultasi</label>
                            <div className="flex gap-2">
                                <Button
                                    variant={consultation === "offline" ? "default" : "outline"}
                                    onClick={() => setConsultation("offline")}
                                >
                                    Offline
                                </Button>
                                <Button
                                    variant={consultation === "online" ? "default" : "outline"}
                                    onClick={() => setConsultation("online")}
                                >
                                    Online
                                </Button>
                            </div>
                        </div>

                        <div className="space-y-2">
                            <label className="text-sm font-medium">Keluhan</label>
                            <Textarea className="h-full" placeholder="Tuliskan keluhan Anda" />
                        </div>
                    </div>
                </div>

                {/* Date picker */}
                <div>
                    <h3 className="font-medium mb-2">Select Date</h3>
                    <Card className="p-4">
                        <Calendar
                            mode="single"
                            selected={date}
                            onSelect={setDate}
                            className="rounded-md w-full"
                        />
                    </Card>
                </div>

                {/* Hours */}
                <div>
                    <h3 className="font-medium mb-2">Select Hours</h3>
                    <div className="grid grid-cols-4 gap-3">
                        {hours.map((h) => (
                            <Button
                                key={h}
                                variant={selectedHour === h ? "default" : "outline"}
                                onClick={() => setSelectedHour(h)}
                                className="w-full"
                            >
                                {h}
                            </Button>
                        ))}
                    </div>
                </div>

                {/* Submit */}
                <div className="flex justify-center">
                    <Button className="px-8 py-2">Confirm Booking</Button>
                </div>
            </div>
        </Layout>
    )
}
