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
    public $username;
    public $phone;
    public $password;
    public $adress;
    public $no_rek;


public $password_confirmation;

    public function mount()
    {
        $user = Auth::user();
        $this->name = $user->name;
        $this->username = $user->username;
        $this->phone = $user->phone;
    }
public function updateProfile()
{
    $validatedData = $this->validate([
        'name' => 'required',
        'username' => 'required',
        'phone' => 'required|numeric|digits_between:1,12',
        'password' => 'nullable|min:6|same:password_confirmation',
        'password_confirmation' => 'nullable',
        'adress' => 'nullable|string|min:5',
        'no_rek' => 'nullable|string',
    ]);

    $user = User::find(Auth::id());
    
    if ($user) {
        $user->name = $validatedData['name'];
        $user->username = $validatedData['username'];
        $user->phone = $validatedData['phone'];
        $user->adress = $validatedData['adress'];
        $user->no_rek = $validatedData['no_rek'];
        if (!empty($validatedData['password'])) {
            $user->password = bcrypt($validatedData['password']);
        }
        $user->save();

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
