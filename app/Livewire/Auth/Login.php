<?php

namespace App\Livewire\Auth;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Title;

#[Title('Login')]
class Login extends Component
{   
    public $username;
    public $password;

    protected $rules = [
        'username' => 'required',
        'password' => 'required'
    ];

    public function login()
    {
        $this->validate();
    
        // Cek apakah username ada di database
        $user = \App\Models\User::where('username', $this->username)->first();
        
        if (!$user) {
            session()->flash('error', 'username tidak terdaftar');
            return;
        }
        
        // Jika username ada, cek password
        if (Auth::attempt(['username' => $this->username, 'password' => $this->password])) {
            $user = Auth::user();
            
            if ($user->hasRole('admin')) {
                return redirect()->route('admin.dashboard');
            } else {
                return redirect()->route('/');
            }
        } else {
            // Jika username benar tapi password salah
            session()->flash('error', 'Password yang Anda masukkan salah');
        }
    }

    public function normalizeUsername()
{
    $this->username = strtolower(preg_replace('/\s+/', '', $this->username));
}
    

    public function render()
    {
        return view('livewire.auth.login');
    }
}
