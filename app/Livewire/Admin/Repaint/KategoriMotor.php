<?php

namespace App\Livewire\Admin\Repaint;

use Livewire\Component;
use App\Models\KategoriMotor as KategoriMotorModel;
use Livewire\WithPagination;
use Livewire\Attributes\Title;
use Livewire\Attributes\Layout;

#[Layout('livewire.admin.layouts.app')]
#[Title('Kelola Kategori Motor')]
class KategoriMotor extends Component
{
    use WithPagination;

    public $nama_kategori;
    public $kategori_id;
    public $isEditing = false;
    
    public function rules()
    {
        return [
            'nama_kategori' => 'required|min:3'
        ];
    }

    public function save()
    {
        $this->validate();

        if ($this->isEditing) {
            KategoriMotorModel::find($this->kategori_id)->update([
                'nama_kategori' => $this->nama_kategori
            ]);
            session()->flash('success', 'Kategori berhasil diupdate!');
        } else {
            KategoriMotorModel::create([
                'nama_kategori' => $this->nama_kategori
            ]);
            session()->flash('success', 'Kategori berhasil ditambahkan!');
        }

        $this->reset('nama_kategori', 'isEditing', 'kategori_id');
    }

    public function edit($id)
    {
        $kategori = KategoriMotorModel::find($id);
        $this->kategori_id = $id;
        $this->nama_kategori = $kategori->nama_kategori;
        $this->isEditing = true;
    }

    public function delete($id)
    {
        KategoriMotorModel::find($id)->delete();
        session()->flash('success', 'Kategori berhasil dihapus!');
    }

    public function render()
    {
        return view('livewire.admin.repaint.kategori-motor', [
            'kategoris' => KategoriMotorModel::latest()->paginate(10)
        ]);
    }
}
