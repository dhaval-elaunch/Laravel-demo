<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {   
        // Fetch or create the Admin role
        $adminRole = Role::where('name', 'Admin')->first();
        
        // Create admin user if not exists
        $admin = User::firstOrCreate(
            ['email' => 'admin@admin.com'],
            [
                'name' => 'Admin User',
                'password' => Hash::make('admin@123'), // Set a secure password
            ]
        );

        // Check if the user already has the Admin role assigned
        $roleExists = DB::table('role_user')->where('user_id', $admin->id)->where('role_id', $adminRole->id)->exists();

        if (!$roleExists) {
            DB::table('role_user')->insert([
                'user_id' => $admin->id,
                'role_id' => $adminRole->id,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
