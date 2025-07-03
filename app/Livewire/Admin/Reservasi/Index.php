<?php

namespace App\Livewire\Admin\Reservasi;

use Livewire\Component;
use App\Models\Reservasi;
use App\Models\JenisRepaint;
use App\Models\Penolakan;
use Livewire\Attributes\Title;
use Livewire\Attributes\Layout;
use Livewire\WithFileUploads;

#[Layout('livewire.admin.layouts.app')]
#[Title('Reservasi')]
class Index extends Component
{
    use WithFileUploads;

    public $selectedPenolakanId;
    public $reservasiIdToReject;
    public $showRejectModal = false;
    public $buktiPengembalian;
    public $showRefundModal = []; // Tambahkan property ini


    public function updateStatus($reservasiId, $status)
    {
        $reservasi = Reservasi::find($reservasiId);
        $reservasi->status = $status;
        $reservasi->save();

        session()->flash('message', 'Status reservasi berhasil diperbarui.');
    }

    public function openRefundModal($reservasiId)
    {
        $this->showRefundModal[$reservasiId] = true;
        $this->buktiPengembalian = null;
    }

    public function closeRefundModal($reservasiId)
    {
        $this->showRefundModal[$reservasiId] = false;
        $this->buktiPengembalian = null;
    }

    public function showRejectModal($reservasiId)
    {
        $this->reservasiIdToReject = $reservasiId;
        $this->selectedPenolakanId = null;
        $this->showRejectModal = true;
    }

    public function closeRejectModal()
    {
        $this->showRejectModal = false;
        $this->reservasiIdToReject = null;
        $this->selectedPenolakanId = null;
    }

    public function rejectReservasi($reservasiId)
    {
        $this->validate(
            [
                'selectedPenolakanId' => 'required|exists:penolakans,id',
            ],
            [
                'selectedPenolakanId.required' => 'Silakan pilih alasan penolakan',
                'selectedPenolakanId.exists' => 'Alasan penolakan tidak valid',
            ],
        );

        $reservasi = Reservasi::find($reservasiId);
        $reservasi->status = 'tolak';
        $reservasi->penolakan_id = $this->selectedPenolakanId;
        $reservasi->save();

        $this->selectedPenolakanId = null;
        session()->flash('message', 'Reservasi berhasil ditolak dengan alasan yang dipilih.');
    }

    public function uploadBuktiPengembalian($reservasiId)
    {
        $this->validate(
            [
                'buktiPengembalian' => 'required|image|max:2048',
            ],
            [
                'buktiPengembalian.required' => 'Bukti pengembalian harus diupload',
                'buktiPengembalian.image' => 'File harus berupa gambar',
                'buktiPengembalian.max' => 'Ukuran file maksimal 2MB',
            ],
        );

        $reservasi = Reservasi::find($reservasiId);

        if ($reservasi && $reservasi->payment) {
            $path = $this->buktiPengembalian->store('bukti-pengembalian', 'public');

            $reservasi->payment->update([
                'bukti_pengembalian' => $path,
                'status_pengembalian' => true,
            ]);

            $this->closeRefundModal($reservasiId);
            session()->flash('message', 'Bukti pengembalian berhasil diupload.');
        }
    }

    public function render()
    {
        $query = Reservasi::with(['tipeMotor', 'kategoriMotor', 'payment', 'user', 'penolakan'])->orderBy('created_at', 'asc');

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

        $alasanPenolakan = Penolakan::all(); // Hapus where status

        return view('livewire.admin.reservasi.index', compact('reservasi', 'alasanPenolakan'));
    }
}
