import { Button } from "@/components/ui/button"
import { Input } from "@/components/ui/input"
import { Card } from "@/components/ui/card"
import { Textarea } from "@/components/ui/textarea"
import { Calendar } from "@/components/ui/calendar"
import Layout from "@/layouts/layout"
import { useForm, usePage } from "@inertiajs/react"
import { Label } from "@/components/ui/label"
import { startOfDay } from "date-fns"
import { formatDate } from "@/lib/utils"

export default function PsychologistBooking() {
    const { props: { psychologist_id } }: { props: { psychologist_id: string } } = usePage();
    interface Data {
        psychologist_id: string;
        is_online: boolean;
        complaints: string;
        start_time: Date | undefined;
        end_time: Date | undefined;
    }

    const { data, setData, post, errors } = useForm<Data>({
        psychologist_id: psychologist_id,
        is_online: false,
        complaints: '',
        start_time: undefined,
        end_time: undefined,
    });

    //TODO fixing timepicker
    function handleTimePicker(input_name: keyof Data, e: React.ChangeEvent<HTMLInputElement>) {
        var dateTime = e.target.valueAsDate!;
        const updatedDate = data[input_name] as Date;
        updatedDate.setHours(dateTime.getHours() + dateTime.getTimezoneOffset());
        updatedDate.setMinutes(dateTime.getMinutes());

        setData(input_name, updatedDate);
    }

    function handleSubmit(e: React.FormEvent<HTMLFormElement>) {
        e.preventDefault();

        const payload = {
            ...data,
            start_time: formatDate(data.start_time!),
            end_time: formatDate(data.end_time!),
        }

        post(route("appointment.book", { data: payload }));
    }

    return (
        <Layout>
            <form name="createForm" onSubmit={handleSubmit}>
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
                                        type="button"
                                        variant={!data.is_online ? "default" : "outline"}
                                        onClick={(e) => setData("is_online", false)}
                                    >
                                        Offline
                                    </Button>
                                    <Button
                                        type="button"
                                        variant={data.is_online ? "default" : "outline"}
                                        onClick={(e) => setData("is_online", true)}
                                    >
                                        Online
                                    </Button>
                                </div>
                            </div>

                            <div className="space-y-2">
                                <label className="text-sm font-medium">Keluhan</label>
                                <Textarea
                                    className="h-full"
                                    placeholder="Tuliskan keluhan Anda"
                                    value={data.complaints}
                                    onChange={(e) => setData("complaints", e.target.value)} />
                            </div>
                        </div>
                    </div>

                    {/* Date picker */}
                    <div>
                        <h3 className="font-medium mb-2">Select Date</h3>
                        <Card className="p-4">
                            <Calendar
                                mode="single"
                                selected={data.start_time ? new Date(data.start_time) : new Date()}
                                onSelect={(e) => {
                                    console.log(e);
                                    setData("start_time", startOfDay(e!))
                                    setData("end_time", startOfDay(e!))
                                }}
                                className="rounded-md w-full"
                                required
                            />
                        </Card>
                    </div>

                    {/* Hours */}
                    <div>
                        <h3 className="font-medium mb-2">Select Hours</h3>
                        <div className="grid grid-cols-4 gap-3">

                            <div className='flex flex-col gap-3 col-span-2'>
                                <Label htmlFor='time-from' className='px-1'>
                                    From
                                </Label>
                                <Input
                                    className='bg-background appearance-none [&::-webkit-calendar-picker-indicator]:hidden [&::-webkit-calendar-picker-indicator]:appearance-none'
                                    type='time'
                                    id='time-from'
                                    step='1'
                                    defaultValue='00:00:00'
                                    onChange={(e) => handleTimePicker("start_time", e)}
                                    required
                                    disabled={!data.start_time}
                                />
                            </div>
                            <div className='flex flex-col gap-3 col-span-2'>
                                <Label htmlFor='time-to' className='px-1'>
                                    To
                                </Label>
                                <Input
                                    className='bg-background appearance-none [&::-webkit-calendar-picker-indicator]:hidden [&::-webkit-calendar-picker-indicator]:appearance-none'
                                    type='time'
                                    id='time-to'
                                    step='1'
                                    defaultValue='00:00:00'
                                    onChange={(e) => handleTimePicker("end_time", e)}
                                    required
                                    disabled={!data.end_time}
                                />
                            </div>
                        </div>
                    </div>

                    {/* Submit */}
                    <div className="flex justify-center">
                        <Button type="submit" className="px-8 py-2">Confirm Booking</Button>
                    </div>
                </div>
            </form>
        </Layout>
    )
}
