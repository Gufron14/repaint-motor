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
    <title>Login</title>
</head>
<body>
    @include('components.navbar')
    <div class="card mt-5" style="width: 25rem; margin: 0 auto;">
        <div class="card-body">

            <h1 class="my-3 fw-bold">Login</h1>

            <form action="{{ route('doLogin') }}" method="post">
                @csrf
                <div class="mb-3">
                    <label for="email" class="">Email</label>
                    <input type="email" name="email" class="form-control" placeholder="hypeproject@gmail.com" required>
                </div>

                <div class="mb-3">
                    <label for="password">Password</label>
                    <input type="password" name="password" class="form-control" placeholder="Password" required>
                </div>

                <!-- Submit button -->
                <div class="row">
                    <div class="col-4">
                        <button type="submit" class="btn btn-primary btn-block fw-bold">Masuk</button>
                    </div>
                    <div class="col align-self-center">
                        <small>Belum punya akun?
                            <a href="{{ route('register') }}">Buat Akun</a>
                        </small>
                    </div>
                </div>
            </form>
        </div>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous">
    </script>
</body>
</html>
    

