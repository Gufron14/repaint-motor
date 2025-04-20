        <!-- Main Sidebar Container -->
        <aside class="main-sidebar sidebar-dark-primary elevation-4">
            <!-- Brand Logo -->
            <a href="{{ url('admin/dashboard') }}" class="brand-link">
                <img src="{{ asset('asset/img/logo.png') }}" alt="AdminLTE Logo"
                    class="brand-image" style="opacity: .8">
                <span class="brand-text font-weight-light font-weight-bold">Hype Project</span>
            </a>

            <!-- Sidebar -->
            <div class="sidebar">

                <!-- Sidebar Menu -->
                <nav class="mt-2">
                    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu"
                        data-accordion="false">
                        <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
                        <li class="nav-item">
                            <a href="{{ url('admin/dashboard') }}" class="nav-link {{ Request::is('admin/dashboard') ? 'active fw-bold' : ' ' }}">
                                <i class="nav-icon fas fa-tachometer-alt"></i>
                                <p>
                                    Dashboard
                                </p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('admin.reservasi') }}" class="nav-link {{ Request::is('admin/reservasi') ? 'active fw-bold' : '' }}">
                                <i class="nav-icon fas fa-fill"></i>
                                <p>
                                    Reservasi
                                    <span class="badge badge-info right">2</span>
                                </p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="" class="nav-link {{ Request::is('') ? 'active fw-bold' : '' }}">
                                <i class="nav-icon fas fa-history"></i>
                                <p>
                                    Riwayat Reservasi
                                </p>
                            </a>
                        </li>
                        {{-- Kelola Repaint --}}
                        <li class="nav-item">
                            <a href="" class="nav-link {{ Request::is('admin/motor') ? 'active fw-bold' : '' }}">
                                <i class="nav-icon fas fa-motorcycle"></i>
                                <p>
                                    Kelola Repaint Motor
                                </p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="" class="nav-link {{ Request::is('') ? 'active fw-bold' : '' }}">
                                <i class="nav-icon fas fa-money-check-alt"></i>
                                <p>
                                    Laporan Keuangan
                                </p>
                            </a>
                        </li>
                        {{-- <li class="nav-item">
                            <a href="{{ route('repaint') }}" class="nav-link {{ Request::is('admin/repaint') ? 'active fw-bold' : '' }}">
                                <i class="nav-icon fas fa-palette"></i>
                                <p>
                                    Repaint
                                </p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('repaint') }}" class="nav-link {{ Request::is('') ? 'active fw-bold' : '' }}">
                                <i class="nav-icon fas fa-tags"></i>
                                <p>
                                    Pricelist
                                </p>
                            </a>
                        </li> --}}

                        {{-- <li class="nav-header">KELOLA USERS</li> --}}
                        <li class="nav-item">
                            <a href="" class="nav-link {{ Request::is('admin/user') ? 'active fw-bold' : '' }}">
                                <i class="nav-icon fas fa-users"></i>
                                <p>
                                    User
                                </p>
                            </a>
                        </li>
                    </ul>
                </nav>
                <!-- /.sidebar-menu -->
            </div>
            <!-- /.sidebar -->
        </aside>
