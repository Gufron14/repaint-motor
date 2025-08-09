<?php

namespace App\Livewire\Reservasi;

use Midtrans\Snap;
use App\Models\Payment;
use Livewire\Component;
use App\Models\Reservasi;
use App\Models\TipeMotor;
use App\Models\JenisRepaint;
use App\Models\MotorRepaint;
use App\Models\KategoriMotor;
use App\Models\Warna;
use Livewire\WithFileUploads;
use Livewire\Attributes\Title;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;

#[Title('Reservasi')]
class Index extends Component
{
    use WithFileUploads;

    // Motor
    public $kategoriMotor;
    public $tipeMotor = [];
    public $jenisRepaint;
    public $selectedKategori = null;
    public $selectedTipe = null;
    public $selectedRepaints = [];
    public $warna_body_id;
    public $warna_velg_id;
    public $warna_knalpot_id;
    public $warna_cvt_id;

    // Data untuk warna
    public $availableNamaWarna = [];
    public $selectedNamaWarna = [];
    public $availableJenisWarna = [];
    public $selectedJenisWarna = [];
    public $selectedWarna = [];
    public $foto_motor;
    public $foto_velg;
    public $foto_knalpot;
    public $foto_cvt;
    public $nomor_polisi;
    public $catatan;

    // Harga Repaint
    public $totalHarga = 0;
    public $estimasiWaktu = 0;
    public $bukti_pembayaran;
    public $dpHarga = 0;

    // Reservasi
    public $reservasiId;
    public $snapToken;

    public $availableFullBodyTypes = [];
    public $availableBodyHalusTypes = [];
    public $availableBodyKasarTypes = [];
    public $availableVelgTypes = [];
    public $availableKnalpotTypes = [];
    public $availableCVTTypes = [];

    public $reservasiTersimpan = false; // Cek apakah reservasi sudah tersimpan

    protected $rules = [
        'selectedKategori' => 'required',
        'selectedTipe' => 'required',
        'selectedRepaints' => 'required|array|min:1|max:2',
        'bukti_pembayaran' => 'required|image|max:2048',
    ];

    public function mount()
    {
        $this->kategoriMotor = KategoriMotor::all();
        $this->jenisRepaint = JenisRepaint::all();
        $this->availableNamaWarna = Warna::pluck('nama_warna')->unique()->toArray();
    }

    public function resetForm()
    {
        $this->selectedKategori = null;
        $this->selectedTipe = null;
        $this->selectedRepaints = [];
        $this->totalHarga = 0;
        $this->estimasiWaktu = 0;
        $this->tipeMotor = [];
        $this->resetWarna();
    }

    public function resetWarna()
    {
        $this->selectedNamaWarna = [];
        $this->availableJenisWarna = [];
        $this->selectedJenisWarna = [];
        $this->selectedWarna = [];
        $this->warna_body_id = null;
        $this->warna_velg_id = null;
        $this->warna_knalpot_id = null;
        $this->warna_cvt_id = null;
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
            // Ambil data jenis repaint yang tersedia untuk tipe motor yang dipilih
            $motorRepaints = MotorRepaint::where('tipe_motor_id', $value)->get();

            // Update array tipe yang tersedia untuk setiap jenis repaint
            $this->availableFullBodyTypes = $motorRepaints->where('jenis_repaint_id', 1)->pluck('tipe_motor_id')->toArray();
            $this->availableBodyHalusTypes = $motorRepaints->where('jenis_repaint_id', 2)->pluck('tipe_motor_id')->toArray();
            $this->availableBodyKasarTypes = $motorRepaints->where('jenis_repaint_id', 3)->pluck('tipe_motor_id')->toArray();
            $this->availableVelgTypes = $motorRepaints->where('jenis_repaint_id', 4)->pluck('tipe_motor_id')->toArray();
            $this->availableKnalpotTypes = $motorRepaints->where('jenis_repaint_id', 5)->pluck('tipe_motor_id')->toArray();
            $this->availableCVTTypes = $motorRepaints->where('jenis_repaint_id', 6)->pluck('tipe_motor_id')->toArray();
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
        $this->resetWarna();
    }

    // Method untuk menangani perubahan nama warna
    public function updatedSelectedNamaWarna($value, $type)
    {
        if ($value) {
            $this->availableJenisWarna[$type] = Warna::where('nama_warna', $value)->get(['jenis_warna', 'kode_hex']);
        } else {
            $this->availableJenisWarna[$type] = [];
            $this->selectedJenisWarna[$type] = null;
            $this->selectedKodeHex[$type] = null;
        }
    }

