<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use App\Models\User;
use App\Models\Villa;
use App\Models\Transaction;
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

        // 4. Create Dummy Villa tied to Pemilik
        $villa = Villa::create([
            'pemilik_id' => $userPemilik->id,
            'name' => 'Villa Sunset Paradise',
            'email' => 'sunset@villa.com',
            'description' => 'Villa mewah dengan pemandangan sunset yang indah.',
        ]);

        // 5. Create Dummy Transaction Data tied to Villa
        Transaction::create([
            'villa_id' => $villa->id,
            'name' => 'Sewa Villa 2 Malam (Tamu A)',
            'amount' => 5000000,
            'type' => 'income',
            'date' => now()->subDays(2),
        ]);

        Transaction::create([
            'villa_id' => $villa->id,
            'name' => 'Pembelian Sabun dan Tissue',
            'amount' => 250000,
            'type' => 'expense',
            'date' => now()->subDays(1),
        ]);

        Transaction::create([
            'villa_id' => $villa->id,
            'name' => 'Gaji Staff Kebersihan',
            'amount' => 1500000,
            'type' => 'expense',
            'date' => now(),
        ]);
    }
}
