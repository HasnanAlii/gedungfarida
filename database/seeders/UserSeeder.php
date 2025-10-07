<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class UserSeeder extends Seeder
{
    /**
     * Jalankan database seeder.
     */
    public function run(): void
    {
        // === Buat Role ===
        $adminRole = Role::firstOrCreate(['name' => 'admin']);
        $userRole  = Role::firstOrCreate(['name' => 'customer']);

        // === Buat Permission ===
        $manageUsers = Permission::firstOrCreate(['name' => 'manage users']);
        $viewReport  = Permission::firstOrCreate(['name' => 'view report']);

        // === Assign Permission ke Role ===
        $adminRole->givePermissionTo([$manageUsers, $viewReport]);
        $userRole->givePermissionTo([$viewReport]);

        // === Buat User Admin ===
        $admin = User::firstOrCreate(
            ['email' => 'admin@gmail.com'],
            [
                'name' => 'Owner',
                'password' => Hash::make('password'),
            ]
        );
        $admin->assignRole($adminRole);

        // === Buat User Biasa ===
        $user = User::firstOrCreate(
            ['email' => 'user@gmail.com'],
            [
                'name' => 'customer ',
                'password' => Hash::make('password'),
            ]
        );
        $user->assignRole($userRole);
    }
}
