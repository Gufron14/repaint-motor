<div class="container py-5">
    <h2 class="mb-5 text-center">Portfolio Hype Project</h2>

    <div class="row g-4">
        @forelse($portfolios as $portfolio)
            <div class="col-lg-4 col-md-6">
                @if($portfolio->type === 'video')
                    <video controls class="w-100 shadow-1-strong rounded mb-4">
                        <source src="{{ asset('storage/' . $portfolio->media) }}" type="video/mp4">
                        Your browser does not support the video tag.
                    </video>
                @else
                    <img src="{{ asset('storage/' . $portfolio->media) }}"
                        class="w-100 shadow-1-strong rounded mb-4"
                        alt="Portfolio Image" />
                @endif
            </div>
        @empty
            <div class="col-12">
                <h4 class="text-center text-danger">Belum ada portfolio</h4>
            </div>
        @endforelse

    </div>
</div>
