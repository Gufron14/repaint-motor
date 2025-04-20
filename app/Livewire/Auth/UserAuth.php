<?php

namespace App\Livewire\Auth;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserAuth extends Component
{
    public $email, $password, $name, $password_confirmation;
    public $page = 'login'; // Default ke halaman login

    // Fungsi untuk Login
    public function login()
    {
        $this->validate([
            'email' => 'required|email',
            'password' => 'required|min:6',
        ]);

        if (Auth::attempt(['email' => $this->email, 'password' => $this->password])) {
            session()->regenerate();
            return redirect()->route('dashboard'); // Arahkan ke halaman setelah login
        } else {
            session()->flash('error', 'Email atau Password salah');
        }
    }

    // Fungsi untuk Register
    public function register()
    {
        $this->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6|confirmed',
        ]);

        $user = User::create([
            'name' => $this->name,
            'email' => $this->email,
            'password' => Hash::make($this->password),
        ]);

        Auth::login($user);
        return redirect()->route('dashboard');
    }

    // Fungsi untuk Logout
    public function logout()
    {
        Auth::logout();
        session()->invalidate();
        session()->regenerateToken();
        return redirect()->route('login');
    }

    // Fungsi untuk menampilkan halaman login atau register
    public function setPage($page)
    {
        $this->page = $page;
    }

    public function render()
    {
        return view('livewire.auth.auth-livewire');
    }
}

