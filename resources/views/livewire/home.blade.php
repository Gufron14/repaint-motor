<div>
    <div class="text-center mb-5">
        <h1 class="fw-bold">Hype Custom Project</h1>
        <h3>Repaint Motor</h3>
        <p>Hype Project menghadirkan layanan repaint motor berkualitas tinggi untuk Anda yang ingin tampil beda di jalanan. Dengan sentuhan kreatif dari tim profesional kami, motor Anda akan bertransformasi menjadi karya seni yang mencerminkan gaya dan kepribadian Anda. Percayakan motor Anda kepada Hype Project, karena kami tidak hanya mengecat, tapi juga menghadirkan hype pada setiap kendaraan! 💥</p>
        <a href="{{ route('reservasi') }}" class="btn btn-warning fw-bold">Reservasi</a>
    </div>

    <h3 class="text-center fw-bold">Portofolio</h3>
    <div class="row g-4">
        @foreach(\App\Models\Portfolio::latest()->take(6)->get() as $portfolio)
            <div class="col-lg-4 col-md-6">
                @if($portfolio->type === 'video')
                    <video controls class="w-100 shadow-1-strong rounded mb-4" autoplay muted loop>
                        <source src="{{ asset('storage/' . $portfolio->media) }}" type="video/mp4">
                        Your browser does not support the video tag.
                    </video>
                @else
                    <img src="{{ asset('storage/' . $portfolio->media) }}"
                        class="w-100 shadow-1-strong rounded mb-4"
                        alt="Portfolio Image" />
                @endif
            </div>
        @endforeach
    </div>
    

    @guest        
    <h3 class="text-center mt-5 mb-5 fw-bold">Kalkulator Harga & Estimasi Waktu</h3>
    <div class="row">
        <div class="col text-center">
            <img src="{{ asset('asset/img/IMG_20240311_135947.JPG') }}"
                alt="" width="50%">
        </div>
        <div class="col align-self-center">
            <p>Hitung Harga Custom Sekarang di Hype Project!
                Dapatkan estimasi biaya repaint motor Anda hanya dengan beberapa klik. Sesuaikan warna dan gaya sesuai keinginan Anda—cepat, mudah, dan transparan!</p>
            <a href="{{ route('kalkulator-harga') }}" class="btn btn-warning fw-bold">Mulai Sekarang</a>
        </div>
    </div>
    @endguest

    <h3 class="text-center mt-5 mb-5 fw-bold">Antrean Reservasi</h3>
    <div class="row">
        <div class="col align-self-center">
            <p>
                Dapatkan antrean layanan Anda di Hype Project dengan mudah! Lakukan reservasi sekarang, dan kami akan mengatur jadwal pengerjaan sesuai dengan antrean yang tersedia. Pantau status reservasi Anda secara real-time tanpa perlu datang langsung ke bengkel. Jangan tunda lagi, daftarkan motor Anda sekarang dan biarkan kami menangani sisanya!
            </p>
            <a href="{{ route('antrean') }}" class="btn btn-warning fw-bold">Lihat Antrean</a>
        </div>
        <div class="col text-center">
            <img src="{{ asset('asset/img/IMG_20240512_022859.JPG') }}"
                alt="" width="50%">
        </div>
    </div>

</div>


