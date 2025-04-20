@extends('admin.layout.app')

@section('page')
    Kelola Repaint
@endsection

@section('button')
    <button class="btn btn-primary fw-bold">
        Tambah Jenis Repaint
    </button>
@endsection

@section('content')
    <div class="card">
        <div class="card-body">
            <table class="table table-bordered table-sm">
                <thead>
                    <th>#</th>
                    <th>Nama Repaint</th>
                    <th>Harga</th>
                    <th>Aksi</th>
                </thead>
                <tbody>
                    @forelse ($repaints as $repaint)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $repaint->nama }}</td>
                            <td>
                                @foreach($repaint->hargaRepaints as $hargaRepaint)
                                    {{ $hargaRepaint->harga }}<br>
                                @endforeach
                            </td>
                            <td>
                                <button class="btn btn-warning btn-sm">Edit</button>
                                <button class="btn btn-danger btn-sm">Hapus</button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="text-center">Tidak ada data</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection