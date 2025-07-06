<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $title ?? config('app.name') }}</title>

    <link rel="stylesheet" href="{{ asset('asset/css/style.css') }}">

    <link rel="shortcut icon" href="{{ asset('asset/img/logo.png') }}">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Ubuntu:ital,wght@0,300;0,400;0,500;0,700;1,300;1,400;1,500;1,700&display=swap"
        rel="stylesheet">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <script type="text/javascript" src="{{ config('midtrans.snap_url') }}"
        data-client-key="{{ config('midtrans.client_key') }}"></script>
    @livewireStyles
</head>

<body>

    @include('components.navbar')
    {{-- @livewire('navbar') --}}

    <div class="container-fluid bg-light">
        <div class="container p-5">
            <div class="min-h-screen">
                {{ $slot }}
            </div>
        </div>
    </div>

    <!-- Floating WhatsApp Button -->
    <a href="https://wa.me/62895320501644?text=Hallo%20Hype%20Custom%20Project,%20%Aku%20mau%20Reservasi%20Repaint%20Motor" target="_blank" class="whatsapp-button">
        <i class="bi bi-whatsapp"></i> Hubungi Kami
    </a>

    <footer class="bg-body-tertiary text-center text-lg-start">
        <div class="d-flex justify-content-between align-items-middle mx-5 py-3">
            <div>
                <h5 class="fw-bold">Hype Custom Project</h5>
                Jl. Cipendawa Lama, Gg. Sinar Agung, RT.02 RW. 07 No.72, Rawa lumbu, Bekasi - 17117
            </div>
            <div class="align-self-center">
                <div class="fs-5">
                    <a href="https://wa.me/62895320501644"><i class="bi bi-telephone-fill"></i></a>
                    <a
                        href="https://www.instagram.com/hypecustom.project?utm_source=ig_web_button_share_sheet&igsh=ZDNlZDc0MzIxNw=="><i
                            class="bi bi-instagram"></i></a>
                </div>
                © 2025 Hype Custom Project
            </div>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous">
    </script>

    @livewireScripts
</body>

</html>
