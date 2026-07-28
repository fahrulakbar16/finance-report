<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Villa;
use App\Models\Voucher;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;
use Carbon\Carbon;

class CheckoutController extends Controller
{
    // GET /checkout
    public function index(Request $request)
    {
        $villa = Villa::with(['rooms', 'galleries', 'fasilitas'])->findOrFail($request->villa_id);

        $checkIn = Carbon::parse($request->checkin);
        $checkOut = Carbon::parse($request->checkout);
        $nights = $checkIn->diffInDays($checkOut);

        if ($nights < 1) {
            return redirect()->back()->with('error', 'Tanggal checkout harus setelah tanggal check-in.');
        }

        $basePrice = $villa->price;
        $totalPrice = $basePrice * $nights;

        return view('customer.pages.checkout', compact('villa', 'checkIn', 'checkOut', 'nights', 'basePrice', 'totalPrice'));
    }

    // POST /checkout/voucher
    public function applyVoucher(Request $request)
    {
        $request->validate([
            'code' => 'required|string',
            'base_total' => 'required|numeric'
        ]);

        $voucher = Voucher::where('code', $request->code)->first();

        if (!$voucher || !$voucher->isValid()) {
            return response()->json(['success' => false, 'message' => 'Voucher tidak valid atau sudah tidak aktif.']);
        }

        $baseTotal = $request->base_total;
        $discountAmount = 0;

        if ($voucher->discount_type === 'percentage') {
            $discountAmount = ($baseTotal * $voucher->discount_amount) / 100;
        } else {
            $discountAmount = $voucher->discount_amount;
        }

        $finalPrice = max(0, $baseTotal - $discountAmount);

        return response()->json([
            'success' => true,
            'message' => 'Voucher berhasil digunakan!',
            'discount_amount' => $discountAmount,
            'final_price' => $finalPrice,
            'voucher_id' => $voucher->id
        ]);
    }

    // POST /checkout/process
    public function process(Request $request)
    {
        $request->validate([
            'villa_id' => 'required|exists:villas,id',
            'check_in' => 'required|date',
            'check_out' => 'required|date',
            'guest_name' => 'required|string|max:255',
            'guest_email' => 'required|email',
            'guest_phone' => 'required|string',
            'voucher_code' => 'nullable|string'
        ]);

        $villa = Villa::with(['rooms', 'galleries', 'fasilitas'])->findOrFail($request->villa_id);

        $checkIn = Carbon::parse($request->check_in);
        $checkOut = Carbon::parse($request->check_out);
        $nights = $checkIn->diffInDays($checkOut);

        if ($nights < 1) {
            return back()->with('error', 'Tanggal menginap tidak valid.');
        }

        $totalPrice = $villa->price * $nights;
        $voucherModel = null;

        if ($request->voucher_code) {
            $voucherModel = Voucher::where('code', $request->voucher_code)->first();
            if ($voucherModel && $voucherModel->isValid()) {
                if ($voucherModel->discount_type === 'percentage') {
                    $totalPrice -= ($totalPrice * $voucherModel->discount_amount) / 100;
                } else {
                    $totalPrice -= $voucherModel->discount_amount;
                }
            }
        }
        $totalPrice = max(0, $totalPrice);

        $invoiceNumber = 'INV-' . time() . '-' . Str::upper(Str::random(5));

        // Create booking
        $booking = Booking::create([
            'invoice_number' => $invoiceNumber,
            'user_id' => Auth::id(),
            'villa_id' => $villa->id,
            'guest_name' => $request->guest_name,
            'guest_email' => $request->guest_email,
            'guest_phone' => $request->guest_phone,
            'check_in' => $checkIn,
            'check_out' => $checkOut,
            'total_price' => $totalPrice,
            'voucher_id' => $voucherModel ? $voucherModel->id : null,
            'villa_snapshot' => $villa->toArray(), // Save snapshot of villa data
            'payment_status' => 'pending'
        ]);

        // Generate DOKU Payment Link (Jokul Checkout)
        $paymentUrl = $this->createDokuPaymentUrl($booking);

        if ($paymentUrl) {
            $booking->update(['payment_url' => $paymentUrl]);
            return redirect($paymentUrl);
        }

        return back()->with('error', 'Gagal memproses pembayaran DOKU.');
    }

