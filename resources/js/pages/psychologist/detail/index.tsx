import { Badge } from '@/components/ui/badge';
import { Button } from '@/components/ui/button';
import { Card } from '@/components/ui/card';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import { Textarea } from '@/components/ui/textarea';
import Layout from '@/layouts/layout';
import { usePage } from '@inertiajs/react';
import { useState } from 'react';

interface Psychologist {
    id: string;
    first_name: string;
    last_name: string;
    education: string;
    experience: string;
    description: string;
    locations: Location[];
    specializations: Specialization[];
}

interface Location {
    location_name: string;
}

interface Specialization {
    specialization_name: string;
}

export default function PsychologistDetail() {
    const {
        props: { psychologist },
    }: { props: { psychologist: Psychologist } } = usePage();

    // Booking form state
    const [name, setName] = useState('');
    const [birthday, setBirthday] = useState('');
    const [type, setType] = useState<'online' | 'offline'>('online');
    const [complaint, setComplaint] = useState('');
    const [date, setDate] = useState('');
    const [time, setTime] = useState('');

    const times = ['09:00', '10:00', '11:00', '12:00', '13:00', '14:00', '15:00', '16:00', '17:00', '18:00'];

    const submitBooking = () => {
        // integrate with API later; just placeholder action
        if (!date || !time) return;
        alert(`Booking submitted for ${psychologist.first_name} ${psychologist.last_name} on ${date} at ${time}`);
    };

    return (
        <Layout>
            <div className="mx-auto max-w-screen-xl space-y-6 px-6 xl:px-0">
                {/* Booking Info Section */}
                <section className="grid grid-cols-1 gap-6 rounded-lg border bg-primary/5 p-6 md:grid-cols-[280px_1fr]">
                    {/* Profile Sidebar */}
                    <Card className="p-4 text-center">
                        <div className="mx-auto h-28 w-28 rounded-full bg-blue-200" />
                        <div className="mt-4 font-semibold">
                            {psychologist.first_name} {psychologist.last_name}
                        </div>
                        <div className="mt-3 flex flex-wrap justify-center gap-2 text-xs">
                            {psychologist.specializations.slice(0, 3).map((s, i) => (
                                <Badge key={i} variant="secondary">
                                    {s.specialization_name}
                                </Badge>
                            ))}
                        </div>
                        <div className="mt-4 text-xs text-muted-foreground">Lorem Ipsum</div>
                    </Card>

                    {/* Form */}
                    <div className="space-y-4">
                        <h2 className="text-2xl font-bold">Booking Info</h2>
                        <div className="grid grid-cols-1 gap-4 sm:grid-cols-2">
                            <div className="space-y-1">
                                <Label>Name</Label>
                                <Input value={name} onChange={(e) => setName(e.target.value)} placeholder="Your full name" />
                            </div>
                            <div className="space-y-1">
                                <Label>Birthday</Label>
                                <Input type="date" value={birthday} onChange={(e) => setBirthday(e.target.value)} />
                            </div>
                        </div>
                        <div className="space-y-1">
                            <Label>Jenis Konsultasi</Label>
                            <div className="flex gap-3">
                                <Button
                                    type="button"
                                    variant={type === 'offline' ? 'default' : 'outline'}
                                    onClick={() => setType('offline')}
                                    className="flex-1"
                                >
                                    Offline
                                </Button>
                                <Button
                                    type="button"
                                    variant={type === 'online' ? 'default' : 'outline'}
                                    onClick={() => setType('online')}
                                    className="flex-1"
                                >
                                    Online
                                </Button>
                            </div>
                        </div>
                        <div className="space-y-1">
                            <Label>Keluhan</Label>
                            <Textarea
                                value={complaint}
                                onChange={(e) => setComplaint(e.target.value)}
                                placeholder="Describe your concern..."
                                className="min-h-[110px]"
                            />
                        </div>

                        <div className="space-y-4">
                            <div className="rounded-xl border bg-primary/10 p-4">
                                <div className="mb-2 font-semibold">Select Date</div>
                                <Input type="date" value={date} onChange={(e) => setDate(e.target.value)} />
                            </div>

                            <div>
                                <div className="mb-2 font-semibold">Select Hours</div>
                                <div className="grid grid-cols-2 gap-2 sm:grid-cols-5">
                                    {times.map((t) => (
                                        <Button key={t} type="button" variant={time === t ? 'default' : 'outline'} onClick={() => setTime(t)}>
                                            {t}
                                        </Button>
                                    ))}
                                </div>
                            </div>

                            <div className="flex justify-center pt-2">
                                <Button disabled={!date || !time} onClick={submitBooking}>
                                    Confirm Booking
                                </Button>
                            </div>
                        </div>
                    </div>
                </section>
            </div>
        </Layout>
    );
}
