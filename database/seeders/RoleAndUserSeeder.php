<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class RoleAndUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 1. Create Roles
        $rolePemilik = Role::create(['name' => 'pemilik']);
        $rolePengelola = Role::create(['name' => 'pengelola']);

        // 2. Create User Pemilik
        $userPemilik = User::create([
            'name' => 'Pemilik Villa',
            'email' => 'pemilik@villa.com',
            'password' => Hash::make('password'),
        ]);
        $userPemilik->assignRole($rolePemilik);

        // 3. Create User Pengelola
        $userPengelola = User::create([
            'name' => 'Pengelola Villa',
            'email' => 'pengelola@villa.com',
            'password' => Hash::make('password'),
        ]);
        $userPengelola->assignRole($rolePengelola);

        // 4. Create Dummy Finance Data
        \App\Models\FinanceReport::create([
            'date' => now()->subDays(2),
            'description' => 'Sewa Villa 2 Malam (Tamu A)',
            'amount' => 5000000,
            'type' => 'income',
        ]);

        \App\Models\FinanceReport::create([
            'date' => now()->subDays(1),
            'description' => 'Pembelian Sabun dan Tissue',
            'amount' => 250000,
            'type' => 'expense',
        ]);

        \App\Models\FinanceReport::create([
            'date' => now(),
            'description' => 'Gaji Staff Kebersihan',
            'amount' => 1500000,
            'type' => 'expense',
        ]);
    }
}
