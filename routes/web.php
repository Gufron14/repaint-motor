<?php

use App\Livewire\Admin\Laporan;
use App\Livewire\Home;
use App\Livewire\Antrean;
use App\Livewire\Portfolio;
use App\Livewire\Pricelist;
use App\Livewire\Auth\Login;
use App\Livewire\Auth\Profil;
use App\Livewire\Auth\Register;
use App\Livewire\Admin\Dashboard;
use App\Livewire\KalkulatorHarga;
use App\Livewire\Reservasi\Index;
use Illuminate\Support\Facades\Route;
use App\Livewire\Admin\Repaint\TipeMotor;
use App\Livewire\Admin\Repaint\HargaRepaint;
use App\Livewire\Admin\Repaint\JenisRepaint;
use App\Livewire\Reservasi\RiwayatReservasi;
use App\Livewire\Admin\Repaint\KategoriMotor;
use App\Livewire\Admin\Reservasi\ViewReservasi;
use App\Http\Controllers\User\UserAuthController;
use App\Livewire\Admin\Portfolio as AdminPortfolio;
use App\Http\Controllers\MidtransCallbackController;
use App\Livewire\Admin\Reservasi\Index as ReservasiIndex;
use App\Livewire\Reservasi\Payment;

// USER
// User Auth
// Route::get('login', [UserAuthController::class, 'login'])->name('login');
// Route::post('login', [UserAuthController::class, 'doLogin'])->name('doLogin');
// Route::get('register', [UserAuthController::class, 'register'])->name('register');
// Route::post('register', [UserAuthController::class, 'doRegister'])->name('doRegister');

Route::middleware('isGuest')->group(function () {
    Route::get('login', Login::class)->name('login');
    Route::get('register', Register::class)->name('register');
});
Route::get('profil/{user:name}', Profil::class)->name('profil');

Route::get('logout', [UserAuthController::class, 'logout'])->name('logout');

// User View Page
Route::get('/', Home::class)->name('/');
Route::get('kalkulator-harga', KalkulatorHarga::class)->name('kalkulator-harga');
Route::get('portofolio', Portfolio::class)->name('portfolio');
Route::get('pricelist', Pricelist::class)->name('pricelist');
Route::get('antrean', Antrean::class)->name('antrean');

Route::middleware(['auth', 'role:user|admin'])->group(function () {
    Route::get('reservasi', Index::class)->name('reservasi');
    Route::get('riwayat', RiwayatReservasi::class)->name('riwayat.reservasi');
});


// ADMIN
Route::prefix('admin')->middleware(['auth', 'role:admin'])->group(function () {
    Route::get('dashboard', Dashboard::class)->name('admin.dashboard');
    Route::get('reservasi', ReservasiIndex::class)->name('admin.reservasi');
    Route::get('reservasi/{id}/view', App\Livewire\Admin\Reservasi\ViewReservasi::class)->name('admin.reservasi.view');

    
    // Kelola Repaint
    Route::get('kategori-motor', KategoriMotor::class)->name('admin.kategori-motor');
    Route::get('tipe-motor', TipeMotor::class)->name('admin.tipe-motor');
    Route::get('jenis-repaint', JenisRepaint::class)->name('admin.jenis-repaint');
    Route::get('harga-repaint', HargaRepaint::class)->name('admin.harga-repaint');

    Route::get('portofolio', AdminPortfolio::class)->name('admin.portofolio');
    Route::get('laporan', Laporan::class)->name('admin.laporan');

    // Kelola Customer
    Route::get('customer', App\Livewire\Admin\Customer\Customer::class)->name('admin.customer');
    Route::get('customer/{id}/view', App\Livewire\Admin\Customer\ViewCustomer::class)->name('admin.customer.view');
});

Route::post('midtrans/callback', [MidtransCallbackController::class, 'handle'])->name('midtrans.callback');


