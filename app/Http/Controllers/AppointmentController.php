<?php

namespace App\Http\Controllers;

use App\Enums\AppointmentStatus;
use App\Enums\PaymentStatus;
use App\Models\Appointment;
use App\Models\AppointmentOrder;
use App\Models\PackageDetail;
use App\Models\Psychologist;
use App\Models\Schedule;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;
use App\Services\PaymentGateway\PaymentGatewayFactory;
use Illuminate\Support\Facades\Log;

class AppointmentController extends Controller
{
    protected $paymentGateway;

    public function __construct()
    {
        $this->paymentGateway = PaymentGatewayFactory::create();
    }

    public function index(Request $request)
    {
        $request->validate([
            'start_date' => ['nullable', 'date', 'after_or_equal:today'],
        ]);

        $user = Auth::user()->load([
            'person' => fn ($query) => $query->select('id', 'user_id', 'first_name', 'last_name', 'dob'),
        ]);

        $psychologist = Psychologist::select('id', 'first_name', 'last_name')
            ->with(['specializations:specialization_name', 'packages:id'])
            ->findOrFail($request->psychologist_id);

        $psychologist->specializations->each->makeHidden('pivot');

        // Parse start_date - handle both date string (YYYY-MM-DD) and ISO datetime string
        if ($request->start_date) {
            // Check if it's a date string (YYYY-MM-DD) or ISO datetime string
            $dateInput = $request->start_date;
            
            // If it's just a date string (YYYY-MM-DD), parse it as Asia/Jakarta to avoid timezone issues
            if (preg_match('/^\d{4}-\d{2}-\d{2}$/', $dateInput)) {
                // Date string format: parse as date in Asia/Jakarta timezone
                $start_date_utc = Carbon::createFromFormat('Y-m-d', $dateInput, 'Asia/Jakarta')
                    ->setTimezone('UTC')
                    ->startOfDay();
            } else {
                // ISO datetime string: parse and convert to UTC
                $parsedDate = Carbon::parse($dateInput);
                $start_date_utc = $parsedDate->setTimezone('UTC')->startOfDay();
            }
        } else {
            $start_date_utc = Carbon::today('Asia/Jakarta')->setTimezone('UTC')->startOfDay();
        }

        // Get schedule for the selected date
        // First try to find exact date match
        $schedule = Schedule::where('psychologist_id', $request->psychologist_id)
            ->whereDate('start_time', $start_date_utc->toDateString())
            ->first();

        // If not found, try to find schedule by day of week (for recurring weekly schedules)
        // Get schedules for current week to find the pattern
        if (!$schedule) {
            $weekStart = Carbon::now('Asia/Jakarta')->startOfWeek()->setTimezone('UTC');
            $weekEnd = Carbon::now('Asia/Jakarta')->endOfWeek()->setTimezone('UTC');
            
            $dayOfWeek = $start_date_utc->dayOfWeek; // 0 = Sunday, 1 = Monday, etc.
            
            // Find schedule for the same day of week in current week
            $weekSchedules = Schedule::where('psychologist_id', $request->psychologist_id)
                ->whereBetween('start_time', [$weekStart, $weekEnd])
                ->get();
            
            // Find schedule that matches the day of week
            $schedule = $weekSchedules->first(function($s) use ($dayOfWeek) {
                return Carbon::parse($s->start_time)->dayOfWeek === $dayOfWeek;
            });
            
            // check schedule 
            if ($schedule) {
                $scheduleStart = Carbon::parse($schedule->start_time);
                $scheduleEnd = Carbon::parse($schedule->end_time);
                $scheduleBreakStart = $schedule->break_start_time ? Carbon::parse($schedule->break_start_time) : null;
                $scheduleBreakEnd = $schedule->break_end_time ? Carbon::parse($schedule->break_end_time) : null;
                
                // Calculate time difference from schedule date
                $hoursDiff = $scheduleStart->hour;
                $minutesDiff = $scheduleStart->minute;
                $endHoursDiff = $scheduleEnd->hour;
                $endMinutesDiff = $scheduleEnd->minute;
                
                $newStartTime = $start_date_utc->copy()->setTime($hoursDiff, $minutesDiff, 0)->toDateTimeString();
                $newEndTime = $start_date_utc->copy()->setTime($endHoursDiff, $endMinutesDiff, 0)->toDateTimeString();
                $newBreakStart = $scheduleBreakStart ? $start_date_utc->copy()->setTime($scheduleBreakStart->hour, $scheduleBreakStart->minute, 0)->toDateTimeString() : null;
                $newBreakEnd = $scheduleBreakEnd ? $start_date_utc->copy()->setTime($scheduleBreakEnd->hour, $scheduleBreakEnd->minute, 0)->toDateTimeString() : null;
                
                // Create a temporary schedule object (using stdClass to avoid database interaction)
                $schedule = (object) [
                    'psychologist_id' => $schedule->psychologist_id,
                    'start_time' => $newStartTime,
                    'end_time' => $newEndTime,
                    'break_start_time' => $newBreakStart,
                    'break_end_time' => $newBreakEnd,
                ];
            }
        }

        $slots = collect();
        if($schedule) {
            // Parse schedule times - handle both Carbon objects and strings
            $start = is_string($schedule->start_time) 
                ? Carbon::parse($schedule->start_time)->setTimezone('UTC')
                : Carbon::instance($schedule->start_time)->setTimezone('UTC');
            
            $end = is_string($schedule->end_time)
                ? Carbon::parse($schedule->end_time)->setTimezone('UTC')
                : Carbon::instance($schedule->end_time)->setTimezone('UTC');

            $break_start = $schedule->break_start_time 
                ? (is_string($schedule->break_start_time)
                    ? Carbon::parse($schedule->break_start_time)->setTimezone('UTC')
                    : Carbon::instance($schedule->break_start_time)->setTimezone('UTC'))
                : null;
            
            $break_end = $schedule->break_end_time 
                ? (is_string($schedule->break_end_time)
                    ? Carbon::parse($schedule->break_end_time)->setTimezone('UTC')
                    : Carbon::instance($schedule->break_end_time)->setTimezone('UTC'))
                : null;

            // Get booked appointments (exclude rejected/cancelled)
            $bookedAppointments = Appointment::where('psychologist_id', $request->psychologist_id)
                ->whereDate('start_time', $start_date_utc->toDateString())
                ->whereNotIn('status', [AppointmentStatus::Rejected])
                ->get()
                ->map(function($appointment) {
                    return Carbon::parse($appointment->start_time)->setTimezone('UTC')->startOfHour();
                })
                ->filter();

            // Get reserved slots from paid orders (even if appointment not created yet)
            // Filter by psychologist_id in JSON data and date after getting records
            $reservedSlots = AppointmentOrder::where('payment_status', PaymentStatus::Paid)
                ->get()
                ->filter(function($order) use ($request, $start_date_utc) {
                    // Check if psychologist_id matches
                    $orderPsychologistId = $order->data['psychologist_id'] ?? null;
                    if ($orderPsychologistId !== $request->psychologist_id) {
                        return false;
                    }
                    
                    // Check if appointment exists and date matches
                    if ($order->appointment) {
                        $apptDate = Carbon::parse($order->appointment->start_time)->setTimezone('UTC');
                        return $apptDate->format('Y-m-d') === $start_date_utc->format('Y-m-d');
                    }
                    
                    // Check order data for reserved slot
                    if (isset($order->data['start_time'])) {
                        $orderStartDate = Carbon::parse($order->data['start_time'])->setTimezone('UTC');
                        return $orderStartDate->format('Y-m-d') === $start_date_utc->format('Y-m-d');
                    }
                    
                    return false;
                })
                ->map(function($order) use ($start_date_utc) {
                    if ($order->appointment) {
                        $apptDate = Carbon::parse($order->appointment->start_time)->setTimezone('UTC');
                        return $apptDate->startOfHour();
                    }
                    
                    if (isset($order->data['start_time'])) {
                        $orderStartDate = Carbon::parse($order->data['start_time'])->setTimezone('UTC');
                        return $orderStartDate->startOfHour();
                    }
                    
                    return null;
                })
                ->filter();

            // Combine all booked/reserved slots - use collection of formatted strings for comparison
            $allBookedTimes = $bookedAppointments->merge($reservedSlots)
                ->map(fn($slot) => $slot->format('Y-m-d H:i'))
                ->unique()
                ->values();

            while ($start < $end) {
                $next = (clone $start)->addHour();
                $slotStart = $start->copy()->startOfHour();

                // skip break
                if ($break_start && $break_end) {
                    if ($slotStart >= $break_start && $slotStart < $break_end) {
                        $start = $next;
                        continue;
                    }
                }

                // skip booked/reserved slots - compare by hour precision
                $slotTimeKey = $slotStart->format('Y-m-d H:i');
                if ($allBookedTimes->contains($slotTimeKey)) {
                    $start = $next;
                    continue;
                }

                // Only show slots that are in the future or today but not past current hour
                $now = Carbon::now('UTC');
                if ($slotStart->greaterThanOrEqualTo($now->startOfHour())) {
                    $slots->push([
                        'start_time' => $slotStart->toIso8601String(),
                        'end_time'   => $next->toIso8601String(),
                    ]);
                }

                $start = $next;
            }
        }

        // Get package details that match is_online and belong to psychologist's packages
        $package_ids = $psychologist->packages->pluck('id');
        $package_details = PackageDetail::query()
            ->select('id', 'title', 'price')
            ->whereIn('package_id', $package_ids)
            ->when($request->has('is_online'), function ($query) use ($request) {
                $query->where('is_online', $request->is_online);
            }, function ($query) {
                $query->where('is_online', false);
            })
        ->get();

        return Inertia::render('psychologist/book/index', [
            'psychologist' => $psychologist,
            'patient' => $user->person,
            'schedules' => $slots,
            'packages' => $package_details,
        ]);
    }

