import { Head } from '@inertiajs/react';
import { useState } from 'react';
import Navbar from '@/components/navbar/navbar';
import Footer from '@/components/footer';
import UserProfileCard from '@/components/booking/user-profile-card';
import DatePicker from '@/components/booking/date-picker';
import TimeSlotPicker from '@/components/booking/time-slot-picker';
import { Button } from '@/components/ui/button';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import { Textarea } from '@/components/ui/textarea';

const BookingPage = () => {
    const [formData, setFormData] = useState({
        name: '',
        birthday: '',
        consultationType: 'online' as 'online' | 'offline',
        complaint: ''
    });

    const [selectedDate, setSelectedDate] = useState<Date | null>(null);
    const [selectedTime, setSelectedTime] = useState<string | null>(null);

    const handleInputChange = (field: string, value: string) => {
        setFormData(prev => ({
            ...prev,
            [field]: value
        }));
    };

    const handleConsultationTypeChange = (type: 'online' | 'offline') => {
        setFormData(prev => ({
            ...prev,
            consultationType: type
        }));
    };

    const handleSubmit = async () => {
        if (!selectedDate || !selectedTime) {
            alert('Please select a date and time');
            return;
        }

        const bookingData = {
            ...formData,
            date: selectedDate,
            time: selectedTime
        };

        try {
            const response = await fetch('/api/bookings', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || ''
                },
                body: JSON.stringify(bookingData)
            });

            if (response.ok) {
                // Redirect to payment success page
                window.location.href = '/payment/success';
            } else {
                const error = await response.json();
                alert(error.message || 'Booking failed');
            }
        } catch (error) {
            console.error('Booking error:', error);
            alert('An error occurred while booking');
        }
    };

    return (
        <>
            <Head title="Booking Info" />
            
            <div className="min-h-screen bg-white">
                <Navbar />
                
                {/* Header */}
                <div className="bg-blue-50 py-8">
                    <div className="max-w-7xl mx-auto px-4">
                        <h1 className="text-3xl font-bold text-blue-900 text-center">
                            Booking Info
                        </h1>
                    </div>
                </div>

                {/* Main Content */}
                <div className="max-w-7xl mx-auto px-4 py-12">
                    <div className="grid lg:grid-cols-3 gap-8">
                        {/* Left Panel - User Profile */}
                        <div className="lg:col-span-1">
                            <UserProfileCard />
                        </div>

                        {/* Right Panel - Booking Form */}
                        <div className="lg:col-span-2 space-y-8">
                            {/* Booking Form */}
                            <div className="bg-white rounded-xl border p-6 space-y-6">
                                <h2 className="text-xl font-semibold text-gray-900">Booking Information</h2>
                                
                                {/* Name Input */}
                                <div className="space-y-2">
                                    <Label htmlFor="name">Name</Label>
                                    <Input
                                        id="name"
                                        value={formData.name}
                                        onChange={(e) => handleInputChange('name', e.target.value)}
                                        placeholder="Enter your full name"
                                        className="rounded-lg"
                                    />
                                </div>

                                {/* Birthday Input */}
                                <div className="space-y-2">
                                    <Label htmlFor="birthday">Birthday</Label>
                                    <Input
                                        id="birthday"
                                        type="date"
                                        value={formData.birthday}
                                        onChange={(e) => handleInputChange('birthday', e.target.value)}
                                        className="rounded-lg"
                                    />
                                </div>

                                {/* Consultation Type */}
                                <div className="space-y-2">
                                    <Label>Jenis Konsultasi</Label>
                                    <div className="flex gap-4">
                                        <Button
                                            variant={formData.consultationType === 'offline' ? 'default' : 'outline'}
                                            onClick={() => handleConsultationTypeChange('offline')}
                                            className="flex-1 rounded-lg"
                                        >
                                            Offline
                                        </Button>
                                        <Button
                                            variant={formData.consultationType === 'online' ? 'default' : 'outline'}
                                            onClick={() => handleConsultationTypeChange('online')}
                                            className="flex-1 rounded-lg"
                                        >
                                            Online
                                        </Button>
                                    </div>
                                </div>

                                {/* Complaint */}
                                <div className="space-y-2">
                                    <Label htmlFor="complaint">Keluhan</Label>
                                    <Textarea
                                        id="complaint"
                                        value={formData.complaint}
                                        onChange={(e) => handleInputChange('complaint', e.target.value)}
                                        placeholder="Describe your concerns or issues..."
                                        className="rounded-lg min-h-[100px]"
                                    />
                                </div>
                            </div>

                            {/* Date Picker */}
                            <DatePicker
                                selectedDate={selectedDate}
                                onDateSelect={setSelectedDate}
                            />

                            {/* Time Slot Picker */}
                            <TimeSlotPicker
                                selectedTime={selectedTime}
                                onTimeSelect={setSelectedTime}
                            />

                            {/* Confirm Booking Button */}
                            <div className="flex justify-center pt-6">
                                <Button
                                    onClick={handleSubmit}
                                    className="bg-blue-600 hover:bg-blue-700 text-white px-8 py-3 rounded-lg font-medium"
                                    disabled={!selectedDate || !selectedTime}
                                >
                                    Confirm Booking
                                </Button>
                            </div>
                        </div>
                    </div>
                </div>

                <Footer />
            </div>
        </>
    );
};

export default BookingPage; 