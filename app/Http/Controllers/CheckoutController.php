<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Villa;
use App\Models\Voucher;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Carbon\Carbon;
use App\Http\Requests\ProcessCheckoutRequest;
use App\Actions\ProcessCheckoutAction;

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
    public function process(ProcessCheckoutRequest $request)
    {
        try {
            $paymentUrl = app(ProcessCheckoutAction::class)->execute($request->validated());
            return redirect($paymentUrl);
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
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
