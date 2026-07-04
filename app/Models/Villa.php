<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Villa extends Model
{
    use HasFactory;

    protected $fillable = [
        'pemilik_id',
        'name',
        'email',
        'image',
        'description',
        'price',
        'address',
        'latitude',
        'longitude',
        'persenan_pengelola',
        'persenan_pemilik',
    ];

    public function pemilik(): BelongsTo
    {
        return $this->belongsTo(User::class, 'pemilik_id');
    }

    public function transactions(): HasMany
    {
        return $this->hasMany(Transaction::class);
    }

    public function recurringTransactions(): HasMany
    {
        return $this->hasMany(RecurringTransaction::class);
    }

    public function rooms(): HasMany
    {
        return $this->hasMany(VillaRoom::class);
    }

    public function fasilitas()
    {
        return $this->belongsToMany(Fasilitas::class, 'fasilitas_villa', 'villa_id', 'fasilitas_id');
    }

    public function galleries()
    {
        return $this->hasMany(VillaGallery::class);
    }
}
