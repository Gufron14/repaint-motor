<?php

namespace App\Livewire\Reservasi;

use App\Models\Payment;
use Livewire\Component;
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

    $reservasi->transform(function ($item) {
        $jenisRepaintIds = json_decode($item->jenis_repaint_id, true); // array of IDs
        $item->jenisRepaint = JenisRepaint::whereIn('id', $jenisRepaintIds)->pluck('nama_repaint')->toArray();
        $tipeMotorId = $item->tipe_motor_id;

        // Ambil data harga berdasarkan kombinasi tipe_motor_id & jenis_repaint_id
        $details = MotorRepaint::with('jenisRepaint')
            ->where('tipe_motor_id', $tipeMotorId)
            ->whereIn('jenis_repaint_id', $jenisRepaintIds)
            ->get();

        $jenisRepaintDetails = $details->map(function ($detail) {
            return [
                'nama' => $detail->jenisRepaint->nama_repaint,
                'harga' => $detail->harga,
            ];
        })->toArray();

        $item->jenisRepaintDetails = $jenisRepaintDetails;
        $item->total_harga = array_sum(array_column($jenisRepaintDetails, 'harga'));

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
