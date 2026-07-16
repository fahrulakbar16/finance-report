<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    use HasFactory;

    protected $fillable = [
        'invoice_number',
        'user_id',
        'villa_id',
        'guest_name',
        'guest_email',
        'guest_phone',
        'check_in',
        'check_out',
        'total_price',
        'voucher_id',
        'villa_snapshot',
        'payment_status',
        'payment_url',
    ];

    protected $casts = [
        'check_in' => 'date',
        'check_out' => 'date',
        'villa_snapshot' => 'json',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function villa()
    {
        return $this->belongsTo(Villa::class);
    }

    public function voucher()
    {
        return $this->belongsTo(Voucher::class);
    }
}
