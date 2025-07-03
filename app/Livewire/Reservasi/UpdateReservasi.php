<?php

namespace App\Livewire\Reservasi;

use Log;
use Midtrans\Snap;
use App\Models\Payment;
use Livewire\Component;
use App\Models\Reservasi;
use App\Models\TipeMotor;
use App\Models\JenisRepaint;
use App\Models\MotorRepaint;
use App\Models\KategoriMotor;
use Livewire\WithFileUploads;
use Livewire\Attributes\Title;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

#[Title('Update Reservasi')]
class UpdateReservasi extends Component
{
    use WithFileUploads;

    // Motor
    public $kategoriMotor;
    public $tipeMotor = [];
    public $jenisRepaint;
    public $selectedKategori = null;
    public $selectedTipe = null;
    public $selectedRepaints = [];
    public $warna_body;
    public $warna_velg;
    public $warna_knalpot;
    public $warna_cvt;
    public $foto_motor;
    public $foto_velg;
    public $foto_knalpot;
    public $foto_cvt;
    public $nomor_polisi;
    public $catatan;

    // Existing photos
    public $existing_foto_motor;
    public $existing_foto_velg;
    public $existing_foto_knalpot;
    public $existing_foto_cvt;

    // Harga Repaint
    public $totalHarga = 0;
    public $estimasiWaktu = 0;
    public $bukti_pembayaran;
    public $dpHarga = 0;

    // Reservasi
    public $reservasiId;
    public $reservasi;
    public $snapToken;

    public $availableFullBodyTypes = [];
    public $availableBodyHalusTypes = [];
    public $availableBodyKasarTypes = [];
    public $availableVelgTypes = [];
    public $availableKnalpotTypes = [];
    public $availableCVTTypes = [];

    public $reservasiTersimpan = false;

    // Payment
    public $existingPayment;
    public $originalTotalHarga = 0;
    public $additionalPayment = 0;
    public $showPaymentModal = false;

    protected $rules = [
        'selectedKategori' => 'required',
        'selectedTipe' => 'required',
        'selectedRepaints' => 'required|array|min:1|max:2',
        'bukti_pembayaran' => 'nullable|image|max:2048',
    ];

    public function mount($id)
    {
        $this->kategoriMotor = KategoriMotor::all();
        $this->jenisRepaint = JenisRepaint::all();

        // Load existing reservasi data
        $this->reservasi = Reservasi::where('id', $id)->where('user_id', Auth::id())->firstOrFail();

        $this->reservasiId = $this->reservasi->id;
        $this->loadExistingData();
    }

    public function loadExistingData()
    {
        // Load existing data into form fields
        $this->selectedKategori = $this->reservasi->kategori_motor_id;
        $this->selectedTipe = $this->reservasi->tipe_motor_id;
        $this->selectedRepaints = json_decode($this->reservasi->jenis_repaint_id, true) ?? [];
        $this->warna_body = $this->reservasi->warna_body;
        $this->warna_velg = $this->reservasi->warna_velg;
        $this->warna_knalpot = $this->reservasi->warna_knalpot;
        $this->warna_cvt = $this->reservasi->warna_cvt;
        $this->nomor_polisi = $this->reservasi->nomor_polisi;
        $this->catatan = $this->reservasi->catatan;
        $this->totalHarga = $this->reservasi->total_harga;
        $this->estimasiWaktu = $this->reservasi->estimasi_waktu;
        $this->dpHarga = $this->totalHarga * 0.1;

        // Store existing photo paths
        $this->existing_foto_motor = $this->reservasi->foto_motor;
        $this->existing_foto_velg = $this->reservasi->foto_velg;
        $this->existing_foto_knalpot = $this->reservasi->foto_knalpot;
        $this->existing_foto_cvt = $this->reservasi->foto_cvt;

        // Load tipe motor based on selected kategori
        if ($this->selectedKategori) {
            $this->tipeMotor = TipeMotor::where('kategori_motor_id', $this->selectedKategori)->get();
        }

        // Load available types for selected tipe
        if ($this->selectedTipe) {
            $this->loadAvailableTypes();
        }

        $this->reservasiTersimpan = true;

        $this->originalTotalHarga = $this->reservasi->total_harga;
        $this->existingPayment = Payment::where('reservasi_id', $this->reservasiId)->first();
    }

    public function calculateAdditionalPayment()
    {
        if ($this->existingPayment) {
            // Jika sudah ada pembayaran, hitung selisih dari total harga baru
            $this->additionalPayment = $this->totalHarga - $this->originalTotalHarga;
        } else {
            // Jika belum ada pembayaran, bayar DP 10%
            $this->additionalPayment = $this->dpHarga;
        }
    }

