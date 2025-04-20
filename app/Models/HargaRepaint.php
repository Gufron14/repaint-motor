<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HargaRepaint extends Model
{
    use HasFactory;

    protected $fillable = ['tipe_motor_id', 'jenis_repaint_id', 'harga'];

    public function tipeMotor()
    {
        return $this->belongsTo(TipeMotor::class);
    }

    public function jenisRepaint()
    {
        return $this->belongsTo(JenisRepaint::class);
    }
}
