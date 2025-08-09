<div class="container">
    <div class="card shadow-sm">
        <div class="card-header bg-primary text-white">
            <h4 class="mb-0">Detail Reservasi #{{ $reservasi->id }}</h4>
        </div>
        <div class="card-body">
            <div class="row mb-4">
                <div class="col-md-6">
                    <h5 class="border-bottom pb-2">Informasi Pelanggan</h5>
                    <table class="table table-sm table-borderless">
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
                            <td>: {{ \Carbon\Carbon::parse($reservasi->tanggal_reservasi)->format('d M Y') }}</td>
                        </tr>
                        {{-- <tr>
                            <td>Status</td>
                            <td>:
                                <span
                                    class="badge bg-{{ $reservasi->status === 'pending'
                                        ? 'warning'
                                        : ($reservasi->status === 'confirmed'
                                            ? 'info'
                                            : ($reservasi->status === 'completed'
                                                ? 'success'
                                                : ($reservasi->status === 'cancelled'
                                                    ? 'danger'
                                                    : 'secondary'))) }}">
                                    {{ ucfirst($reservasi->status) }}
                                </span>
                            </td>
                        </tr> --}}
                    </table>
                </div>
                <div class="col-md-6">
                    <h5 class="border-bottom pb-2">Informasi Motor</h5>
                    <table class="table table-sm table-borderless">
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
                        <table class="table table-sm">
                            <thead class="bg-light">
                                <tr>
                                    <th>Jenis Repaint</th>
                                    <th>Harga</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($repaintDetails as $repaint)
                                    <tr>
                                        <td>{{ $repaint['nama'] }}</td>
                                        <td>Rp{{ number_format($repaint['harga'], 0, ',', '.') }}</td>
                                    </tr>
                                @endforeach
                                <tr class="fw-bold table-info">
                                    <td>Total Harga</td>
                                    <td>Rp{{ number_format($reservasi->total_harga, 0, ',', '.') }}</td>
                                </tr>
                                <tr class="table-warning">
                                    <td>DP 10%</td>
                                    <td>Rp{{ number_format($reservasi->total_harga * 0.1, 0, ',', '.') }}</td>
                                </tr>
                                <tr class="fw-bold table-danger">
                                    <td>Pelunasan</td>
                                    <td>Rp{{ number_format($reservasi->total_harga * 0.9, 0, ',', '.') }}</td>
                                </tr>
                            </tbody>
                            <tfoot>

                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>




