<?php

namespace App\Models;

use App\Models\Reservasi;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Payment extends Model
{
    use HasFactory;

    protected $table = 'payment';

    protected $fillable = [
        'reservasi_id',
        'amount',
        'payment_type',
        'description',
        'metode_pembayaran',
        'status_pembayaran',
        'bukti_pembayaran',
        'bukti_pengembalian',
        'status_pengembalian',
        'snap_token'
    ];

    public function reservasi()
    {
        return $this->belongsTo(Reservasi::class, 'reservasi_id');
    }
}
