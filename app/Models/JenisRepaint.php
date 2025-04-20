<?php

namespace App\Models;

use App\Models\MotorRepaint;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class JenisRepaint extends Model
{
    use HasFactory;

    protected $fillable = ['nama_repaint'];

    public function motorRepaints()
    {
        return $this->hasMany(MotorRepaint::class, 'jenis_repaint_id');
    }
}
