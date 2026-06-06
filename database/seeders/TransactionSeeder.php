<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Transaction;
use App\Models\Villa;
use Faker\Factory as Faker;

class TransactionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create('id_ID');
        $villas = Villa::all();

        if ($villas->isEmpty()) {
            $this->command->info('Tidak ada villa ditemukan, transaksi gagal dibuat. Silakan tambahkan villa terlebih dahulu.');
            return;
        }

        $this->command->info('Membuat 100 data pemasukkan...');
        // 100 Pemasukkan
        for ($i = 0; $i < 100; $i++) {
            Transaction::create([
                'villa_id' => $villas->random()->id,
                'name' => 'Pendapatan Sewa ' . $faker->firstName(),
                'amount' => $faker->numberBetween(5, 50) * 100000, // Rp 500k - Rp 5juta
                'type' => 'income',
                'date' => $faker->dateTimeBetween('-6 months', 'now')->format('Y-m-d'),
                'is_recurring' => false,
                'is_tanggungan_pemilik' => false,
            ]);
        }

        $this->command->info('Membuat 100 data pengeluaran...');
        // 100 Pengeluaran
        for ($i = 0; $i < 100; $i++) {
            Transaction::create([
                'villa_id' => $villas->random()->id,
                'name' => 'Biaya ' . $faker->randomElement(['Listrik', 'Air', 'Kebersihan', 'Perbaikan', 'Lainnya']) . ' ' . $faker->word(),
                'amount' => $faker->numberBetween(1, 20) * 50000, // Rp 50k - Rp 1juta
                'type' => 'expense',
                'date' => $faker->dateTimeBetween('-6 months', 'now')->format('Y-m-d'),
                'is_recurring' => false,
                'is_tanggungan_pemilik' => $faker->boolean(20), // 20% tanggungan pemilik
            ]);
        }

        $this->command->info('Berhasil membuat 100 pemasukkan dan 100 pengeluaran!');
    }
}
