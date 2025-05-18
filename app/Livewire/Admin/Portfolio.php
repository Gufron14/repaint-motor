<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\Attributes\Title;
use Livewire\Attributes\Layout;
use Illuminate\Support\Facades\Storage;
use App\Models\Portfolio as PortfolioModel;

#[Layout('livewire.admin.layouts.app')]
#[Title('Portfolio Custom Project')]

class Portfolio extends Component
{
    use WithFileUploads;

    public $media = []; // array of uploaded files
    public $isEditing = false;
    public $portfolioId;
    public $editMedia;

    protected $rules = [
        'media.*' => 'required|mimes:jpg,jpeg,png,mp4,mov,avi|max:102400',
        // No title/description
        'editMedia' => 'nullable|mimes:jpg,jpeg,png,mp4,mov,avi|max:102400',
    ];

    protected $listeners = ['fileUploaded' => 'handleFileUpload'];

    public function handleFileUpload($files)
    {
        // Files from drag & drop
        $this->media = array_merge($this->media ?? [], $files);
    }

    public function save()
    {
        $this->validate([
            'media.*' => 'required|mimes:jpg,jpeg,png,mp4,mov,avi|max:102400',
        ]);

        foreach ($this->media as $file) {
            $mediaName = $file->store('portfolios', 'public');
            $extension = $file->getClientOriginalExtension();
            $isVideo = in_array(strtolower($extension), ['mp4', 'mov', 'avi']);

            PortfolioModel::create([
                'media' => $mediaName,
                'type' => $isVideo ? 'video' : 'image',
            ]);
        }

        $this->reset(['media']);
        session()->flash('message', 'Media uploaded successfully.');
    }

    public function edit($id)
    {
        $this->isEditing = true;
        $this->portfolioId = $id;
        $portfolio = PortfolioModel::find($id);
        // Untuk edit, bisa upload file baru
        $this->editMedia = null;
    }

    public function update()
    {
        $this->validate([
            'editMedia' => 'nullable|mimes:jpg,jpeg,png,mp4,mov,avi|max:102400',
        ]);

        $portfolio = PortfolioModel::find($this->portfolioId);
        if ($portfolio) {
            $data = [];

            if ($this->editMedia) {
                // Delete old file
                Storage::disk('public')->delete($portfolio->media);
                // Upload new file
                $mediaName = $this->editMedia->store('portfolios', 'public');
                $extension = $this->editMedia->getClientOriginalExtension();
                $isVideo = in_array(strtolower($extension), ['mp4', 'mov', 'avi']);
                $data['media'] = $mediaName;
                $data['type'] = $isVideo ? 'video' : 'image';
            }

            $portfolio->update($data);
            $this->reset(['editMedia', 'isEditing', 'portfolioId']);
            session()->flash('message', 'Portfolio updated successfully.');
        }
    }

    public function delete($id)
    {
        $portfolio = PortfolioModel::find($id);
        if ($portfolio) {
            Storage::disk('public')->delete($portfolio->media);
            $portfolio->delete();
            session()->flash('message', 'Media deleted successfully.');
        }
    }

    public function cancelEdit()
    {
        $this->reset(['editMedia', 'isEditing', 'portfolioId']);
    }

    public function render()
    {
        return view('livewire.admin.portfolio', [
            'portfolios' => PortfolioModel::latest()->get()
        ]);
    }
}
