<?php

namespace App\Models;

use App\Models\TipeMotor;
use App\Models\JenisRepaint;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class MotorRepaint extends Model
{
    use HasFactory;

    protected $casts = [
        'estimasi_waktu' => 'integer',
        'harga' => 'integer'
    ];
    

    protected $table = 'motor_repaint';

    protected $fillable = ['tipe_motor_id', 'jenis_repaint_id', 'harga', 'estimasi_waktu'];

    public function tipeMotor()
    {
        return $this->belongsTo(TipeMotor::class, 'tipe_motor_id');
    }

    public function jenisRepaint()
    {
        return $this->belongsTo(JenisRepaint::class, 'jenis_repaint_id');
    }
}
