<?php

namespace App\Http\Controllers;

use App\Enums\AppointmentStatus;
use App\Models\Appointment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class AppointmentController extends Controller
{
    public function index(string $psychologist_id)
    {
        return Inertia::render('psychologist/book/index', [
            'psychologist_id' => $psychologist_id
        ]);
    }

    public function book(Request $request)
    {
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
