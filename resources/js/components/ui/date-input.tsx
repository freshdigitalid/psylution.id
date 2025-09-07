"use client"

import * as React from "react"
import { format, parse } from "date-fns"
import { Calendar as CalendarIcon } from "lucide-react"
import {
    Popover,
    PopoverContent,
    PopoverTrigger,
} from "@/components/ui/popover"
import { Button } from "@/components/ui/button"
import { Input } from "@/components/ui/input"
import { Calendar } from "@/components/ui/calendar"

export interface DateInputProps {
    value?: Date
    onChange?: (date: Date | undefined) => void
    placeholder?: string
    displayFormat?: string // how to show in input, default yyyy-MM-dd
    error?: string
}

export function DateInput({
    value,
    onChange,
    placeholder = "YYYY-MM-DD",
    displayFormat = "yyyy-MM-dd",
    error,
}: DateInputProps) {
    const [internalDate, setInternalDate] = React.useState<Date | undefined>(value)
    const [inputValue, setInputValue] = React.useState(
        value ? format(value, displayFormat) : ""
    )
    const [open, setOpen] = React.useState(false)

    // keep inputValue in sync when parent value changes
    React.useEffect(() => {
        if (value) {
            setInternalDate(value)
            setInputValue(format(value, displayFormat))
        } else {
            setInternalDate(undefined)
            setInputValue("")
        }
    }, [value, displayFormat])

    const handleInputChange = (e: React.ChangeEvent<HTMLInputElement>) => {
        const val = e.target.value
        setInputValue(val)

        const parsed = parse(val, displayFormat, new Date())
        if (!isNaN(parsed.getTime())) {
            setInternalDate(parsed)
            onChange?.(parsed)
        }
    }

    const handleCalendarSelect = (d: Date | undefined) => {
        if (d) {
            setInternalDate(d)
            setInputValue(format(d, displayFormat))
            onChange?.(d)
        }
        setOpen(false)
    }

    return (
        <div
            className="flex items-center rounded-md border border-input transition-[color,box-shadow]
        focus-within:border-ring focus-within:ring-ring/50 focus-within:ring-[3px]"
        >
            <Input
                className="flex-1 border-0 bg-transparent focus-visible:ring-0 focus-visible:ring-offset-0"
                value={inputValue}
                placeholder={placeholder}
                onChange={handleInputChange}
                error={error}
            />

            <Popover open={open} onOpenChange={setOpen}>
                <PopoverTrigger asChild>
                    <Button
                        type="button"
                        variant="ghost"
                        className="h-9 w-9 rounded-l-none"
                    >
                        <CalendarIcon className="h-4 w-4" />
                    </Button>
                </PopoverTrigger>
                <PopoverContent className="w-auto p-3" align="start">
                    <Calendar
                        mode="single"
                        selected={internalDate}
                        onSelect={handleCalendarSelect}
                        initialFocus
                    />
                </PopoverContent>
            </Popover>
        </div>
    )
}