<div class="row mb-4">
    <div class="col-12">
        <h5 class="border-bottom pb-2">Warna yang Dipilih</h5>
        <div class="d-flex gap-4">
            @if ($reservasi->warnaBody)
                <div>
                    <label>Warna Body:</label>
                    <div class="d-flex align-items-center gap-2">
                        <div style="width: 30px; height: 30px; background-color: {{ $reservasi->warnaBody->kode_hex }}; border: 1px solid #ddd; border-radius: 4px;"></div>
                        <span class="text-uppercase">{{ $reservasi->warnaBody->nama_warna }} {{ $reservasi->warnaBody->jenis_warna }} ({{ $reservasi->warnaBody->kode_hex }})</span>
                    </div>
                </div>
            @endif
            @if ($reservasi->warnaVelg)
                <div>
                    <label>Warna Velg:</label>
                    <div class="d-flex align-items-center gap-2">
                        <div style="width: 30px; height: 30px; background-color: {{ $reservasi->warnaVelg->kode_hex }}; border: 1px solid #ddd; border-radius: 4px;"></div>
                        <span class="text-uppercase">{{ $reservasi->warnaVelg->nama_warna }} {{ $reservasi->warnaVelg->jenis_warna }} ({{ $reservasi->warnaVelg->kode_hex }})</span>
                    </div>
                </div>
            @endif
            @if ($reservasi->warnaKnalpot)
                <div>
                    <label>Warna Knalpot:</label>
                    <div class="d-flex align-items-center gap-2">
                        <div style="width: 30px; height: 30px; background-color: {{ $reservasi->warnaKnalpot->kode_hex }}; border: 1px solid #ddd; border-radius: 4px;"></div>
                        <span class="text-uppercase">{{ $reservasi->warnaKnalpot->nama_warna }} {{ $reservasi->warnaKnalpot>jenis_warna }} ({{ $reservasi->warnaKnalpot->kode_hex }})</span>
                    </div>
                </div>
            @endif
            @if ($reservasi->warnaCvt)
                <div>
                    <label>Warna CVT:</label>
                    <div class="d-flex align-items-center gap-2">
                        <div style="width: 30px; height: 30px; background-color: {{ $reservasi->warnaCvt->kode_hex }}; border: 1px solid #ddd; border-radius: 4px;"></div>
                        <span class="text-uppercase">{{ $reservasi->warnaCvt->nama_warna }} {{ $reservasi->warnaCvt->jenis_warna }} ({{ $reservasi->warnaCvt->kode_hex }})</span>
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
                        @if ($reservasi->foto_motor)
                            <div class="col-md-6 mb-3">
                                <div class="card">
                                    <div class="card-header">Foto Motor</div>
                                    <div class="card-body text-center">
                                        <img src="{{ Storage::url($reservasi->foto_motor) }}" alt="Foto Motor"
                                            class="img-fluid" style="max-height: 300px;">
                                    </div>
                                </div>
                            </div>
                        @endif

                        @if ($reservasi->foto_velg)
                            <div class="col-md-6 mb-3">
                                <div class="card">
                                    <div class="card-header">Foto Velg</div>
                                    <div class="card-body text-center">
                                        <img src="{{ Storage::url($reservasi->foto_velg) }}" alt="Foto Velg"
                                            class="img-fluid" style="max-height: 300px;">
                                    </div>
                                </div>
                            </div>
                        @endif

                        @if ($reservasi->foto_knalpot)
                            <div class="col-md-6 mb-3">
                                <div class="card">
                                    <div class="card-header">Foto Knalpot</div>
                                    <div class="card-body text-center">
                                        <img src="{{ Storage::url($reservasi->foto_knalpot) }}" alt="Foto Velg"
                                            class="img-fluid" style="max-height: 300px;">
                                    </div>
                                </div>
                            </div>
                        @endif

                        @if ($reservasi->foto_cvt)
                            <div class="col-md-6 mb-3">
                                <div class="card">
                                    <div class="card-header">Foto CVT</div>
                                    <div class="card-body text-center">
                                        <img src="{{ Storage::url($reservasi->foto_cvt) }}" alt="Foto Velg"
                                            class="img-fluid" style="max-height: 300px;">
                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            @if ($reservasi->catatan)
                <div class="row mb-4">
                    <div class="col-12">
                        <h5 class="border-bottom pb-2">Catatan</h5>
                        <div class="p-3 bg-light rounded">
                            {{ $reservasi->catatan }}
                        </div>
                    </div>
                </div>
            @endif

            {{-- <div class="row">
                <div class="col-12">
                    <h5 class="border-bottom pb-2">Bukti Pembayaran</h5>
                    @if ($reservasi->motorRepaint->bukti_pembayaran)
                        <div class="text-center">
                            <img src="{{ Storage::url($reservasi->motorRepaint->bukti_pembayaran) }}" alt="Bukti Pembayaran"
                                class="img-fluid" style="max-height: 400px;">
                        </div>
                    @else
                        <div class="alert alert-warning">
                            Belum ada bukti pembayaran yang diunggah.
                        </div>
                    @endif
                </div>
            </div> --}}

            <a href="{{ route('admin.reservasi') }}" class="btn btn-secondary">
                <i class="bi bi-arrow-left"></i> Kembali
            </a>
            {{-- <div class="mt-4 d-flex justify-content-between">

                <div class="d-flex gap-2">
                    @if ($reservasi->status === 'pending')
                        <button class="btn btn-success" wire:click="updateStatus('confirmed')"
                            wire:loading.attr="disabled">
                            <i class="bi bi-check-circle"></i> Konfirmasi
                        </button>
                    @endif

                    @if ($reservasi->status === 'confirmed')
                        <button class="btn btn-primary" wire:click="updateStatus('completed')"
                            wire:loading.attr="disabled">
                            <i class="bi bi-check-all"></i> Selesaikan
                        </button>
                    @endif

                    @if ($reservasi->status !== 'cancelled' && $reservasi->status !== 'completed')
                        <button class="btn btn-danger" wire:click="updateStatus('cancelled')"
                            wire:loading.attr="disabled">
                            <i class="bi bi-x-circle"></i> Batalkan
                        </button>
                    @endif
                </div>
            </div> --}}
        </div>
    </div>
</div>
