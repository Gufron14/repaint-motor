<?php

namespace App\Http\Controllers\User;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserAuthController extends Controller
{
    public function login()
    {
        return view('auth.login');
    }

    public function doLogin(Request $request)
    {

        $request->validate([
            'email' => 'required',
            'password' => 'required'
        ]);

        $infologin = [
            'email' => $request->email,
            'password' => $request->password
        ];
        
        if (Auth::attempt($infologin)) {
            return redirect()->intended()->with('success', 'Login Success.');
        } else {
            return redirect('login')->with('error', 'Anda Penyusup.');
        }
    }

    public function register()
    {
        return view('auth.register');
    }

    public function doRegister(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'phone' => 'required|numeric|digits_between:1,12|unique:users',
            'password' => 'required|min:8'
        ]);

        $data = [
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'password' => Hash::make($request->password)
        ];

        User::create($data);

        return redirect('login')->with('success', 'Success make Account.');
    }

    function logout()
    {
        Auth::logout();

        return redirect('login')->with('success', 'Logout Success.');
    }

    public function profil()
    {
        $user = Auth::user();
        return view('profil', compact('user'));
    }

    public function update(Request $request, User $user)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email',
            'phone' => 'required|numeric|digits_between:1,12',
        ]);

        // $user = Auth::user();

        $user->name = $request->name;
        $user->email = $request->email;
        $user->phone = $request->phone;

        $user->update([
            'name' => $user->name,
            'email' => $user->email,
            'phone' => $user->phone
        ]);

        return redirect()->back()->with('success', 'Update Success.');
    }

    public function index(){
        $users = User::all();
        return view('admin.user', compact('users'));
    }
}
