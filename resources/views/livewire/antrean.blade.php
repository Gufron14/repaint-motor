<div class="p-4">
    <div class="card border-0 shadow-sm">
        <div class="card-body p-3">
            <div class="mb-5 text-center">
                <h4 class="fw-bold">Daftar Antrean</h4>
            </div>
            <table class="table  table-striped">
                <thead class="text-center">
                    <tr>
                        <th>Antrean</th>
                        <th>Tipe Motor</th>
                        <th>Repaint</th>
                        <th>Status</th>
                        <th>Estimasi Waktu</th>
                    </tr>
                </thead>
                <tbody>
                    @if(count($antreans) > 0)
                        @foreach($antreans as $antrean)
                        <tr class="text-center {{ $antrean['is_current_user'] ? 'bg-warning bg-opacity-25' : '' }}">
                            <td>{{ $antrean['customer'] }}</td>
                            <td>{{ $antrean['tipe_motor'] }}</td>
                            <td>{{ implode(', ', (array)$antrean['repaint']) }}</td>
                            <td><span class="badge text-bg-warning">{{  $antrean['status'] }}</span> </td>
                            <td>{{ $antrean['estimasi_selesai'] }}</td>
                        </tr>
                        @endforeach
                    @else
                        <tr>
                            <td colspan="5" class="text-center p-5">
                                Belum ada Antrean.<br><br>
                                <a href="{{ route('reservasi') }}" class="btn btn-warning fw-bold">Reservasi Sekarang</a>
                            </td>
                        </tr>
                    @endif
                
                </tbody>
            </table>
        </div>
    </div>
</div>
