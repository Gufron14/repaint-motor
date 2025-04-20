<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\KategoriMotor;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(){
        $kategoriMotors = KategoriMotor::with('tipeMotors.motorRepaints.jenisRepaint')->get();

        return view('admin.dashboard', compact('kategoriMotors'));
    }
}
