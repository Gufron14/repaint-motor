<?php

namespace App\Models;

use App\Models\MotorRepaint;
use App\Models\KategoriMotor;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class TipeMotor extends Model
{
    use HasFactory;

    protected $fillable = ['nama_motor', 'kategori_motor_id'];

    public function kategoriMotor()
    {
        return $this->belongsTo(KategoriMotor::class, 'kategori_motor_id');
    }

    public function motorRepaints()
    {
        return $this->hasMany(MotorRepaint::class, 'tipe_motor_id');
    }
}
