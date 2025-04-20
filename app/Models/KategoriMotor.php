<?php

namespace App\Models;

use App\Models\TipeMotor;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class KategoriMotor extends Model
{
    use HasFactory;

    protected $fillable = ['nama_kategori'];

    public function tipeMotors()
    {
        return $this->hasMany(TipeMotor::class, 'kategori_motor_id');
    }
}
