<div>
    <h3 class="text-center fw-bold mb-3">
        Formulir Reservasi Repaint Hype Custom Project
    </h3>
    <div class="card mb-5">
        <div class="card-body p-5">
            <label for="" class="text-uppercase fw-bold text-secondary mb-2">Tipe Motor</label>
            <div class="d-flex gap-3 mb-3">
                <div class="col">
                    <label for="" class="form-label text-secondary">Kategori Motor</label>
                    <select class="form-select mb-3" wire:model.live="selectedKategori">
                        <option value="">-- Pilih Kategori Motor --</option>
                        @foreach ($kategoriMotor as $kategori)
                            <option value="{{ $kategori->id }}">{{ $kategori->nama_kategori }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="col">
                    <label for="" class="form-label text-secondary">Tipe Motor</label>
                    <select class="form-select mb-3" wire:model.live="selectedTipe">
                        <option value="">-- Pilih Tipe Motor --</option>
                        @foreach ($tipeMotor as $tipe)
                            <option value="{{ $tipe->id }}">{{ $tipe->nama_motor }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col">
                    <label class="form-label text-secondary">Nomor Polisi Motor:</label>
                    <input type="text" wire:model='nomor_polisi' class="form-control"
                        placeholder="Masukkan plat nomor" style="text-transform: uppercase;"
                        oninput="this.value = this.value.toUpperCase()">
                </div>
            </div>
            <label for="" class="text-uppercase fw-bold text-secondary mb-2">Jenis Repaint</label>

            <div class="">
                <label class="form-label text-secondary">Pilih Jenis Repaint:</label>
                <div class="mb-3 d-flex gap-3">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" wire:model.live="selectedRepaints"
                            value="1" id="fullBody" @if (!in_array($selectedTipe, $availableFullBodyTypes)) disabled @endif>
                        <label class="form-check-label" for="fullBody">Full Body</label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" wire:model.live="selectedRepaints"
                            value="2" id="bodyHalus" @if (!in_array($selectedTipe, $availableBodyHalusTypes)) disabled @endif>
                        <label class="form-check-label" for="bodyHalus">Body Halus</label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" wire:model.live="selectedRepaints"
                            value="3" id="bodyKasar" @if (!in_array($selectedTipe, $availableBodyKasarTypes)) disabled @endif>
                        <label class="form-check-label" for="bodyKasar">Body Kasar</label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" wire:model.live="selectedRepaints"
                            value="4" id="velg" @if (!in_array($selectedTipe, $availableVelgTypes)) disabled @endif>
                        <label class="form-check-label" for="velg">Velg</label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" wire:model.live="selectedRepaints"
                            value="5" id="knalpot" @if (!in_array($selectedTipe, $availableKnalpotTypes)) disabled @endif>
                        <label class="form-check-label" for="knalpot">Knalpot</label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" wire:model.live="selectedRepaints"
                            value="6" id="cvt" @if (!in_array($selectedTipe, $availableCVTTypes)) disabled @endif>
                        <label class="form-check-label" for="cvt">CVT</label>
                    </div>
                </div>

                @if (in_array('1', $selectedRepaints) ||
                        in_array('2', $selectedRepaints) ||
                        in_array('3', $selectedRepaints) ||
                        in_array('4', $selectedRepaints) ||
                        in_array('5', $selectedRepaints) ||
                        in_array('6', $selectedRepaints))
                    <label for="" class="text-uppercase fw-bold text-secondary mb-1 text-center">Unggah Foto
                        Komponen</label>
                @endif

                <div class="d-flex gap-3 mb-3">
                    @if (in_array('1', $selectedRepaints) || in_array('2', $selectedRepaints) || in_array('3', $selectedRepaints))
                        <div>
                            <label for="" class="form-label text-secondary">Foto Motor</label>
                            <input type="file" wire:model='foto_motor' class="form-control">
                        </div>
                    @endif
                    @if (in_array('4', $selectedRepaints))
                        <div>
                            <label for="foto_velg" class="form-label text-secondary">Foto Velg:</label>
                            <input type="file" wire:model='foto_velg' class="form-control">
                        </div>
                    @endif
                    @if (in_array('5', $selectedRepaints))
                        <div>
                            <label for="foto_knalpot" class="form-label text-secondary">Foto Knalpot:</label>
                            <input type="file" wire:model='foto_knalpot' class="form-control">
                        </div>
                    @endif
                    @if (in_array('6', $selectedRepaints))
                        <div>
                            <label for="foto_cvt" class="form-label text-secondary">Foto CVT:</label>
                            <input type="file" wire:model='foto_cvt' class="form-control">
                        </div>
                    @endif
                </div>

                @if (in_array('1', $selectedRepaints) ||
                        in_array('2', $selectedRepaints) ||
                        in_array('3', $selectedRepaints) ||
                        in_array('4', $selectedRepaints) ||
                        in_array('5', $selectedRepaints) ||
                        in_array('6', $selectedRepaints))
                    <label for="" class="text-uppercase fw-bold text-secondary mb-3 text-center">Pilih Warna
                        Repaint</label>
                @endif

                <div class="d-flex gap-5 mb-3">
                    @if (in_array('1', $selectedRepaints) || in_array('2', $selectedRepaints) || in_array('3', $selectedRepaints))
                        <div class="d-flex gap-3">
                            <label for="warna_body" class="form-label text-secondary">Warna Body:</label>
                            <input type="color" name="warna_body" id="warna_body" wire:model='warna_body'
                                value="#CCCCCC" title="Pilih Warna">
                        </div>
                    @endif
                    @if (in_array('4', $selectedRepaints))
                        <div class="d-flex gap-3">
                            <label for="warna_velg" class="form-label text-secondary">Warna Velg:</label>
                            <input type="color" name="warna_velg" id="warna_velg" wire:model='warna_velg'
                                value="#CCCCCC" title="Pilih Warna">
                        </div>
                    @endif
                    @if (in_array('5', $selectedRepaints))
                        <div class="d-flex gap-3">
                            <label for="warna_knalpot" class="form-label text-secondary">Warna Knalpot:</label>
                            <input type="color" name="warna_knalpot" id="warna_knalpot" wire:model='warna_knalpot'
                                value="#CCCCCC" title="Pilih Warna">
                        </div>
                    @endif
                    @if (in_array('6', $selectedRepaints))
                        <div class="d-flex gap-3">
                            <label for="warna_cvt" class="form-label text-secondary">Warna CVT:</label>
                            <input type="color" name="warna_cvt" id="warna_cvt" wire:model='warna_cvt'
                                value="#CCCCCC" title="Pilih Warna">
                        </div>
                    @endif
                </div>
                @if ($selectedRepaints)
                    <p class="fst-italic text-danger"><i class="bi bi-info-circle me-2"></i>Untuk keakuratan
                        warna,
                        tulis warna
                        lengkap pada Catatan.</p>
                @endif


                <div class="col">
                    <label for="catatan" class="form-label fw-bold text-uppercase text-secondary">Catatan</label>
                    <textarea name="" id="" class="form-control" wire:model='catatan'
                        placeholder="Tinggalkan Catatan anda untuk kami"></textarea>
                </div>

                <hr class="my-4">

                <div class="row mt-4 gap-3 mb-5">
                    <div class="col">
                        <div class="card border-warning">
                            <div class="card-body text-warning">
                                <label class="form-label text-secondary fw-bold text-uppercase">DP 10%:</label>
                                <h3 class="fw-bold">Rp{{ number_format($dpHarga, 0, ',', '.') }}</h3>
                            </div>
                        </div>
                    </div>
                    <div class="col">
                        <div class="card border-success">
                            <div class="card-body text-success">
                                <label class="form-label text-secondary fw-bold text-uppercase">Total Harga:</label>
                                <h3 class="fw-bold">Rp{{ number_format($totalHarga, 0, ',', '.') }}</h3>
                            </div>
                        </div>
                    </div>
                    <div class="col">
                        <div class="card border-info">
                            <div class="card-body text-info">
                                <label class="form-label text-secondary fw-bold text-uppercase">Estimasi
                                    Pengerjaan:</label>
                                <h3 class="fw-bold">{{ $estimasiWaktu }} Hari</h3>
                            </div>
                        </div>
                    </div>
                </div>

                <button type="button" class="btn btn-success fw-bold w-100" wire:click="reservasi"
                    data-bs-toggle="modal" data-bs-target="#modalPembayaran"
                    @if (!$selectedKategori || !$selectedTipe || empty($selectedRepaints)) disabled @endif>
                    Reservasi Sekarang
                </button>
            </div>
        </div>
    </div>


    {{-- modal Pembayaran dengan Midtrans --}}
    {{-- <div wire:ignore.self class="modal fade" id="modalPembayaran" data-bs-backdrop="static" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Pembayaran Reservasi</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    @if (session()->has('message'))
                        <div class="alert alert-success">
                            {{ session('message') }}
                        </div>
                    @endif

                    @if (session()->has('error'))
                        <div class="alert alert-danger">
                            {{ session('error') }}
                        </div>
                    @endif

                    <div class="mb-3">
                        <p class="fw-bold h4">Total Pembayaran: Rp. {{ number_format($totalHarga, 0, ',', '.') }}</p>
                        <p>Silahkan pilih metode pembayaran melalui Midtrans:</p>
                    </div>

                    @if ($snapToken)
                        <div wire:ignore>
                            <div id="snap-container"></div>
                            <p class="text-success">Token: {{ $snapToken }}</p> <!-- Untuk debugging -->
                        </div>
                    @else
                        <div class="alert alert-warning">
                            Sedang mempersiapkan metode pembayaran...
                            @if (app()->environment('local'))
                                <p>Debug: Snap Token tidak tersedia</p>
                            @endif
                        </div>
                    @endif
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                </div>
            </div>
        </div>
    </div> --}}


    {{-- modal Pembayaran --}}
    <div wire:ignore.self class="modal fade" id="modalPembayaran" data-bs-backdrop="static" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Upload Bukti Pembayaran</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    @if (session()->has('message'))
                        <div class="alert alert-success">
                            {{ session('message') }}
                        </div>
                    @endif
                    
                    {{-- @if (session()->has('error'))
                        <div class="alert alert-danger">
                            {{ session('error') }}
                        </div>
                    @endif --}}
                    
                    <!-- Debug info untuk development -->
                    {{-- @if (app()->environment('local'))
                    <div class="alert alert-info">
                        <p><strong>Info:</strong></p>
                        <p>Reservasi {{ $reservasiTersimpan ? 'Berhasil' : 'Tidak' }} Tersimpan</p>
                    </div>
                    @endif --}}

                    <div class="mb-3">
                        <p class="fw-bold h4">Total Pembayaran DP 10%: Rp. {{ number_format($dpHarga, 0, ',', '.') }}</p>
                        <p>Silahkan transfer ke rekening:</p>
                        <ul>
                            <li class="fw-bold">BCA: 1234567890 (A/N Hype Custom Project)</li>
                        </ul>
                    </div>
                    <div class="mb-3">
                        <label class="form-label text-secondary">Upload Bukti Transfer</label>
                        <input type="file" class="form-control @error('bukti_pembayaran') is-invalid @enderror"
                            wire:model="bukti_pembayaran">
                        @error('bukti_pembayaran')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"
                        wire:click="handleModalClose">Batal</button>
                    <button type="button" class="btn btn-primary fw-bold" wire:click="submitPembayaran"
                        @if (!$reservasiId) disabled @endif>
                        Kirim
                    </button>
                </div>
            </div>
        </div>
    </div>


    {{-- @push('scripts')
        <script type="text/javascript">
            document.addEventListener('livewire:initialized', () => {
                @this.on('openPaymentModal', () => {
                    console.log('Payment modal opened');
                    console.log('Snap Token:', @this.snapToken);

                    // Tunggu sebentar untuk memastikan snapToken sudah tersedia
                    setTimeout(() => {
                        if (@this.snapToken) {
                            console.log('Initializing Snap with token:', @this.snapToken);

                            // Pastikan snap.js sudah dimuat
                            if (typeof snap !== 'undefined') {
                                snap.pay(@this.snapToken, {
                                    onSuccess: function(result) {
                                        console.log('Payment success:', result);
                                        @this.handlePaymentCallback(result);
                                    },
                                    onPending: function(result) {
                                        console.log('Payment pending:', result);
                                        @this.handlePaymentCallback(result);
                                    },
                                    onError: function(result) {
                                        console.error('Payment error:', result);
                                        alert('Pembayaran gagal!');
                                    },
                                    onClose: function() {
                                        console.log('Snap popup closed');
                                        alert(
                                            'Anda menutup popup tanpa menyelesaikan pembayaran'
                                            );
                                    }
                                });
                            } else {
                                console.error('Snap.js not loaded');
                                alert('Gagal memuat Snap.js. Silakan refresh halaman dan coba lagi.');
                            }
                        } else {
                            console.error('Snap Token not available');
                            // Coba muat ulang token
                            @this.dispatch('refreshSnapToken');
                        }
                    }, 2000); // Tunggu 2 detik
                });
            });
        </script>
    @endpush --}}



</div>
