@extends('admin.layout.app')

@section('page')
    Daftar Pelanggan
@endsection

@section('content')
    <div class="card">
        <div class="card-body">
            <table class="table table-bordered">
                <thead>
                    <th>#</th>
                    <th>Nama Lengkap</th>
                    <th>Email</th>
                    <th>No. HP</th>
                    <th>Aksi</th>
                </thead>
                <tbody>
                    @forelse ($users as $user)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $user->name }}</td>
                            <td>{{ $user->email }}</td>
                            <td>{{ $user->phone }}</td>
                            <td>Aksi</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5"> blm ada user</td>
                        </tr>
                    @endforelse
                </tbody>

            </table>
        </div>
    </div>
@endsection
