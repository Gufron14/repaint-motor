<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\Attributes\Title;
use App\Models\Reservasi;
use App\Models\JenisRepaint;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

#[Title('Antrean')]
class Antrean extends Component
{
    public function getAntreanData()
    {
        // Ambil reservasi dan urutkan berdasarkan waktu pembuatan (yang paling awal di urutan pertama)
        $reservasis = Reservasi::with(['user', 'jenisRepaint'])
            ->whereIn('status', ['setuju', 'bongkar', 'cuci', 'amplas', 'dempul', 'epoxy', 'warna', 'permis', 'pasang'])
            ->orderBy('created_at', 'asc')
            ->get();

        $currentUserId = Auth::id();
        
        return $reservasis->map(function ($reservasi, $index) use ($currentUserId) {
            $hariPengerjaan = $reservasi->estimasi_waktu;
            
            // Jika status sudah pasang, maka estimasi waktu jadi 0 hari
            if ($reservasi->status == 'pasang') {
                $hariPengerjaan = 0;
            } else {
                // Kurangi hari pengerjaan berdasarkan status
                $pengurangan = 0;
                
                if ($reservasi->status == 'epoxy') {
                    $pengurangan = 1;
                } elseif ($reservasi->status == 'warna') {
                    $pengurangan = 2; // 1 dari epoxy + 1 dari warna
                } elseif ($reservasi->status == 'permis') {
                    $pengurangan = 3; // 1 dari epoxy + 1 dari warna + 1 dari permis
                }
                
                // Pastikan hari pengerjaan tidak menjadi negatif
                $hariPengerjaan = max(1, $hariPengerjaan - $pengurangan);
            }
            
            // Estimasi selesai hanya berdasarkan estimasi waktu reservasi itu sendiri
            $hariSelesai = $hariPengerjaan;
            
            // Ambil nama jenis repaint
            $repaintIds = json_decode($reservasi->jenis_repaint_id);
            $jenisRepaints = JenisRepaint::whereIn('id', $repaintIds)->pluck('nama_repaint')->toArray();
            $tipeMotorId = $reservasi->tipe_motor_id;
            
            // Tentukan label customer (Kamu atau nama yang disamarkan)
            $isCurrentUser = ($currentUserId && $reservasi->user_id == $currentUserId);
            
            if ($isCurrentUser) {
                $customerLabel = 'Kamu';
            } else {
                // Ambil nama user dan samarkan
                $nama = $reservasi->user->name ?? 'Customer';
                if (strlen($nama) > 2) {
                    $firstChar = mb_substr($nama, 0, 1);
                    $lastChar = mb_substr($nama, -1, 1);
                    $middleLength = mb_strlen($nama) - 2;
                    $stars = str_repeat('*', $middleLength);
                    $customerLabel = $firstChar . $stars . $lastChar;
                } else {
                    $customerLabel = $nama; // Jika nama terlalu pendek, tampilkan apa adanya
                }
            }
            
            // Format status untuk tampilan
            $statusLabel = ucfirst($reservasi->status);
            
            // Format estimasi selesai
            $estimasiSelesai = $reservasi->status == 'pasang' ? '0 Hari Lagi' : $hariSelesai . ' Hari Lagi';
            
            return [
                'customer' => $customerLabel,
                'repaint' => $jenisRepaints,
                'status' => $statusLabel,
                'estimasi_selesai' => $estimasiSelesai,
                'is_current_user' => $isCurrentUser,
                'tipe_motor' => $reservasi->tipeMotor->nama_motor ?? '-' // Menggunakan nama_motor dari reservasi
            ];
        });
    }

    public function render()
    {
        $dataAntrean = $this->getAntreanData();
        $userHasReservation = false;
        
        if (Auth::check()) {
            $userHasReservation = Reservasi::where('user_id', Auth::id())
                ->whereIn('status', ['setuju', 'bongkar', 'cuci', 'amplas', 'dempul', 'epoxy', 'warna', 'permis', 'pasang'])
                ->exists();
        }
        
        return view('livewire.antrean', [
            'antreans' => $dataAntrean,
            'userHasReservation' => $userHasReservation
        ]);
    }
}
