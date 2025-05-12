<?php

namespace App\Livewire\Admin\Repaint;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\MotorRepaint;
use App\Models\TipeMotor;
use App\Models\JenisRepaint;
use App\Models\KategoriMotor;
use Livewire\Attributes\Title;
use Livewire\Attributes\Layout;

#[Layout('livewire.admin.layouts.app')]
#[Title('Kelola Harga Repaint')]
class HargaRepaint extends Component
{
    use WithPagination;

    public $search = '';
    public $kategori_id = '';
    public $motorRepaintId;
    public $tipe_motor_id;
    public $jenis_repaint_id;
    public $harga;
    public $estimasi_waktu;
    public $isOpen = false;

    public function render()
    {
        $query = MotorRepaint::query()
            ->with(['tipeMotor.kategoriMotor', 'jenisRepaint']);
    
        if ($this->search) {
            $query->whereHas('tipeMotor', function($q) {
                $q->where('nama_motor', 'like', '%' . $this->search . '%');
            });
        }
    
        if ($this->kategori_id) {
            $query->whereHas('tipeMotor', function($q) {
                $q->where('kategori_motor_id', $this->kategori_id);
            });
        }
    
        // Ambil semua jenis repaint yang tersedia
        $jenisRepaints = JenisRepaint::all();
        $totalJenisRepaint = $jenisRepaints->count();
        
        // Ambil semua tipe motor
        $allTipeMotors = TipeMotor::all();
        
        // Filter tipe motor yang belum memiliki semua jenis repaint
        $filteredTipeMotors = $allTipeMotors->filter(function($tipeMotor) use ($totalJenisRepaint) {
            $existingRepaintCount = MotorRepaint::where('tipe_motor_id', $tipeMotor->id)->count();
            return $existingRepaintCount < $totalJenisRepaint;
        });
        
        return view('livewire.admin.repaint.harga-repaint', [
            'motorRepaints' => $query->paginate(10),
            'kategoriMotors' => KategoriMotor::all(),
            'tipeMotors' => $filteredTipeMotors,
            'jenisRepaints' => $jenisRepaints
        ]);
    }
    

    public function create()
    {
        $this->resetInputFields();
        $this->openModal();
    }

    public function updatedTipeMotorId()
{
    if (!$this->tipe_motor_id) {
        return;
    }
    
    // Ambil jenis repaint yang sudah dimiliki oleh tipe motor ini
    $existingRepaintIds = MotorRepaint::where('tipe_motor_id', $this->tipe_motor_id)
        ->pluck('jenis_repaint_id')
        ->toArray();
    
    // Filter jenis repaint yang belum dimiliki
    $this->availableJenisRepaints = JenisRepaint::whereNotIn('id', $existingRepaintIds)->get();
}


    public function store()
    {
        $this->validate([
            'tipe_motor_id' => 'required',
            'jenis_repaint_id' => 'required',
            'harga' => 'required|numeric',
            'estimasi_waktu' => 'required|numeric'
        ]);
    
        // Check for existing combination
        $exists = MotorRepaint::where('tipe_motor_id', $this->tipe_motor_id)
            ->where('jenis_repaint_id', $this->jenis_repaint_id)
            ->where('id', '!=', $this->motorRepaintId)
            ->exists();
    
        if ($exists) {
            session()->flash('error', 'Kombinasi motor dan jenis repaint ini sudah ada.');
            return;
        }
    
        MotorRepaint::updateOrCreate(['id' => $this->motorRepaintId], [
            'tipe_motor_id' => $this->tipe_motor_id,
            'jenis_repaint_id' => $this->jenis_repaint_id,
            'harga' => $this->harga,
            'estimasi_waktu' => $this->estimasi_waktu
        ]);
    
        session()->flash('message', $this->motorRepaintId ? 'Data berhasil diperbarui.' : 'Data berhasil ditambahkan.');
        $this->closeModal();
        $this->resetInputFields();
    }
    

    public function edit($id)
    {
        $motorRepaint = MotorRepaint::findOrFail($id);
        $this->motorRepaintId = $id;
        $this->tipe_motor_id = $motorRepaint->tipe_motor_id;
        $this->jenis_repaint_id = $motorRepaint->jenis_repaint_id;
        $this->harga = $motorRepaint->harga;
        $this->estimasi_waktu = $motorRepaint->estimasi_waktu;
        $this->openModal();
    }

    public function delete($id)
    {
        MotorRepaint::find($id)->delete();
        session()->flash('message', 'Data berhasil dihapus.');
    }

    private function resetInputFields()
    {
        $this->motorRepaintId = '';
        $this->tipe_motor_id = '';
        $this->jenis_repaint_id = '';
        $this->harga = '';
        $this->estimasi_waktu = '';
    }

    public function openModal()
    {
        $this->isOpen = true;
    }

    public function closeModal()
    {
        $this->isOpen = false;
    }
}
