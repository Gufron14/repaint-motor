<div class="container">
    <div class="card shadow-sm">
        <div class="card-header bg-primary text-white">
            <h4 class="mb-0">Detail Reservasi #{{ $reservasi->id }}</h4>
        </div>
        <div class="card-body">
            <div class="row mb-4">
                <div class="col-md-6">
                    <h5 class="border-bottom pb-2">Informasi Pelanggan</h5>
                    <table class="table table-borderless">
                        <tr>
                            <td width="40%">Nama</td>
                            <td>: {{ $reservasi->user->name }}</td>
                        </tr>
                        <tr>
                            <td>Email</td>
                            <td>: {{ $reservasi->user->email }}</td>
                        </tr>
                        <tr>
                            <td>No. Telepon</td>
                            <td>: {{ $reservasi->user->phone }}</td>
                        </tr>
                        <tr>
                            <td>Tanggal Reservasi</td>
                            <td>: {{ \Carbon\Carbon::parse($reservasi->tanggal_reservasi)->format('d F Y') }}</td>
                        </tr>
                        <tr>
                            <td>Status</td>
                            <td>: 
                                <span class="badge bg-{{ 
                                    $reservasi->status === 'pending' ? 'warning' : 
                                    ($reservasi->status === 'confirmed' ? 'info' : 
                                    ($reservasi->status === 'completed' ? 'success' : 
                                    ($reservasi->status === 'cancelled' ? 'danger' : 'secondary'))) 
                                }}">
                                    {{ ucfirst($reservasi->status) }}
                                </span>
                            </td>
                        </tr>
                    </table>
                </div>
                <div class="col-md-6">
                    <h5 class="border-bottom pb-2">Informasi Motor</h5>
                    <table class="table table-borderless">
                        <tr>
                            <td width="40%">Kategori Motor</td>
                            <td>: {{ $reservasi->kategoriMotor->nama_kategori }}</td>
                        </tr>
                        <tr>
                            <td>Tipe Motor</td>
                            <td>: {{ $reservasi->tipeMotor->nama_motor }}</td>
                        </tr>
                        <tr>
                            <td>Plat Nomor</td>
                            <td>: {{ $reservasi->nomor_polisi }}</td>
                        </tr>
                    </table>
                </div>
            </div>

            <div class="row mb-4">
                <div class="col-12">
                    <h5 class="border-bottom pb-2">Jenis Repaint</h5>
                    <div class="table-responsive">
                        <table class="table">
                            <thead class="bg-light">
                                <tr>
                                    <th>Jenis Repaint</th>
                                    <th>Harga</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($repaintDetails as $repaint)
                                <tr>
                                    <td>{{ $repaint['nama'] }}</td>
                                    <td>Rp{{ number_format($repaint['harga'], 0, ',', '.') }}</td>
                                </tr>
                                @endforeach
                                <tr class="fw-bold">
                                    <td>Total</td>
                                    <td>Rp{{ number_format($reservasi->total_harga, 0, ',', '.') }}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            
            
            

            <div class="row mb-4">
                <div class="col-12">
                    <h5 class="border-bottom pb-2">Warna yang Dipilih</h5>
                    <div class="d-flex gap-4">
                        @if($reservasi->warna_body)
                        <div>
                            <label>Warna Body:</label>
                            <div class="d-flex align-items-center gap-2">
                                <div style="width: 30px; height: 30px; background-color: {{ $reservasi->warna_body }}; border: 1px solid #ddd; border-radius: 4px;"></div>
                                <span>{{ $reservasi->warna_body }}</span>
                            </div>
                        </div>
                        @endif
                        
                        @if($reservasi->warna_velg)
                        <div>
                            <label>Warna Velg:</label>
                            <div class="d-flex align-items-center gap-2">
                                <div style="width: 30px; height: 30px; background-color: {{ $reservasi->warna_velg }}; border: 1px solid #ddd; border-radius: 4px;"></div>
                                <span>{{ $reservasi->warna_velg }}</span>
                            </div>
                        </div>
                        @endif
                    </div>
                </div>
            </div>

            <div class="row mb-4">
                <div class="col-12">
                    <h5 class="border-bottom pb-2">Foto Motor</h5>
                    <div class="row">
                        @if($reservasi->foto_motor)
                        <div class="col-md-6 mb-3">
                            <div class="card">
                                <div class="card-header">Foto Motor</div>
                                <div class="card-body text-center">
                                    <img src="{{ Storage::url($reservasi->foto_motor) }}" alt="Foto Motor" class="img-fluid" style="max-height: 300px;">
                                </div>
                            </div>
                        </div>
                        @endif
                        
                        @if($reservasi->foto_velg)
                        <div class="col-md-6 mb-3">
                            <div class="card">
                                <div class="card-header">Foto Velg</div>
                                <div class="card-body text-center">
                                    <img src="{{ Storage::url($reservasi->foto_velg) }}" alt="Foto Velg" class="img-fluid" style="max-height: 300px;">
                                </div>
                            </div>
                        </div>
                        @endif
                    </div>
                </div>
            </div>

            @if($reservasi->catatan)
            <div class="row mb-4">
                <div class="col-12">
                    <h5 class="border-bottom pb-2">Catatan</h5>
                    <div class="p-3 bg-light rounded">
                        {{ $reservasi->catatan }}
                    </div>
                </div>
            </div>
            @endif

            <div class="row">
                <div class="col-12">
                    <h5 class="border-bottom pb-2">Bukti Pembayaran</h5>
                    @if($reservasi->bukti_pembayaran)
                    <div class="text-center">
                        <img src="{{ Storage::url($reservasi->bukti_pembayaran) }}" alt="Bukti Pembayaran" class="img-fluid" style="max-height: 400px;">
                    </div>
                    @else
                    <div class="alert alert-warning">
                        Belum ada bukti pembayaran yang diunggah.
                    </div>
                    @endif
                </div>
            </div>

            <div class="mt-4 d-flex justify-content-between">
                <a href="{{ route('admin.reservasi') }}" class="btn btn-secondary">
                    <i class="bi bi-arrow-left"></i> Kembali
                </a>
                
                <div class="d-flex gap-2">
                    @if($reservasi->status === 'pending')
                    <button class="btn btn-success" wire:click="updateStatus('confirmed')" wire:loading.attr="disabled">
                        <i class="bi bi-check-circle"></i> Konfirmasi
                    </button>
                    @endif
                    
                    @if($reservasi->status === 'confirmed')
                    <button class="btn btn-primary" wire:click="updateStatus('completed')" wire:loading.attr="disabled">
                        <i class="bi bi-check-all"></i> Selesaikan
                    </button>
                    @endif
                    
                    @if($reservasi->status !== 'cancelled' && $reservasi->status !== 'completed')
                    <button class="btn btn-danger" wire:click="updateStatus('cancelled')" wire:loading.attr="disabled">
                        <i class="bi bi-x-circle"></i> Batalkan
                    </button>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
