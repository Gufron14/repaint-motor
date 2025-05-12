<!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-dark-primary elevation-4">
            <!-- Brand Logo -->
            <a href="{{ url('admin/dashboard') }}" class="brand-link">
                <img src="{{ asset('asset/img/logo.png') }}" alt="HCP Logo" class="brand-image" style="opacity: .8">
                <span class="brand-text font-weight-light font-weight-bold">Hype Project</span>
            </a>

            <!-- Sidebar -->
            <div class="sidebar">

                <!-- Sidebar Menu -->
                <nav class="mt-2">
                    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu"
                        data-accordion="false">
                        <x-nav-link :active="request()->routeIs('admin.dashboard')" href="{{ route('admin.dashboard') }}">
                            <i class="nav-icon fas fa-tachometer-alt"></i>Dashboard</x-nav-link>
                        <x-nav-link :active="request()->routeIs('admin.reservasi')" href="{{ route('admin.reservasi') }}">
                            <i class="nav-icon fas fa-fill"></i>
                            Reservasi                                
                                <span class="badge badge-danger right">
                                    {{ \App\Models\Reservasi::where('status', 'pending')->count() }}
                                </span>
                        </x-nav-link>

                        <li class="nav-header text-uppercase">Kelola Repaint</li>

                        <x-nav-link :active="request()->routeIs('admin.kategori-motor')" href="{{ route('admin.kategori-motor') }}">
                            <i class="nav-icon fas fa-list-alt"></i>Kategori Motor
                        </x-nav-link>
                        <x-nav-link :active="request()->routeIs('admin.tipe-motor')" href="{{ route('admin.tipe-motor') }}">
                            <i class="nav-icon fas fa-motorcycle"></i>Tipe Motor
                        </x-nav-link>
                        <x-nav-link :active="request()->routeIs('admin.jenis-repaint')" href="{{ route('admin.jenis-repaint') }}">
                            <i class="nav-icon fas fa-palette"></i>Jenis Repaint
                        </x-nav-link>
                        <x-nav-link :active="request()->routeIs('admin.harga-repaint')" href="{{ route('admin.harga-repaint') }}">
                            <i class="nav-icon fas fa-tag"></i>Harga Repaint
                        </x-nav-link>

                        <li class="nav-header text-uppercase">Kelola Web</li>

                        <x-nav-link :active="request()->routeIs('admin.portofolio')" href="{{ route('admin.portofolio') }}">
                            <i class="nav-icon fas fa-brush"></i>Portofolio
                        </x-nav-link>

                        <li class="nav-header text-uppercase">Kelola Customer</li>

                        {{-- <li class="nav-header">KELOLA USERS</li> --}}
                        <li class="nav-item">
                            <a href="{{ route('admin.customer') }}" class="nav-link {{ Request::is('admin/user') ? 'active fw-bold' : '' }}">
                                <i class="nav-icon fas fa-users"></i>
                                <p>
                                    Customer
                                </p>
                            </a>
                        </li>
                    </ul>
                </nav>
                <!-- /.sidebar-menu -->
            </div>
            <!-- /.sidebar -->
        </aside>
