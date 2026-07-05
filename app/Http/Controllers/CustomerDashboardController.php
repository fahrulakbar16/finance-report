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
        return view('customer.history');
    }

    public function account()
    {
        return view('customer.account');
    }
}
