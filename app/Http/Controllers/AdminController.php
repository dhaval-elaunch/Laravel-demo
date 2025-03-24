<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    public function dashboard()
    {
        return response()->json(['message' => 'Welcome to the Admin Dashboard']);
    }

    public function logout(Request $request)
    {
        $request->user()->token()->revoke(); // Revoke token
        return response()->json(['message' => 'Successfully logged out']);
    }

    public function userList(Request $request)
    {
        $currentUserId = auth()->id(); // Get the currently logged-in user ID

        $users = User::with('roles')
            ->where('id', '!=', $currentUserId) // Exclude the logged-in user
            ->where('email', '!=', 'admin@admin.com') // Exclude admin@admin.com
            ->get();

        return response()->json($users);
    }

    public function createAdmin(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6',
            'role' => 'required|string|exists:roles,name', // Accept role as string
        ]);

        // Find role ID from role name
        $roleId = DB::table('roles')->where('name', $request->role)->value('id');

        if (!$roleId) {
            return response()->json(['message' => 'Invalid role name.'], 422);
        }

        // Create new user
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        // Insert role into `role_user` table
        DB::table('role_user')->insert([
            'user_id' => $user->id,
            'role_id' => $roleId,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return response()->json(['message' => 'Admin created successfully', 'user' => $user]);
    }

    public function updateAdmin(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'role_id' => 'required|exists:roles,id',
        ]);

        $user = User::find($id);
        if (!$user) {
            return response()->json(['message' => 'User not found'], 404);
        }

        $user->update([
            'name' => $request->name,
        ]);

        $user->roles()->sync([$request->role_id]); // Sync role_id with role_user table

        return response()->json(['message' => 'User updated successfully', 'user' => $user]);
    }

    public function show($id)
    {
        $user = User::with('roles')->find($id); // ✅ Fetch user with roles

        if (!$user) {
            return response()->json(['message' => 'User not found'], 404);
        }

        return response()->json($user);
    }

    public function roleList()
    {
        $roles = Role::all();

        if ($roles->isEmpty()) {
            return response()->json(['message' => 'No roles found'], 404);
        }

        return response()->json($roles);
    }
}