    private function createDokuPaymentUrl(Booking $booking)
    {
        $clientId = env('DOKU_CLIENT_ID', 'DUMMY_CLIENT_ID');
        $secretKey = env('DOKU_SECRET_KEY', 'DUMMY_SECRET_KEY');

        // For development, use sandbox URL. In production, use production URL.
        $url = 'https://api-sandbox.doku.com/checkout/v1/payment';

        $requestId = (string) Str::uuid();
        $targetPath = '/checkout/v1/payment';
        $timestamp = gmdate("Y-m-d\TH:i:s\Z");

        $payload = [
            "order" => [
                "amount" => $booking->total_price,
                "invoice_number" => $booking->invoice_number,
                "callback_url" => route('checkout.success', ['invoice' => $booking->invoice_number]),
                "notify_url" => route('doku.notification'),
            ],
            "payment" => [
                "payment_due_date" => 60 // 60 minutes
            ],
            "customer" => [
                "name" => $booking->guest_name,
                "email" => $booking->guest_email,
                "phone" => $booking->guest_phone
            ],
            "additional_info" => [
                "override_notification_url" => route('doku.notification')
            ]
        ];

        $jsonPayload = json_encode($payload);

        // Generate DOKU Signature
        $digest = base64_encode(hash('sha256', $jsonPayload, true));
        $signatureComponent = "Client-Id:" . $clientId . "\n" .
            "Request-Id:" . $requestId . "\n" .
            "Request-Timestamp:" . $timestamp . "\n" .
            "Request-Target:" . $targetPath . "\n" .
            "Digest:" . $digest;
        $signature = base64_encode(hash_hmac('sha256', $signatureComponent, $secretKey, true));

        $response = Http::withHeaders([
            'Client-Id' => $clientId,
            'Request-Id' => $requestId,
            'Request-Timestamp' => $timestamp,
            'Signature' => "HMACSHA256=" . $signature,
            'Content-Type' => 'application/json',
        ])->post($url, $payload);

        if ($response->successful() && isset($response['response']['payment']['url'])) {
            return $response['response']['payment']['url'];
        }

        \Log::error('DOKU Checkout Error: ' . $response->body());
        return null;
    }

    // POST /doku/notification
    public function dokuNotification(Request $request)
    {
        \Log::info('DOKU Webhook Received: ', $request->all());

        // For production, you MUST validate the DOKU Signature here to ensure security!
        $invoiceNumber = $request->input('order.invoice_number');
        $amount = $request->input('order.amount');
        $status = $request->input('transaction.status');

        $booking = Booking::where('invoice_number', $invoiceNumber)->first();
        if ($booking) {
            \Log::info("Booking found for $invoiceNumber. Transaction status: $status");
            // Check status transaction from DOKU
            if (strtoupper($status) === 'SUCCESS') {
                $booking->update([
                    'payment_status' => 'paid'
                ]);
                \Log::info("Booking $invoiceNumber marked as paid.");
                
                // Mark voucher as used if necessary
                if ($booking->voucher_id) {
                    $voucher = Voucher::find($booking->voucher_id);
                    if ($voucher) {
                        $voucher->increment('used_count');
                    }
                }
            } else {
                \Log::info("Booking $invoiceNumber ignored because status is not SUCCESS.");
            }
        } else {
            \Log::warning("DOKU Webhook Error: Booking not found for invoice $invoiceNumber");
        }

        return response()->json(['status' => 'success']);
    }

    // GET /checkout/success
    public function success(Request $request)
    {
        return view('customer.pages.checkout-success', [
            'invoice' => $request->query('invoice')
        ]);
    }
}
