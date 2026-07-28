<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Fasilitas;

class FasilitasSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $fasilitas = [
            ['nama' => 'Kolam Renang', 'ikon' => 'bi bi-water'],
            ['nama' => 'WiFi Gratis', 'ikon' => 'bi bi-wifi'],
            ['nama' => 'Dapur', 'ikon' => 'bi bi-cup-hot'],
            ['nama' => 'AC', 'ikon' => 'bi bi-snow'],
            ['nama' => 'TV', 'ikon' => 'bi bi-tv'],
            ['nama' => 'Parkir Gratis', 'ikon' => 'bi bi-car-front'],
            ['nama' => 'Pemanas Air', 'ikon' => 'bi bi-thermometer-half'],
            ['nama' => 'Area BBQ', 'ikon' => 'bi bi-fire'],
            ['nama' => 'Taman', 'ikon' => 'bi bi-tree'],
        ];

        foreach ($fasilitas as $item) {
            Fasilitas::firstOrCreate(
                ['nama' => $item['nama']],
                ['ikon' => $item['ikon']]
            );
        }
    }
}
