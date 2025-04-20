<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\Portfolio as PortfolioModel;
use Livewire\Attributes\Title;
use Livewire\Attributes\Layout;

#[Layout('livewire.admin.layouts.app')]
#[Title('Portfolio Custom Project')]
class Portfolio extends Component
{
    use WithFileUploads;

    public $media;
    public $type;
    public $portfolioId;
    public $isEditing = false;

    public function save()
    {
        $this->validate([
            'media' => 'required|mimes:jpg,jpeg,png,mp4,mov,avi|max:102400',
        ]);

        $mediaName = $this->media->store('portfolios', 'public');
        $type = $this->media->getClientOriginalExtension();
        $isVideo = in_array($type, ['mp4', 'mov', 'avi']);

        PortfolioModel::create([
            'media' => $mediaName,
            'type' => $isVideo ? 'video' : 'image'
        ]);

        $this->reset();
        session()->flash('message', 'Media uploaded successfully.');
    }

    public function delete($id)
    {
        $portfolio = PortfolioModel::find($id);
        if($portfolio) {
            unlink(storage_path('app/public/' . $portfolio->media));
            $portfolio->delete();
        }
        session()->flash('message', 'Media deleted successfully.');
    }

    public function render()
    {
        return view('livewire.admin.portfolio', [
            'portfolios' => PortfolioModel::latest()->get()
        ]);
    }
}
