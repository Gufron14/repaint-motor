<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="{{ asset('asset/css/style.css') }}">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <title>Buat Akun</title>
</head>
<body>
    @include('components.navbar')
    <div class="container mt-5">
        <div class="card" style="width: 25rem; margin: 0 auto;">
            <div class="card-body">
    
                <h1 class="my-3 fw-bold">Register</h1>
    
                <form action="{{ route('doRegister') }}" method="post">
                    @csrf
                    <div class="mb-3">
                        <label for="name" class="">Nama Lengkap</label>
                        <input type="text" name="name" class="form-control" placeholder="Nama" required>
                    </div>
                    <div class="mb-3">
                        <label for="phone" class="">No. Telepon</label>
                        <input type="number" name="phone" class="form-control" placeholder="08123456789" required>
                    </div>
                    <div class="mb-3">
                        <label for="email" class="">Email</label>
                        <input type="email" name="email" class="form-control" placeholder="hypeproject@gmail.com" required>
                    </div>
                    <div class="mb-3">
                        <label for="">Password</label>
                        <input type="password" name="password" class="form-control" placeholder="Password" required>
                    </div>
    
                    <div class="row">
                        <div class="col">
                            <button type="submit" class="btn btn-primary fw-bold">Buat Akun</button>
                        </div>
    
                        <div class="col align-self-center">                        
                            <small>Sudah punya akun?
                                <a href="{{ route('login') }}" class="text-decoration-none">Login</a>
                            </small>
                        </div>
                    </div>
                </form>
    
    
            </div>
        </div>
    </div>
</body>
</html>
    
    