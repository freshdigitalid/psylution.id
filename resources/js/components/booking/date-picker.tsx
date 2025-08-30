import { Button } from '@/components/ui/button';
import { cn } from '@/lib/utils';
import { ChevronLeft, ChevronRight } from 'lucide-react';
import { useState } from 'react';

interface DatePickerProps {
    selectedDate: Date | null;
    onDateSelect: (date: Date) => void;
    className?: string;
}

const DatePicker = ({ selectedDate, onDateSelect, className }: DatePickerProps) => {
    const [currentMonth, setCurrentMonth] = useState(new Date()); // date

    const daysInMonth = new Date(currentMonth.getFullYear(), currentMonth.getMonth() + 1, 0).getDate();

    const firstDayOfMonth = new Date(currentMonth.getFullYear(), currentMonth.getMonth(), 1).getDay();

    const monthNames = ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'];

    const dayNames = ['Su', 'Mo', 'Tu', 'We', 'Th', 'Fr', 'Sa'];

    const goToPreviousMonth = () => {
        setCurrentMonth(new Date(currentMonth.getFullYear(), currentMonth.getMonth() - 1));
    };

    const goToNextMonth = () => {
        setCurrentMonth(new Date(currentMonth.getFullYear(), currentMonth.getMonth() + 1));
    };

    const isToday = (day: number) => {
        const today = new Date();
        return day === today.getDate() && currentMonth.getMonth() === today.getMonth() && currentMonth.getFullYear() === today.getFullYear();
    };

    const isSelected = (day: number) => {
        if (!selectedDate) return false;
        return (
            day === selectedDate.getDate() &&
            currentMonth.getMonth() === selectedDate.getMonth() &&
            currentMonth.getFullYear() === selectedDate.getFullYear()
        );
    };

    const isPastDate = (day: number) => {
        const today = new Date();
        const checkDate = new Date(currentMonth.getFullYear(), currentMonth.getMonth(), day);
        return checkDate < new Date(today.getFullYear(), today.getMonth(), today.getDate());
    };

    const renderCalendarDays = () => {
        const days = [];

        // Add empty cells for days before the first day of the month
        for (let i = 0; i < firstDayOfMonth; i++) {
            days.push(<div key={`empty-${i}`} className="h-10"></div>);
        }

        // Add days of the month
        for (let day = 1; day <= daysInMonth; day++) {
            const isPast = isPastDate(day);
            days.push(
                <button
                    key={day}
                    onClick={() => !isPast && onDateSelect(new Date(currentMonth.getFullYear(), currentMonth.getMonth(), day))}
                    disabled={isPast}
                    className={cn(
                        'h-10 w-10 rounded-full text-sm font-medium transition-colors',
                        isPast && 'cursor-not-allowed text-gray-300',
                        !isPast && 'hover:bg-blue-100',
                        isToday(day) && 'bg-blue-200 text-blue-800',
                        isSelected(day) && 'bg-blue-600 text-white hover:bg-blue-700',
                        !isPast && !isToday(day) && !isSelected(day) && 'text-gray-700',
                    )}
                >
                    {day}
                </button>,
            );
        }

        return days;
    };

    return (
        <div className={cn('rounded-xl bg-blue-50 p-6', className)}>
            {/* Header */}
            <div className="mb-4 flex items-center justify-between">
                <Button variant="ghost" size="sm" onClick={goToPreviousMonth} className="h-8 w-8 p-0">
                    <ChevronLeft className="h-4 w-4" />
                </Button>
                <h3 className="text-lg font-semibold text-gray-900">
                    {monthNames[currentMonth.getMonth()]} {currentMonth.getFullYear()}
                </h3>
                <Button variant="ghost" size="sm" onClick={goToNextMonth} className="h-8 w-8 p-0">
                    <ChevronRight className="h-4 w-4" />
                </Button>
            </div>

            {/* Day names */}
            <div className="mb-2 grid grid-cols-7 gap-1">
                {dayNames.map((day) => (
                    <div key={day} className="flex h-8 items-center justify-center text-xs font-medium text-gray-500">
                        {day}
                    </div>
                ))}
            </div>

            {/* Calendar grid */}
            <div className="grid grid-cols-7 gap-1">{renderCalendarDays()}</div>
        </div>
    );
};

export default DatePicker;
