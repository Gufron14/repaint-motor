<?php

namespace App\Livewire\Admin\Repaint;

use Livewire\Component;
use App\Models\JenisRepaint as JenisRepaintModel;
use Livewire\WithPagination;
use Livewire\Attributes\Title;
use Livewire\Attributes\Layout;

#[Layout('livewire.admin.layouts.app')]
#[Title('Kelola Jenis Repaint')]
class JenisRepaint extends Component
{
    use WithPagination;

    public $nama_repaint = '';
    public $jenisRepaintId;
    public $isEditing = false;

    public function rules()
    {
        return [
            'nama_repaint' => 'required|min:3'
        ];
    }

    public function save()
    {
        $this->validate();

        if ($this->isEditing) {
            JenisRepaintModel::find($this->jenisRepaintId)->update([
                'nama_repaint' => $this->nama_repaint
            ]);
            session()->flash('success', 'Jenis repaint berhasil diupdate!');
        } else {
            JenisRepaintModel::create([
                'nama_repaint' => $this->nama_repaint
            ]);
            session()->flash('success', 'Jenis repaint berhasil ditambahkan!');
        }

        $this->reset('nama_repaint', 'isEditing', 'jenisRepaintId');
    }

    public function edit($id)
    {
        $jenisRepaint = JenisRepaintModel::find($id);
        $this->jenisRepaintId = $id;
        $this->nama_repaint = $jenisRepaint->nama_repaint;
        $this->isEditing = true;
    }

    public function delete($id)
    {
        JenisRepaintModel::find($id)->delete();
        session()->flash('success', 'Jenis repaint berhasil dihapus!');
    }

    public function render()
    {
        return view('livewire.admin.repaint.jenis-repaint', [
            'jenisRepaints' => JenisRepaintModel::latest()->paginate(10)
        ]);
    }
}
