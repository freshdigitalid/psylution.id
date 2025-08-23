<?php

namespace App\Http\Controllers;

use App\Enums\AppointmentStatus;
use App\Models\Appointment;
use App\Models\Psychologist;
use Illuminate\Http\Request;
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

        return Inertia::render('psychologist/book/index', [
            'psychologist' => $psychologist,
            'patient' => $user->person,
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
