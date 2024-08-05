<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    public function register()
    {
        return view('auth.register');
    }
  
    public function registerSave(Request $request)
    {
        Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|confirmed'
        ])->validate();

        // Menentukan role default sebagai user biasa
        $role = 'user';

        // Anda bisa menentukan apakah pengguna yang mendaftar akan menjadi admin
        if ($request->has('role') && $request->role === 'admin') {
            $role = 'admin';
        }

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $role  // Menyimpan peran pengguna
        ]);

        return redirect()->route('login')->with('success', 'Registration successful. Please login.');
    }

    public function createAdmin(Request $request)
    {
        // Validasi data jika diperlukan
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|confirmed',
        ]);

        // Simpan admin baru ke dalam database
        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'admin',
        ]);

        return redirect()->route('dashboard')->with('success', 'Admin created successfully.');
    }

    public function login()
    {
        return view('auth.login');
    }

    public function loginAction(Request $request)
    {
        Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required'
        ])->validate();

        if (!Auth::attempt($request->only('email', 'password'), $request->boolean('remember'))) {
            return redirect()->back()->withErrors([
                'email' => 'Email atau password yang Anda masukkan salah.',
            ])->withInput();
        }

        $request->session()->regenerate();

        // Tambahkan pesan sukses ke sesi
        return redirect()->intended(route('dashboard'))->with('success', 'Login berhasil!');
    }


    public function logout(Request $request)
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        return redirect('/');
    }

    public function updateProfile(Request $request)
    {
        // Retrieve the authenticated user
        $user = Auth::user();

        // Validate the request data
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        // Update the user's name
        $user->name = $request->input('name');

        // Save the changes to the database
        $user->save();

        // Redirect back to the profile page with a success message
        return redirect()->route('profile')->with('success', 'Profile updated successfully');
    }

    public function profile()
    {
        return view('profile');
    }

    
}
