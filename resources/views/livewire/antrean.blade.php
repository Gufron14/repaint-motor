<div class="p-4">
    <div class="card border-0 shadow-sm">
        <div class="card-body p-3">
            <div class="mb-5 text-center">
                <h4 class="fw-bold">Daftar Antrean</h4>
                {{-- <div class="mb-3 p-2 bg-light border rounded">
                    <small><strong>Debug Info:</strong></small><br>
                    <small id="debug-info">Loading debug...</small>
                </div> --}}

                {{-- <small class="text-muted">*Demo Sidang Skripsi: 30 detik = 1 hari</small> --}}
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
                    @if (count($antreans) > 0)
                        @foreach ($antreans as $antrean)
                            <tr class="text-center {{ $antrean['is_current_user'] ? 'bg-warning bg-opacity-25' : '' }}">
                                <td>{{ $antrean['customer'] }}</td>
                                <td>{{ $antrean['tipe_motor'] }}</td>
                                <td>{{ implode(', ', (array) $antrean['repaint']) }}</td>
                                <td><span class="badge text-bg-warning">{{ $antrean['status'] }}</span> </td>
                                <td>
                                    {{ $antrean['estimasi_selesai'] }}

                                    <!-- Debug data untuk setiap item -->
                                    {{-- <div class="mt-1 p-1 bg-light border rounded" style="font-size: 10px;">
                                        <div>ID: {{ $antrean['id'] }}</div>
                                        <div>Created: {{ $antrean['created_at'] }}</div>
                                        <div>Total Detik: {{ $antrean['total_detik_sisa'] }}</div>
                                        <div>Status: {{ $antrean['status'] }}</div>
                                    </div> --}}

                                    {{-- @if ($antrean['total_detik_sisa'] > 0)
                                        <br>
                                        <small class="text-primary fw-bold">
                                            <span class="countdown-timer"
                                                data-created-at="{{ $antrean['created_at'] }}"
                                                data-estimasi="{{ $antrean['total_detik_sisa'] }}"
                                                data-id="{{ $antrean['id'] }}">
                                                Loading...
                                            </span>
                                        </small>
                                    @elseif($antrean['estimasi_selesai'] !== 'Selesai' && $antrean['estimasi_selesai'] !== 'Hari Ini')
                                        <br>
                                        <small class="text-danger fw-bold">Waktu Habis</small>
                                    @endif --}}
                                </td>

                            </tr>
                        @endforeach
                    @else
                        <tr>
                            <td colspan="5" class="text-center p-5">
                                Belum ada Antrean.<br><br>
                                <a href="{{ route('reservasi') }}" class="btn btn-warning fw-bold">Reservasi
                                    Sekarang</a>
                            </td>
                        </tr>
                    @endif

                </tbody>
            </table>
        </div>
    </div>

    <script>
        function updateAllCountdowns() {
            const timers = document.querySelectorAll('.countdown-timer');
            const now = new Date();
            let debugInfo = `Current Time: ${now.toLocaleTimeString()}<br>`;

            debugInfo += `Found ${timers.length} timers<br>`;

            timers.forEach(function(timer, index) {
                const createdAt = new Date(timer.dataset.createdAt);
                let remainingSeconds = parseInt(timer.dataset.estimasi);
                const id = timer.dataset.id;

                // Debug info per timer
                debugInfo += `Timer ${index + 1} (ID: ${id}):<br>`;
                debugInfo += `- Created: ${createdAt.toLocaleTimeString()}<br>`;
                debugInfo += `- Backend Remaining: ${remainingSeconds} detik<br>`;

                // Hitung detik yang sudah berlalu sejak halaman dimuat
                const elapsedSeconds = Math.floor((now - createdAt) / 1000);
                
                // Kurangi waktu yang sudah berlalu dari estimasi backend
                remainingSeconds = Math.max(0, remainingSeconds - elapsedSeconds);
                debugInfo += `- Elapsed: ${elapsedSeconds} detik<br>`;
                debugInfo += `- Current Remaining: ${remainingSeconds} detik<br>`;

                if (remainingSeconds > 0) {
                    // Konversi ke hari dan detik (30 detik = 1 hari)
                    const days = Math.floor(remainingSeconds / 30);
                    const seconds = remainingSeconds % 30;
                    
                    timer.textContent = `${seconds} detik lagi`;
                    // if (days > 0) {
                    //     timer.textContent = `${days} hari ${seconds} detik lagi`;
                    // } else {
                    // }

                    timer.className = 'countdown-timer text-primary fw-bold';
                } else {
                    timer.textContent = 'Waktu Habis!';
                    timer.className = 'countdown-timer text-danger fw-bold';
                }

                debugInfo += `- Display: ${timer.textContent}<br><br>`;
            });

            // Update debug info
            const debugElement = document.getElementById('debug-info');
            if (debugElement) {
                debugElement.innerHTML = debugInfo;
            }

            // Console log untuk debugging
            console.log('Debug Info:', {
                currentTime: now.toISOString(),
                timersCount: timers.length,
                timersData: Array.from(timers).map(t => ({
                    id: t.dataset.id,
                    createdAt: t.dataset.createdAt,
                    estimasi: t.dataset.estimasi,
                    currentText: t.textContent
                }))
            });
        }

        // Jalankan countdown setiap detik
        const countdownInterval = setInterval(updateAllCountdowns, 1000);

        // Jalankan pertama kali saat halaman dimuat
        document.addEventListener('DOMContentLoaded', function() {
            console.log('DOM loaded, starting countdown...');
            updateAllCountdowns();
        });

        // Auto refresh setiap 2 menit untuk sinkronisasi
        setTimeout(function() {
            console.log('Auto refreshing page...');
            window.location.reload();
        }, 120000);
    </script>
</div>
