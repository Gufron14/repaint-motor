<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Reservasi;
use App\Models\TipeMotor;
use App\Models\JenisRepaint;
use App\Models\MotorRepaint;
use App\Models\KategoriMotor;
use Livewire\Attributes\Title;
use Illuminate\Support\Facades\Auth;

#[Title('Kalkulator Harga')]
class KalkulatorHarga extends Component
{   

    public $kategoriMotor;
    public $tipeMotor = [];
    public $jenisRepaint;
    public $selectedKategori = null;
    public $selectedTipe = null;
    public $selectedRepaints = [];
    public $totalHarga = 0;
    public $estimasiWaktu = 0;
    public $reservasiId;

    public $availableFullBodyTypes = [];
    public $availableBodyHalusTypes = [];
    public $availableBodyKasarTypes = [];

    public $reservasiTersimpan = false; // Cek apakah reservasi sudah tersimpan

    protected $rules = [
        'selectedKategori' => 'required',
        'selectedTipe' => 'required',
        'selectedRepaints' => 'required|array|min:1|max:2',
    ];

    public function mount()
    {
        $this->kategoriMotor = KategoriMotor::all();
        $this->jenisRepaint = JenisRepaint::all();
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
            // Ambil data jenis repaint yang tersedia untuk tipe motor yang dipilih
            $motorRepaints = MotorRepaint::where('tipe_motor_id', $value)->get();

            // Update array tipe yang tersedia untuk setiap jenis repaint
            $this->availableFullBodyTypes = $motorRepaints->where('jenis_repaint_id', 1)->pluck('tipe_motor_id')->toArray();
            $this->availableBodyHalusTypes = $motorRepaints->where('jenis_repaint_id', 2)->pluck('tipe_motor_id')->toArray();
            $this->availableBodyKasarTypes = $motorRepaints->where('jenis_repaint_id', 3)->pluck('tipe_motor_id')->toArray();
        }

        $this->resetCalculation();
    }

    public function updatedSelectedRepaints($value)
    {
        $velgId = 4;

        // Jika memilih lebih dari 2 jenis
        if (count($this->selectedRepaints) > 2) {
            $this->selectedRepaints = array_slice($this->selectedRepaints, 0, 2);
        }

        // Jika memilih 2 jenis, salah satunya harus velg
        if (count($this->selectedRepaints) == 2) {
            if (!in_array($velgId, $this->selectedRepaints)) {
                // Jika tidak ada velg, ambil pilihan terakhir saja
                $this->selectedRepaints = [end($this->selectedRepaints)];
            }
        }

        $this->calculateTotal();
    }

    public function calculateTotal()
    {
        $this->totalHarga = 0;
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
        $this->validate([
            'selectedKategori' => 'required',
            'selectedTipe' => 'required',
            'selectedRepaints' => 'required|array|min:1|max:2',
        ]);

        $reservasi = Reservasi::create([
            'user_id' => Auth::id(),
            'kategori_motor_id' => $this->selectedKategori,
            'tipe_motor_id' => $this->selectedTipe,
            'jenis_repaint_id' => $this->selectedRepaints,
            'total_harga' => $this->totalHarga,
            'estimasi_waktu' => $this->estimasiWaktu,
            'tgl_reservasi' => now(),
            'status' => 'pending',
        ]);

        $reservasi->update([
            'jenis_repaint_id' => json_encode($this->selectedRepaints)
        ]);

        $this->reservasiId = $reservasi->id;
        $this->reservasiTersimpan = true; // Tandai bahwa reservasi sudah tersimpan

        session()->flash('message', 'Reservasi berhasil disimpan! Silakan lanjutkan ke pembayaran.');

    }

    public function render()
    {
        return view('livewire.kalkulator-harga', [
            'kategoriMotor' => $this->kategoriMotor,
            'tipeMotor' => $this->tipeMotor,
            'jenisRepaint' => $this->jenisRepaint,
        ]);
    }
}
