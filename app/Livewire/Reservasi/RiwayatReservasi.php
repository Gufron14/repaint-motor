<?php

namespace App\Livewire\Reservasi;

use App\Models\Payment;
use Livewire\Component;
use App\Models\Penolakan;
use App\Models\Reservasi;
use App\Models\JenisRepaint;
use App\Models\MotorRepaint;
use Livewire\WithFileUploads;
use Livewire\Attributes\Title;

#[Title('Riwayat Reservasi')]
class RiwayatReservasi extends Component
{
    use WithFileUploads;

    public $bukti_pembayaran;
    public $reservasiId;
    public $warna_body = [];
    public $warna_velg = [];
    public $warna_knalpot = [];
    public $warna_cvt = [];
    public $foto_motor = [];
    public $foto_velg = [];
    public $foto_knalpot = [];
    public $foto_cvt = [];

    public $komponenTambah = [];

    public $selectedPenolakanId;
    public $showCancelModal = [];

    protected $rules = [
        'bukti_pembayaran' => 'required|image|max:2048',
    ];

    public function openCancelModal($reservasiId)
    {
        $this->showCancelModal[$reservasiId] = true;
        $this->selectedPenolakanId = null;
    }

    public function closeCancelModal($reservasiId)
    {
        $this->showCancelModal[$reservasiId] = false;
        $this->selectedPenolakanId = null;
    }

    public function batalkanReservasi($id)
    {
        $this->validate(
            [
                'selectedPenolakanId' => 'required|exists:penolakans,id',
            ],
            [
                'selectedPenolakanId.required' => 'Silakan pilih alasan pembatalan',
                'selectedPenolakanId.exists' => 'Alasan pembatalan tidak valid',
            ],
        );

        $reservasi = Reservasi::find($id);
        $reservasi->status = 'batal';
        $reservasi->penolakan_id = $this->selectedPenolakanId;
        $reservasi->save();

        $this->closeCancelModal($id);
        session()->flash('success', 'Reservasi berhasil dibatalkan');
    }

    public function submitPembayaran($reservasiId)
    {
        $this->validate([
            'bukti_pembayaran' => 'required|image|max:2048',
        ]);

        $this->reservasiId = $reservasiId;

        $reservasi = Reservasi::find($this->reservasiId);

        if (!$reservasi) {
            session()->flash('error', 'Reservasi tidak ditemukan.');
            return;
        }

        $filename = $this->bukti_pembayaran->store('bukti-pembayaran', 'public');

        Payment::updateOrCreate(
            ['reservasi_id' => $reservasi->id],
            [
                'metode_pembayaran' => 'transfer',
                'status_pembayaran' => 'pending',
                'bukti_pembayaran' => $filename,
            ],
        );

        session()->flash('success', 'Bukti pembayaran berhasil dikirim!');
        $this->reset('bukti_pembayaran');

        return redirect()->route('riwayat.reservasi');
    }

