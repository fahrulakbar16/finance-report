<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class RecurringTransaction extends Model
{
    use HasFactory;

    protected $fillable = [
        'villa_id',
        'name',
        'amount',
        'type',
        'category_id',
        'frequency',
        'start_date',
        'end_date',
    ];

    public function villa(): BelongsTo
    {
        return $this->belongsTo(Villa::class);
    }

    public function transactions(): HasMany
    {
        return $this->hasMany(Transaction::class, 'recurring_id');
    }
}
