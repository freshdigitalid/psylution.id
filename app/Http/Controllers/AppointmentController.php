<?php

namespace App\Http\Controllers;

use App\Enums\AppointmentStatus;
use App\Enums\PaymentStatus;
use App\Models\Appointment;
use App\Models\AppointmentOrder;
use App\Models\Psychologist;
use App\Models\Schedule;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;
use Xendit\Invoice\InvoiceApi;
use Xendit\Configuration;
use Illuminate\Support\Facades\Log;
use Xendit\Invoice\CreateInvoiceRequest;

class AppointmentController extends Controller
{
    protected $apiInstance;

    public function __construct()
    {
        // Setup Xendit configuration
        Configuration::setXenditKey(config('services.xendit.secret_key'));
        $this->apiInstance = new InvoiceApi();
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
            ->with('specializations:specialization_name')
            ->findOrFail($request->psychologist_id);
            
        $psychologist->specializations->each->makeHidden('pivot');
        
        $start_date = $request->start_date ?? Carbon::today('Asia/Jakarta')->toDateString();

        // normalize to UTC for DB query
        $start_date_utc = Carbon::parse($start_date, 'Asia/Jakarta')->setTimezone('UTC');

        // get schedules for today + that psychologist
        $schedule = Schedule::where('psychologist_id', $request->psychologist_id)
            ->whereDate('start_time', $start_date_utc)
            ->first();

        $slots = collect();
        if($schedule) {
            $start = Carbon::parse($schedule->start_time);
            $end   = Carbon::parse($schedule->end_time);

            $break_start = $schedule->break_start_time ? Carbon::parse($schedule->break_start_time) : null;
            $break_end   = $schedule->break_end_time ? Carbon::parse($schedule->break_end_time) : null;

            $booked = Appointment::where('psychologist_id', $request->psychologist_id)
                ->where('start_time', '>=', $start_date_utc)
                ->where('start_time', '<=', (clone $start_date_utc)->addDay())
                ->pluck('start_time')
                ->map(fn($time) => Carbon::parse($time));

            while ($start < $end) {
                $next = (clone $start)->addHour();
    
                // skip break
                if ($break_start && $break_end) {
                    if ($start >= $break_start && $next <= $break_end) {
                        $start = $next;
                        continue;
                    }
                }

                // skip booked slots
                if ($booked->contains(fn ($b) => $b->equalTo($start))) {
                    $start = $next;
                    continue;
                }

                $slots->push([
                    'start_time' => $start,
                    'end_time'   => $next,
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

        try {
            // Create invoice request object
            $createInvoiceRequest = new CreateInvoiceRequest([
                'external_id' => 'inv-' . time(),
                'description' => "Pembelian Psylution", //"Pembelian {$product->name}",
                'amount' => 10000,//$product->price,
                'invoice_duration' => 86400,
                'currency' => 'IDR',
                'reminder_time' => 1,
                'customer' => [
                    'given_names' => Auth::user()->name,
                    'email' => Auth::user()->email
                ],
                'success_redirect_url' => route('profile'), //route('payment.success'),
                'failure_redirect_url' => route('profile'), //route('payment.failed'),
                'payment_methods' => ['BCA', 'BNI', 'BSI', 'BRI', 'MANDIRI', 'PERMATA', 'ALFAMART', 'INDOMARET', 'OVO', 'DANA', 'LINKAJA', 'QRIS'],
            ]);

            // Optional: If you're using Xendit Platform feature
            $forUserId = null; // Isi dengan Business ID jika menggunakan fitur sub-account

            // Create invoice
            $invoice = $this->apiInstance->createInvoice($createInvoiceRequest, $forUserId);

            AppointmentOrder::create([
                'invoice_id' => $invoice['external_id'],
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
                ]
            ]);

            // Redirect ke halaman pembayaran Xendit
            return Inertia::location($invoice['invoice_url']);
        } catch (\Xendit\XenditSdkException $e) {
            Log::error('Xendit Error: ' . $e->getMessage());
            Log::error('Full Error: ' . json_encode($e->getFullError()));
            return back()->with('error', 'Terjadi kesalahan saat membuat invoice. Silakan coba lagi.');
        }
    }

    public function callback(Request $request)
    {
        try {
            $callbackToken = $request->header('x-callback-token');

            if ($callbackToken !== config('services.xendit.webhook_secret')) {
                return response()->json(['error' => 'Invalid token'], 403);
            }

            $payment = $request->all();

            $order = AppointmentOrder::where('invoice_id', $payment['external_id'])->first();
            if ($order) {
                if ($payment['status'] === 'PAID') {
                    $appointment = Appointment::create([
                        'psychologist_id' => $order->data['psychologist_id'],
                        'patient_id' => $order->data['patient_id'],
                        'start_time' => $order->data['start_time'],
                        'end_time' => $order->data['end_time'],
                        'complaints' => $order->data['complaints'],
                        'is_online' => $order->data['is_online'],
                        'status' => AppointmentStatus::Pending,
                    ]);
                }

                $order->update([
                    'payment_status' => $payment['status'] === 'PAID' ? PaymentStatus::Paid : PaymentStatus::Unpaid,
                    'payment_method' => $payment['payment_method'],
                    'payment_channel' => $payment['payment_channel'],
                    'appointment_id' => $appointment->id ?? null,
                ]);
            }

            return response()->json(['success' => true]);
        } catch (\Exception $e) {
            Log::error('Callback Error: ' . $e->getMessage());
            return response()->json(['error' => 'Internal server error'], 500);
        }
    }
}
