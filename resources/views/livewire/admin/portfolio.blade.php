<!-- resources/views/livewire/admin/portfolio.blade.php -->
<div class="container">
    <h2 class="mb-4">Manage Portfolio</h2>

    @if (session()->has('message'))
        <div class="alert alert-success">{{ session('message') }}</div>
    @endif

    <!-- Upload Form -->
    <div class="card mb-4">
        <div class="card-body">
            <form wire:submit.prevent="save">
                <div 
                    class="border border-primary p-3 mb-3" 
                    wire:dragover.prevent 
                    wire:drop.prevent="$emit('fileDropped', $event.dataTransfer.files)"
                    style="min-height: 150px; cursor: pointer;"
                >
                    <p class="text-center">Drag & Drop Files Here or Click to Select</p>
                    <input type="file" multiple class="form-control" wire:model="media" accept="image/*,video/*" style="cursor:pointer;" />
                </div>
                @error('media.*') <span class="text-danger">{{ $message }}</span> @enderror
                <button type="submit" class="btn btn-primary">Upload</button>
                <div wire:loading>Uploading...</div>
            </form>
        </div>
    </div>

    <!-- List Portfolio -->
    <div class="row g-4">
        @foreach($portfolios as $portfolio)
            <div class="col-md-4">
                <div class="card">
                    @if($portfolio->type === 'video')
                        <video controls class="card-img-top" style="max-height:200px; object-fit:cover;">
                            <source src="{{ asset('storage/' . $portfolio->media) }}" type="video/mp4">
                        </video>
                    @else
                        <img src="{{ asset('storage/' . $portfolio->media) }}" class="card-img-top" style="max-height:200px; object-fit:cover;">
                    @endif
                    <div class="card-body d-flex justify-content-between">
                        <button wire:click="edit({{ $portfolio->id }})" class="btn btn-sm btn-warning">Edit</button>
                        <button wire:click="delete({{ $portfolio->id }})" class="btn btn-sm btn-danger">Delete</button>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    <!-- Edit Modal or Inline -->
    @if($isEditing)
        <div class="modal show d-block" tabindex="-1">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Edit Portfolio</h5>
                        <button type="button" class="btn-close" wire:click="cancelEdit"></button>
                    </div>
                    <div class="modal-body">
                        <form wire:submit.prevent="update">
                            <div class="mb-3">
                                <label class="form-label">Upload New Media</label>
                                <input type="file" class="form-control" wire:model="editMedia" accept="image/*,video/*">
                                @error('editMedia') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>
                            <button type="submit" class="btn btn-primary">Update</button>
                            <button type="button" class="btn btn-secondary" wire:click="cancelEdit">Cancel</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>

@push('scripts')
<script>
    Livewire.on('fileDropped', files => {
        // Convert DataTransfer files to File objects
        // Note: Livewire supports file uploads via wire:model, but for drag & drop, custom handling may be needed
        // For simplicity, assume files are selected via input
    });
</script>
@endpush
