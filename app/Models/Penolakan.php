<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Penolakan extends Model
{
    use HasFactory;

    protected $fillable = [
        'keterangan',
        'tipe',
    ];

    // Tambahkan scope untuk customer
    public function scopeForCustomer($query)
    {
        return $query->where('tipe', 'customer');
    }

    public function reservasi()
    {
        return $this->hasMany(Reservasi::class, 'penolakan_id');
    }
}
