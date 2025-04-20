<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use Livewire\Attributes\Title;
use Livewire\Attributes\Layout;

#[Layout('livewire.admin.layouts.app')]
#[Title('Dashboard Hype Custom Project')]
class Dashboard extends Component
{
    public function render()
    {
        return view('livewire.admin.dashboard');
    }
}
