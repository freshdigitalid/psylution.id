import { Button } from "@/components/ui/button"
import { Input } from "@/components/ui/input"
import { Card, CardContent, CardHeader, CardTitle } from "@/components/ui/card"
import { Textarea } from "@/components/ui/textarea"
import { Calendar } from "@/components/ui/calendar"
import Layout from "@/layouts/layout"
import { router, useForm, usePage } from "@inertiajs/react"
import { format, startOfDay } from "date-fns"
import { formatDate } from "@/lib/utils"
import { SharedData } from "@/types"
import { Badge } from "@/components/ui/badge"
import { useEffect } from "react"

interface PsychologistBookingProps extends SharedData {
    psychologist: PsychologistProps;
    patient: PatientProps;
    schedules: ScheduleProps[];
    packages: PackageProps[];
}

interface PsychologistProps {
    id: string;
    first_name: string;
    last_name: string;
    specializations: SpecializationProps[];
}

interface PatientProps {
    id: string;
    first_name: string;
    last_name: string;
    dob: string;
}

interface SpecializationProps {
    specialization_name: string;
}

interface PackageProps {
    id: string;
    title: string;
    price: number;
}

interface ScheduleProps {
    start_time: string;
    end_time: string;
}


export default function PsychologistBooking() {
    const { psychologist, patient, schedules, packages } = usePage<PsychologistBookingProps>().props;

    interface Data {
        psychologist_id: string;
        is_online: boolean;
        complaints: string;
        start_time: Date | undefined;
        end_time: Date | undefined;
        package_detail_id: string | undefined;
    }

    const { data, setData, post, errors, transform, processing } = useForm<Data>({
        psychologist_id: psychologist.id,
        is_online: false,
        complaints: '',
        start_time: undefined,
        end_time: undefined,
        package_detail_id: undefined,
    });

    function handleSubmit(e: React.FormEvent<HTMLFormElement>) {
        e.preventDefault();

        transform((data) => ({
            ...data,
            start_time: formatDate(data.start_time!),
            end_time: formatDate(data.end_time!),
        }));

        post(route("appointment.book"));
    }

    useEffect(() => {
        const params = new URLSearchParams(window.location.search);
        if(params.get('start_date')) {
            setData("start_time", new Date(params.get('start_date')!))
            setData("end_time", new Date(params.get('start_date')!))
        }
    
    }, []);

    return (
        <Layout>
            <form name="createForm" onSubmit={handleSubmit}>
                <div className="w-full max-w-4xl mx-auto space-y-6 p-6">
                    {/* Top Section */}
                    <div className="grid grid-cols-1 md:grid-cols-3 gap-6">
                        {/* Profile card */}
                        <Card className="flex flex-col items-center justify-center p-4">
                            <div className="w-24 h-24 rounded-full bg-blue-100" />
                            <h1 className="text-2xl font-bold">{psychologist.first_name} {psychologist.last_name}</h1>

                            <div>
                                <p className="text-gray-600">Specialization</p>
                                <div className="flex flex-wrap gap-2 mt-1">
                                    {psychologist.specializations.map((specialization, index) => (
                                        <Badge key={index} variant="secondary">{specialization.specialization_name}</Badge>
                                    ))}
                                </div>
                            </div>
                            {/* <div className="flex flex-col gap-2 mt-2"> */}
                            {/* <Button variant="outline" size="sm">Sesi</Button> */}
                            {/* <Button variant="outline" size="sm">Ulasan</Button> */}
                            {/* <Button variant="outline" size="sm">Tahun?</Button> */}
                            {/* </div> */}
                        </Card>

                        {/* Form fields */}
                        <div className="md:col-span-2 space-y-4 flex flex-col">
                            <div className="space-y-2">
                                <label className="text-sm font-medium">Name</label>
                                <Input
                                    placeholder="Your name"
                                    defaultValue={patient.first_name + ' ' + patient.last_name}
                                    disabled
                                />
                            </div>

                            <div className="space-y-2">
                                <label className="text-sm font-medium">Birthday</label>
                                <Input
                                    type="date"
                                    defaultValue={format(new Date(patient.dob), 'yyyy-MM-dd')}
                                    disabled
                                />
                            </div>

                            <div className="space-y-2">
                                <label className="text-sm font-medium">Jenis Konsultasi</label>
                                <div className="flex gap-2">
                                    <Button
                                        type="button"
                                        variant={!data.is_online ? "default" : "outline"}
                                        onClick={(e) => {
                                            setData("is_online", false)
                                            router.get(
                                                route("psychologist.book", psychologist.id),
                                                {
                                                    is_online: false,
                                                    start_date: data.start_time ? startOfDay(data.start_time) : undefined,
                                                },
                                                {
                                                    preserveState: true,
                                                    preserveScroll: true,
                                                }
                                            )
                                        }}
                                    >
                                        Offline
                                    </Button>
                                    <Button
                                        type="button"
                                        variant={data.is_online ? "default" : "outline"}
                                        onClick={(e) => {
                                            setData("is_online", true)
                                            router.get(
                                                route("psychologist.book", psychologist.id),
                                                {
                                                    is_online: true,
                                                    start_date: data.start_time ? startOfDay(data.start_time) : undefined,
                                                },
                                                {
                                                    preserveState: true,
                                                    preserveScroll: true,
                                                }
                                            )
                                        }}
                                    >
                                        Online
                                    </Button>
                                </div>
                            </div>

                            <div className="space-y-2">
                                <label className="text-sm font-medium">Keluhan</label>
                                <Textarea
                                    placeholder="Tuliskan keluhan Anda"
                                    value={data.complaints}
                                    onChange={(e) => setData("complaints", e.target.value)} />
                            </div>
                        </div>
                    </div>

                    {/* Package */}
                    <div>
                        <h3 className="font-medium mb-2">Select Package</h3>
                        <div className="flex gap-2">
                            {packages.length === 0 && (
                                <p className="text-sm text-gray-500 col-span-full">No available package for this psychology.</p>
                            )}
                            {packages.map((s, i) => (
                                <Button
                                    key={i}
                                    type="button"
                                    className="h-full"
                                    onClick={(e) => setData("package_detail_id", s.id)}
                                    variant={data.package_detail_id === s.id
                                        ? 'default' 
                                        : 'outline'
                                    } 
                                    asChild>
                                    <Card className="p-4">
                                        <CardHeader>
                                        <CardTitle>{s.title}</CardTitle>
                                        </CardHeader>
                                        <CardContent>
                                            <p>Rp {s.price?.toLocaleString('id-ID')}</p>
                                        </CardContent>
                                    </Card>
                                </Button>
                            ))}
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
                                    setData("start_time", startOfDay(e!))
                                    setData("end_time", startOfDay(e!))
                                    router.get(
                                        route("psychologist.book", psychologist.id), 
                                        {
                                            is_online: data.is_online,
                                            start_date: startOfDay(e!),
                                        },
                                        {
                                            preserveState: true,
                                            preserveScroll: true,
                                        }
                                    )
                                }}
                                className="rounded-md w-full"
                                required
                                disabled={[
                                    { before: new Date() }
                                ]}
                            />
                            {errors.start_time && (
                                <div className="text-red-600 text-sm">{errors.start_time}</div>
                            )}
                        </Card>
                    </div>

                    {/* Hours */}
                    <div>
                        <h3 className="font-medium mb-2">Select Hours</h3>
                        <div className="grid grid-cols-2 gap-2 sm:grid-cols-5">
                            {schedules.length === 0 && (
                                <p className="text-sm text-gray-500 col-span-full">No available schedules for the selected date.</p>
                            )}
                            {schedules.map((s, i) => (
                                <Button
                                    key={i}
                                    type="button"
                                    variant={new Date(s.start_time).toISOString() === data.start_time?.toISOString() 
                                        ? 'default' 
                                        : 'outline'
                                    }
                                    onClick={(e) => {
                                        setData("start_time", new Date(s.start_time))
                                        setData("end_time", new Date(s.end_time))
                                    }}>
                                    {new Date(s.start_time).toLocaleTimeString("en-GB", { hour: "2-digit", minute: "2-digit" })} - {new Date(s.end_time).toLocaleTimeString("en-GB", { hour: "2-digit", minute: "2-digit" })}
                                </Button>
                            ))}
                        </div>
                    </div>

                    {/* Submit */}
                    <div className="flex justify-center">
                        <Button type="submit" className="px-8 py-2" disabled={processing}>Confirm Booking</Button>
                    </div>
                </div>
            </form>
        </Layout>
    )
}
