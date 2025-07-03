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
        // Auto-cancel reservasi yang sudah expired dengan status pending
        $this->autoCancelExpiredReservations();

        // Ambil reservasi dan urutkan berdasarkan waktu pembuatan (yang paling awal di urutan pertama)
        $reservasis = Reservasi::with(['user', 'jenisRepaint'])
            ->whereIn('status', ['pending', 'setuju', 'bongkar', 'cuci', 'amplas', 'dempul', 'epoxy', 'warna', 'permis', 'pasang'])
            ->orderBy('created_at', 'asc')
            ->get();

        $currentUserId = Auth::id();

        return $reservasis->map(function ($reservasi, $index) use ($currentUserId) {
            $hariPengerjaan = $reservasi->estimasi_waktu;

            // Jika status sudah pasang, maka estimasi waktu jadi 0 hari
            if ($reservasi->status == 'pasang') {
                $hariPengerjaan = 0;
                $detikSisa = 0;
                $totalDetikSisa = 0;
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

                // Hitung detik yang telah berlalu sejak reservasi dibuat (untuk testing: 30 detik = 1 hari)
                $tanggalReservasi = Carbon::parse($reservasi->created_at);
                $sekarang = Carbon::now();
                $detikTerlalu = $sekarang->diffInSeconds($tanggalReservasi);
                $hariTerlalu = floor($detikTerlalu / 86400); // 30 detik = 1 hari untuk testing // 86400 detik = 1 hari sebenarnya

                // Kurangi estimasi waktu dengan hari yang telah berlalu dan pengurangan berdasarkan status
                $hariPengerjaan = $hariPengerjaan - $hariTerlalu - $pengurangan;

                // Hitung sisa detik untuk hari berikutnya
                $detikSisa = 86400 - ($detikTerlalu % 86400); // 30 detik = 1 hari untuk testing // 86400 detik = 1 hari sebenarnya

                // Hitung total detik sisa
                if ($hariPengerjaan > 0) {
                    $totalDetikSisa = ($hariPengerjaan - 1) * 86400 + $detikSisa; // 30 detik = 1 hari untuk testing // 86400 detik = 1 hari sebenarnya
                } else {
                    $totalDetikSisa = 0;
                }

                // Pastikan tidak negatif
                $totalDetikSisa = max(0, $totalDetikSisa);

                // Pastikan hari pengerjaan tidak menjadi negatif
                $hariPengerjaan = max(0, $hariPengerjaan);

                if ($hariPengerjaan <= 0) {
                    $detikSisa = 0;
                    $totalDetikSisa = 0;
                }
            }

            // Estimasi selesai hanya berdasarkan estimasi waktu reservasi itu sendiri
            $hariSelesai = $hariPengerjaan;

            // Ambil nama jenis repaint
            $repaintIds = json_decode($reservasi->jenis_repaint_id);
            $jenisRepaints = JenisRepaint::whereIn('id', $repaintIds)->pluck('nama_repaint')->toArray();
            $tipeMotorId = $reservasi->tipe_motor_id;

            // Tentukan label customer (Kamu atau nama yang disamarkan)
            $isCurrentUser = $currentUserId && $reservasi->user_id == $currentUserId;

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

            // Format estimasi selesai dengan detik
            if ($reservasi->status == 'pasang') {
                $estimasiSelesai = 'Selesai';
            } elseif ($hariSelesai <= 0) {
                $estimasiSelesai = 'Hari Ini';
            } else {
                $estimasiSelesai = $hariSelesai . ' Hari Lagi';
            }

            return [
                'id' => $reservasi->id,
                'customer' => $customerLabel,
                'repaint' => $jenisRepaints,
                'status' => $statusLabel,
                'estimasi_selesai' => $estimasiSelesai,
                'is_current_user' => $isCurrentUser,
                'tipe_motor' => $reservasi->tipeMotor->nama_motor ?? '-',
                'detik_sisa' => $detikSisa,
                'total_detik_sisa' => max(0, $totalDetikSisa),
                'created_at' => $reservasi->created_at->format('Y-m-d\TH:i:s.v\Z'), // Format ISO yang lebih kompatibel
            ];
        });
    }

    private function autoCancelExpiredReservations()
    {
        $reservasisPending = Reservasi::where('status', 'pending')->get();

        foreach ($reservasisPending as $reservasi) {
            $tanggalReservasi = Carbon::parse($reservasi->created_at);
            $sekarang = Carbon::now();
            $detikTerlalu = $sekarang->diffInSeconds($tanggalReservasi);
            $hariTerlalu = floor($detikTerlalu / 30); // 30 detik = 1 hari untuk testing

            // Gunakan estimasi waktu yang sama seperti perhitungan utama
            $estimasiSisa = $reservasi->estimasi_waktu - $hariTerlalu;

            // Auto cancel jika waktu sudah habis
            if ($estimasiSisa <= 0) {
                $reservasi->update([
                    'status' => 'batal',
                    'penolakan_id' => $this->getAutoCancelPenolakanId(),
                ]);
            }
        }
    }

    private function getAutoCancelPenolakanId()
    {
        // Cari atau buat penolakan otomatis
        $penolakan = \App\Models\Penolakan::firstOrCreate([
            'keterangan' => 'Dibatalkan otomatis',
            'tipe' => 'admin',
        ]);

        return $penolakan->id;
    }

    public function render()
    {
        $dataAntrean = $this->getAntreanData();
        $userHasReservation = false;

        if (Auth::check()) {
            $userHasReservation = Reservasi::where('user_id', Auth::id())
                ->whereIn('status', ['setuju', 'bongkar', 'cuci', 'amplas', 'dempul', 'epoxy', 'warna', 'permis', 'pasang', 'pending'])
                ->exists();
        }

        return view('livewire.antrean', [
            'antreans' => $dataAntrean,
            'userHasReservation' => $userHasReservation,
        ]);
    }
}
