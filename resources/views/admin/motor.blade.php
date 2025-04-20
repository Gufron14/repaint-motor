@extends('admin.layout.app')

@section('page')
    Kelola Motor
@endsection

@section('button')
    <button class="btn btn-danger fw-bold btn-sm" data-bs-toggle="modal" data-bs-target="#tipe"><i class="fas fa-plus me-2"></i> Tipe Motor</button>
    &nbsp;&nbsp; | &nbsp;&nbsp;<button class="btn btn-primary fw-bold btn-sm" data-bs-toggle="modal" data-bs-target="#kategori"><i
            class="fas fa-plus me-2"></i> Kategori</button>
    <button class="btn btn-success fw-bold btn-sm" data-bs-toggle="modal" data-bs-target="#jenis"><i class="fas fa-plus me-2"></i> Jenis Repaint</button>
@endsection

@section('content')
    <div class="card">
        <div class="card-body">
            <table class="table table-bordered table-sm">
                <thead class="text-center">
                    <th>#</th>
                    <th>Kategori Motor</th>
                    <th>Tipe Motor</th>
                    <th>Jenis Repaint</th>
                    <th>Harga</th>
                    <th>Aksi</th>
                </thead>
                <tbody>
                    {{-- @forelse ($motors as $motor)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $motor->nama }}</td>
                            <td>
                                @foreach ($motor->tipeMotors as $tipe)
                                    {{ $tipe->nama }}<br>
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
                    @endforelse --}}
                </tbody>

            </table>
        </div>
    </div>

    <!-- Kategori Modal -->
    <div class="modal fade" id="kategori" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5 fw-bold" id="exampleModalLabel">Kelola Kategori Motor</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="kategori" class="form-label">Kategori Motor</label>
                        <div class="d-flex gap-2">
                            <div>
                                <input type="text" class="form-control" id="kategori" placeholder="Kategori Motor">
                            </div>
                            <button class="btn btn-sm btn-primary">Tambah</button>
                        </div>
                    </div>
                    <table class="table table-bordered table-sm">
                        <thead>
                            <th>#</th>
                            <th>Kategori Motor</th>
                        </thead>
                        <tbody>
                            @foreach ($motors as $motor)                                
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $motor->nama }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="button" class="btn btn-primary">Simpan Perubahan</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Jenis Modal -->
    <div class="modal fade" id="jenis" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5 fw-bold" id="exampleModalLabel">Kelola Jenis Repaint</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="jenisRepaint" class="form-label">Jenis Repaint</label>
                        <div class="d-flex gap-2">
                            <div>
                                <input type="text" class="form-control" id="jenisRepaint" placeholder="Jenis Repaint">
                            </div>
                            <button class="btn btn-sm btn-primary">Tambah</button>
                        </div>
                    </div>
                    <table class="table table-bordered table-sm">
                        <thead>
                            <th>#</th>
                            <th>Jenis Repaint</th>
                        </thead>
                        <tbody>
                            @foreach ($jenisRepaints as $jenisRepaint)                                
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $jenisRepaint->nama }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="button" class="btn btn-primary">Simpan Perubahan</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Tipe Modal -->
    <div class="modal fade" id="tipe" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5 fw-bold" id="exampleModalLabel">Kelola Tipe Motor</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="kategori">Kategori Motor</label>
                        <select class="form-select" aria-label="Default select example">
                            <option selected>Pilih Kategori</option>
                            @foreach ($motors as $motor)
                                <option value="{{ $motor->id }}">{{ $motor->nama }}</option>
                            @endforeach
                          </select>
                    </div>
                    <div class="mb-3">
                        <label for="tipe" class="form-label">Tipe Motor</label>
                        <input type="text" name="" id="" class="form-control" placeholder="Nama Tipe Motor">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="button" class="btn btn-primary">Simpan</button>
                </div>
            </div>
        </div>
    </div>
@endsection
