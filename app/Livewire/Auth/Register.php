<?php

namespace App\Livewire\Auth;

use App\Models\User;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Title;

#[Title('Register')]
class Register extends Component
{
    public $name;
    public $username;
    public $phone;
    public $password;

    protected $rules = [
        'name' => 'required|min:3',
        'username' => 'required|unique:users',
        'phone' => 'required|numeric|unique:users|min:10|max:12',
        'password' => 'required|min:6',
    ];

    public function register()
    {
        $this->validate();

        

        if (strlen(preg_replace('/\D/', '', $this->phone)) < 10 || strlen(preg_replace('/\D/', '', $this->phone)) > 12) {
            $this->addError('phone', 'Nomor telepon harus terdiri dari 10 sampai 12 digit.');
            return;
        }

        $user = User::create([
            'name' => $this->name,
            'username' => $this->username,
            'phone' => $this->phone,
            'password' => bcrypt($this->password),
        ]);

        // Assign role user (customer) secara default
        $user->assignRole('user');

        // Auth::login($user);

        return redirect()->route('login');
    }

    public function normalizeUsername()
    {
        $this->username = strtolower(preg_replace('/\s+/', '', $this->username));
    }

    public function updatedPassword()
    {
        if (!preg_match('/^[a-zA-Z0-9]{6,}$/', $this->password ?? '')) {
            $this->addError('password', 'Password minimal 6 karakter, hanya huruf atau angka.');
        } else {
            $this->resetErrorBag('password');
        }
    }

    public function render()
    {
        return view('livewire.auth.register');
    }
}
