<div class="p-4">
    <div class="card p-3">
        <div class="card-body">
            <div class="mb-3 text-center">
                <h4 class="fw-bold">Daftar Antrean</h4>
            </div>
            <table class="table table-bordered table-sm">
                <thead class="text-center">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Antrean</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Repaint</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Estimasi Selesai</th>
                    </tr>
                </thead>
                <tbody>
                    @if(count($antreans) > 0)
                        @foreach($antreans as $antrean)
                        <tr class="text-center">
                            <td class="px-6 py-4 whitespace-nowrap">{{ $antrean['customer'] }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">{{ implode(', ', (array)$antrean['repaint']) }}</td>
                            <td class="px-6 py-4 whitespace-nowrap"><span class="badge text-bg-warning">{{  $antrean['status'] }}</span> </td>
                            <td class="px-6 py-4 whitespace-nowrap">{{ $antrean['estimasi_selesai'] }}</td>
                        </tr>
                        @endforeach
                    @else
                        <tr>
                            <td colspan="4" class="text-center p-5">
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
