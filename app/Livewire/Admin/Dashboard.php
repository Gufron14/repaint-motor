<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use Livewire\Attributes\Title;
use Livewire\Attributes\Layout;
use App\Models\Reservasi; // Pastikan model ini ada
use App\Models\User; // Pastikan model ini ada
use App\Models\TipeMotor; // Pastikan model ini ada

#[Layout('livewire.admin.layouts.app')]
#[Title('Dashboard Hype Custom Project')]
class Dashboard extends Component
{
    public $jumlahReservasi;
    public $jumlahCustomer;
    public $jumlahTipeMotor;
    public $pendapatanDP;
    public $totalPendapatan;

    public function mount()
    {
        $this->jumlahReservasi = Reservasi::count();
        $this->jumlahCustomer = User::count();
        $this->jumlahTipeMotor = TipeMotor::count();
        // $this->pendapatanDP = Reservasi::sum('dp') * 0.10; // Asumsi 'dp' adalah kolom di tabel reservasi
        $this->totalPendapatan = Reservasi::sum('total_harga'); // Asumsi 'total_pendapatan' adalah kolom di tabel reservasi
    }

    public function render()
    {
        return view('livewire.admin.dashboard');
    }
}

