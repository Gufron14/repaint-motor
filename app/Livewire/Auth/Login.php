<?php

namespace App\Livewire\Auth;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Title;

#[Title('Login')]
class Login extends Component
{   
    public $email;
    public $password;

    protected $rules = [
        'email' => 'required|email',
        'password' => 'required'
    ];

    public function login()
    {
        $this->validate();

        if(Auth::attempt(['email' => $this->email, 'password' => $this->password])) {
            $user = Auth::user();
            
            if($user->hasRole('admin')) {
                return redirect()->route('admin.dashboard');
            } else {
                return redirect()->route('reservasi');
            }
        }

        session()->flash('error', 'Email atau password salah');
    }

    public function render()
    {
        return view('livewire.auth.login');
    }
}
