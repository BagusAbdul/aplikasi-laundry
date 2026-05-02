<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\Role;
use App\Models\Outlet;
use App\Models\User;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Seed Roles
        $adminRole = Role::create(['nama_role' => 'admin']);
        $kasirRole = Role::create(['nama_role' => 'kasir']);
        $ownerRole = Role::create(['nama_role' => 'owner']);

        // 2. Seed Initial Outlet
        $outlet = Outlet::create([
            'nama_outlet' => 'Laundry Pusat Segar',
            'alamat' => 'Jl. Merdeka No. 123',
            'telepon' => '08123456789'
        ]);

        // 3. Seed Users for each Role
        User::create([
            'name' => 'Administrator',
            'email' => 'admin@laundry.com',
            'password' => Hash::make('password'),
            'role_id' => $adminRole->id,
            'outlet_id' => $outlet->id,
        ]);

        User::create([
            'name' => 'Kasir Utama',
            'email' => 'kasir@laundry.com',
            'password' => Hash::make('password'),
            'role_id' => $kasirRole->id,
            'outlet_id' => $outlet->id,
        ]);

        User::create([
            'name' => 'Bapak Owner',
            'email' => 'owner@laundry.com',
            'password' => Hash::make('password'),
            'role_id' => $ownerRole->id,
            'outlet_id' => $outlet->id,
        ]);
    }
}
