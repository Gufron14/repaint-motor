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
                    <th>Waktu Reservasi</th>
                    <th>Nama Customer</th>
                    <th>Reservasi</th>
                    <th colspan="2">Warna</th>
                    <th>Status Proses</th>
                    <th>Status Pembayaran</th>
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
                        @if ($item->warna_body && $item->warna_velg)
                            <td style="background-color: {{ $item->warna_body }}" class="text-uppercase align-middle">
                                {{ $item->warna_body }}</td>
                            <td style="background-color: {{ $item->warna_velg }}" class="text-uppercase align-middle">
                                {{ $item->warna_velg }}</td>
                        @elseif ($item->warna_body)
                            <td colspan="2" style="background-color: {{ $item->warna_body }}"
                                class="text-uppercase align-middle">
                                {{ $item->warna_body }}</td>
                        @elseif ($item->warna_velg)
                            <td colspan="2" style="background-color: {{ $item->warna_velg }}"
                                class="text-uppercase align-middle">
                                {{ $item->warna_velg }}</td>
                        @endif

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
                                <span class="badge text-bg-danger ">Dibatalkan</span>
                            @elseif ($item->status == 'tolak')
                                <span class="badge text-bg-danger ">Ditolak</span>
                            @endif
                        </td>
                        <td class="align-middle">
                            @if ($item->payment && $item->payment->bukti_pembayaran)
                                <span class="badge text-bg-success">Sudah Bayar</span>
                                <a href="" data-bs-toggle="modal"
                                    data-bs-target="#imageModal{{ $item->id }}">Lihat Bukti</a>
                                <br>
                            @else
                                <span class="badge text-bg-warning">Belum Bayar</span>
                            @endif
                        </td>
                        <td class="d-flex gap-2 justify-content-center align-items-center">
                            <div class="dropdown">
                                <button class="btn btn-sm btn-primary fw-bold dropdown-toggle" type="button"
                                    data-bs-toggle="dropdown"
                                    {{ in_array($item->status, ['tolak', 'batal', 'selesai']) ? 'disabled' : '' }}>
                                    Proses
                                </button>
                                <ul class="dropdown-menu">
                                    @if ($item->status == 'pending')
                                        <li><button wire:click="updateStatus({{ $item->id }}, 'setuju')"
                                                class="dropdown-item"><span
                                                    class="badge text-bg-primary">Setujui</span></button></li>
                                        <li><button wire:click="updateStatus({{ $item->id }}, 'tolak')"
                                                class="dropdown-item text-warning"><span
                                                    class="badge text-bg-danger">Tolak</span></button></li>
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
                            <div>
                                <a href="{{ route('admin.reservasi.view', ['id' => $item->id]) }}"
                                        class="btn btn-sm btn-warning">
                                        <i class="fas fa-eye"></i>
                                </a>
                            </div>
                        </td>
                    </tr>

                    {{-- Gambar bukti_pembayaran --}}
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
