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

    <h3 class="fw-bold mb-3 text-center">Riwayat Reservasi</h3>

    @forelse ($reservasi as $index => $item)
        <div class="card mx-auto shadow-sm border-0 mb-3 p-3">
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
                                Reservasi Anda <strong>Ditolak</strong> karena
                                <strong>{{ $item->penolakan->keterangan }}</strong> dan tidak akan diproses. Coba lagi
                                lain kali.
                            </div>
                        </div>
                    @elseif ($item->status == 'batal')
                        <div class="d-flex align-items-center alert alert-danger mt-2">
                            <div class="me-2 fs-5">
                                <i class="bi bi-x-lg"></i>
                            </div>
                            <div class="">
                                Reservasi ini <strong>Dibatalkan</strong> karena
                                <strong>{{ $item->penolakan->keterangan }}</strong> dan tidak akan diproses.
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
                <div class="row align-items-center justify-content-between mb-4">
                    <div class="col">
                        <div class="d-flex align-items-center gap-2 mb-2">
                            <span class="badge text-bg-warning fs-6">
                                {{ $item->kategoriMotor->nama_kategori }}
                            </span>
                            <span class="badge text-bg-info fs-6">
                                {{ $item->nomor_polisi }}
                            </span>
                            <span class="badge text-bg-success fs-6">
                                {{ $item->estimasi_waktu }} hari
                            </span>
                        </div>
                        <div class="d-flex align-items-center justify-content-between">
                            <div class="d-flex align-items-center flex-wrap">
                                <h4 class="mb-0 fw-bold me-2">
                                    {{ $item->tipeMotor->nama_motor }}:
                                    @if (is_array($item->jenisRepaint) && count($item->jenisRepaint) > 0)
                                        {{ implode(', ', $item->jenisRepaint) }}
                                    @else
                                        Data tidak tersedia
                                    @endif
                                </h4>
                                @if ($item->status === 'pending')
                                    <a href="{{ route('tambahKomponen', $item->id) }}">Ubah Repaint</a>
                                @endif
                            </div>
                        </div>
                    </div>
                    @if ($item->status === 'batal' || $item->status === 'tolak')
                    @else
                        <div class="col d-flex gap-2 align-items-center">
                            <div class="card border-warning">
                                <div class="card-body text-warning fw-bold">
                                    <label for="" class="form-label text-secondary text-uppercase">dp
                                        10%</label>
                                    <span>
                                        <a href="#" data-bs-toggle="modal"
                                            data-bs-target="#imageModal{{ $item->id }}">
                                            <i class="bi bi-eye-fill"></i>
                                        </a>
                                    </span>
                                    <h5 class="mb-0 fw-bold">
                                        Rp{{ number_format($item->total_harga * 0.1, 0, ',', '.') }}
                                    </h5>
                                </div>
                            </div>
                            <div class="card border-danger">
                                <div class="card-body text-danger fw-bold">
                                    <label for="" class="form-label text-secondary text-uppercase">sisa
                                        bayar</label>
                                    <h5 class="mb-0 fw-bold">
                                        {{ $item->formatted_sisa_bayar }}
                                    </h5>
                                </div>
                            </div>


                            <div class="card border-success">
                                <div class="card-body text-success fw-bold">
                                    <label for="" class="form-label text-secondary text-uppercase">total
                                        harga</label>
                                    <span>
                                        <a href="#" data-bs-toggle="modal"
                                            data-bs-target="#exampleModal{{ $item->id }}">
                                            <i class="bi bi-eye-fill"></i>
                                        </a>
                                    </span>
                                    <h5 class="mb-0 fw-bold">
                                        Rp{{ number_format($item->total_harga, 0, ',', '.') }}
                                    </h5>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>

                <div class="d-flex gap-3">
                    <div class="alert alert-warning text-center" role="alert">
                        Status pengerjaan Repaint Motor saat ini:
                        <strong>
                            @if ($item->status == 'pending')
                                Menunggu Persetujuan
                            @elseif ($item->status == 'setuju')
                                Disetujui
                            @elseif ($item->status == 'bongkar')
                                Proses Pembongkaran
                            @elseif ($item->status == 'cuci')
                                Proses Pencucian
                            @elseif ($item->status == 'amplas')
                                Proses Pengamplasan
                            @elseif ($item->status == 'dempul')
                                Proses Pendempulan
                            @elseif ($item->status == 'epoxy')
                                Proses Epoxy
                            @elseif ($item->status == 'warna')
                                Proses Naik Warna
                            @elseif ($item->status == 'permis')
                                Proses Permis
                            @elseif ($item->status == 'pasang')
                                Proses Pemasangan Kembali
                            @elseif ($item->status == 'selesai')
                                Selesai
                            @elseif ($item->status == 'batal')
                                Dibatalkan
                            @elseif ($item->status == 'tolak')
                                Ditolak
                            @endif
                        </strong>
                    </div>

                    @if ($item->status === 'batal' || $item->status === 'selesai' || $item->status === 'tolak')
                        @if (in_array($item->status, ['batal', 'tolak']) && $item->payment && $item->payment->bukti_pembayaran)
                            <div class="alert alert-info text-center" role="alert">
                                Pengembalian Dana akan dikirim ke <strong>{{ $item->user->no_rek }}</strong>  dalam waktu kurang lebih 24 Jam. Pastikan nomor rekening/e-wallet Benar.
                            </div>
                        @endif
                    @else
                        <div class="alert alert-info text-center" role="alert">
                            Estimasi waktu pengerjaan <strong>{{ $item->estimasi_waktu }} hari</strong> sampai dengan
                            <strong>{{ \Carbon\Carbon::parse($item->created_at)->addDays($item->estimasi_waktu)->locale('id')->isoFormat('dddd, D MMMM Y') }}</strong>
                        </div>
                    @endif

                </div>

                @php
                    $warnaList = [
                        'Body' => $item->warna_body ?? null,
                        'Velg' => $item->warna_velg ?? null,
                        'Knalpot' => $item->warna_knalpot ?? null,
                        'CVT' => $item->warna_cvt ?? null,
                    ];
                @endphp

                <div class="d-flex gap-3 justify-content-center mb-4">
                    @foreach ($warnaList as $label => $warna)
                        @if ($warna)
                            <div class="card w-100">
                                <div class="d-flex align-items-center justify-content-center text-white"
                                    style="height: 200px; background-color: {{ $warna }}">
                                    <div class="text-center p-3">
                                        <small class="opacity-75">Warna {{ $label }}</small>
                                        <h5 class="mb-0 fw-bold text-uppercase">{{ $warna }}</h5>
                                    </div>
                                </div>
                            </div>
                        @endif
                    @endforeach
                </div>

                <div class="d-flex mb-3 gap-2 align-items-center">
                    <label for="" class="form-label text-secondary">Catatan:</label>
                    <input type="text" class="form-control" placeholder="{{ $item->catatan }}" disabled>
                </div>

                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <small class="form-label text-secondary">Waktu Reservasi:</small>
                        <small><span>{{ $item->created_at->format('d/m/Y H:i') }} WIB</span></small>
                    </div>
                    <div>
                        <div>
                            @if ($item->status == 'pending')
                                <button wire:click="openCancelModal({{ $item->id }})"
                                    class="btn btn-danger fw-bold">
                                    Batalkan Reservasi
                                </button>
                                @if (!$item->payment || !$item->payment->bukti_pembayaran)
                                    <button class="btn btn-success fw-bold ms-2" data-bs-toggle="modal"
                                        data-bs-target="#modalPembayaran{{ $item->id }}">
                                        Bayar Sekarang
                                    </button>
                                @endif
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- modal Pembayaran --}}
        <div wire:ignore.self class="modal fade" id="modalPembayaran{{ $item->id }}" data-bs-backdrop="static"
            tabindex="-1">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Upload Bukti Pembayaran</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        @if (session()->has('message'))
                            <div class="alert alert-success">
                                {{ session('message') }}
                            </div>
                        @endif
                        @if (session()->has('error'))
                            <div class="alert alert-danger">
                                {{ session('error') }}
                            </div>
                        @endif

                        <div class="mb-3">
                            <p class="fw-bold h4">Total Pembayaran DP 10%: Rp.
                                {{ number_format($item->total_harga * 0.1, 0, ',', '.') }}</p>
                            <p>Silahkan transfer ke rekening:</p>
                            <ul>
                                <li class="fw-bold">BCA: 1234567890 (A/N Hype Custom Project)</li>
                            </ul>
                        </div>
                        <div class="mb-3">
                            <label class="form-label text-secondary">Upload Bukti Transfer</label>
                            <input type="file" class="form-control @error('bukti_pembayaran') is-invalid @enderror"
                                wire:model="bukti_pembayaran">
                            @error('bukti_pembayaran')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="button" class="btn btn-primary fw-bold"
                            wire:click="submitPembayaran({{ $item->id }})">
                            Kirim
                        </button>
                    </div>
                </div>
            </div>
        </div>

        @if (isset($showCancelModal[$item->id]) && $showCancelModal[$item->id])
            <div class="modal fade show" style="display: block; background-color: rgba(0,0,0,0.5);" tabindex="-1">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Batalkan Reservasi</h5>
                            <button type="button" class="btn-close"
                                wire:click="closeCancelModal({{ $item->id }})"></button>
                        </div>
                        <div class="modal-body">
                            <p class="mb-3">Pilih alasan pembatalan reservasi:</p>

                            @error('selectedPenolakanId')
                                <div class="alert alert-danger">{{ $message }}</div>
                            @enderror

                            <div class="form-group">
                                @foreach ($alasanPembatalan as $penolakan)
                                    <div class="form-check mb-3">
                                        <input class="form-check-input" type="radio"
                                            wire:model="selectedPenolakanId" value="{{ $penolakan->id }}"
                                            name="pembatalan_{{ $item->id }}"
                                            id="pembatalan{{ $penolakan->id }}_{{ $item->id }}">
                                        <label class="form-check-label"
                                            for="pembatalan{{ $penolakan->id }}_{{ $item->id }}">
                                            {{ $penolakan->keterangan }}
                                        </label>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary"
                                wire:click="closeCancelModal({{ $item->id }})">
                                Tutup
                            </button>
                            <button type="button" class="btn btn-danger"
                                wire:click="batalkanReservasi({{ $item->id }})">
                                <i class="fas fa-times me-1"></i>
                                Batalkan Reservasi
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        @endif


        {{-- Gambar bukti_pembayaran --}}
        <div class="modal fade" id="imageModal{{ $item->id }}" tabindex="-1"
            aria-labelledby="imageModalLabel{{ $item->id }}" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="imageModalLabel{{ $item->id }}">Bukti Pembayaran</h5>
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

        {{-- Modal Rincian Biaya --}}
        <div class="modal fade" id="exampleModal{{ $item->id }}" tabindex="-1"
            aria-labelledby="exampleModalLabel{{ $item->id }}" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="exampleModalLabel{{ $item->id }}">Rincian Biaya</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                            aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="table-responsive mt-3">
                            <table class="table table-bordered">
                                <thead class="table-light">
                                    <tr class="text-center">
                                        <th>Jenis Repaint</th>
                                        <th>Harga</th>
                                    </tr>
                                </thead>
                                <tbody class="text-center">
                                    @foreach ($item->jenisRepaintDetails as $jenis)
                                        <tr>
                                            <td>{{ $jenis['nama'] }}</td>
                                            <td>Rp{{ number_format($jenis['harga'], 0, ',', '.') }}</td>
                                        </tr>
                                    @endforeach
                                    <tr class="table-secondary fw-bold">
                                        <td>Total Harga</td>
                                        <td>Rp{{ number_format($item->total_harga, 0, ',', '.') }}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary fw-bold" data-bs-dismiss="modal">Tutup</button>
                    </div>
                </div>
            </div>
        </div>


        <div class="modal fade" id="tambahModal" tabindex="-1" aria-labelledby="tambahModalLabel"
            aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="tambahModalLabel">Modal title</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                            aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        ...
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary">Save changes</button>
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
