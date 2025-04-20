<?php

namespace App\Livewire\Admin\Repaint;

use Livewire\Component;
use App\Models\TipeMotor as TipeMotorModel;
use App\Models\KategoriMotor;
use Livewire\Attributes\Title;
use Livewire\Attributes\Layout;
use Livewire\WithPagination;

#[Layout('livewire.admin.layouts.app')]
#[Title('Kelola Tipe Motor')]
class TipeMotor extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';

    public $nama_motor;
    public $kategori_motor_id;
    public $tipeMotorId;
    public $isEditing = false;
    public $selectedKategori = '';
    public $search = '';

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function rules()
    {
        return [
            'nama_motor' => 'required|string|max:255',
            'kategori_motor_id' => 'required|exists:kategori_motors,id'
        ];
    }

    public function save()
    {
        $this->validate();

        if ($this->isEditing) {
            TipeMotorModel::find($this->tipeMotorId)->update([
                'nama_motor' => $this->nama_motor,
                'kategori_motor_id' => $this->kategori_motor_id
            ]);
            session()->flash('success', 'Tipe motor berhasil diupdate!');
        } else {
            TipeMotorModel::create([
                'nama_motor' => $this->nama_motor,
                'kategori_motor_id' => $this->kategori_motor_id
            ]);
            session()->flash('success', 'Tipe motor berhasil ditambahkan!');
        }

        $this->reset();
    }

    public function edit($id)
    {
        $tipeMotor = TipeMotorModel::find($id);
        $this->tipeMotorId = $id;
        $this->nama_motor = $tipeMotor->nama_motor;
        $this->kategori_motor_id = $tipeMotor->kategori_motor_id;
        $this->isEditing = true;
    }

    public function delete($id)
    {
        TipeMotorModel::find($id)->delete();
        session()->flash('success', 'Tipe motor berhasil dihapus!');
    }

    public function render()
    {
        $query = TipeMotorModel::with('kategoriMotor');
        
        if ($this->selectedKategori) {
            $query->where('kategori_motor_id', $this->selectedKategori);
        }

        if ($this->search) {
            $query->where('nama_motor', 'like', '%' . $this->search . '%')
                  ->orWhereHas('kategoriMotor', function($q) {
                      $q->where('nama_kategori', 'like', '%' . $this->search . '%');
                  });
        }

        return view('livewire.admin.repaint.tipe-motor', [
            'tipeMotors' => $query->latest()->paginate(5),
            'kategoriMotors' => KategoriMotor::all()
        ]);
    }
}