    public function loadAvailableTypes()
    {
        $motorRepaints = MotorRepaint::where('tipe_motor_id', $this->selectedTipe)->get();

        $this->availableFullBodyTypes = $motorRepaints->where('jenis_repaint_id', 1)->pluck('tipe_motor_id')->toArray();
        $this->availableBodyHalusTypes = $motorRepaints->where('jenis_repaint_id', 2)->pluck('tipe_motor_id')->toArray();
        $this->availableBodyKasarTypes = $motorRepaints->where('jenis_repaint_id', 3)->pluck('tipe_motor_id')->toArray();
        $this->availableVelgTypes = $motorRepaints->where('jenis_repaint_id', 4)->pluck('tipe_motor_id')->toArray();
        $this->availableKnalpotTypes = $motorRepaints->where('jenis_repaint_id', 5)->pluck('tipe_motor_id')->toArray();
        $this->availableCVTTypes = $motorRepaints->where('jenis_repaint_id', 6)->pluck('tipe_motor_id')->toArray();
    }

    public function resetForm()
    {
        $this->selectedKategori = null;
        $this->selectedTipe = null;
        $this->selectedRepaints = [];
        $this->totalHarga = 0;
        $this->estimasiWaktu = 0;
        $this->tipeMotor = [];
    }

    public function updatedSelectedKategori($value)
    {
        if ($value) {
            $this->tipeMotor = TipeMotor::where('kategori_motor_id', $value)->get();
        } else {
            $this->tipeMotor = [];
        }
        $this->selectedTipe = null;
        $this->resetCalculation();
    }

    public function updatedSelectedTipe($value)
    {
        if ($value) {
            $this->loadAvailableTypes();
        }
        $this->resetCalculation();
    }

    public function updatedSelectedRepaints($value)
    {
        $fullBodyId = 1;
        $bodyHalusId = 2;
        $bodyKasarId = 3;
        $allowedSecondary = [4, 5, 6]; // velg, knalpot, cvt

        // Logika: hanya salah satu dari Full Body, Body Halus, Body Kasar yang boleh aktif
        $bodyIds = [$fullBodyId, $bodyHalusId, $bodyKasarId];
        $selectedBodyIds = array_intersect($this->selectedRepaints, $bodyIds);

        if (count($selectedBodyIds) > 1) {
            // Ambil ID terakhir yang dicentang dari group body
            $lastBodySelected = end($selectedBodyIds);

            // Reset pilihan body hanya ke ID terakhir
            $this->selectedRepaints = array_filter($this->selectedRepaints, function ($id) use ($bodyIds, $lastBodySelected) {
                // Buang semua kecuali body terakhir & pilihan non-body
                return !in_array($id, $bodyIds) || $id == $lastBodySelected;
            });

            // Reset array index
            $this->selectedRepaints = array_values($this->selectedRepaints);
        }

        // Maksimal 4 pilihan
        if (count($this->selectedRepaints) > 4) {
            $this->selectedRepaints = array_slice($this->selectedRepaints, 0, 4);
        }

        // Jika memilih 2 jenis, salah satunya harus velg, knalpot, atau cvt
        if (count($this->selectedRepaints) === 2) {
            $containsAllowed = false;
            foreach ($this->selectedRepaints as $id) {
                if (in_array($id, $allowedSecondary)) {
                    $containsAllowed = true;
                    break;
                }
            }

            if (!$containsAllowed) {
                $this->selectedRepaints = [end($this->selectedRepaints)];
            }
        }

        $this->calculateTotal();
    }

    public function calculateTotal()
{
    $this->totalHarga = 0;
    $this->dpHarga = 0;
    $this->estimasiWaktu = 0;

    if (!empty($this->selectedRepaints)) {
        $repaints = JenisRepaint::whereIn('id', $this->selectedRepaints)->get();

        foreach ($repaints as $repaint) {
            $motorRepaint = MotorRepaint::where('tipe_motor_id', $this->selectedTipe)->where('jenis_repaint_id', $repaint->id)->first();

            if ($motorRepaint) {
                $this->totalHarga += $motorRepaint->harga;
                $this->estimasiWaktu += $motorRepaint->estimasi_waktu;
            }
        }

        $this->dpHarga = $this->totalHarga * 0.1;
        $this->calculateAdditionalPayment(); // Tambahkan ini
    }
}

    public function resetCalculation()
    {
        $this->selectedRepaints = [];
        $this->totalHarga = 0;
        $this->estimasiWaktu = 0;
    }

    public function openPaymentModal()
    {
        $this->calculateAdditionalPayment();
        $this->showPaymentModal = true;
        $this->dispatch('openPaymentModal');
    }

