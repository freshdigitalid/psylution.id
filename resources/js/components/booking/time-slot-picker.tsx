import { Button } from '@/components/ui/button';
import { cn } from '@/lib/utils';

interface TimeSlotPickerProps {
    selectedTime: string | null;
    onTimeSelect: (time: string) => void;
    availableSlots?: string[];
    className?: string;
}

const TimeSlotPicker = ({ selectedTime, onTimeSelect, availableSlots = [], className }: TimeSlotPickerProps) => {
    // Default time slots from 9 AM to 6 PM
    const defaultTimeSlots = ['09:00', '10:00', '11:00', '12:00', '13:00', '14:00', '15:00', '16:00', '17:00', '18:00'];

    const timeSlots = availableSlots.length > 0 ? availableSlots : defaultTimeSlots;

    return (
        <div className={cn('space-y-4', className)}>
            <h3 className="text-lg font-semibold text-gray-900">Select Hours</h3>
            <div className="grid grid-cols-5 gap-3">
                {timeSlots.map((time) => (
                    <Button
                        key={time}
                        variant={selectedTime === time ? 'default' : 'outline'}
                        onClick={() => onTimeSelect(time)}
                        className={cn(
                            'h-12 rounded-lg font-medium transition-colors',
                            selectedTime === time ? 'bg-blue-600 text-white hover:bg-blue-700' : 'bg-white text-gray-700 hover:bg-gray-50',
                        )}
                    >
                        {time}
                    </Button>
                ))}
            </div>
        </div>
    );
};

export default TimeSlotPicker;
