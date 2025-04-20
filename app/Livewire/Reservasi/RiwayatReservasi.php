<?php

namespace App\Livewire\Reservasi;

use App\Models\Payment;
use Livewire\Component;
use App\Models\Reservasi;
use App\Models\JenisRepaint;
use Livewire\WithFileUploads;
use Livewire\Attributes\Title;

#[Title('Riwayat Reservasi')]
class RiwayatReservasi extends Component
{   
    use WithFileUploads;

    public $bukti_pembayaran;
    public $reservasiId;

    protected $rules = [
        'bukti_pembayaran' => 'required|image|max:2048',
    ];

    public function submitPembayaran($reservasiId)
    {   
        $this->validate([
            'bukti_pembayaran' => 'required|image|max:2048'
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
            ]
        );
    
        session()->flash('success', 'Bukti pembayaran berhasil dikirim!');
        $this->reset('bukti_pembayaran');
    
        return redirect()->route('riwayat.reservasi');
    }
    

    public function render()
    {
        $reservasi = Reservasi::with(['tipeMotor', 'kategoriMotor', 'payment', 'user'])
        ->where('user_id', auth()->id())
        ->orderBy('created_at', 'desc')
        ->get();
    
        // Decode JSON dan ambil data jenis repaint
        $reservasi->transform(function ($item) {
            $jenisRepaintIds = json_decode($item->jenis_repaint_id, true); // Decode JSON ke array
            $item->jenisRepaint = JenisRepaint::whereIn('id', $jenisRepaintIds)->pluck('nama_repaint')->toArray();
            return $item;
        });

        return view('livewire.reservasi.riwayat-reservasi', [
            'reservasi' => $reservasi,
        ]);
    }

    public function batalkanReservasi($id)
    {
        $reservasi = Reservasi::find($id);
        $reservasi->status = 'batal';
        $reservasi->save();

        session()->flash('success', 'Reservasi berhasil dibatalkan');
    }
}