    public function updateReservasi()
    {
        try {
            $this->validate([
                'selectedKategori' => 'required',
                'selectedTipe' => 'required',
                'selectedRepaints' => 'required|array|min:1|max:4',
                'warna_body' => 'nullable',
                'warna_velg' => 'nullable',
                'warna_knalpot' => 'nullable',
                'warna_cvt' => 'nullable',
                'foto_motor' => 'nullable|image|max:1024',
                'foto_velg' => 'nullable|image|max:1024',
                'foto_knalpot' => 'nullable|image|max:1024',
                'foto_cvt' => 'nullable|image|max:1024',
                'nomor_polisi' => 'required',
                'catatan' => 'required',
            ]);

            // Handle file uploads - only update if new files are uploaded
            $foto_motor_path = $this->existing_foto_motor;
            if ($this->foto_motor) {
                // Delete old file if exists
                if ($this->existing_foto_motor) {
                    Storage::disk('public')->delete($this->existing_foto_motor);
                }
                $foto_motor_path = $this->foto_motor->store('foto-motor', 'public');
            }

            $foto_velg_path = $this->existing_foto_velg;
            if ($this->foto_velg) {
                if ($this->existing_foto_velg) {
                    Storage::disk('public')->delete($this->existing_foto_velg);
                }
                $foto_velg_path = $this->foto_velg->store('foto-velg', 'public');
            }

            $foto_knalpot_path = $this->existing_foto_knalpot;
            if ($this->foto_knalpot) {
                if ($this->existing_foto_knalpot) {
                    Storage::disk('public')->delete($this->existing_foto_knalpot);
                }
                $foto_knalpot_path = $this->foto_knalpot->store('foto-knalpot', 'public');
            }

            $foto_cvt_path = $this->existing_foto_cvt;
            if ($this->foto_cvt) {
                if ($this->existing_foto_cvt) {
                    Storage::disk('public')->delete($this->existing_foto_cvt);
                }
                $foto_cvt_path = $this->foto_cvt->store('foto-cvt', 'public');
            }

            // Update reservasi
            $this->reservasi->update([
                'kategori_motor_id' => $this->selectedKategori,
                'tipe_motor_id' => $this->selectedTipe,
                'jenis_repaint_id' => json_encode($this->selectedRepaints),
                'warna_body' => $this->warna_body,
                'warna_velg' => $this->warna_velg,
                'warna_knalpot' => $this->warna_knalpot,
                'warna_cvt' => $this->warna_cvt,
                'foto_motor' => $foto_motor_path,
                'foto_velg' => $foto_velg_path,
                'foto_knalpot' => $foto_knalpot_path,
                'foto_cvt' => $foto_cvt_path,
                'nomor_polisi' => $this->nomor_polisi,
                'catatan' => $this->catatan,
                'total_harga' => $this->totalHarga,
                'estimasi_waktu' => $this->estimasiWaktu,
            ]);

            // Update existing photo paths
            $this->existing_foto_motor = $foto_motor_path;
            $this->existing_foto_velg = $foto_velg_path;
            $this->existing_foto_knalpot = $foto_knalpot_path;
            $this->existing_foto_cvt = $foto_cvt_path;

            // Reset file inputs
            $this->reset(['foto_motor', 'foto_velg', 'foto_knalpot', 'foto_cvt']);

            // Jika ada pembayaran tambahan, buka modal pembayaran
            if ($this->additionalPayment > 0) {
                $this->openPaymentModal();
                session()->flash('message', 'Reservasi berhasil diupdate! Silakan lakukan pembayaran tambahan.');
            } else {
                session()->flash('message', 'Reservasi berhasil diupdate!');
                return redirect()->route('riwayat.reservasi');
            }
        } catch (\Exception $e) {
            \Log::error('Error in updateReservasi method: ' . $e->getMessage());
            \Log::error('Error trace: ' . $e->getTraceAsString());

            session()->flash('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function submitAdditionalPayment()
    {
        try {
            if (!$this->bukti_pembayaran) {
                session()->flash('error', 'File bukti pembayaran tidak ditemukan.');
                return;
            }

            $filename = $this->bukti_pembayaran->store('bukti-pembayaran', 'public');

            // Buat payment baru untuk pembayaran tambahan
            Payment::create([
                'reservasi_id' => $this->reservasiId,
                'metode_pembayaran' => 'transfer',
                'status_pembayaran' => 'pending',
                'bukti_pembayaran' => $filename,
                'jumlah_pembayaran' => $this->additionalPayment,
                'keterangan' => 'Pembayaran tambahan untuk update reservasi',
            ]);

            session()->flash('success', 'Pembayaran tambahan berhasil dikirim!');
            $this->reset('bukti_pembayaran');
            $this->showPaymentModal = false;

            return redirect()->route('riwayat.reservasi');
        } catch (\Exception $e) {
            \Log::error('Error in submitAdditionalPayment: ' . $e->getMessage());
            session()->flash('error', 'Terjadi kesalahan saat menyimpan pembayaran: ' . $e->getMessage());
        }
    }

    public function closePaymentModal()
    {
        $this->showPaymentModal = false;
        $this->reset('bukti_pembayaran');
    }

    public function render()
    {
        return view('livewire.reservasi.update-reservasi', [
            'kategoriMotor' => $this->kategoriMotor,
            'tipeMotor' => $this->tipeMotor,
            'jenisRepaint' => $this->jenisRepaint,
        ]);
    }
}
