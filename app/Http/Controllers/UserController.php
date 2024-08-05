<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function create()
    {
        return view('users.create');
    }

     // Store a newly created user in the database
     public function store(Request $request)
     {
         $request->validate([
             'name' => 'required|string|max:255',
             'email' => 'required|string|email|max:255|unique:users',
             'role' => 'required|string|in:admin,user',
             'password' => 'required|string|min:8|confirmed',
         ]);
 
         $user = new User();
         $user->name = $request->input('name');
         $user->email = $request->input('email');
         $user->role = $request->input('role');
         $user->password = Hash::make($request->input('password'));
         $user->save();
 
         return redirect()->route('users.index')->with('success', 'User created successfully');
     }
     
    // Menampilkan daftar pengguna
    public function index()
    {
        $users = User::all();
        return view('users.index', compact('users'));
    }

    // Menampilkan formulir untuk mengedit pengguna
    public function edit(User $user)
    {
        return view('users.edit', compact('user'));
    }

    // Memperbarui informasi pengguna
    public function update(Request $request, User $user)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'role' => 'required|string|in:admin,user', // Pastikan hanya role yang valid
            'password' => 'nullable|string|min:8|confirmed', // Password opsional
        ]);

        $user->name = $request->input('name');
        $user->email = $request->input('email');
        $user->role = $request->input('role');

        if ($request->filled('password')) {
            $user->password = Hash::make($request->input('password'));
        }

        $user->save();

        return redirect()->route('users.index')->with('success', 'User updated successfully');
    }

    // Menghapus pengguna
    public function destroy(User $user)
    {
        $user->delete();
        return redirect()->route('users.index')->with('success', 'User deleted successfully');
    }
}
