<?php

namespace App\Actions;

use App\Models\Booking;
use App\Models\Villa;
use App\Models\Voucher;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;
use App\Mail\PaymentPendingMail;
use Illuminate\Support\Facades\Mail;

class ProcessCheckoutAction
{
    public function execute(array $params)
    {
        $villa = Villa::with(['rooms', 'galleries', 'fasilitas'])->findOrFail($params['villa_id']);

        $checkIn = Carbon::parse($params['check_in']);
        $checkOut = Carbon::parse($params['check_out']);
        $nights = $checkIn->diffInDays($checkOut);

        if ($nights < 1) {
            throw new \Exception('Tanggal menginap tidak valid.');
        }

        $totalPrice = $villa->price * $nights;
        $voucherModel = null;

        if (!empty($params['voucher_code'])) {
            $voucherModel = Voucher::where('code', $params['voucher_code'])->first();
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
            'guest_name' => $params['guest_name'],
            'guest_email' => $params['guest_email'],
            'guest_phone' => $params['guest_phone'],
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

            try {
                Mail::to($booking->guest_email)->send(new PaymentPendingMail($booking));
            } catch (\Exception $e) {
                \Log::error('Gagal mengirim email pembayaran: ' . $e->getMessage());
            }

            return $paymentUrl;
        }

        throw new \Exception('Gagal memproses pembayaran DOKU.');
    }

    private function createDokuPaymentUrl(Booking $booking)
    {
        $clientId = config('services.doku.client_id');
        $secretKey = config('services.doku.secret_key');
        $isProduction = config('services.doku.is_production');

        // For development, use sandbox URL. In production, use production URL.
        $url =  $isProduction ? 'https://api.doku.com/checkout/v1/payment' : 'https://api-sandbox.doku.com/checkout/v1/payment';

        $requestId = (string) Str::uuid();
        $targetPath = '/checkout/v1/payment';
        $timestamp = gmdate("Y-m-d\TH:i:s\Z");

        $nights = $booking->check_in->diffInDays($booking->check_out);
        $formattedPrice = number_format($booking->total_price, 0, ',', '.');
        $checkInDate = $booking->check_in->format('d M Y');
        $description = "{$booking->villa->name}, {$nights} Malam, Rp {$formattedPrice}, {$checkInDate}";

        $payload = [
            "order" => [
                "amount" => $booking->total_price,
                "invoice_number" => $booking->invoice_number,
                "callback_url" => route('checkout.success', ['invoice' => $booking->invoice_number]),
                "notify_url" => route('doku.notification'),
                "line_items" => [
                    [
                        "name" => substr($description, 0, 100),
                        "price" => $booking->total_price,
                        "quantity" => 1
                    ]
                ]
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
        return null;
    }
}