    // Method untuk menangani perubahan jenis warna
    public function updatedSelectedJenisWarna($value, $type)
    {
        if ($value && isset($this->selectedNamaWarna[$type])) {
            $warna = Warna::where('nama_warna', $this->selectedNamaWarna[$type])
                          ->where('jenis_warna', $value)
                          ->first();
            
            if ($warna) {
                $this->selectedWarna[$type] = $warna;
                // Set warna_id sesuai tipe
                switch($type) {
                    case 'body':
                        $this->warna_body_id = $warna->id;
                        break;
                    case 'velg':
                        $this->warna_velg_id = $warna->id;
                        break;
                    case 'knalpot':
                        $this->warna_knalpot_id = $warna->id;
                        break;
                    case 'cvt':
                        $this->warna_cvt_id = $warna->id;
                        break;
                }
            }
        } else {
            $this->selectedWarna[$type] = null;
        }
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
        }
    }

    public function resetCalculation()
    {
        $this->selectedRepaints = [];
        $this->totalHarga = 0;
        $this->estimasiWaktu = 0;
    }

    public function reservasi()
    {
        try {
            $existingReservasi = Reservasi::where('user_id', Auth::id())
            ->where('status', 'pending')
            ->whereDoesntHave('payment', function ($q) {
                $q->whereNotNull('bukti_pembayaran');
            })
            ->first();

        if ($existingReservasi) {
            session()->flash('error', 'Anda sudah memiliki reservasi yang belum mengupload bukti pembayaran. Silakan upload bukti pembayaran terlebih dahulu di halaman Riwayat Reservasi.');
            return;
        }
        

            $this->validate([
                'selectedKategori' => 'required',
                'selectedTipe' => 'required',
                'selectedRepaints' => 'required|array|min:1|max:4',
                'warna_body_id' => 'nullable',
                'warna_velg_id' => 'nullable',
                'warna_knalpot_id' => 'nullable',
                'warna_cvt_id' => 'nullable',
                'foto_motor' => 'nullable|image|max:1024',
                'foto_velg' => 'nullable|image|max:1024',
                'foto_knalpot' => 'nullable|image|max:1024',
                'foto_cvt' => 'nullable|image|max:1024',
                'nomor_polisi' => 'required',
                'catatan' => 'required',
            ]);

            // Simpan file foto_motor jika ada
            $foto_motor_path = null;
            if ($this->foto_motor) {
                $foto_motor_path = $this->foto_motor->store('foto-motor', 'public');
            }

            // Simpan file foto_velg jika ada
            $foto_velg_path = null;
            if ($this->foto_velg) {
                $foto_velg_path = $this->foto_velg->store('foto-velg', 'public');
            }

            // Simpan file foto_knalpot jika ada
            $foto_knalpot_path = null;
            if ($this->foto_knalpot) {
                $foto_knalpot_path = $this->foto_knalpot->store('foto-knalpot', 'public');
            }

            // Simpan file foto_cvt jika ad
            $foto_cvt_path = null;
            if ($this->foto_cvt) {
                $foto_cvt_path = $this->foto_cvt->store('foto-cvt', 'public');
            }

            $reservasi = Reservasi::create([
                'user_id' => Auth::id(),
                'kategori_motor_id' => $this->selectedKategori,
                'tipe_motor_id' => $this->selectedTipe,
                'jenis_repaint_id' => $this->selectedRepaints,
                'warna_body_id' => $this->warna_body_id,
                'warna_velg_id' => $this->warna_velg_id,
                'warna_knalpot_id' => $this->warna_knalpot_id,
                'warna_cvt_id' => $this->warna_cvt_id,
                'foto_motor' => $foto_motor_path,
                'foto_velg' => $foto_velg_path,
                'foto_knalpot' => $foto_knalpot_path,
                'foto_cvt' => $foto_cvt_path,
                'nomor_polisi' => $this->nomor_polisi,
                'catatan' => $this->catatan,
                'total_harga' => $this->totalHarga,
                'estimasi_waktu' => $this->estimasiWaktu,
                'status' => 'pending',
            ]);

            // Log untuk debugging
            Log::info('Reservasi created with ID: ' . $reservasi->id);

            $reservasi->update([
                'jenis_repaint_id' => json_encode($this->selectedRepaints),
            ]);

            $this->reservasiId = $reservasi->id;
            $this->reservasiTersimpan = true; // Tandai bahwa reservasi sudah tersimpan

            // Log untuk debugging
            Log::info('ReservasiId set to: ' . $this->reservasiId);

            // Buat Snap Token dari Midtrans
            $this->createSnapToken($reservasi);

            session()->flash('message', 'Reservasi berhasil disimpan! Silakan lanjutkan ke pembayaran.');

            $this->dispatch('openPaymentModal');
        } catch (\Exception $e) {
            // Log error untuk debugging
            Log::error('Error in reservasi method: ' . $e->getMessage());
            Log::error('Error trace: ' . $e->getTraceAsString());

            session()->flash('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function createSnapToken($reservasi)
    {
        try {
            $user = Auth::user();

            // Make sure Midtrans is properly configured
            \Midtrans\Config::$serverKey = config('midtrans.server_key');
            \Midtrans\Config::$isProduction = (bool) config('midtrans.is_production');
            \Midtrans\Config::$isSanitized = true;
            \Midtrans\Config::$is3ds = true;

            $transaction_details = [
                'order_id' => 'REPAINT-' . $reservasi->id . '-' . time(),
                'gross_amount' => (int) $this->totalHarga,
            ];

            $customer_details = [
                'first_name' => $user->name,
                'email' => $user->email,
            ];

            $transaction = [
                'transaction_details' => $transaction_details,
                'customer_details' => $customer_details,
            ];

            // Tambahkan log untuk debugging
            Log::info('Creating Snap Token with data:', $transaction);

            $snapToken = Snap::getSnapToken($transaction);
            Log::info('Snap Token created: ' . $snapToken);

            // Simpan snap token ke database
            $payment = Payment::create([
                'reservasi_id' => $reservasi->id,
                'amount' => $this->dpHarga,
                'payment_type' => 'dp',
                'description' => 'DP Awal 10% dari total harga',
                'metode_pembayaran' => 'midtrans',
                'status_pembayaran' => 'pending',
                'snap_token' => $snapToken,
            ]);

            $this->snapToken = $snapToken;

            // Tambahkan log untuk memastikan snapToken tersimpan
            Log::info('Snap Token saved to component: ' . $this->snapToken);

            // Dispatch event to refresh the UI
            $this->dispatch('snapTokenGenerated', ['token' => $snapToken]);
        } catch (\Exception $e) {
            Log::error('Error creating Snap Token: ' . $e->getMessage());
            Log::error('Error trace: ' . $e->getTraceAsString());
            session()->flash('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function refreshSnapToken()
    {
        if ($this->reservasiId) {
            $reservasi = Reservasi::find($this->reservasiId);
            if ($reservasi) {
                $this->createSnapToken($reservasi);
                $this->dispatch('snapTokenRefreshed');
            }
        }
    }

    public function handleModalClose()
    {
        // Reset hanya field bukti pembayaran
        $this->reset('bukti_pembayaran');
        // Pertahankan data formulir lainnya
    }

    public function submitPembayaran()
    {
        try {
            // Debug info
            Log::info('submitPembayaran called with reservasiId: ' . ($this->reservasiId ?? 'null'));

            if (!$this->reservasiId) {
                session()->flash('error', 'ID Reservasi tidak ditemukan. Silakan buat reservasi terlebih dahulu.');
                return;
            }

            $filename = $this->bukti_pembayaran->store('bukti-pembayaran', 'public');

            // Debug info
            Log::info('Creating payment with reservasi_id: ' . $this->reservasiId);

            $reservasi = Reservasi::find($this->reservasiId);
            $payment = Payment::create([
                'reservasi_id' => $this->reservasiId,
                'amount' => $this->dpHarga,
                'payment_type' => 'dp',
                'description' => 'DP Awal 10% dari total harga',
                'metode_pembayaran' => 'transfer',
                'status_pembayaran' => 'pending',
                'bukti_pembayaran' => $filename,
            ]);

            if (!$this->bukti_pembayaran) {
                session()->flash('error', 'File bukti pembayaran tidak ditemukan.');
                return;
            }

            // Debug info
            Log::info('Payment created with ID: ' . $payment->id);

            session()->flash('success', 'Reservasi berhasil dikirim!');
            $this->reset('bukti_pembayaran');

            // Redirect ke home
            return redirect()->route('riwayat.reservasi');
        } catch (\Exception $e) {
            // Log error untuk debugging
            Log::error('Error in submitPembayaran: ' . $e->getMessage());
            Log::error('Error trace: ' . $e->getTraceAsString());

            session()->flash('error', 'Terjadi kesalahan saat menyimpan pembayaran: ' . $e->getMessage());
        }
    }

    public function render()
    {
        return view('livewire.reservasi.index', [
            'kategoriMotor' => $this->kategoriMotor,
            'tipeMotor' => $this->tipeMotor,
            'jenisRepaint' => $this->jenisRepaint,
        ]);
    }
}
