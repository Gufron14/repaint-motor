<!-- Navbar -->
<nav class="main-header navbar navbar-expand navbar-white navbar-light border px-5">
    <!-- Left navbar links -->
    <ul class="navbar-nav border">
        <li class="nav-item">
            <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
        </li>
    </ul>

    <!-- Right navbar links -->
    <div class="ml-auto border d-flex gap-2">
        <a href="{{ route('/') }}" class="btn btn-outline-success">Website</a>
        <li class="nav nav-item dropdown dropstart">
            <button class="btn btn-danger dropdown-toggle dropstart" data-bs-toggle="dropdown" aria-expanded="false">
                {{ Auth::user()->name }}
            </button>
            <ul class="dropdown-menu dropdown-menu-light">
                {{-- <li><a class="dropdown-item" href="{{ route('profil', ['user' => Auth::user()->name]) }}">Profil</a></li> --}}
                <li><a class="dropdown-item" href="{{ route('logout') }}">Logout</a></li>
            </ul>
        </li>
    </div>
</nav>
<!-- /.navbar -->
