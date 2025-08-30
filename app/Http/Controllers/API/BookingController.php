<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Validator;
use App\Models\Appointment;
use App\Models\User;

class BookingController extends Controller
{
    /**
     * Store a new booking
     */
    public function store(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'birthday' => 'required|date',
            'consultationType' => 'required|in:online,offline',
            'complaint' => 'required|string|max:1000',
            'date' => 'required|date|after:today',
            'time' => 'required|string|regex:/^([01]?[0-9]|2[0-3]):[0-5][0-9]$/',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            // Get authenticated user or create a guest user
            $user = auth()->user();
            
            if (!$user) {
                // For demo purposes, create a guest user
                $user = User::firstOrCreate(
                    ['email' => 'guest@example.com'],
                    [
                        'name' => $request->name,
                        'password' => bcrypt('guest123'),
                        'role_id' => 2 // Patient role
                    ]
                );
            }

            // Create the appointment
            $appointment = Appointment::create([
                'user_id' => $user->id,
                'psychologist_id' => 1, // Default psychologist for demo
                'appointment_date' => $request->date,
                'appointment_time' => $request->time,
                'consultation_type' => $request->consultationType,
                'complaint' => $request->complaint,
                'status' => 'pending',
                'notes' => 'Booking created via API'
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Booking created successfully',
                'data' => [
                    'appointment_id' => $appointment->id,
                    'appointment_date' => $appointment->appointment_date,
                    'appointment_time' => $appointment->appointment_time,
                    'consultation_type' => $appointment->consultation_type
                ]
            ], 201);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to create booking',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get available time slots for a specific date
     */
    public function getAvailableSlots(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'date' => 'required|date|after:today',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid date',
                'errors' => $validator->errors()
            ], 422);
        }

        // Get all time slots
        $allTimeSlots = [
            '09:00', '10:00', '11:00', '12:00', '13:00',
            '14:00', '15:00', '16:00', '17:00', '18:00'
        ];

        // Get booked time slots for the date
        $bookedSlots = Appointment::where('appointment_date', $request->date)
            ->pluck('appointment_time')
            ->toArray();

        // Filter out booked slots
        $availableSlots = array_diff($allTimeSlots, $bookedSlots);

        return response()->json([
            'success' => true,
            'data' => [
                'available_slots' => array_values($availableSlots),
                'booked_slots' => $bookedSlots
            ]
        ]);
    }

    /**
     * Get user's booking history
     */
    public function getUserBookings(Request $request): JsonResponse
    {
        $user = auth()->user();
        
        if (!$user) {
            return response()->json([
                'success' => false,
                'message' => 'User not authenticated'
            ], 401);
        }

        $bookings = Appointment::where('user_id', $user->id)
            ->with(['psychologist'])
            ->orderBy('appointment_date', 'desc')
            ->get();

        return response()->json([
            'success' => true,
            'data' => $bookings
        ]);
    }

    /**
     * Cancel a booking
     */
    public function cancel(Request $request, $id): JsonResponse
    {
        $user = auth()->user();
        
        if (!$user) {
            return response()->json([
                'success' => false,
                'message' => 'User not authenticated'
            ], 401);
        }

        $appointment = Appointment::where('id', $id)
            ->where('user_id', $user->id)
            ->first();

        if (!$appointment) {
            return response()->json([
                'success' => false,
                'message' => 'Appointment not found'
            ], 404);
        }

        if ($appointment->status === 'cancelled') {
            return response()->json([
                'success' => false,
                'message' => 'Appointment is already cancelled'
            ], 400);
        }

        $appointment->update(['status' => 'cancelled']);

        return response()->json([
            'success' => true,
            'message' => 'Appointment cancelled successfully'
        ]);
    }
}
