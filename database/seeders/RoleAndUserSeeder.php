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
        $rolePemilik = Role::firstOrCreate(['name' => 'pemilik']);
        $rolePengelola = Role::firstOrCreate(['name' => 'pengelola']);
        $roleCustomer = Role::firstOrCreate(['name' => 'customer']);

        // 2. Create User Pemilik
        $userPemilik = User::firstOrCreate(
            ['email' => 'pemilik@villa.com'],
            [
                'name' => 'Pemilik Villa',
                'password' => Hash::make('password'),
            ]
        );
        if (!$userPemilik->hasRole('pemilik')) {
            $userPemilik->assignRole($rolePemilik);
        }

        // 3. Create User Pengelola
        $userPengelola = User::firstOrCreate(
            ['email' => 'pengelola@villa.com'],
            [
                'name' => 'Pengelola Villa',
                'password' => Hash::make('password'),
            ]
        );
        if (!$userPengelola->hasRole('pengelola')) {
            $userPengelola->assignRole($rolePengelola);
        }

        // 3b. Create User Customer
        $userCustomer = User::firstOrCreate(
            ['email' => 'customer@villa.com'],
            [
                'name' => 'Customer Villa',
                'password' => Hash::make('password'),
            ]
        );
        if (!$userCustomer->hasRole('customer')) {
            $userCustomer->assignRole($roleCustomer);
        }

        // 4. Create Dummy Villa tied to Pemilik
        $villa = Villa::firstOrCreate(
            ['email' => 'sunset@villa.com'],
            [
                'pemilik_id' => $userPemilik->id,
                'name' => 'Villa Sunset Paradise',
                'description' => 'Villa mewah dengan pemandangan sunset yang indah.',
            ]
        );

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
