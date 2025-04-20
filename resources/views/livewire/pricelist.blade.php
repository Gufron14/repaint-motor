<div>

    <div class="mb-5 text-center">
        <h3 class="fw-bold">Tabel Harga Repaint Hype Custom Project</h3>
        <p class="text-danger"><i class="bi bi-info-circle me-2"></i>Harga sewaktu-waktu bisa berubah</p>
    </div>

    <table class="table table-bordered table-striped table-sm">
        <thead class="table-dark text-center">
            <tr>
                <th rowspan="2" class="align-middle">No</th>
                <th rowspan="2" class="align-middle">Kategori Motor</th>
                <th rowspan="2" class="align-middle">Tipe Motor</th>
                <th>Nama Repaint</th>
                <th>Harga</th>
                <th>Estimasi Waktu</th>
            </tr>
        </thead>
        <tbody>
            @php $nomor = 1; @endphp
            @forelse ($kategoriMotors as $kategori)
                @php
                    $totalBarisKategori = $kategori->tipeMotors->sum(fn($tipe) => $tipe->motorRepaints->count());
                    $kategoriPertama = true;
                @endphp

                @foreach ($kategori->tipeMotors as $tipe)
                    @php
                        $totalBarisTipe = $tipe->motorRepaints->count();
                        $tipePertama = true;
                    @endphp

                    @foreach ($tipe->motorRepaints as $repaint)
                        <tr>
                            @if ($kategoriPertama)
                                <td class="text-center align-middle" rowspan="{{ $totalBarisKategori }}">
                                    {{ $nomor++ }}</td>
                                <td class="align-middle" rowspan="{{ $totalBarisKategori }}">
                                    {{ $kategori->nama_kategori }}</td>
                                @php $kategoriPertama = false; @endphp
                            @endif

                            @if ($tipePertama)
                                <td class="align-middle text-center" rowspan="{{ $totalBarisTipe }}">{{ $tipe->nama_motor }}</td>
                                @php $tipePertama = false; @endphp
                            @endif

                            <td>{{ $repaint->jenisRepaint->nama_repaint }}</td>
                            <td class="text-end">Rp{{ number_format($repaint->harga, 0, ',', '.') }}</td>
                            <td class="text-center">{{ $repaint->estimasi_waktu }} hari</td>
                        </tr>
                    @endforeach
                @endforeach
            @empty
                        <tr>
                            <td colspan="6" class="text-center text-danger p-3">Belum ada data</td>
                        </tr>
            @endforelse
        </tbody>
    </table>
</div>
