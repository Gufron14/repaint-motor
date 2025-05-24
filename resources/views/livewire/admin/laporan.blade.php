<div>
    <div class="card">
        <div class="card-header d-flex justify-content-between">
            <h3 class="card-title fw-bold">Laporan Pendapatan</h3>
        </div>
        <div class="card-body">
            <div class="d-flex mb-3 gap-5">
                <div class="input-group gap-2 me-2">
                        <label for="" class="form-label">Dari</label>
                        <input type="date" class="form-control" wire:model.live="startDate">

                        <label for="" class="form-label">Sampai</label>
                        <input type="date" class="form-control" wire:model.live="endDate">
                </div>
                <button wire:click="downloadPdf" class="btn btn-primary fw-bold btn-sm">
                    <i class="bi bi-download me-2"></i>Unduh laporan
                </button>
            </div>
            <table class="table table-bordered table-sm">
                <thead>
                    <tr class="text-center">
                        <th>Tanggal Selesai</th>
                        <th>Nama Customer</th>
                        <th>Tipe Motor</th>
                        <th>Repaint</th>
                        <th>Harga</th>
                        <th>Jumlah</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($laporan as $item)
                        @foreach ($item['jenis_repaints'] as $index => $repaint)
                            <tr class="align-middle">
                                @if ($index === 0)
                                    <td rowspan="{{ $item['rowspan'] }}" class="text-center align-middle">
                                        {{ $item['tanggal'] }}</td>
                                    <td rowspan="{{ $item['rowspan'] }}" class="text-center align-middle">
                                        {{ $item['nama_customer'] }}</td>
                                    <td rowspan="{{ $item['rowspan'] }}" class="text-center align-middle">
                                        {{ $item['tipe_motor'] }}</td>
                                @endif
                                <td>{{ $repaint['nama_repaint'] }}</td>
                                <td>Rp {{ number_format($repaint['harga'] ?? 0, 0, ',', '.') }}</td>
                                @if ($index === 0)
                                    <td rowspan="{{ $item['rowspan'] }}" class="text-center align-middle">Rp
                                        {{ number_format($item['total_harga'], 0, ',', '.') }}</td>
                                @endif
                            </tr>
                        @endforeach
                    @empty
                        <tr>
                            <td colspan="6" class="text-center">Tidak ada data laporan</td>
                        </tr>
                    @endforelse
                </tbody>
                <tfoot>
                    <tr>
                        <th colspan="5" class="text-end">Total Pendapatan:</th>
                        <th class="text-center">Rp {{ number_format($totalPendapatan, 0, ',', '.') }}</th>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
</div>
