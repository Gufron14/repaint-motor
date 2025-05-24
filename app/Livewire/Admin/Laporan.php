<?php

namespace App\Livewire\Admin;

use App\Models\Reservasi;
use App\Models\TipeMotor;
use App\Models\JenisRepaint;
use App\Models\MotorRepaint;
use Livewire\Component;
use Livewire\Attributes\Title;
use Livewire\Attributes\Layout;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Storage;

#[Layout('livewire.admin.layouts.app')]
#[Title('Laporan')]
class Laporan extends Component
{
    public $startDate;
    public $endDate;
    
    public function mount()
    {
        // Default to current month
        $this->startDate = now()->startOfMonth()->format('Y-m-d');
        $this->endDate = now()->endOfMonth()->format('Y-m-d');
    }
    
    public function render()
    {
        $laporan = $this->getLaporanData();
        
        return view('livewire.admin.laporan', [
            'laporan' => $laporan,
            'totalPendapatan' => collect($laporan)->sum('total_harga')
        ]);
    }
    
    public function getLaporanData()
    {
        $result = [];
        
        $reservasis = Reservasi::with(['user'])
            ->where('status', 'selesai')
            ->when($this->startDate, function($query) {
                return $query->whereDate('updated_at', '>=', $this->startDate);
            })
            ->when($this->endDate, function($query) {
                return $query->whereDate('updated_at', '<=', $this->endDate);
            })
            ->orderBy('updated_at', 'desc')
            ->get();
            
        foreach ($reservasis as $reservasi) {
            // Get motor type
            $tipeMotorId = $reservasi->tipe_motor_id;
            $tipeMotor = 'Tidak diketahui';
            if ($tipeMotorId) {
                $motorData = TipeMotor::find($tipeMotorId);
                if ($motorData) {
                    $tipeMotor = $motorData->nama_motor;
                }
            }
            
            // Get repaint types and prices
            $jenisRepaints = [];
            $repaintIds = [];
            
            // Try to get repaint IDs from jenis_repaint_id field
            if ($reservasi->jenis_repaint_id) {
                $repaintIds = json_decode($reservasi->jenis_repaint_id, true);
                if (!is_array($repaintIds)) {
                    $repaintIds = [$repaintIds];
                }
            }
            
            // If we have repaint IDs and motor type ID, get prices from motor_repaint table
            if (!empty($repaintIds) && $tipeMotorId) {
                foreach ($repaintIds as $repaintId) {
                    $jenisRepaint = JenisRepaint::find($repaintId);
                    if ($jenisRepaint) {
                        // Get price from motor_repaint table
                        $motorRepaint = MotorRepaint::where('tipe_motor_id', $tipeMotorId)
                            ->where('jenis_repaint_id', $repaintId)
                            ->first();
                        
                        $harga = 0;
                        if ($motorRepaint) {
                            $harga = $motorRepaint->harga;
                        }
                        
                        $jenisRepaints[] = [
                            'nama_repaint' => $jenisRepaint->nama_repaint,
                            'harga' => $harga
                        ];
                    }
                }
            }
            
            // If no repaint types found, add a default one
            if (empty($jenisRepaints)) {
                $jenisRepaints[] = [
                    'nama_repaint' => 'Tidak diketahui',
                    'harga' => 0
                ];
            }
            
            $result[] = [
                'tanggal' => $reservasi->updated_at->format('d-m-Y'),
                'nama_customer' => $reservasi->user->name ?? 'Customer',
                'tipe_motor' => $tipeMotor,
                'jenis_repaints' => $jenisRepaints,
                'total_harga' => $reservasi->total_harga ?? 0,
                'rowspan' => count($jenisRepaints)
            ];
        }
        
        return $result;
    }
    
    public function downloadPdf()
    {
        $laporan = $this->getLaporanData();
        $totalPendapatan = collect($laporan)->sum('total_harga');
        
        $pdf = Pdf::loadView('livewire.admin.laporan-pdf', [
            'laporan' => $laporan,
            'totalPendapatan' => $totalPendapatan,
            'startDate' => $this->startDate,
            'endDate' => $this->endDate,
        ]);
        
        return response()->streamDownload(function() use ($pdf) {
            echo $pdf->output();
        }, 'laporan-pendapatan-' . now()->format('d-m-Y') . '.pdf');
    }
}
