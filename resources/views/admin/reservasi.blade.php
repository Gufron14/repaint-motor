@extends('admin.layout.app')

@section('page')
    Daftar Reservasi
@endsection

@section('content')
    <div class="card">
        <div class="card-body">
            <table class="table table-bordered table-sm">
                <thead class="text-center">
                    <tr>
                        <th>#</th>
                        <th>Waktu</th>
                        <th>Nama Pelanggan</th>
                        <th>Jenis Reservasi</th>
                        <th>Status</th>
                        <th>Status Pembayaran</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>1</td>
                        <td>22-01-25, 12:45</td>
                        <td>Hakim Baehaqi</td>
                        <td>Beat Karbu, Full Body</td>
                        <td class="text-center"><span class="badge text-bg-danger">Belum Diproses</span></td>
                        <td>
                            <span class="badge text-bg-success">Sudah Bayar</span>
                            <small><a href="">Lihat Bukti</a></small>
                        </td>
                        <td>
                            <button class="btn btn-sm btn-primary fw-bold">Proses</button>
                        </td>
                    </tr>
                    <tr>
                        <td>2</td>
                        <td>22-01-25, 12:45</td>
                        <td>Hakim Kim</td>
                        <td>Varion 125, Body Kasar</td>
                        <td class="text-center"><span class="badge text-bg-success">Selesai</span></td>
                        <td>
                            <span class="badge text-bg-success">Sudah Bayar</span>
                            <small><a href="">Lihat Bukti</a></small>
                        </td>
                        <td>
                            <button class="btn btn-sm btn-primary fw-bold" disabled>Proses</button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
@endsection