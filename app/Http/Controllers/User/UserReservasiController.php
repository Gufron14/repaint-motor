<?php

namespace App\Http\Controllers\User;

use App\Models\TipeMotor;
use App\Models\JenisRepaint;
use Illuminate\Http\Request;
use App\Models\KategoriMotor;
use App\Http\Controllers\Controller;

class UserReservasiController extends Controller
{
    public function index()
    {
        $kategoriMotor = KategoriMotor::all();
        return view('reservasi', compact('kategoriMotor'));
    }

    public function getTipeMotor(Request $request)
    {
        $tipeMotor = TipeMotor::where('kategori_motor_id', $request->kategori_id)->get();
        return response()->json($tipeMotor);
    }

    public function getJenisRepaint()
    {
        $jenisRepaint = JenisRepaint::all();
        return response()->json($jenisRepaint);
    }


}
