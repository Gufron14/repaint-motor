<?php

namespace App\Livewire\Auth;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Livewire\Attributes\Title;

#[Title('Profil')]
class Profil extends Component
{   
    public $name;
    public $email;
    public $phone;

    public function mount()
    {
        $user = Auth::user();
        $this->name = $user->name;
        $this->email = $user->email;
        $this->phone = $user->phone;
    }

    public function updateProfile()
    {
        $validatedData = $this->validate([
            'name' => 'required',
            'email' => 'required|email',
            'phone' => 'required|numeric|digits_between:1,12',
        ]);

        // Ambil ulang user dari database
        $user = User::find(Auth::id());
        
        if ($user) {
            $user->name = $validatedData['name'];
            $user->email = $validatedData['email'];
            $user->phone = $validatedData['phone'];
            $user->save(); // Simpan data baru ke database

            session()->flash('success', 'Berhasil update profil');
        } else {
            session()->flash('error', 'User tidak ditemukan');
        }
    }
    
    public function render()
    {   
        return view('livewire.auth.profil');
    }
}
