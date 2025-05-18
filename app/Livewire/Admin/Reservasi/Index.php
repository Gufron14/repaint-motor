<?php

namespace App\Livewire\Admin\Reservasi;

use Livewire\Component;
use App\Models\Reservasi;
use App\Models\JenisRepaint;
use Livewire\Attributes\Title;
use Livewire\Attributes\Layout;

#[Layout('livewire.admin.layouts.app')]
#[Title('Reservasi')]
class Index extends Component
{
    public function updateStatus($reservasiId, $status)
    {
        $reservasi = Reservasi::find($reservasiId);
        $reservasi->status = $status;
        $reservasi->save();

        session()->flash('message', 'Status reservasi berhasil diperbarui.');
    }

    public function render()
    {
        $query = Reservasi::with(['tipeMotor', 'kategoriMotor', 'payment', 'user'])
            ->orderBy('created_at', 'asc');
        
        if (!auth()->user()->hasRole('admin')) {
            $query->where('user_id', auth()->id());
        }
        
        $reservasi = $query->orderBy('created_at', 'desc')->get();
    
        // Transform remains the same
        $reservasi->transform(function ($item) {
            $jenisRepaintIds = json_decode($item->jenis_repaint_id, true);
            $item->jenisRepaint = JenisRepaint::whereIn('id', $jenisRepaintIds)->pluck('nama_repaint')->toArray();
            return $item;
        });
    
        return view('livewire.admin.reservasi.index', compact('reservasi'));
    }
    
}
