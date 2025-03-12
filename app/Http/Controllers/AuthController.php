<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Role;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function loginForm()
    {
        if (Auth::check()) {
            return redirect()->route('admin.dashboard');
        }
        return view('admin.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::attempt($request->only('email', 'password'))) {
            return redirect()->route('admin.dashboard');
        }

        return back()->withErrors(['message' => 'Invalid credentials']);
    }

    public function dashboard()
    {
        $users = User::with('roles')->get(); // Fetch all users with their roles
        return view('admin.dashboard', compact('users'));
    }

    public function logout()
    {
        Auth::logout();
        return redirect()->route('admin.login');
    }

    public function usersList()
    {
        $users = User::with('roles')->get();
        return view('admin.login');
    }

    public function createUser()
    {
        $roles = Role::all();
        return view('admin.create', compact('roles'));
    }

    public function storeUser(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6',
            'role' => 'required|exists:roles,id',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        $user->roles()->attach($request->role);

        return redirect()->route('admin.dashboard')->with('success', 'User created successfully');
    }

    public function editUser($id)
    {
        $admin = User::findOrFail($id);
        $roles = Role::all(); // Get all roles to allow selection
    
        return view('admin.edit', compact('admin', 'roles'));
    }

    public function updateUser(Request $request, $id)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users,email,' . $id,
            'role' => 'required|exists:roles,id',
        ]);

        $user = User::findOrFail($id);
        $user->update([
            'name' => $request->name,
            'email' => $request->email,
        ]);

        $user->roles()->sync([$request->role]);

        return redirect()->route('admin.dashboard')->with('success', 'User updated successfully');
    }

    public function deleteUser($id)
    {
        $user = User::findOrFail($id);
        $user->delete();

        return redirect()->route('admin.dashboard')->with('success', 'User deleted successfully');
    }
}
