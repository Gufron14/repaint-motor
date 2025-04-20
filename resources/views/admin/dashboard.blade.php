@extends('admin.layout.app')

@section('page')
    Dashboard
@endsection

@section('content')
{{-- <div class="card">
    <div class="card-header">
        <h3 class="card-title">Daftar Harga Repaint Motor</h3>
    </div>
    <div class="card-body">
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
                @foreach ($kategoriMotors as $kategori)
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
                                    <td class="text-center align-middle" rowspan="{{ $totalBarisKategori }}">{{ $nomor++ }}</td>
                                    <td class="align-middle" rowspan="{{ $totalBarisKategori }}">{{ $kategori->nama_kategori }}</td>
                                    @php $kategoriPertama = false; @endphp
                                @endif

                                @if ($tipePertama)
                                    <td class="align-middle" rowspan="{{ $totalBarisTipe }}">{{ $tipe->nama_motor }}</td>
                                    @php $tipePertama = false; @endphp
                                @endif

                                <td>{{ $repaint->jenisRepaint->nama_repaint }}</td>
                                <td class="text-end">Rp{{ number_format($repaint->harga, 0, ',', '.') }}</td>
                                <td class="text-center">{{ $repaint->estimasi_waktu }}</td>
                            </tr>
                        @endforeach
                    @endforeach
                @endforeach
            </tbody>
        </table>
    </div>
</div> --}}
@endsection
