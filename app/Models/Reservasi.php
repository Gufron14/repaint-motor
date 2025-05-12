<?php

namespace App\Models;

use App\Models\User;
use App\Models\Payment;
use App\Models\TipeMotor;
use App\Models\JenisRepaint;
use App\Models\KategoriMotor;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Reservasi extends Model
{
    use HasFactory;

    protected $casts = [
        'jenis_repaint_id' => 'array'
    ];
    

    protected $fillable = [
        'user_id',
        'kategori_motor_id',
        'tipe_motor_id',
        'jenis_repaint_id',
        'warna_body',
        'warna_velg',
        'foto_motor',
        'foto_velg',
        'nomor_polisi',
        'catatan',
        'total_harga',
        'estimasi_waktu',
        'status',
        'status_bayar'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function kategoriMotor()
    {
        return $this->belongsTo(KategoriMotor::class, 'kategori_motor_id');
    }

    public function tipeMotor()
    {
        return $this->belongsTo(TipeMotor::class, 'tipe_motor_id');
    }

    public function jenisRepaint()
    {
        return $this->belongsTo(JenisRepaint::class, 'jenis_repaint_id');
    }

    public function payment()
    {
        return $this->hasOne(Payment::class, 'reservasi_id');
    }
}
