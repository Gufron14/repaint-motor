<div class="container py-4">
    <h2 class="mb-4 text-center">Dashboard Admin</h2>
    <div class="row g-4">
        <!-- Card Jumlah Reservasi -->
        <div class="col">
            <div class="card shadow-sm border-0 rounded-3 bg-light-info h-100">
                <div class="card-body d-flex align-items-center">
                    <div class="me-3">
                        <div class="icon bg-info text-white rounded-circle p-3 shadow-sm">
                            <i class="bi bi-calendar-check fs-3"></i>
                        </div>
                    </div>
                    <div>
                        <h5 class="card-title mb-1">Reservasi</h5>
                        <h3 class="mb-0">{{ $jumlahReservasi ?? 0 }}</h3>
                    </div>
                </div>
            </div>
        </div>
        <!-- Card Jumlah Customer -->
        <div class="col">
            <div class="card shadow-sm border-0 rounded-3 bg-light-success h-100">
                <div class="card-body d-flex align-items-center">
                    <div class="me-3">
                        <div class="icon bg-success text-white rounded-circle p-3 shadow-sm">
                            <i class="bi bi-people fs-3"></i>
                        </div>
                    </div>
                    <div>
                        <h5 class="card-title mb-1">Customer</h5>
                        <h3 class="mb-0">{{ $jumlahCustomer ?? 0 }}</h3>
                    </div>
                </div>
            </div>
        </div>
        <!-- Card Jumlah Tipe Motor -->
        <div class="col">
            <div class="card shadow-sm border-0 rounded-3 bg-light-warning h-100">
                <div class="card-body d-flex align-items-center">
                    <div class="me-3">
                        <div class="icon bg-warning text-white rounded-circle p-3 shadow-sm">
                            <i class="bi bi-motorcycle fs-3"></i>
                        </div>
                    </div>
                    <div>
                        <h5 class="card-title mb-1">Tipe Motor</h5>
                        <h3 class="mb-0">{{ $jumlahTipeMotor ?? 0 }}</h3>
                    </div>
                </div>
            </div>
        </div>
        <!-- Card Total Pendapatan -->
        <div class="d-flex mt-4 gap-5">
            <div class="card shadow-sm border-0 rounded-3 bg-light-primary h-100">
                <div class="card-body d-flex align-items-center">
                    <div class="me-3">
                        <div class="icon bg-primary text-white rounded-circle p-3 shadow-sm">
                            <i class="bi bi-currency-dollar fs-3"></i>
                        </div>
                    </div>
                    <div>
                        <h5 class="card-title mb-1">Pendapatan DP 10%</h5> <br>
                        <h3 class="mb-0">Rp {{ number_format($pendapatanDP ?? 0, 0, ',', '.') }}</h3>
                    </div>
                </div>
            </div>
            <div class="card shadow-sm border-0 rounded-3 bg-light-secondary h-100">
                <div class="card-body d-flex align-items-center">
                    <div class="me-3">
                        <div class="icon bg-secondary text-white rounded-circle p-3 shadow-sm">
                            <i class="bi bi-wallet2 fs-3"></i>
                        </div>
                    </div>
                    <div class="d-flex flex-column">
                        <h5 class="card-title mb-1">Total Pendapatan</h5>
                        <h3 class="mb-0">Rp{{ number_format($totalPendapatan ?? 0, 0, ',', '.') }}</h3>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
