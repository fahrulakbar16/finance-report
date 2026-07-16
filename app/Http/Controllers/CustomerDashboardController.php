<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CustomerDashboardController extends Controller
{
    public function index()
    {
        return view('customer.dashboard');
    }

    public function history()
    {
        $userId = auth()->id();
        $today = now()->format('Y-m-d');
        
        $bookings = \App\Models\Booking::where('user_id', $userId)
            ->where(function ($query) use ($today) {
                $query->where('payment_status', 'pending')
                      ->orWhere(function ($q) use ($today) {
                          $q->where('payment_status', 'paid')
                            ->where('check_out', '>=', $today);
                      });
            })
            ->orderBy('created_at', 'desc')
            ->get();
            
        return view('customer.history', compact('bookings'));
    }

    public function account()
    {
        $userId = auth()->id();
        $bookings = \App\Models\Booking::where('user_id', $userId)
            ->orderBy('created_at', 'desc')
            ->get();
            
        return view('customer.account', compact('bookings'));
    }
}
