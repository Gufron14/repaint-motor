<?php

namespace App\Livewire;

use App\Models\Image;
use Livewire\Component;
use Livewire\Attributes\Title;
use App\Models\Portfolio as PortfolioModel;

#[Title('Portfolio Hype Custom Project')]
class Portfolio extends Component
{
    public function render()
    {
        return view('livewire.portfolio', [
            'portfolios' => PortfolioModel::latest()->get(),
        ]); 
    }
}
