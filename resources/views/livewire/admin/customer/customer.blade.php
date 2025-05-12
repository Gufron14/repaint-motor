<div>
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Daftar Customer</h3>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th class="text-center">No.</th>
                            <th>Nama Customer</th>
                            <th class="text-center">Reservasi</th>
                            <th class="text-center">Status Pesanan</th>
                            <th class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($customers as $index => $customer)
                            <tr>
                                <td class="text-center">{{ $loop->iteration }}</td>
                                <td>{{ $customer->name }}</td>
                                <td>
                                    @if($customer->reservasis->count() > 0)
                                        @foreach($customer->reservasis->take(1) as $reservasi)
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
                                        @endforeach
                                    @else
                                        Belum ada reservasi
                                    @endif
                                </td>


                                <td class="text-center">
                                    @if($customer->reservasis->count() > 0)
                                        @foreach($customer->reservasis->take(1) as $reservasi)
                                            @if($reservasi->status == 'selesai')
                                                <span class="badge bg-success">Selesai</span>
                                            @elseif($reservasi->status == 'tolak' || $reservasi->status == 'batal')
                                                <span class="badge bg-danger">{{ ucfirst($reservasi->status) }}</span>
                                            @else
                                                <span class="badge bg-info">{{ ucfirst($reservasi->status) }}</span>
                                            @endif
                                        @endforeach
                                    @else
                                        <span class="badge bg-secondary">Belum ada reservasi</span>
                                    @endif
                                </td>
                                <td class="text-center">
                                    <a href="{{ route('admin.customer.view', $customer->id) }}" class="btn btn-sm btn-primary">
                                        <i class="fas fa-eye"></i> Lihat Detail
                                    </a>
                                    @if($customer->phone)
                                        <a href="https://wa.me/{{ $this->formatPhoneNumber($customer->phone) }}" target="_blank" class="btn btn-sm btn-success">
                                            <i class="fab fa-whatsapp"></i> Hubungi
                                        </a>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center">Tidak ada data customer</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="mt-3">
                {{ $customers->links() }}
            </div>
        </div>
    </div>
</div>