    public function tambahKomponen($reservasiId)
    {
        $reservasi = Reservasi::find($reservasiId);
        if (!$reservasi) {
            session()->flash('error', 'Reservasi tidak ditemukan.');
            return;
        }

        $komponenBaru = $this->komponenTambah[$reservasiId] ?? [];
        if (empty($komponenBaru)) {
            session()->flash('error', 'Pilih komponen yang ingin ditambahkan.');
            return;
        }

        // Validasi warna & foto sesuai komponen dengan logika yang sama seperti Index.php
        $rules = [];
        foreach ($komponenBaru as $komponenId) {
            // Body components (Full Body, Body Halus, Body Kasar)
            if (in_array($komponenId, [1, 2, 3])) {
                $rules["warna_body.$reservasiId"] = 'nullable';
                $rules["foto_motor.$reservasiId"] = 'required|image|max:1024';
            }
            // Velg
            if ($komponenId == 4) {
                $rules["warna_velg.$reservasiId"] = 'nullable';
                $rules["foto_velg.$reservasiId"] = 'nullable|image|max:1024';
            }
            // Knalpot
            if ($komponenId == 5) {
                $rules["warna_knalpot.$reservasiId"] = 'nullable';
                $rules["foto_knalpot.$reservasiId"] = 'nullable|image|max:1024';
            }
            // CVT
            if ($komponenId == 6) {
                $rules["warna_cvt.$reservasiId"] = 'nullable';
                $rules["foto_cvt.$reservasiId"] = 'nullable|image|max:1024';
            }
        }

        $this->validate($rules);

        // Gabungkan komponen lama dan baru
        $jenisLama = json_decode($reservasi->jenis_repaint_id, true) ?? [];
        $jenisBaru = array_unique(array_merge($jenisLama, $komponenBaru));

        // Hitung harga & estimasi baru
        $details = MotorRepaint::where('tipe_motor_id', $reservasi->tipe_motor_id)->whereIn('jenis_repaint_id', $jenisBaru)->get();
        $totalBaru = $details->sum('harga');
        $estimasiBaru = $details->sum('estimasi_waktu');
        $dpBaru = $totalBaru * 0.1;
        $dpLama = $reservasi->total_harga * 0.1;
        $sisaDp = $dpBaru - $dpLama;

        // Simpan foto baru jika ada
        if (isset($this->foto_motor[$reservasiId])) {
            $foto_motor_path = $this->foto_motor[$reservasiId]->store('foto-motor', 'public');
            $reservasi->foto_motor = $foto_motor_path;
        }
        if (isset($this->foto_velg[$reservasiId])) {
            $foto_velg_path = $this->foto_velg[$reservasiId]->store('foto-velg', 'public');
            $reservasi->foto_velg = $foto_velg_path;
        }
        if (isset($this->foto_knalpot[$reservasiId])) {
            $foto_knalpot_path = $this->foto_knalpot[$reservasiId]->store('foto-knalpot', 'public');
            $reservasi->foto_knalpot = $foto_knalpot_path;
        }
        if (isset($this->foto_cvt[$reservasiId])) {
            $foto_cvt_path = $this->foto_cvt[$reservasiId]->store('foto-cvt', 'public');
            $reservasi->foto_cvt = $foto_cvt_path;
        }

        // Update warna komponen
        if (isset($this->warna_body[$reservasiId])) {
            $reservasi->warna_body = $this->warna_body[$reservasiId];
        }
        if (isset($this->warna_velg[$reservasiId])) {
            $reservasi->warna_velg = $this->warna_velg[$reservasiId];
        }
        if (isset($this->warna_knalpot[$reservasiId])) {
            $reservasi->warna_knalpot = $this->warna_knalpot[$reservasiId];
        }
        if (isset($this->warna_cvt[$reservasiId])) {
            $reservasi->warna_cvt = $this->warna_cvt[$reservasiId];
        }

        // Update reservasi
        $reservasi->jenis_repaint_id = json_encode($jenisBaru);
        $reservasi->total_harga = $totalBaru;
        $reservasi->estimasi_waktu = $estimasiBaru;
        $reservasi->save();

        session()->flash('sisa_dp', $sisaDp);
        $this->komponenTambah[$reservasiId] = [];
        session()->flash('success', 'Komponen berhasil ditambahkan. Silakan upload bukti pembayaran sisa DP.');
    }

    public function submitPembayaranSisaDp($reservasiId)
    {
        $this->validate([
            'bukti_pembayaran' => 'required|image|max:2048',
        ]);

        $reservasi = Reservasi::find($reservasiId);
        if (!$reservasi) {
            session()->flash('error', 'Reservasi tidak ditemukan.');
            return;
        }

        $filename = $this->bukti_pembayaran->store('bukti-pembayaran', 'public');

        // Update atau buat payment baru
        Payment::updateOrCreate(
            ['reservasi_id' => $reservasi->id],
            [
                'metode_pembayaran' => 'transfer',
                'status_pembayaran' => 'pending',
                'bukti_pembayaran' => $filename,
            ],
        );

        session()->flash('success', 'Bukti pembayaran sisa DP berhasil dikirim!');
        $this->reset('bukti_pembayaran');
        return redirect()->route('riwayat.reservasi');
    }

    public function render()
    {
        $reservasi = Reservasi::with(['tipeMotor', 'kategoriMotor', 'payment', 'user', 'penolakan'])
            ->where('user_id', auth()->id())
            ->orderBy('created_at', 'desc')
            ->get();

        $reservasi->transform(function ($item) {
            $jenisRepaintIds = json_decode($item->jenis_repaint_id, true); // array of IDs
            $item->jenisRepaint = JenisRepaint::whereIn('id', $jenisRepaintIds)->pluck('nama_repaint')->toArray();
            $tipeMotorId = $item->tipe_motor_id;

            // Ambil data harga berdasarkan kombinasi tipe_motor_id & jenis_repaint_id
            $details = MotorRepaint::with('jenisRepaint')->where('tipe_motor_id', $tipeMotorId)->whereIn('jenis_repaint_id', $jenisRepaintIds)->get();

            $jenisRepaintDetails = $details
                ->map(function ($detail) {
                    return [
                        'nama' => $detail->jenisRepaint->nama_repaint,
                        'harga' => $detail->harga,
                    ];
                })
                ->toArray();

            $item->jenisRepaintDetails = $jenisRepaintDetails;
            $item->total_harga = array_sum(array_column($jenisRepaintDetails, 'harga'));

            return $item;
        });

        // Tambahkan baris berikut untuk mengirim $jenisRepaint ke view
        $jenisRepaint = JenisRepaint::all();

        $alasanPembatalan = Penolakan::forCustomer()->get();

        return view('livewire.reservasi.riwayat-reservasi', [
            'reservasi' => $reservasi,
            'jenisRepaint' => $jenisRepaint,
            'alasanPembatalan' => $alasanPembatalan,
        ]);
    }
}
