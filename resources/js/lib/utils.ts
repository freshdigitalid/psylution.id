import { type ClassValue, clsx } from 'clsx';
import { addMinutes, format } from 'date-fns';
import { twMerge } from 'tailwind-merge';

export function cn(...inputs: ClassValue[]) {
    return twMerge(clsx(inputs));
}


export function formatDate(date: Date) {
    return format(addMinutes(date, date.getTimezoneOffset()), 'yyyy-MM-dd HH:mm:ss');
}
