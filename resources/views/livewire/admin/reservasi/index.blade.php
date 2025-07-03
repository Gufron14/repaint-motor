<div>
    @if (session()->has('message'))
        <div class="alert alert-success">
            {{ session('message') }}
        </div>
    @endif
    <h3 class="fw-bold ms-3 mb-3">Daftar Reservasi</h3>
    <div class="">
        <table class="table table-bordered table-striped table-sm">
            <thead>
                <tr class="text-center align-middle">
                    <th>#</th>
                    <th>Waktu</th>
                    <th>Customer</th>
                    <th>Reservasi</th>
                    <th>Status Proses</th>
                    @if (
                        ($reservasi->first() && $reservasi->first()->payment && $reservasi->first()->payment->bukti_pengembalian) ||
                            $reservasi->first()->status === 'tolak' ||
                            $reservasi->first()->status === 'batal')
                        <th>Pengembalian Dana</th>
                    @endif
                    <th>DP 10%</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($reservasi as $item)
                    <tr class="text-center">
                        <td class="align-middle">{{ $loop->iteration }}</td>
                        <td class="align-middle">
                            <small>{{ $item->created_at->format('d/m/Y H:i') }}</small>
                        </td>
                        <td class="align-middle">{{ $item->user->name }}</td>
                        <td class="align-middle">
                            {{ $item->tipeMotor->nama_motor }}:
                            @if (is_array($item->jenisRepaint) && count($item->jenisRepaint) > 0)
                                {{ implode(', ', $item->jenisRepaint) }}
                            @else
                                Data tidak tersedia
                            @endif
                        </td>

                        <td class="align-middle">
                            @if ($item->status == 'pending')
                                <span class="badge text-bg-secondary ">Menunggu Persetujuan</span>
                            @elseif ($item->status == 'setuju')
                                <span class="badge text-bg-primary ">Disetujui</span>
                            @elseif ($item->status == 'bongkar')
                                <span class="badge text-bg-warning ">Pembongkaran</span>
                            @elseif ($item->status == 'cuci')
                                <span class="badge text-bg-warning ">Pencucian</span>
                            @elseif ($item->status == 'amplas')
                                <span class="badge text-bg-warning ">Pengamplasan</span>
                            @elseif ($item->status == 'dempul')
                                <span class="badge text-bg-warning ">Pendempulan</span>
                            @elseif ($item->status == 'epoxy')
                                <span class="badge text-bg-warning ">Epoxy</span>
                            @elseif ($item->status == 'warna')
                                <span class="badge text-bg-warning ">Naik Warna</span>
                            @elseif ($item->status == 'permis')
                                <span class="badge text-bg-warning ">Permis</span>
                            @elseif ($item->status == 'pasang')
                                <span class="badge text-bg-warning ">Pemasangan Kembali</span>
                            @elseif ($item->status == 'selesai')
                                <span class="badge text-bg-success ">Selesai</span>
                            @elseif ($item->status == 'batal')
                                <span class="badge text-bg-danger ">Dibatalkan</span> <br>
                                @if ($item->penolakan)
                                    <small class="text-muted">{{ $item->penolakan->keterangan }}</small>
                                @endif
                            @elseif ($item->status == 'tolak')
                                <span class="badge text-bg-danger ">Ditolak</span> <br>
                                @if ($item->penolakan)
                                    <small class="text-muted">{{ $item->penolakan->keterangan }}</small>
                                @endif
                            @endif

                        </td>
                        @if ($item->payment->bukti_pengembalian || $item->status === 'tolak' || $item->status === 'batal')
                            <td class="align-middle">
                                @if (!$item->payment->status_pengembalian)
                                    <span class="badge badge-danger">Belum Dikembalikan</span>
                                @else
                                    <span class="badge badge-success">Dikembalikan</span>
                                @endif
                            </td>
                        @endif
                        <td class="align-middle">
                            @if ($item->payment && $item->payment->bukti_pembayaran)
                                <span class="badge text-bg-success">Sudah Bayar</span>
                                <a href="" data-bs-toggle="modal"
                                    data-bs-target="#imageModal{{ $item->id }}"><i class="fas fa-eye"></i></a>
                                <br>
                            @else
                                <span class="badge text-bg-warning">Belum Bayar</span>
                            @endif
                        </td>
                        <td class="d-flex gap-1 justify-content-center align-items-center">
                            @if ($item->status == 'tolak' || ($item->status == 'batal' && $item->payment && !$item->payment->bukti_pengembalian))
                                {{-- Button Kembalikan Uang untuk reservasi yang ditolak dan sudah bayar, jika belum ada bukti_pengembalian --}}
                                <button class="btn btn-sm btn-success"
                                    wire:click="openRefundModal({{ $item->id }})">
                                    Refund
                                </button>
                            @elseif (!in_array($item->status, ['tolak', 'batal', 'selesai']))
                                {{-- Button Proses untuk status selain tolak, batal, selesai --}}
                                <div class="dropdown">
                                    <button class="btn btn-sm btn-primary fw-bold dropdown-toggle" type="button"
                                        data-bs-toggle="dropdown">
                                        Proses
                                    </button>
                                    <ul class="dropdown-menu">
                                        {{-- Dropdown menu yang sudah ada --}}
                                        @if ($item->status == 'pending')
                                            <li><button wire:click="updateStatus({{ $item->id }}, 'setuju')"
                                                    class="dropdown-item"><span
                                                        class="badge text-bg-primary">Setujui</span></button></li>
                                            <li>
                                                <a href="#" class="dropdown-item text-danger"
                                                    data-bs-toggle="modal"
                                                    data-bs-target="#rejectModal{{ $item->id }}">
                                                    <span class="badge text-bg-danger">Tolak</span>
                                                </a>
                                            </li>
                                        @endif
                                        
                                            @if ($item->status != 'pending' && !in_array($item->status, ['tolak', 'batal', 'selesai']))
                                        <li><button wire:click="updateStatus({{ $item->id }}, 'bongkar')"
                                                class="dropdown-item"
                                                {{ $item->status != 'setuju' ? 'disabled' : '' }}>Proses
                                                Pembongkaran</button></li>
                                        <li><button wire:click="updateStatus({{ $item->id }}, 'cuci')"
                                                class="dropdown-item"
                                                {{ $item->status != 'bongkar' ? 'disabled' : '' }}>Proses
                                                Pencucian</button></li>
                                        <li><button wire:click="updateStatus({{ $item->id }}, 'amplas')"
                                                class="dropdown-item"
                                                {{ $item->status != 'cuci' ? 'disabled' : '' }}>Proses
                                                Pengamplasan</button></li>
                                        <li><button wire:click="updateStatus({{ $item->id }}, 'dempul')"
                                                class="dropdown-item"
                                                {{ $item->status != 'amplas' ? 'disabled' : '' }}>Proses
                                                Pendempulan</button></li>
                                        <li><button wire:click="updateStatus({{ $item->id }}, 'epoxy')"
                                                class="dropdown-item"
                                                {{ $item->status != 'dempul' ? 'disabled' : '' }}>Proses Epoxy</button>
                                        </li>
                                        <li><button wire:click="updateStatus({{ $item->id }}, 'warna')"
                                                class="dropdown-item"
                                                {{ $item->status != 'epoxy' ? 'disabled' : '' }}>Proses Naik
                                                Warna</button></li>
                                        <li><button wire:click="updateStatus({{ $item->id }}, 'permis')"
                                                class="dropdown-item"
                                                {{ $item->status != 'warna' ? 'disabled' : '' }}>Proses Permis</button>
                                        </li>
                                        <li><button wire:click="updateStatus({{ $item->id }}, 'pasang')"
                                                class="dropdown-item"
                                                {{ $item->status != 'permis' ? 'disabled' : '' }}>Proses
                                                Pemasangan</button></li>
                                        <li><button wire:click="updateStatus({{ $item->id }}, 'selesai')"
                                                class="dropdown-item"
                                                {{ $item->status != 'pasang' ? 'disabled' : '' }}><span
                                                    class="badge text-bg-success">Selesai</span></button></li>
                                        <li><button wire:click="updateStatus({{ $item->id }}, 'batal')"
                                                class="dropdown-item text-danger"><span
                                                    class="badge text-bg-danger">Batalkan</span></button></li>
                                    @endif

                                    </ul>
                                </div>
                            @endif

                            {{-- Button View tetap ada --}}
                            <div>
                                <a href="{{ route('admin.reservasi.view', ['id' => $item->id]) }}"
                                    class="btn btn-sm btn-warning">
                                    <i class="fas fa-eye"></i>
                                </a>
                            </div>
                        </td>

                    </tr>

                    {{-- Modal Gambar bukti_pembayaran --}}
                    <div class="modal fade" id="imageModal{{ $item->id }}" tabindex="-1"
                        aria-labelledby="imageModalLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="imageModalLabel">Bukti Pembayaran</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                                </div>
                                <div class="modal-body text-center">
                                    @if ($item->payment && $item->payment->bukti_pembayaran)
                                        <img src="{{ Storage::url($item->payment->bukti_pembayaran) }}"
                                            class="img-fluid" alt="Bukti Pembayaran">
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

                    {{-- Modal Tolak Reservasi --}}
                    <div class="modal fade" id="rejectModal{{ $item->id }}" tabindex="-1"
                        aria-labelledby="rejectModalLabel{{ $item->id }}" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="rejectModalLabel{{ $item->id }}">Tolak Reservasi
                                    </h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <p class="mb-3">Pilih alasan penolakan reservasi untuk
                                        <strong>{{ $item->user->name }}</strong>:
                                    </p>

                                    @error('selectedPenolakanId')
                                        <div class="alert alert-danger">{{ $message }}</div>
                                    @enderror

                                    <div class="form-group">
                                        @foreach ($alasanPenolakan->where('tipe', 'admin') as $penolakan)
                                            <div class="form-check mb-3">
                                                <input class="form-check-input" type="radio"
                                                    wire:model="selectedPenolakanId" value="{{ $penolakan->id }}"
                                                    name="penolakan_{{ $item->id }}"
                                                    id="penolakan{{ $penolakan->id }}_{{ $item->id }}">
                                                <label class="form-check-label"
                                                    for="penolakan{{ $penolakan->id }}_{{ $item->id }}">
                                                    {{ $penolakan->keterangan }}
                                                </label>
                                            </div>
                                        @endforeach
                                    </div>

                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                                        Batal
                                    </button>
                                    <button type="button" class="btn btn-danger"
                                        wire:click="rejectReservasi({{ $item->id }})"
                                        wire:confirm="Yakin ingin menolak reservasi ini?" data-bs-dismiss="modal">
                                        <i class="fas fa-times me-1"></i>
                                        Tolak Reservasi
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Modal Kembalikan Uang - letakkan setelah modal rejectModal --}}
                    @if ($item->status == 'tolak' && $item->payment)
                        <div class="modal fade @if (isset($showRefundModal[$item->id]) && $showRefundModal[$item->id]) show @endif"
                            id="refundModal{{ $item->id }}" tabindex="-1"
                            @if (isset($showRefundModal[$item->id]) && $showRefundModal[$item->id]) style="display: block; background-color: rgba(0,0,0,0.5);" @endif>
                            <div class="modal-dialog">
                                <div class="modal-content" wire:ignore.self>
                                    <div class="modal-header">
                                        <h5 class="modal-title">Kembalikan Uang DP</h5>
                                        <button type="button" class="btn-close"
                                            wire:click="closeRefundModal({{ $item->id }})"></button>
                                    </div>
                                    <div class="modal-body">
                                        <p class="mb-3">Upload bukti pengembalian uang DP untuk
                                            <strong>{{ $item->user->name }}</strong> ke nomor rekening
                                            &nbsp;<strong>{{ $item->user->no_rek }}</strong>
                                        </p>

                                        <div class="alert alert-info">
                                            <i class="fas fa-info-circle me-2"></i>
                                            Jumlah yang harus dikembalikan (10% dari total harga):
                                            <strong>Rp
                                                {{ number_format(($item->total_harga ?? 0) * 0.1, 0, ',', '.') }}
                                            </strong>
                                        </div>

                                        <div class="mb-3">
                                            <label class="form-label">Upload Bukti Transfer Pengembalian</label>
                                            <input type="file" class="form-control"
                                                wire:model.defer="buktiPengembalian" accept="image/*">
                                            @error('buktiPengembalian')
                                                <div class="text-danger mt-1">{{ $message }}</div>
                                            @enderror

                                            {{-- Loading indicator --}}
                                            <div wire:loading wire:target="buktiPengembalian" class="mt-2">
                                                <small class="text-info">
                                                    <i class="fas fa-spinner fa-spin me-1"></i>
                                                    Mengupload file...
                                                </small>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary"
                                            wire:click="closeRefundModal({{ $item->id }})">
                                            Batal
                                        </button>
                                        <button type="button" class="btn btn-success"
                                            wire:click="uploadBuktiPengembalian({{ $item->id }})"
                                            wire:loading.attr="disabled" wire:target="buktiPengembalian">
                                            <i class="fas fa-upload me-1"></i>
                                            Upload Bukti
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif

                @empty
                    <tr>
                        <td colspan="10" class="p-4 text-center text-danger fs-5">
                            <i class="far fa-times-circle me-2"></i>
                            Belum ada Data
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
