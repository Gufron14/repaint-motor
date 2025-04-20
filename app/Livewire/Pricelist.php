<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\KategoriMotor;
use Livewire\Attributes\Title;

#[Title('Pricelist Hype Custom Project')]

class Pricelist extends Component
{
    public function render()
    {
        $kategoriMotors = KategoriMotor::with('tipeMotors.motorRepaints.jenisRepaint')->get();

        return view('livewire.pricelist', compact('kategoriMotors'));
    }
}
