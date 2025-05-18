<?php

namespace App\Livewire\Admin\Reservasi;

use Livewire\Component;
use App\Models\Reservasi;
use App\Models\JenisRepaint;
use App\Models\MotorRepaint;
use Livewire\Attributes\Title;
use Livewire\Attributes\Layout;
use Illuminate\Support\Facades\Storage;

#[Title('Detail Reservasi')]
#[Layout('livewire.admin.layouts.app')]

class ViewReservasi extends Component
{
    public $reservasiId;
    public $reservasi;

    public $repaintDetails = [];
    
    public function mount($id)
    {
        $this->reservasiId = $id;
        $this->loadReservasi();
    }
    
    public function loadReservasi()
    {
        // Load reservasi with relationships
        $this->reservasi = Reservasi::with([
            'user', 
            'kategoriMotor', 
            'tipeMotor'
        ])->findOrFail($this->reservasiId);
        
        // Process jenis repaint data
        $jenisRepaintIds = json_decode($this->reservasi->jenis_repaint_id, true);
        
        // Create a separate property for repaint details instead of adding to the model
        $this->repaintDetails = [];
        
        foreach ($jenisRepaintIds as $repaintId) {
            $jenisRepaint = JenisRepaint::find($repaintId);
            $motorRepaint = MotorRepaint::where('tipe_motor_id', $this->reservasi->tipe_motor_id)
                                        ->where('jenis_repaint_id', $repaintId)
                                        ->first();
            
            if ($jenisRepaint && $motorRepaint) {
                $this->repaintDetails[] = [
                    'nama' => $jenisRepaint->nama_repaint,
                    'harga' => $motorRepaint->harga
                ];
            }
        }
        
        // Process jenis repaint names for display
        $this->reservasi->jenisRepaint = JenisRepaint::whereIn('id', $jenisRepaintIds)->pluck('nama_repaint')->toArray();
    }
    

    public function render()
    {
        return view('livewire.admin.reservasi.view-reservasi');
    }
}