    public function book(Request $request)
    {
        $request->validate([
            'psychologist_id' => ['required', 'uuid', 'exists:persons,id'],
            'is_online'       => ['required', 'boolean'],
            'start_time'      => ['required', 'date', 'after_or_equal:now'],
            'end_time'        => ['required', 'date', 'after:start_time'],
            'package_detail_id' => ['required', 'uuid', 'exists:package_details,id'],
        ]);

        try {
            $detail = PackageDetail::findOrFail($request->package_detail_id);
            
            // Create invoice using PaymentGatewayFactory
            $invoice = $this->paymentGateway->createInvoice([
                'external_id' => 'inv-' . time(),
                'description' => "Pembelian {$detail->title}",
                'amount' => $detail->price,
                'invoice_duration' => 86400,
                'currency' => 'IDR',
                'reminder_time' => 1,
                'customer' => [
                    'given_names' => Auth::user()->name,
                    'email' => Auth::user()->email
                ],
                'success_url' => route('profile'),
                'failure_url' => route('profile'),
                'payment_methods' => ['BCA', 'BNI', 'BSI', 'BRI', 'MANDIRI', 'PERMATA', 'ALFAMART', 'INDOMARET', 'OVO', 'DANA', 'LINKAJA', 'QRIS'],
            ]);
            
            AppointmentOrder::create([
                'invoice_id' => $invoice['invoice_id'] ?? $invoice['external_id'],
                'amount' => $invoice['amount'],
                'customer_name' => Auth::user()->name,
                'customer_email' => Auth::user()->email,
                'status' => PaymentStatus::Unpaid,
                'data' => [
                    'psychologist_id' => $request->psychologist_id,
                    'patient_id' => Auth::user()->person->id,
                    'start_time' => $request->start_time,
                    'end_time' => $request->end_time,
                    'complaints' => $request->complaints,
                    'is_online' => $request->is_online,
                    'status' => AppointmentStatus::Pending,
                    'package_detail_id' => $request->package_detail_id,
                ]
            ]);

            return Inertia::location($invoice['invoice_url']);
        } catch (\Exception $e) {
            Log::error('Payment Gateway Error: ' . $e->getMessage());
            return back()->with('error', 'Terjadi kesalahan saat membuat invoice. Silakan coba lagi.');
        }
    }

