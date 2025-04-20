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

        $totalHariSebelumnya = 0;
        $today = Carbon::now();
        $currentUserId = Auth::id();
        
        return $reservasis->map(function ($reservasi, $index) use (&$totalHariSebelumnya, $today, $currentUserId) {
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
            
            // Hitung estimasi selesai berdasarkan total hari pengerjaan sebelumnya
            if ($index === 0) {
                $hariSelesai = $hariPengerjaan;
            } else {
                $hariSelesai = $totalHariSebelumnya + $hariPengerjaan;
            }
            
            // Update total hari untuk customer berikutnya
            $totalHariSebelumnya = $hariSelesai;
            
            // Ambil nama jenis repaint
            $repaintIds = json_decode($reservasi->jenis_repaint_id);
            $jenisRepaints = JenisRepaint::whereIn('id', $repaintIds)->pluck('nama_repaint')->toArray();
            
            // Tentukan label customer (Kamu atau Customer X)
            // Nomor antrean dimulai dari 1 (bukan 0)
            $customerNumber = $index + 1;
            $customerLabel = ($currentUserId && $reservasi->user_id == $currentUserId) 
                ? 'Kamu' 
                : 'Customer ' . $customerNumber;
            
            // Format status untuk tampilan
            $statusLabel = ucfirst($reservasi->status);
            
            // Format estimasi selesai
            $estimasiSelesai = $reservasi->status == 'pasang' ? '0 Hari Lagi' : $hariSelesai . ' Hari Lagi';
            
            return [
                'customer' => $customerLabel,
                'repaint' => $jenisRepaints,
                'status' => $statusLabel,
                'estimasi_selesai' => $estimasiSelesai
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
