<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VillaRoom extends Model
{
    use HasFactory;

    protected $fillable = [
        'villa_id',
        'name',
        'amount',
    ];

    public function villa()
    {
        return $this->belongsTo(Villa::class);
    }
}
