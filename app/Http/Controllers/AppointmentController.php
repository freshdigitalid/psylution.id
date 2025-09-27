<?php

namespace App\Http\Controllers;

use App\Enums\AppointmentStatus;
use App\Models\Appointment;
use App\Models\Psychologist;
use App\Models\Schedule;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class AppointmentController extends Controller
{
    public function index(string $psychologist_id)
    {
        $user = Auth::user()->load([
            'person' => fn ($query) => $query->select('id', 'user_id', 'first_name', 'last_name', 'dob'),
        ]);
        
        $psychologist = Psychologist::select('id', 'first_name', 'last_name')
            ->with('specializations:specialization_name')
            ->findOrFail($psychologist_id);
            
        $psychologist->specializations->each->makeHidden('pivot');
        
        $today = Carbon::today('Asia/Jakarta')->setTimezone('UTC'); // current date (00:00:00)

        // get schedules for today + that psychologist
        $schedule = Schedule::where('psychologist_id', $psychologist_id)
            ->whereDate('start_time', $today)
            ->first();

        $slots = collect();
        if($schedule) {
            $start = Carbon::parse($schedule->start_time);
            $end   = Carbon::parse($schedule->end_time);

            $break_start = $schedule->break_start_time ? Carbon::parse($schedule->break_start_time) : null;
            $break_end   = $schedule->break_end_time ? Carbon::parse($schedule->break_end_time) : null;
    
            while ($start < $end) {
                $next = (clone $start)->addHour();
    
                // skip break
                if ($break_start && $break_end) {
                    if ($start >= $break_start && $next <= $break_end) {
                        $start = $next;
                        continue;
                    }
                }
    
                $slots->push([
                    'start_time'      => $start,
                    'end_time'        => $next,
                ]);
    
                $start = $next;
            }
        }

        return Inertia::render('psychologist/book/index', [
            'psychologist' => $psychologist,
            'patient' => $user->person,
            'schedules' => $slots
        ]);
    }

    public function book(Request $request)
    {
        $request->validate([
            'psychologist_id' => ['required', 'uuid', 'exists:persons,id'],
            'is_online'       => ['required', 'boolean'],
            'complaints'      => ['required', 'string', 'max:1000'],
            'start_time'      => ['required', 'date', 'after_or_equal:now'],
            'end_time'        => ['required', 'date', 'after:start_time'],
        ]);

        $patient_id = Auth::user()->person->id;

        Appointment::create([
            'psychologist_id' => $request->psychologist_id,
            'patient_id' => $patient_id,
            'start_time' => $request->start_time,
            'end_time' => $request->end_time,
            'complaints' => $request->complaints,
            'is_online' => $request->is_online,
            'status' => AppointmentStatus::Pending,
        ]);
    }
}
