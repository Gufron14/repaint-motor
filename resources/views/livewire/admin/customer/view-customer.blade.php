<div>
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Detail Customer</h3>
            <div class="card-tools">
                <a href="{{ route('admin.customer') }}" class="btn btn-sm btn-secondary">
                    <i class="fas fa-arrow-left"></i> Kembali
                </a>
            </div>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <h4>Informasi Customer</h4>
                    <table class="table">
                        <tr>
                            <th>Nama</th>
                            <td>{{ $user->name }}</td>
                        </tr>
                        <tr>
                            <th>Email</th>
                            <td>{{ $user->email }}</td>
                        </tr>
                        <tr>
                            <th>No. Telepon</th>
                            <td>
                                {{ $user->phone }}
                                @if($user->phone)
                                    <a href="https://wa.me/{{ $this->formatPhoneNumber($user->phone) }}" target="_blank" class="btn btn-sm btn-success ml-2">
                                        <i class="fab fa-whatsapp"></i> Hubungi
                                    </a>
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <th>Alamat</th>
                            <td>{{ $user->alamat ?? 'Tidak ada' }}</td>
                        </tr>
                        <tr>
                            <th>Terdaftar Sejak</th>
                            <td>{{ $user->created_at->format('d/m/Y H:i') }}</td>
                        </tr>
                    </table>
                </div>
            </div>
            
            <div class="row mt-4">
                <div class="col-md-12">
                    <h4>Riwayat Reservasi</h4>
                    @if($reservasis->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>No.</th>
                                        <th>Reservasi</th>
                                        <th>Nomor Polisi</th>
                                        <th>Foto Motor</th>
                                        <th>Foto Velg</th>
                                        <th>Status</th>
                                        <th>Tanggal Reservasi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($reservasis as $index => $reservasi)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>
                                                {{ $reservasi->tipeMotor->nama_motor ?? 'N/A' }}:
                                                @php
                                                    $jenisRepaintIds = json_decode($reservasi->jenis_repaint_id, true);
                                                    $jenisRepaints = \App\Models\JenisRepaint::whereIn('id', $jenisRepaintIds)->pluck('nama_repaint')->toArray();
                                                @endphp
                                                @if (is_array($jenisRepaints) && count($jenisRepaints) > 0)
                                                    {{ implode(', ', $jenisRepaints) }}
                                                @else
                                                    Data tidak tersedia
                                                @endif
                                                @if($reservasi->repaint_velg)
                                                    , Velg
                                                @endif
                                            </td>
                                            <td>{{ $reservasi->nomor_polisi }}</td>
                                            <td>
                                                @if($reservasi->foto_motor)
                                                    <a href="{{ asset('storage/' . $reservasi->foto_motor) }}" target="_blank">
                                                        <img src="{{ asset('storage/' . $reservasi->foto_motor) }}" alt="Foto Motor" class="img-thumbnail" style="max-width: 100px;">
                                                    </a>
                                                @else
                                                    Tidak ada foto
                                                @endif
                                            </td>
                                            <td>
                                                @if($reservasi->foto_velg)
                                                    <a href="{{ asset('storage/' . $reservasi->foto_velg) }}" target="_blank">
                                                        <img src="{{ asset('storage/' . $reservasi->foto_velg) }}" alt="Foto Velg" class="img-thumbnail" style="max-width: 100px;">
                                                    </a>
                                                @else
                                                    Tidak ada foto
                                                @endif
                                            </td>
                                            <td>
                                                @if($reservasi->status == 'selesai')
                                                    <span class="badge bg-success">Selesai</span>
                                                @elseif($reservasi->status == 'tolak' || $reservasi->status == 'batal')
                                                    <span class="badge bg-danger">{{ ucfirst($reservasi->status) }}</span>
                                                @else
                                                    <span class="badge bg-primary">{{ ucfirst($reservasi->status) }}</span>
                                                @endif
                                            </td>
                                            <td>{{ $reservasi->created_at->format('d/m/Y H:i') }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="alert alert-info">
                            Customer ini belum memiliki reservasi.
                        </div>
                    @endif
                </div>
            </div>
            
        </div>
    </div>
</div>
