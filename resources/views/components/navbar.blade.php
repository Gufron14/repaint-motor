<header class="p-3 text-bg-dark">
    <div class="container">
        <div class="d-flex flex-wrap align-items-center justify-content-center justify-content-lg-start">
            <a href="/" class="d-flex align-items-center mb-2 mb-lg-0 text-white text-decoration-none">
                <img src="{{ asset('asset/img/logo.png') }}" alt="" width="40px">
                {{-- <svg class="bi me-2" width="40" height="32" role="img" aria-label="Bootstrap"><use xlink:href="#bootstrap"/></svg> --}}
            </a>

            <ul class="nav col-12 col-lg-auto me-lg-auto ms-5 mb-2 justify-content-center mb-md-0">
                {{-- <li><a href="/" class="nav-link px-2 {{ Request::is('/') ? 'text-white fw-bold' : 'text-secondary' }}">Beranda</a></li>
            
                @auth
                    <li><a href="{{ route('reservasi') }}" class="nav-link px-2 {{ Request::is('reservasi*') ? 'text-white fw-bold' : 'text-secondary' }}">Reservasi</a></li>
                @endauth
            
                <li><a href="{{ route('kalkulator-harga') }}" class="nav-link px-2 {{ Request::is('simulasi*') ? 'text-white fw-bold' : 'text-secondary' }}">Kalkulator Harga</a></li>
                <li><a href="/jadwal" class="nav-link px-2 {{ Request::is('jadwal*') ? 'text-white fw-bold' : 'text-secondary' }}">Jadwal</a></li>
                <li><a href="/portfolio" class="nav-link px-2 {{ Request::is('portfolio*') ? 'text-white fw-bold' : 'text-secondary' }}">Portofolio</a></li> --}}

                <x-nav-link :active="request()->routeIs('/')" href="{{ route('/') }}">Beranda</x-nav-link>
                @auth                    
                    <x-nav-link :active="request()->routeIs('reservasi')" href="{{ route('reservasi') }}">Reservasi</x-nav-link>
                    <x-nav-link :active="request()->routeIs('riwayat.reservasi')" href="{{ route('riwayat.reservasi') }}">Riwayat</x-nav-link>
                @endauth

                @guest
                    <x-nav-link :active="request()->routeIs('kalkulator-harga')" href="{{ route('kalkulator-harga') }}">Kalkulator Harga</x-nav-link>
                @endguest
                
                <x-nav-link :active="request()->routeIs('antrean')" href="{{ route('antrean') }}">Antrean</x-nav-link>
                <x-nav-link :active="request()->routeIs('pricelist')" href="{{ route('pricelist') }}">Pricelist</x-nav-link>
                <x-nav-link :active="request()->routeIs('portfolio')" href="{{ route('portfolio') }}">Portofolio</x-nav-link>



                {{-- @if (Auth::check())
                    <button wire:click="logout">Logout</button>
                @endif --}}

            </ul>

            <div class="text-end">
                @guest
                    <!-- Jika user belum login, tampilkan tombol Login dan Daftar -->
                    <a href="{{ route('login') }}" class="btn btn-outline-light me-2 fw-bold">Login</a>
                    <a href="{{ route('register') }}" class="btn btn-warning fw-bold">Daftar</a>
                @else
                    <!-- Jika user sudah login, tampilkan tombol Logout -->
                    <li class="nav nav-item dropdown">
                        <button class="btn btn-dark dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                            {{ Auth::user()->name }}
                        </button>
                        <ul class="dropdown-menu dropdown-menu-dark">
                            <li><a class="dropdown-item" href="{{ route('profil', ['user' => Auth::user()->name]) }}">Profil</a></li>
                            <li><a class="dropdown-item" href="{{ route('logout') }}">Logout</a></li>
                        </ul>
                    </li>
                @endguest
            </div>

        </div>
    </div>
</header>
