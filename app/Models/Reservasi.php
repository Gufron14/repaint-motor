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
        'penolakan_id',
        'warna_body',
        'warna_velg',
        'warna_knalpot',
        'warna_cvt',
        'foto_motor',
        'foto_velg',
        'foto_knalpot',
        'foto_cvt',
        'nomor_polisi',
        'catatan',
        'total_harga',
        'original_total_harga',
        'original_dp_amount',
        'estimasi_waktu',
        'status',
        'status_bayar'
        
    ];
    

    // Add method to calculate remaining payment
    public function getSisaBayarAttribute()
    {
        if ($this->status == 'selesai') {
            return 0;
        }
        return $this->total_harga * 0.9;
    }

    // Add method to get formatted remaining payment
    public function getFormattedSisaBayarAttribute()
    {
        return 'Rp' . number_format($this->sisa_bayar, 0, ',', '.');
    }

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

    public function penolakan()
    {
        return $this->belongsTo(Penolakan::class, 'penolakan_id');
    }

    public function payment()
    {
        return $this->hasOne(Payment::class, 'reservasi_id');
    }

    public function payments()
    {
        return $this->hasMany(Payment::class, 'reservasi_id');
    }

    // Method untuk menghitung selisih DP
    public function calculateDpDifference()
    {
        $newDp = $this->total_harga * 0.1;
        $originalDp = $this->original_dp_amount ?? ($this->original_total_harga * 0.1);
        
        return $newDp - $originalDp;
    }

    // Method untuk mendapatkan DP yang sudah dibayar
    public function getPaidDpAmount()
    {
        return $this->payments()
            ->where('payment_type', 'dp')
            ->where('status_pembayaran', 'berhasil')
            ->sum('amount');
    }

    // Method untuk mendapatkan total pembayaran tambahan
    public function getAdditionalPaymentAmount()
    {
        return $this->payments()
            ->where('payment_type', 'additional')
            ->where('status_pembayaran', 'berhasil')
            ->sum('amount');
    }
}
