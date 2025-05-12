<div>
    @if (session()->has('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @elseif (session()->has('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif

    <h3 class="fw-bold mb-5 text-center">Riwayat Reservasi</h3>

    @forelse ($reservasi as $index => $item)
        <div class="card mx-auto mb-3 p-3 w-75">
            <div class="card-body">
                <div class="mb-4">
                    @if ($item->status == 'pending')
                    @elseif ($item->status == 'setuju')
                        <div class="d-flex align-items-center alert alert-warning mt-2">
                            <div class="me-2 fs-5">
                                <i class="bi bi-check2-circle me-2"></i>
                            </div>
                            <div class="">
                                Reservasi Anda disetujui, silakan bawa motor anda ke alamat bengkel yang tertera
                                untuk dilakukan Repaint.
                            </div>
                        </div>
                    @elseif ($item->status == 'tolak')
                        <div class="d-flex align-items-center alert alert-danger mt-2">
                            <div class="me-2 fs-5">
                                <i class="bi bi-x-lg"></i>
                            </div>
                            <div class="">
                                Reservasi Anda Ditolak
                            </div>
                        </div>
                    @elseif ($item->status == 'batal')
                        <div class="d-flex align-items-center alert alert-danger mt-2">
                            <div class="me-2 fs-5">
                                <i class="bi bi-x-lg"></i>
                            </div>
                            <div class="">
                                Reservasi Anda Dibatalkan
                            </div>
                        </div>
                    @elseif ($item->status == 'selesai')
                        <div class="d-flex align-items-center alert alert-success mt-2">
                            <div class="me-2 fs-5">
                                <i class="bi bi-check2-circle"></i>
                            </div>
                            <div class="">
                                Motor anda Sudah selesai di Repaint, Silakan ambil Motor anda.
                            </div>
                        </div>
                    @else
                        {{-- Keep existing status badges for other statuses --}}
                        {{-- @include('existing-status-badges') --}}
                    @endif
                </div>
                <div class="d-flex align-items-center justify-content-between mb-3 p-2">
                    <div class="d-flex align-items-center flex-wrap">
                        <span class="badge me-2 text-bg-warning fs-5">
                            {{ $item->kategoriMotor->nama_kategori }}
                        </span>
                        <h4 class="mb-0 fw-bold">
                            {{ $item->tipeMotor->nama_motor }}:
                            @if (is_array($item->jenisRepaint) && count($item->jenisRepaint) > 0)
                                {{ implode(', ', $item->jenisRepaint) }}
                            @else
                                Data tidak tersedia
                            @endif
                        </h4>
                    </div>
                    <div class="d-flex align-items-center">
                        <span class="me-1">Nomor Polisi:</span>
                        <span class="badge text-bg-info fs-6">
                            {{ $item->nomor_polisi }}
                        </span>
                    </div>
                </div>
                
                <div class="d-flex align-items-center gap-5">
                    <div class="col">
                        <table class="table table-borderless table-sm" width="50%">
                            @if ($item->warna_body)
                                <tr>
                                    <td>Warna Body</td>
                                    <td>:</td>
                                    <td style="background-color: {{ $item->warna_body }};"
                                        class="text-center text-uppercase">{{ $item->warna_body }}</td>
                                </tr>
                            @endif

                            @if ($item->warna_velg)
                                <tr>
                                    <td>Warna Velg</td>
                                    <td>:</td>
                                    <td style="background-color: {{ $item->warna_velg }};"
                                        class="text-center text-uppercase">{{ $item->warna_velg }}</td>
                                </tr>
                            @endif

                            <tr>
                                <td>Total Harga</td>
                                <td>:</td>
                                <td class="fw-bold text-success">Rp{{ number_format($item->total_harga, 0, ',', '.') }}
                                </td>
                            </tr>
                            <tr>
                                <td>Estimasi Waktu</td>
                                <td>:</td>
                                <td class="fw-bold text-success">
                                    {{ $item->estimasi_waktu }} hari
                                    <br>
                                    <small>({{ \Carbon\Carbon::parse($item->created_at)->addDays($item->estimasi_waktu)->locale('id')->isoFormat('dddd, D MMMM Y') }})</small>
                                </td>
                            </tr>
                            <tr>
                                <td>Bukti Bayar</td>
                                <td>:</td>
                                <td><a href="" data-bs-toggle="modal" data-bs-target="#imageModal">Lihat
                                        Bukti</a></td>
                            </tr>
                            <tr>
                                <td>Waktu Reservasi</td>
                                <td>:</td>
                                <td>{{ $item->created_at->format('d/m/Y H:i') }}</td>
                            </tr>
                            <tr>
                                <td>Catatan</td>
                                <td>:</td>
                                <td>{{ $item->catatan }}</td>
                            </tr>
                        </table>
                    </div>
                    
                    {{-- Status --}}
                    <div class="col-3">
                        <div class="mb-3">
                            <div>Status Pembayaran:</div>
                            @if ($item->payment && $item->payment->bukti_pembayaran)
                                <span class="badge text-bg-success fs-6">Sudah Bayar</span>
                                <br>
                                <small>({{ $item->payment->metode_pembayaran }})</small>
                            @else
                                <span class="badge text-bg-warning fs-6">Belum Bayar</span>
                            @endif
                        </div>
                        <div>
                            <div>Status Pengerjaan:</div>
                            @if ($item->status == 'pending')
                                <span class="badge text-bg-secondary fs-6">Menunggu Persetujuan</span>
                            @elseif ($item->status == 'setuju')
                                <span class="badge text-bg-primary fs-6"><i
                                        class="bi bi-check2-all me-2"></i>Disetujui</span>
                            @elseif ($item->status == 'bongkar')
                                <span class="badge text-bg-warning fs-6">Proses Pembongkaran</span>
                            @elseif ($item->status == 'cuci')
                                <span class="badge text-bg-warning fs-6">Proses Pencucian</span>
                            @elseif ($item->status == 'amplas')
                                <span class="badge text-bg-warning fs-6">Proses Pengamplasan</span>
                            @elseif ($item->status == 'dempul')
                                <span class="badge text-bg-warning fs-6">Proses Pendempulan</span>
                            @elseif ($item->status == 'epoxy')
                                <span class="badge text-bg-warning fs-6">Proses Epoxy</span>
                            @elseif ($item->status == 'warna')
                                <span class="badge text-bg-warning fs-6">Proses Naik Warna</span>
                            @elseif ($item->status == 'permis')
                                <span class="badge text-bg-warning fs-6">Proses Permis</span>
                            @elseif ($item->status == 'pasang')
                                <span class="badge text-bg-warning fs-6">Proses Pemasangan Kembali</span>
                            @elseif ($item->status == 'selesai')
                                <span class="badge text-bg-success fs-6"><i
                                        class="bi bi-check2-circle me-2"></i>Selesai</span>
                            @elseif ($item->status == 'batal')
                                <span class="badge text-bg-danger fs-6"><i class="bi bi-x-lg me-2"></i>Dibatalkan</span>
                            @elseif ($item->status == 'tolak')
                                <span class="badge text-bg-danger fs-6"><i class="bi bi-x-lg me-2"></i>Ditolak</span>
                            @endif
                        </div>
                        <small class="text-danger">{{ $item->updated_at->format('d/m/Y H:i') }}</small>

                    </div>
                </div>

                {{-- Button --}}
                <div class="mt-5 float-end">
                    @if ($item->status == 'pending')
                        <div class="d-flex gap-2">
                            <button wire:click="batalkanReservasi({{ $item->id }})"
                                class="btn btn-danger fw-bold"
                                onclick="return confirm('Yakin ingin membatalkan reservasi?')">
                                Batalkan Reservasi
                            </button>
                            
                            @if(!$item->payment || !$item->payment->bukti_pembayaran)
                                <button class="btn fw-bold btn-success" data-bs-toggle="modal"
                                    data-bs-target="#modalPembayaran{{ $item->id }}">Bayar Sekarang</button>
                            @endif
                        </div>
                    @else
                        <button wire:click="batalkanReservasi({{ $item->id }})"
                            class="btn btn-danger fw-bold"
                            onclick="return confirm('Yakin ingin membatalkan reservasi?')" disabled>
                            Batalkan Reservasi
                        </button>
                    @endif
                </div>                    
            </div>
        </div>

        {{-- modal Pembayaran --}}
        <div wire:ignore.self class="modal fade" id="modalPembayaran{{ $item->id }}" data-bs-backdrop="static"
            tabindex="-1">
            <div class="modal-dialog">
                <div class="modal-content">
                    <!-- Modal header remains the same -->

                    <div class="modal-body">
                        <!-- Alert messages remain the same -->

                        <div class="mb-3">
                            <p class="fw-bold h4">Total Pembayaran:
                                Rp{{ number_format($item->total_harga, 0, ',', '.') }}
                            </p>
                            <!-- Bank details remain the same -->
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Upload Bukti Transfer</label>
                            <input type="file" class="form-control @error('bukti_pembayaran') is-invalid @enderror"
                                wire:model="bukti_pembayaran">
                            @error('bukti_pembayaran')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="button" class="btn btn-primary"
                            wire:click="submitPembayaran({{ $item->id }})">Kirim</button>
                    </div>
                </div>
            </div>
        </div>


        {{-- Gambar bukti_pembayaran --}}
        <div class="modal fade" id="imageModal" tabindex="-1" aria-labelledby="imageModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="imageModalLabel">Bukti Pembayaran</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                            aria-label="Close"></button>
                    </div>
                    <div class="modal-body text-center">
                        @if ($item->payment && $item->payment->bukti_pembayaran)
                            <img src="{{ Storage::url($item->payment->bukti_pembayaran) }}" class="img-fluid"
                                alt="Bukti Pembayaran">
                        @else
                            <div class="alert alert-warning">
                                <i class="bi bi-exclamation-triangle me-2"></i>
                                Bukti pembayaran belum tersedia karena belum melakukan pembayaran
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>

    @empty
        <h3 class="text-center text-danger">
            <i class="bi bi-exclamation-circle ms-2"></i> Belum ada Reservasi.
        </h3>
        <div class="text-center">Silakan lakukan Reservasi</div>
    @endforelse

</div>
