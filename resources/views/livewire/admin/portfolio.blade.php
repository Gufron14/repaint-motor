<div class="container">
    <h2 class="mb-4">Manage Portfolio</h2>

    @if (session()->has('message'))
        <div class="alert alert-success">
            {{ session('message') }}
        </div>
    @endif

    <div class="card mb-4">
        <div class="card-body">
            <form wire:submit="save">
                <div class="mb-3">
                    <label class="form-label">Upload Media (Image/Video)</label>
                    <input type="file" class="form-control" wire:model="media" accept="image/*,video/*">
                    @error('media') <span class="text-danger">{{ $message }}</span> @enderror
                </div>
                <button type="submit" class="btn btn-primary">Upload</button>
                <div wire:loading> 
                    mengupload...
                </div>
            </form>
        </div>
    </div>

    <div class="row g-4">
        @foreach($portfolios as $portfolio)
            <div class="col-md-4">
                <div class="card">
                    @if($portfolio->type === 'video')
                        <video controls class="card-img-top">
                            <source src="{{ asset('storage/' . $portfolio->media) }}" type="video/mp4">
                            Your browser does not support the video tag.
                        </video>
                    @else
                        <img src="{{ asset('storage/' . $portfolio->media) }}" class="card-img-top" alt="Portfolio Image">
                    @endif
                    <div class="card-body">
                        <button wire:click="delete({{ $portfolio->id }})" class="btn btn-danger btn-sm">Delete</button>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>