    public function callback(Request $request)
    {
        try {
            $payment = $request->all();
            $signature = $request->header('x-callback-token') ?? $request->header('authorization') ?? '';

            // Verify webhook using payment gateway
            if (!$this->paymentGateway->verifyWebhook($payment, $signature)) {
                return response()->json(['error' => 'Invalid token'], 403);
            }

            // Process callback using payment gateway
            $callbackData = $this->paymentGateway->processCallback($payment);
            
            $order = AppointmentOrder::where('invoice_id', $callbackData['invoice_id'])->first();
            if ($order) {
                $isPaid = in_array(strtoupper($callbackData['status'] ?? ''), ['PAID', 'SETTLED', 'COMPLETED']);
                
                $appointmentId = $order->appointment_id;
                
                if ($isPaid) {
                    // Create appointment only if it doesn't exist yet
                    if (!$appointmentId) {
                        $appointment = Appointment::create([
                            'psychologist_id' => $order->data['psychologist_id'],
                            'patient_id' => $order->data['patient_id'],
                            'start_time' => $order->data['start_time'],
                            'end_time' => $order->data['end_time'],
                            'complaints' => $order->data['complaints'] ?? null,
                            'package_detail_id' => $order->data['package_detail_id'],
                            'is_online' => $order->data['is_online'] ?? false,
                            'status' => AppointmentStatus::Pending,
                        ]);
                        $appointmentId = $appointment->id;
                    }
                }
                
                // Update order status and payment information
                $order->update([
                    'status' => $isPaid ? 'paid' : 'pending', 
                    'payment_status' => $isPaid ? PaymentStatus::Paid : PaymentStatus::Unpaid,
                    'payment_method' => $callbackData['payment_method'] ?? $order->payment_method,
                    'payment_channel' => $callbackData['payment_channel'] ?? $order->payment_channel,
                    'appointment_id' => $appointmentId,
                ]);
                
                Log::info('Payment callback processed', [
                    'invoice_id' => $callbackData['invoice_id'],
                    'status' => $callbackData['status'],
                    'is_paid' => $isPaid,
                    'order_id' => $order->id,
                    'appointment_id' => $appointmentId,
                    'payment_status' => $order->payment_status->value,
                    'order_status' => $order->status,
                ]);
            } else {
                Log::warning('Order not found for callback', [
                    'invoice_id' => $callbackData['invoice_id'] ?? 'unknown',
                ]);
            }

            return response()->json(['success' => true]);
        } catch (\Exception $e) {
            Log::error('Callback Error: ' . $e->getMessage());
            return response()->json(['error' => 'Internal server error'], 500);
        }
    }
}
