<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Warna extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama_warna',
        'jenis_warna',
        'kode_hex'
    ];

    // Relasi ke Reservasi berdasarkan foreign key
    public function reservasiBody()
    {
        return $this->hasMany(Reservasi::class, 'warna_body_id');
    }

    public function reservasiVelg()
    {
        return $this->hasMany(Reservasi::class, 'warna_velg_id');
    }

    public function reservasiKnalpot()
    {
        return $this->hasMany(Reservasi::class, 'warna_knalpot_id');
    }

    public function reservasiCvt()
    {
        return $this->hasMany(Reservasi::class, 'warna_cvt_id');
    }
}
