<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Fasilitas extends Model
{
    use HasFactory;

    protected $table = 'fasilitas';
    
    protected $fillable = [
        'nama',
        'ikon',
    ];

    public function villas()
    {
        return $this->belongsToMany(Villa::class, 'fasilitas_villa', 'fasilitas_id', 'villa_id');
    }
}
